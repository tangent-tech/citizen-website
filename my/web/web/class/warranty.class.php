<?php

class warranty {

	public static function GenerateRefNo(){
		
		//return  uniqid("HK",false);
		
		/***
		 * Format: dmY His
		 */
		return date("dmy-His");
	}
	
	public static function SaveWarrantyFormPartOne($requestData){
		
		$q6_reason_pur_string = "";
		$q6_reason_pur_string = self::CheckboxMultipleAnswerToString($requestData["q6_reason_pur"], $requestData["q6_reason_pur_other"]);
		
		$q7_location_pur_string = "";
		$q7_location_pur_string = self::CheckboxMultipleAnswerToString($requestData["q7_location_pur"], $requestData["q7_location_pur_other"]);
		
		$q8_channel_info_string = "";
		$q8_channel_info_string = self::CheckboxMultipleAnswerToString($requestData["q8_channel_info"], $requestData["q8_channel_info_other"]);

		$q9_brands_want_string = "";
		$q9_brands_want_string = self::CheckboxMultipleAnswerToString($requestData["q9_brands_want"], $requestData["q9_brands_want_other"]);

		$ref_date = date("Y-m-d");
		
		$query = " INSERT INTO	`warranty`" .
				 " SET			q1_sex			= '" . customdb::escape(trim($requestData["q1_sex"])) . "'" .
				 " ,			q2_age			= '" . customdb::escape(trim($requestData["q2_age"])) . "'" .
				 " ,			q3_education	= '" . customdb::escape(trim($requestData["q3_education"])) . "'" .
				 " ,			q4_occupation	= '" . customdb::escape(trim($requestData["q4_occupation"])) . "'" .
				 " ,			q5_income		= '" . customdb::escape(trim($requestData["q5_income"])) . "'" .
				 " ,			q6_reason_pur	= '" . customdb::escape(trim($q6_reason_pur_string)) . "'" .
				 " ,			q7_location_pur	= '" . customdb::escape(trim($q7_location_pur_string)) . "'" .
				 " ,			q8_channel_info	= '" . customdb::escape(trim($q8_channel_info_string)) . "'" .
				 " ,			q9_brands_want	= '" . customdb::escape(trim($q9_brands_want_string)) . "'" .
				 " ,			ref_date		= '" . $ref_date . "'" .
				 " ,			status			= 'pending'";
		$result = ave_mysql_query($query, __FILE__, __LINE__, true);
		
		return customdb::mysqli()->insert_id;
	}
	
	public static function SaveWarrantyFormPartTwo($requestData, $warrantyID){
		
		$RelNo = self::GenerateRefNo();
		
		$query = " UPDATE		`warranty`" .
				 " SET			case_no_a		= '" . customdb::escape(trim($requestData["case_no_a"])) . "'" .
				 " ,			case_no_b		= '" . customdb::escape(trim($requestData["case_no_b"])) . "'" .
				 " ,			manu_no			= '" . customdb::escape(trim($requestData["manu_no"])) . "'" .
				 " ,			model_no_a		= '" . customdb::escape(trim($requestData["model_no_a"])) . "'" .
				 " ,			model_no_b		= '" . customdb::escape(trim($requestData["model_no_b"])) . "'" .
				 " ,			pur_date_y		= '" . customdb::escape(trim($requestData["date_y"])) . "'" .
				 " ,			pur_date_m		= '" . customdb::escape(trim($requestData["date_m"])) . "'" .
				 " ,			pur_date_d		= '" . customdb::escape(trim($requestData["date_d"])) . "'" .
				 " ,			ret_name		= '" . customdb::escape(trim($requestData["retailer_name"])) . "'" .
				 " ,			ret_reg			= '" . customdb::escape(trim($requestData["retailer_reg"])) . "'" .
				 " ,			ret_add			= '" . customdb::escape(trim($requestData["retailer_add"])) . "'" .
				 " ,			owner_name		= '" . customdb::escape(trim($requestData["owner_name"])) . "'" . 
				 " ,			contact_no		= '" . customdb::escape(trim($requestData["contact_no"])) . "'" . 
				 " ,			email			= '" . customdb::escape(trim($requestData["email_add"])) . "'" . 
				 " ,			is_subscribe	= '" . intval($requestData["is_subscribe"]) . "'" . 
				 " ,			ref_no			= '" . $RelNo . "'" . 
				 " WHERE		id				= '" . intval($warrantyID) . "'";
		$result = ave_mysql_query($query, __FILE__, __LINE__, true);

		return true;
	}
	
	public static function CancelWarrantyRegister($warrantyID){
		
		$query = " UPDATE `warranty`" .
				 " SET status = 'cancel'" .
				 " WHERE id ='" . intval($warrantyID) . "'";
		
		$result = ave_mysql_query($query, __FILE__, __LINE__, true);
		return true;
	}
	
	public static function ConfirmWarrantyRegister($warrantyID){
		
		$query = " UPDATE `warranty`" .
				 " SET status = 'confirm'" .
				 " WHERE id ='" . intval($warrantyID) . "'";
		
		$result = ave_mysql_query($query, __FILE__, __LINE__, true);
		return true;
	}
	
	public static function GetWarrantyDetailByID($warrantyID){
		
		$query = " SELECT * FROM `warranty`" .
				 " WHERE	id = '" . intval($warrantyID) . "'";
		$result = ave_mysql_query($query, __FILE__, __LINE__, true);
		
		return $result->fetch_assoc();
	}
	
	public static function CheckboxMultipleAnswerToString($requestDataAnswer, $requestOtherSpec = null){
		
		$MultipleAnswerString = "";
		$MultipleOthersAnswerString = "";
		
		if(count($requestDataAnswer) > 0 && is_array($requestDataAnswer)){
			foreach($requestDataAnswer as $D){
				
				if((trim($D) == "Others" || trim($D) == "其他") && $requestOtherSpec != null){
					
					$MultipleOthersAnswerString .= "," . trim($D) . "(" . trim($requestOtherSpec) . ")";
					
				}
					
				else
					$MultipleAnswerString .= "," . trim($D);
				
			}
			
			$MultipleAnswerString .= $MultipleOthersAnswerString;
			$MultipleAnswerString = substr($MultipleAnswerString, 1);
		}
		else {
			
			if(trim($requestDataAnswer) == "Others" || trim($requestDataAnswer) == "Other" || trim($requestDataAnswer) == "其他")
				$MultipleAnswerString .= trim($requestDataAnswer) . "(" . trim($requestOtherSpec) . ")";

			else
				$MultipleAnswerString .= trim($requestDataAnswer);

		}
		
		return $MultipleAnswerString;
	}
	
	public static function GetConfirmWarrantyListToExcel(){
		
		$ConfirmWarrantyList = array();
		
		$query = " SELECT * FROM `warranty`" .
				 //" WHERE status = 'confirm'" .
				 " ORDER BY id DESC";
		$result = ave_mysql_query($query, __FILE__, __LINE__, true);
		
		while($row = $result->fetch_assoc()){
			array_push($ConfirmWarrantyList, $row);
		}
		return $ConfirmWarrantyList;
	}
	
}

?>