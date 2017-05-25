<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class git {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function GetLinuxUserInfo($LinuxUserName) {
		$UserInfo = posix_getpwnam($LinuxUserName);
				
		if ($UserInfo['name'] == 'root' || $UserInfo['name'] == false) // MacOS return false for not found, host02 return name='root'
			return null;
		
		$GroupInfo = posix_getgrgid($UserInfo['gid']);
		$UserInfo['group'] = $GroupInfo['name'];
		return $UserInfo;
	}
		
	public static function IsLinuxUserNameCompatible($LinuxUserName, &$ErrorMsg) {
		
		$LinuxUserInfo = git::GetLinuxUserInfo($LinuxUserName);

		if ($LinuxUserInfo == null) {
			$ErrorMsg = ADMIN_ERROR_LINUX_USER_NOT_FOUND;
			return false;
		}
		if (!preg_match("/^web[0-9]+$/", $LinuxUserName)) {
			$ErrorMsg = ADMIN_ERROR_INCOMPATIBLE_LINUX_USER;
			return false;
		}

		if (!preg_match("/^client[0-9]+$/", $LinuxUserInfo['group'])) {
			$ErrorMsg = ADMIN_ERROR_INCOMPATIBLE_LINUX_USER;
			return false;
		}
		
		if (!file_exists($LinuxUserInfo['dir'])) {
			$ErrorMsg = ADMIN_ERROR_LINUX_USER_DIR_DOES_NOT_EXIST;
			return false;			
		}
		
		return true;
	}
	
	public static function IsLinuxUserInUseForAnotherGit($LinuxUserName, $TargetInUseGitRepoID = null, $TargetInUseGitDeployID = null) {
		$sql = '';
		
		if ($TargetInUseGitRepoID != null)
			$sql = " AND G.git_repo_id != '" . intval($TargetInUseGitRepoID) . "'";
		
		$query =	"	SELECT	* " .
					"	FROM	git_repo G " . 
					"	WHERE	G.git_repo_linux_user = '" . aveEscT(strtolower($LinuxUserName)) . "'" . $sql;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if ($result->num_rows > 0)
			return true;
		else {
			$sql2 = '';
			
			if ($TargetInUseGitDeployID != null)
				$sql2 = " AND D.git_repo_deploy_id != '" . intval($TargetInUseGitDeployID) . "'";

			$query =	"	SELECT	* " .
						"	FROM	git_repo_deploy D " . 
						"	WHERE	D.git_repo_deploy_linux_user = '" . aveEscT(strtolower($LinuxUserName)) . "'" . $sql2;
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			
			return $result->num_rows > 0;
		}
	}	

	public static function GetGitRepoInfo($GitRepoID) {
		$query =	"	SELECT	* " .
					"	FROM	git_repo G " .
					"	WHERE	G.git_repo_id = '" . intval($GitRepoID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}

	public static function GetGitRepoDeployInfo($GitRepoDeployID) {
		$query =	"	SELECT	* " .
					"	FROM	git_repo G JOIN git_repo_deploy D ON (G.git_repo_id = D.git_repo_id) " .
					"	WHERE	D.git_repo_deploy_id = '" . intval($GitRepoDeployID) . "' ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		if ($result->num_rows > 0)
			return $result->fetch_assoc();
		else
			return null;
	}
	
	public static function ActionToCreateSshAccessFile($GitRepoInfo) {		
		
		// Get home dir from user
		$LinuxUserInfo = git::GetLinuxUserInfo($GitRepoInfo['git_repo_linux_user']);
		
		$SshDir = $LinuxUserInfo['dir'] . '/.ssh';
		
		@mkdir($SshDir, 0700);
		
		$fp = @fopen($SshDir . '/authorized_keys', 'w');
		if ($fp !== false) {
			fwrite($fp, "#DO NOT EDIT THIS FILE MANUALLY!!! \n");
			fwrite($fp, "#THIS WILL BE OVERWRITTEN BY CMS \n");
			
			$query =	"	SELECT	* " .
						"	FROM		git_repo G " .
						"		JOIN	system_admin_git_repo R ON (G.git_repo_id = R.git_repo_id AND G.git_repo_id = '" . intval($GitRepoInfo['git_repo_id']) . "') " .
						"		JOIN	system_admin S ON (S.system_admin_id = R.system_admin_id AND S.system_admin_is_enable = 'Y') ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			while ($myResult = $result->fetch_assoc()) {
				fwrite($fp, $myResult['ssh_public_key'] . "\n");
			}
		}
		
		$Output = '';
		
		$Command = "/bin/chown -R " . escapeshellarg($LinuxUserInfo['name']) . ":" . escapeshellarg($LinuxUserInfo['group']) . " " . escapeshellarg($SshDir) . " 2>&1";
		$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";
		
		return $Output;
	}
		
	public static function ActionToInitGitRepo($GitRepoInfo) {
		$LinuxUserInfo = git::GetLinuxUserInfo($GitRepoInfo['git_repo_linux_user']);		
		
		$GitRepoDir = GIT_REPO_STORAGE_PATH . $GitRepoInfo['git_repo_linux_user'];
		
		$Output = '';
		
		if (file_exists($GitRepoDir)) {
			$Output = "git_creation: Git Directory already exists.";
		}
		else {
			$Command = "/usr/bin/git init --bare --shared=0600 " . escapeshellarg($GitRepoDir) . " 2>&1";
			$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";

			$Command = "/bin/chown -R " . escapeshellarg($LinuxUserInfo['name']) . ":" . escapeshellarg($LinuxUserInfo['group']) . " " . escapeshellarg($GitRepoDir) . " 2>&1";
			$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";
		}
		
		$Command = "/usr/bin/chsh -s /usr/bin/git-shell " . escapeshellarg($LinuxUserInfo['name']) . " 2>&1";
		$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";

		return $Output;
	}
		
	public static function ActionToUpdateLinuxUser($GitRepoInfo, $NewLinuxUserName) {
		$Output = '';

		$OriginalGitDir = GIT_REPO_STORAGE_PATH . $GitRepoInfo['git_repo_linux_user'];
		$NewGitDir = GIT_REPO_STORAGE_PATH . trim($NewLinuxUserName);
		$OldLinuxUserName = $GitRepoInfo['git_repo_linux_user'];
		$OldLinuxUserInfo = git::GetLinuxUserInfo($OldLinuxUserName);
		$NewLinuxUserInfo = git::GetLinuxUserInfo($NewLinuxUserName);
		
		// rename dir
		if (file_exists($NewGitDir)) {
			$Output = "update_linux_user: Git Directory already exists.";
		}
		else {
			$Command = "/bin/mv " . escapeshellarg($OriginalGitDir) . " " . escapeshellarg($NewGitDir) . " 2>&1";
			$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";

		}
		
		//	chown dir		
		$Command = "/bin/chown -R " . escapeshellarg($NewLinuxUserInfo['name']) . ":" . escapeshellarg($NewLinuxUserInfo['group']) . " " . escapeshellarg($NewGitDir) . " 2>&1";
		$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";
		
		//	change old user shell
		$Command = "/usr/bin/chsh -s /bin/false " . escapeshellarg($OldLinuxUserName) . " 2>&1";
		$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";
		
		//	change new user shell
		$Command = "/usr/bin/chsh -s /usr/bin/git-shell " . escapeshellarg($NewLinuxUserName) . " 2>&1";
		$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";
		
		//	remove old user ssh access file
		$OldSshAuthKeyPath = $OldLinuxUserInfo['dir'] . '/.ssh/authorized_keys';
		$Command = "/bin/rm " . escapeshellarg($OldSshAuthKeyPath) . " 2>&1";
		$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";
		
		$query	=	"	UPDATE	git_repo " .
					"	SET		git_repo_linux_user = '" . aveEscT($NewLinuxUserName) . "' " .
					"	WHERE	git_repo_id = '" . intval($GitRepoInfo['git_repo_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$NewGitRepoInfo = git::GetGitRepoInfo($GitRepoInfo['git_repo_id']);
		
		//	update new user ssh access file
		git::ActionToCreateSshAccessFile($NewGitRepoInfo);

		//	update git hook
		git::ActionToHookGitCheckout($NewGitRepoInfo);
	}
	
	public static function ActionToHookGitCheckout($GitRepoInfo) {
		
		$GitDir = GIT_REPO_STORAGE_PATH . $GitRepoInfo['git_repo_linux_user'] . '/';
		$PostReceiveFile = $GitDir . 'hooks/post-receive';
		
		$fp = @fopen($PostReceiveFile, 'w');

		$Output = '';

		if ($fp !== false) {
			fwrite($fp, "#!/bin/bash \n");
			fwrite($fp, "#DO NOT EDIT THIS FILE MANUALLY!!! \n");
			fwrite($fp, "#THIS WILL BE OVERWRITTEN BY CMS \n");

			$LinuxUserInfo = git::GetLinuxUserInfo($GitRepoInfo['git_repo_linux_user']);
			
			if ($GitRepoInfo['git_repo_auto_deploy_on_push'] == 'Y') {
				$DefaultDeployPath = $LinuxUserInfo['dir'];

				$FileCommand =
					"while read oldrev newrev refname\n" .
					"do\n" .
					'	branch=$(git rev-parse --symbolic --abbrev-ref $refname)' . "\n" .
					'	if [ "master" == "$branch" ]; then' . "\n" .
					"		/usr/bin/git --work-tree=" . escapeshellarg($DefaultDeployPath) . " --git-dir=" . escapeshellarg($GitDir) . " checkout master -f  2>&1 \n" .
					"		if [ -f " . escapeshellarg($DefaultDeployPath . "/web/common/local.php.sample") . " ]; then \n" .
					"			if [ ! -f " . escapeshellarg($DefaultDeployPath . "/web/common/local.php") . " ]; then \n" .
					"				/bin/echo 'copy local.php.sample to local.php' \n" .
					"				/bin/cp " . escapeshellarg($DefaultDeployPath . "/web/common/local.php.sample") . " " . escapeshellarg($DefaultDeployPath . "/web/common/local.php") . "  2>&1 \n" .
					"			fi\n" .
					"		fi\n" .
					"	fi\n" .
					"done";
				fwrite($fp, $FileCommand);
			}
			
			fclose($fp);
				
			$Command = "/bin/chown " . escapeshellarg($LinuxUserInfo['name']) . ":" . escapeshellarg($LinuxUserInfo['group']) . " " . escapeshellarg($PostReceiveFile)  . " 2>&1";
			$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";

			$Command = "/bin/chmod 700 " . escapeshellarg($PostReceiveFile) . " 2>&1";
			$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";

			return $Output;
		}
		else 
			return "ActionToHookGitCheckout: Failed to write to " . $PostReceiveFile;
	}
	
	public static function ActionToCheckout($GitRepoDeployInfo, $SystemAdminID) {
		$RepoLinuxUserInfo = git::GetLinuxUserInfo($GitRepoDeployInfo['git_repo_linux_user']);;
		$DeployLinuxUserInfo = null;
		
		if ($GitRepoDeployInfo['git_repo_deploy_linux_user'] == null) {
			$DeployLinuxUserInfo = $RepoLinuxUserInfo;
		}
		else {
			$DeployLinuxUserInfo = git::GetLinuxUserInfo($GitRepoDeployInfo['git_repo_deploy_linux_user']);
		}
		
		if (!git::IsLinuxUserNameCompatible($DeployLinuxUserInfo['name'], $ErrorMsg))
			return "ActionToCheckout: " . $ErrorMsg;

		$GitDir = GIT_REPO_STORAGE_PATH . $GitRepoDeployInfo['git_repo_linux_user'] . '/';

		$Output = '';
		$Command = "/usr/bin/git --work-tree=" . escapeshellarg($DeployLinuxUserInfo['dir']) . " --git-dir=" . escapeshellarg($GitDir) . " checkout " . escapeshellarg($GitRepoDeployInfo['git_repo_deploy_branch']) . " -f" . " 2>&1";
		$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";

		$LocalPHP = $DeployLinuxUserInfo['dir'] . "/web/common/local.php";
		$LocalSamplePHP = $DeployLinuxUserInfo['dir'] . "/web/common/local.php.sample";		
		if (!file_exists($LocalPHP) && file_exists($LocalSamplePHP)) {
			$Command = "/bin/cp " . escapeshellarg($LocalSamplePHP) . " " . escapeshellarg($LocalPHP) . " 2>&1";
			$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";
		}
		
		$Command = "/bin/chown -R " . escapeshellarg($DeployLinuxUserInfo['name']) . ":" . escapeshellarg($DeployLinuxUserInfo['group']) . " " . escapeshellarg($DeployLinuxUserInfo['dir'])  . " 2>&1";
		$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";

		// Fix the git repo too (the git/index file created by root cannot be updated by other)
		$Command = "/bin/chown -R " . escapeshellarg($RepoLinuxUserInfo['name']) . ":" . escapeshellarg($RepoLinuxUserInfo['group']) . " " . escapeshellarg($GitDir)  . " 2>&1";
		$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";

		$query	=	"	UPDATE	git_repo_deploy " .
					"	SET		git_repo_deploy_last_deploy_date = NOW(), " .
					"			git_repo_deploy_by_system_admin_id = '" . intval($SystemAdminID) . "' " .
					"	WHERE	git_repo_deploy_id = '" . intval($GitRepoDeployInfo['git_repo_deploy_id']) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		return $Output;
	}
	
	public static function GetGitRepoListBySystemAdminInfo($SystemAdminInfo) {
		if (intval($SystemAdminInfo['system_admin_security_level']) >= SUPER_ADMIN_LEVEL) {
			return git::GetGitRepoList();
		}
		else {
			$query =	"	SELECT	*, COUNT(D.git_repo_deploy_id) AS no_of_deploy " .
						"	FROM	git_repo G	JOIN git_repo_deploy D ON (G.git_repo_id = D.git_repo_id) " .
						"						JOIN system_admin_git_repo R ON (R.git_repo_id = G.git_repo_id AND R.system_admin_id = '" . intval($SystemAdminInfo['system_admin_id']) . "') " .
						"	GROUP BY G.git_repo_id " .
						"	ORDER BY G.git_repo_name ASC ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

			$GitRepoList = array();

			while ($myResult = $result->fetch_assoc()) {
				array_push($GitRepoList, $myResult);
			}
			
			return $GitRepoList;
		}
	}
	
	public static function IsGitRepoAccessible($GitRepoID, $SystemAdminInfo) {
		if (intval($SystemAdminInfo['system_admin_security_level']) >= SUPER_ADMIN_LEVEL) {
			return true;
		}
		else {
			$query =	"	SELECT	* " .
						"	FROM	system_admin_git_repo " .
						"	WHERE	git_repo_id = '" . intval($GitRepoID) . "'" .
						"		AND	system_admin_id = '" . intval($SystemAdminInfo['system_admin_id']) . "'";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
			
			return $result->num_rows > 0;
		}		
	}
	
	public static function GetGitRepoList() {
		
		$query =	"	SELECT	*, COUNT(D.git_repo_deploy_id) AS no_of_deploy " .
					"	FROM	git_repo G JOIN git_repo_deploy D ON (G.git_repo_id = D.git_repo_id) " .
					"	GROUP BY G.git_repo_id " .
					"	ORDER BY G.git_repo_name ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$GitRepoList = array();
		
		while ($myResult = $result->fetch_assoc()) {
			array_push($GitRepoList, $myResult);
		}

		return $GitRepoList;
	}
	
	public static function GetGitRepoDeployListFromGitRepoID($GitRepoID) {
		$query =	"	SELECT	* " .
					"	FROM	git_repo G	JOIN	git_repo_deploy D ON (G.git_repo_id = D.git_repo_id) " .
					"						LEFT JOIN	system_admin A ON (D.git_repo_deploy_by_system_admin_id = A.system_admin_id) " .
					"	WHERE	G.git_repo_id = '" . intval($GitRepoID) . "'" .
					"	ORDER BY D.git_repo_deploy_name ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$GitRepoDeployList = array();
		
		while ($myResult = $result->fetch_assoc()) {
			array_push($GitRepoDeployList, $myResult);
		}

		return $GitRepoDeployList;
	}
		
	public static function AddActionQueue($ActionType, $GitRepoID, $GitRepoDeployID, $SystemAdminID, $Para1 = null, $Para2 = null, $Para3 = null, $Para4 = null, $Para5 = null) {
		global $ValidGitActionType;
		
		if (in_array($ActionType, $ValidGitActionType)) {
			$query =	"	INSERT INTO git_action_queue " .
						"	SET		git_action_type = '" . aveEscT($ActionType) . "', " .
						"			git_repo_id = '" . intval($GitRepoID) . "', " .
						"			git_repo_deploy_id = '" . intval($GitRepoDeployID) . "', " .
						"			system_admin_id = '" . intval($SystemAdminID) . "', " .
						"			git_action_create_date = NOW(), " .
						"			git_action_finish_date = NULL, " .
						"			git_action_output = '', " .
						"			git_action_para_1 = '" . aveEscT($Para1) . "', " .
						"			git_action_para_2 = '" . aveEscT($Para2) . "', " .
						"			git_action_para_3 = '" . aveEscT($Para3) . "', " .
						"			git_action_para_4 = '" . aveEscT($Para4) . "', " .
						"			git_action_para_5 = '" . aveEscT($Para5) . "' ";
			$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		}
	}
	
	public static function GetGitDeployAdminAccessList($GitRepoID) {
		$query =	"	SELECT	* " .
					"	FROM	git_repo G	JOIN	system_admin_git_repo R ON (G.git_repo_id = R.git_repo_id) " .
					"						JOIN	system_admin A ON (R.system_admin_id = A.system_admin_id) " .
					"	WHERE	G.git_repo_id = '" . intval($GitRepoID) . "'" .
					"	ORDER BY A.email ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$SystemAdminList = array();
		
		while ($myResult = $result->fetch_assoc()) {
			array_push($SystemAdminList, $myResult);
		}

		return $SystemAdminList;
	}
	
	public static function GetActionQueueList($JobStatus = 'all/done/pending', $GitRepoID = 0, $OrderByField = 'Q.git_action_queue_id', $OrderByAscDesc = 'DESC') {

		$sql = '';
		if ($JobStatus == 'done')
			$sql = "	AND	Q.git_action_finish_date IS NOT null ";
		else if ($JobStatus == 'pending')
			$sql = "	AND	Q.git_action_finish_date IS null ";
		
		if ($GitRepoID > 0)
			$sql = $sql . "	AND	Q.git_repo_id = '" . intval($GitRepoID) . "'";
		 	
		$query =	"	SELECT	* " .
					"	FROM	git_action_queue Q	JOIN	system_admin A	ON	(Q.system_admin_id = A.system_admin_id) " . 
					"	WHERE	2 > 1 " .
					$sql .
					"	ORDER BY " . $OrderByField . " " . $OrderByAscDesc;
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$JobList = array();
		
		while ($myResult = $result->fetch_assoc()) {
			array_push($JobList, $myResult);
		}

		return $JobList;		
	}
	
	public static function ActionToDelete($GitRepoInfo) {
		$Output = '';
		// remove ssh access file
		$LinuxUser = git::GetLinuxUserInfo($GitRepoInfo['git_repo_linux_user']);		
		$OldSshAuthKeyPath = $LinuxUser['dir'] . '/.ssh/authorized_keys';
		$Command = "/bin/rm " . escapeshellarg($OldSshAuthKeyPath) . " 2>&1";
		$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";

		//	change old user shell
		$Command = "/usr/bin/chsh -s /bin/false " . escapeshellarg($GitRepoInfo['git_repo_linux_user']) . " 2>&1";
		$Output = $Output  . $Command . "\n" . shell_exec($Command) . "\n";
		
		$query =	"	DELETE FROM	git_repo " . 
					"	WHERE	git_repo_id = '" . $GitRepoInfo['git_repo_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$query =	"	DELETE FROM	git_repo_deploy " . 
					"	WHERE	git_repo_id = '" . $GitRepoInfo['git_repo_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		
		$query =	"	DELETE FROM	system_admin_git_repo " . 
					"	WHERE	git_repo_id = '" . $GitRepoInfo['git_repo_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$query =	"	DELETE FROM	git_action_queue " . 
					"	WHERE	git_repo_id = '" . $GitRepoInfo['git_repo_id'] . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
	
	public static function GetGitURL($GitRepoInfo) {
		// ssh://host02.aveego.com/mnt/git_repo/demo.369cms.com/
		return "ssh://" . GIT_HOST . GIT_REPO_STORAGE_PATH . $GitRepoInfo['git_repo_linux_user'] . "/";
	}
	
	public static function GetSystemAdminGitListOption($SystemAdminID) {
		$query =	"	SELECT	L.*, G.* " .
					"	FROM	git_repo G LEFT JOIN system_admin_git_repo L ON (L.git_repo_id = G.git_repo_id AND L.system_admin_id = '" . intval($SystemAdminID) . "') " .
					"	ORDER BY G.git_repo_name  ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		$GitRepoList = array();
		while ($myResult = $result->fetch_assoc()) {
			array_push($GitRepoList, $myResult);
		}
		return $GitRepoList;
	}
	
}