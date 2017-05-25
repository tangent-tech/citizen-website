<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');
require_once('../common/elasing_user_header.php');
require_once('../common/header_elasing.php');

$smarty->assign('CurrentTab', 'newsletter');
$smarty->assign('CurrentTab2', 'elasing_mailing_list');
$smarty->assign('MyJS', 'elasing_import_subscriber_from_csv');

$List = emaillist::GetEmailListDetails($_REQUEST['id']);
if ($List['site_id'] != $_SESSION['site_id'])
	AdminDie('Sorry, this is not your list', 'elasing_mailing_list.php', __LINE__);
if (!$IsContentAdmin && $_SESSION['ContentAdminID'] != $List['content_admin_id'])
	AdminDie('Sorry, this is not your list', 'elasing_mailing_list.php', __LINE__);

$ImportContact = 0;
$InvalidContact = 0;

if (isset($_FILES['csv_file'])) {
	$file = $_FILES['csv_file'];

	if ($file['size'] > 0) {
		if(!file_exists($file['tmp_name']))
			AdminDie(ADMIN_ERROR_UPLOAD_FILE_FAIL, 'elasing_mailing_list.php', __LINE__);

		$handle = fopen($file['tmp_name'], "r");
		$data = fgetcsv($handle, 0, ",");
		$num = count($data);
		$NameField1 = 0;
		$NameField2 = 0;
		$NameField3 = 0;
		$NameField4 = 0;
		$EmailField1 = -1;
		$EmailField2 = -1;
		$EmailField3 = -1;
		
		$data[0] = str_replace("\xEF\xBB\xBF",'', $data[0]); 
		
		if (IsValidEmail($data[0])) {
			$EmailField1 = 0;
			$NameField1 = 1;
			$NameField3 = 2;
			if (emaillist::AddEmailToList($data[$EmailField1], $_REQUEST['id'], $_SESSION['site_id'], 'Y', $data[$NameField1], $data[$NameField3]))
				$ImportContact++;
			else
				$InvalidContact++;
		}
		elseif ($num == 1) {
			$EmailField1 = 0;
			$NameField1 = -1;
			$NameField3 = -1;
			if ($data[$EmailField1] != '') {
				if (emaillist::AddEmailToList($data[$EmailField1], $_REQUEST['id'], $_SESSION['site_id'], 'Y', $data[$NameField1], $data[$NameField3]))
					$ImportContact++;
				else
					$InvalidContact++;
			}
		}
		else {
		    for ($c=0; $c < $num; $c++) {
		    	// Hotmail
				if ($data[$c] == 'E-mail Address')
		    		$EmailField1 = $c;
		    	if ($data[$c] == 'E-mail 2 Address')
		    		$EmailField2 = $c;
		    	if ($data[$c] == 'E-mail 3 Address')
		    		$EmailField3 = $c;
		    	if ($data[$c] == 'First Name')
		    		$NameField1 = $c;
		    	if ($data[$c] == 'Middle Name')
		    		$NameField2 = $c;
		    	if ($data[$c] == 'Last Name')
		    		$NameField3 = $c;

		    	// Yahoo English
				if ($data[$c] == 'Email')
		    		$EmailField1 = $c;
		    	if ($data[$c] == 'Alternate Email 1')
		    		$EmailField2 = $c;
		    	if ($data[$c] == 'Alternate Email 2')
		    		$EmailField3 = $c;
		    	if ($data[$c] == 'First')
		    		$NameField1 = $c;
				if ($data[$c] == 'Middle')
		    		$NameField2 = $c;
		    	if ($data[$c] == 'Last')
		    		$NameField3 = $c;
		    	if ($data[$c] == 'Nickname')
		    		$NameField4 = $c;

		    	// Yahoo English
				if ($data[$c] == '電郵')
		    		$EmailField1 = $c;
		    	if ($data[$c] == '備用電郵地址 1')
		    		$EmailField2 = $c;
		    	if ($data[$c] == '備用電郵地址 2')
		    		$EmailField3 = $c;
		    	if ($data[$c] == '名字')
		    		$NameField1 = $c;
		    	if ($data[$c] == '中名')
		    		$NameField2 = $c;
		    	if ($data[$c] == '姓氏')
		    		$NameField3 = $c;
		    	if ($data[$c] == '別名')
		    		$NameField4 = $c;

		    	// Google
				if ($data[$c] == 'E-mail 1 - Value')
		    		$EmailField1 = $c;
		    	if ($data[$c] == 'E-mail 2 - Value')
		    		$EmailField2 = $c;
		    	if ($data[$c] == 'E-mail 3 - Value')
		    		$EmailField3 = $c;
		    	if ($data[$c] == 'Name')
		    		$NameField1 = $c;
				if ($data[$c] == 'Given Name')
		    		$NameField2 = $c;
		    	if ($data[$c] == 'Family Name')
		    		$NameField3 = $c;
		    	if ($data[$c] == 'Nickname')
		    		$NameField4 = $c;
		    }
		}

		while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
			if ($EmailField1 != -1 && $data[$EmailField1] != '') {
				if (emaillist::AddEmailToList($data[$EmailField1], $_REQUEST['id'], $_SESSION['site_id'], 'Y', $data[$NameField1], $data[$NameField3]))
					$ImportContact++;
				else
					$InvalidContact++;
			}
			if ($EmailField2 != -1 && $data[$EmailField2] != '') {
				if (emaillist::AddEmailToList($data[$EmailField2], $_REQUEST['id'], $_SESSION['site_id'], 'Y', $data[$NameField1], $data[$NameField3]))
					$ImportContact++;
				else
					$InvalidContact++;
			}
			if ($EmailField3 != -1 && $data[$EmailField3] != '') {
				if (emaillist::AddEmailToList($data[$EmailField3], $_REQUEST['id'], $_SESSION['site_id'], 'Y', $data[$NameField1], $data[$NameField3]))
					$ImportContact++;
				else
					$InvalidContact++;
			}
		}
		fclose($handle);
	}
}

$smarty->assign('ImportContact', $ImportContact);
$smarty->assign('InvalidContact', $InvalidContact);

$smarty->display('myadmin/' . $CurrentLang['language_id'] . '/elasing_import_subscriber_from_csv.tpl');