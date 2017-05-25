<?php

class cmLangInfo {
	public $language_id;
	public $language_shortname;
	public $language_longname;
	public $language_native;
	public $paydollar_code;
	
	public static function getLangInfo($LangID) {
		$query = "	SELECT * FROM language WHERE language_id = '" . intval($LangID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
		return $result->fetch_object('cmLangInfo');
	}
}