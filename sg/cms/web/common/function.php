<?php

	function xmlentities ($string) {
    	return str_replace ( array ( '&', '"', "'", '<', '>' ), array ( '&amp;' , '&quot;', '&apos;' , '&lt;' , '&gt;' ), $string );
	}

	function GetNoOfDigits($no, $count = 1)
	{
		if ($no/10 < 1)
			return $count;
		else
			return GetNoOfDigits($no/10, ++$count);
	}

	function AdminDieEX($Msg, $BackURL = 'javascript: history.go(-1)') {
		global $smarty;
		$smarty->assign('Msg', $Msg);
		$smarty->assign('BackURL', $BackURL);
		$smarty->display('myadmin/1/admin_error.tpl');
		die();
	}

	function AdminDie($Msg, $URL, $LineNo = 0) {

		if (strpos($URL, '?') === false)
			header( 'Location: ' . $URL . '?ErrorMessage=' . urlencode($Msg . ' (' . $LineNo . ')'));
		else
			header( 'Location: ' . $URL . '&ErrorMessage=' . urlencode($Msg . ' (' . $LineNo . ')'));
		exit();
	}

	function XMLDie($ErrorNo, $Msg) {
		global $smarty;
		$smarty->assign('status', 'error');
		$smarty->assign('Msg', $Msg);
		$smarty->assign('ErrorNo', $ErrorNo);
		$smarty->display('myadmin/1/xml_die.tpl');
		die();
	}

	function APIDie($API_ERROR, $AdditionalXML = '') {
		$smarty = new mySmarty();
		$smarty->assign('API_ERROR', $API_ERROR);
		$smarty->assign('AdditionalXML', $AdditionalXML);
		$smarty->display('api/api_error.tpl');
		die();
	}

	function IsValidEmail($email) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false)
			return false;
		else
			return true;
	}

	function IsValidEmailEX($email) {
		if (!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
			return false;
		}
		$email_array = explode("@", $email);
		$local_array = explode(".", $email_array[0]);
		for ($i = 0; $i < sizeof($local_array); $i++) {
			if (!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
			  return false;
			}
		}
		if (!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
			$domain_array = explode(".", $email_array[1]);
			if (sizeof($domain_array) < 2) {
			    return false;
			}
			for ($i = 0; $i < sizeof($domain_array); $i++) {
				if (!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
					return false;
				}
			}
		}
		return true;
	}

	function checkDateFormat($date) {
		if (preg_match ("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date, $parts)) {
			if(checkdate($parts[2],$parts[3],$parts[1]))
				return true;
			else
				return false;
			}
		else
			return false;
	}

	function IsValidPassword(&$ErrMsg, $Password, $Password2) {
		if (strlen(trim($Password)) < MIN_PASSWORD || strlen(trim($Password)) > MAX_PASSWORD) {
			$ErrMsg = ADMIN_ERROR_INVALID_PASSWORD_LENGTH;
			return false;
		}
		if (trim($Password) !== trim($Password2)) {
			$ErrMsg = ADMIN_ERROR_PASSWORDS_DO_NOT_MATCH;
			return false;
		}
		return true;
	}

	function ftp_is_file($conn_id, $src) {
		// YOU MUST LOGIN TO THE FTP BEFORE USING THIS FUNCTION
		$files = ftp_nlist($conn_id, dirname($src));
		return in_array(end(explode('/', $src)), $files);
//		return in_array(basename($src), $files);
	}

	function ftp_is_dir($conn_id, $dir) {
		if (ftp_chdir($conn_id, $dir)) {
			ftp_chdir($conn_id, '..');
			return true;
		} else {
			return false;
		}
	}

	function ReformatMultiFilePost($file_post) {
	    $file_ary = array();
	    $file_count = count($file_post['name']);
	    $file_keys = array_keys($file_post);

	    for ($i=0; $i<$file_count; $i++) {
	        foreach ($file_keys as $key) {
	            $file_ary[$i][$key] = $file_post[$key][$i];
	        }
	    }

	    return $file_ary;
	}

	function ynval($input) {
		if ($input === true)
			return 'Y';
		if ($input === false)
			return 'N';		
		if (strval($input) == 'Y' || strval($input) == 'y')
			return 'Y';
		else
			return 'N';
	}

	function FullURL($Site, $Url) {
		if (strpos($Url, 'http://') === false)
			return "http://" . $Site['site_address'] . "/" . $Url;
		else
			return $Url;
	}

	function ConvertToHyphen($Url) {
		$replacements = array('!', '*', "'", "(", ")", ";", ":", "@", "&", "=", "+", "$", ",", "/", "?", "%", "#", "[", "]");
		$Url = trim($Url);
		$Url = str_replace($replacements, "-", $Url);
		$Url = str_replace(" ","-",$Url);
		$Url = str_replace("_","-",$Url);
		$Url = str_replace("　","-",$Url);
		$Url = str_replace(".","-",$Url);
		$Url = str_replace('"',"-",$Url);
		$Url = str_replace("'","-",$Url);
		return strtolower($Url);
	}

	function GetSeoURL($Object) {
		global $Site;
		return object::GetSeoURL($Object, '', $Object['language_id'], $Site);
	}

	function remove_item_by_value($array, $val = '', $preserve_keys = true) {
		if (empty($array) || !is_array($array)) return false;
		if (!in_array($val, $array)) return $array;

		foreach($array as $key => $value) {
			if ($value == $val) unset($array[$key]);
		}
		return ($preserve_keys === true) ? $array : array_values($array);
	}

	function DoEscapeText($Text, $DoNeedEscape) {
		if ($DoNeedEscape)
			return aveEsc($Text);
		else
			return $Text;
	}

	function GetCustomTextSQL($Table, $Type, $DataObjectIndexToUse = 0, $DataObject = null, $OutDatedField = false, $CustomDef = null) {
		// Jeff 20120830
		// Added DataObject and NeedEscape for cloning
		//
		$IsRequest = false;

		if ($DataObject == null) {
			$DataObject = $_REQUEST;
			$IsRequest = true;
		}

		$sql = '';
		
		$MaxValue = 20; // 20 for almost all type
		if ($Type == 'rgb')
			$MaxValue = NO_OF_CUSTOM_RGB_FIELDS;
		if ($Type == 'group_field_name')
			$MaxValue = NO_OF_PRODUCT_GROUP_FIELDS;
		
		for ($i = 1; $i <= $MaxValue; $i++) {
			$EffectiveType = $Type;
			if ($Type == 'autotext') {
				$DefTable = $Table;
				
				if ($Table == 'product_category_special')
					$DefTable = 'product_category';
				
				$Prefix = substr($CustomDef[$DefTable . "_custom_text_" . $i], 0, 5);
				if ($Prefix == "STXT_" || $Prefix == "MTXT_")
					$EffectiveType = "text";
				else
					$EffectiveType = "editor";
			}
			
			if ($EffectiveType == 'date') {
				if ($Table == 'myorder') { // Used by API!
					if (isset($DataObject[$Table . '_custom_date_' . $i]))
						$sql = $sql . " " . $Table . "_custom_date_" . $i . " = '" . aveEscT($DataObject[$Table . '_custom_date_' . $i]) . "',";
				}
				else {
					if (isset($DataObject[$Table . '_custom_date_' . $i])) {
						if ($IsRequest)
							$sql = $sql . " " . $Table . "_custom_date_" . $i . " = '" . aveEscT($DataObject[$Table . '_custom_date_' . $i] . " " . $DataObject[$Table . '_custom_date_' . $i . 'Hour'] . ":" . $DataObject[$Table . '_custom_date_' . $i . 'Minute']) . "',";
						else
							$sql = $sql . " " . $Table . "_custom_date_" . $i . " = '" . aveEscT($DataObject[$Table . '_custom_date_' . $i]) . "',";
					}
				}
			}

			elseif ($EffectiveType == 'editor') {
				if ($Table == 'folder') {
					if (isset($DataObject['CustomFieldEditor' . $i]))
						$sql = $sql . " " . $Table . "_custom_text_" . $i . " = '" . aveEscT($DataObject['CustomFieldEditor' . $i]) . "',";
				}
				else {
					if (isset($DataObject['CustomFieldEditor' . $i . '_' . $DataObjectIndexToUse]))
						$sql = $sql . " " . $Table . "_custom_text_" . $i . " = '" . aveEscT($DataObject['CustomFieldEditor' . $i . '_' . $DataObjectIndexToUse]) . "',";
				}
			}
			elseif ($EffectiveType == 'text') {
				if ($Table == 'user' || $Table == 'myorder' || $Table == 'folder') {
					if (isset($DataObject[$Table . '_custom_' . $EffectiveType . '_' . $i]))
						$sql = $sql . " " . $Table . "_custom_" . $EffectiveType . "_" . $i . " = '". aveEscT($DataObject[$Table . '_custom_' . $EffectiveType . '_' . $i]) . "',";
				}
				else {
					if (isset($DataObject[$Table . '_custom_text_' . $i][$DataObjectIndexToUse])) {
						if ($IsRequest)
							$sql = $sql . " " . $Table . "_custom_text_" . $i . " = '" . aveEscT($DataObject[$Table . '_custom_text_' . $i][$DataObjectIndexToUse]) . "',";
						else
							$sql = $sql . " " . $Table . "_custom_text_" . $i . " = '" . aveEscT($DataObject[$Table . '_custom_text_' . $i]) . "',";
					}

				}
			}
			elseif ($EffectiveType == 'rgb') {
				if (isset($DataObject['object_custom_rgb_' . $i])) {
					$value = aveEscT(substr(trim($DataObject['object_custom_rgb_' . $i]), 1));
					$sql = $sql . " " . $Table . "_custom_rgb_" . $i . " = '" . $value . "',";
				}
			}
			elseif ($EffectiveType == 'group_field_name') {
				if (isset($DataObject['product_category_group_field_name_' . $i])) {
					$value = aveEscT($DataObject['product_category_group_field_name_' . $i]);
					$sql = $sql . " " . $Table . "_group_field_name_" . $i . " = '" . $value . "',";
				}
			}
			else {
				if (isset($DataObject[$Table . '_custom_' . $EffectiveType . '_' . $i]))
					$sql = $sql . " " . $Table . "_custom_" . $EffectiveType . "_" . $i . " = '". aveEscT($DataObject[$Table . '_custom_' . $EffectiveType . '_' . $i]) . "',";
			}
		}
		return $sql;
//		return substr($sql, 0, -1);
	}
	
	function GetObjectPreviewKey($ObjID, $SiteApiKey) {
		return md5('cMs aVEego PreVieW kEy' . $SiteApiKey . $ObjID);
	}

	function GetLock($LockName, $Timeout = 30) {
		$query =	"	SELECT GET_LOCK('" . aveEscT($LockName) . "', " . intval($Timeout) . ") ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	function ReleaseLock($LockName) {
		$query =	"	SELECT RELEASE_LOCK('" . aveEscT($LockName) . "') ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}
	
	function copyObjProperty($FromObj, $ToObj, $PropertyListObj) {
		foreach (get_object_vars($PropertyListObj) as $key => $value) {
			$ToObj->{$key} = $FromObj->{$key};
		}
	}
	
	function chopObjProperty($Obj) {
		$ClassName = get_class($Obj);
		$ClassPropertyList = array_keys(get_class_vars($ClassName));
		foreach (get_object_vars($Obj) as $key => $val) {
			if (!in_array($key, $ClassPropertyList)) {
				unset($Obj->{$key});
			}
		}
	}
	
	function isNumeric($txt) {
	return (preg_match('/^(([1-9]*)|(([1-9]*|0)\.([0-9]*)))$/', trim($txt)) == 1);
}
?>