<?php

class store_location {

	public static function GetAreaListGroupByAreaParentID($AreaParentID, $AreaID, $SearchText, $IsBroadWayOnly = false) {
		
		$SearchSQL = "";
		if(intval($AreaParentID) > 0){
			$SearchSQL .= " AND A.area_parent_id = '" . intval($AreaParentID) . "'";
		}
		if(intval($AreaID) > 0){
			$SearchSQL .= " AND A.area_list_id = '" . intval($AreaID) . "'";
		}
		
		if($SearchSQL != "")
			$SearchSQL = " WHERE " . substr($SearchSQL, 4);

		$AreaList = array();

		$query = " SELECT * FROM	area_list A " .
				 $SearchSQL .
				 " ORDER BY	A.area_parent_id ASC, A.area_list_id ASC";
		$result = ave_mysql_query($query, __FILE__, __LINE__, true);
		
		while($row = $result->fetch_assoc()){
			
			if( !is_array($AreaList[$row["area_parent_id"]]) )
				$AreaList[$row["area_parent_id"]] = array();
			
			$Temp = array();
			$Temp = self::GetStoreLocationListByAreaID($row["area_list_id"], $SearchText, $IsBroadWayOnly);
			
			if(count($Temp) > 0){
				$row['store_location'] = $Temp;
				$AreaList[$row["area_parent_id"]][] = $row;
			}

		}
		
		//Handle Macau
//		if( intval($AreaParentID) == 0 || intval($AreaParentID) == 5 ){
//		
//			$Temp = array();
//			$AreaList[5] = array();
//			$Temp['store_location'] = self::GetMacauStoreList($SearchText);
//
//			if($Temp['store_location'] != null)
//				$AreaList[5][] = $Temp;
//		
//		}
				
		return $AreaList;

	}
	
	public static function GetStoreLocationListByAreaID($AreaID, $SearchText, $IsBroadWayOnly = false){
		
		/***
		 * According to .com.hk
		 * Default store on broadway not is searchable
		 */
		
		$SearchSQL = "";
		if($IsBroadWayOnly) {
			$IsBroadwaySearchSQL = " AND is_broadway = '" . 1 . "'";
		}
		else if (strlen(trim($SearchText)) == 0) {
			$IsBroadwaySearchSQL = " AND is_broadway = '" . 0 . "'";			
		}
		else if (strlen(trim($SearchText)) > 0) {
			$IsBroadwaySearchSQL = "";
			$SearchSQL .= " AND	( S.store_location_name_en LIKE '%" . trim($SearchText) . "%'";
			$SearchSQL .= " OR		S.store_location_name_tc LIKE '%" . trim($SearchText) . "%'";
			$SearchSQL .= " OR		S.store_location_tel_no LIKE '%" . trim($SearchText) . "%'";
			$SearchSQL .= " OR		S.store_location_address_en LIKE '%" . trim($SearchText) . "%'";
			$SearchSQL .= " OR		S.store_location_address_tc LIKE '%" . trim($SearchText) . "%' )";
		}

		$StoreLocationList = array();
		
		$query = " SELECT * FROM	store_location S " .
				 " WHERE			S.area_list_id = '" . intval($AreaID) . "'" . 
				 $IsBroadwaySearchSQL .
				 $SearchSQL .
				 " ORDER BY			S.store_location_id ASC";
		$result = ave_mysql_query($query, __FILE__, __LINE__, true);
		
		while($row = $result->fetch_assoc()){
			
			//$row['search_key_tc'] = AddressTcMakeGoogleSearchKey($row['store_location_address_tc']);
			//echo $row['search_key_tc'] . "<br/>";
			
			//self::UpdateStoreLocationSearchKey($row['search_key_tc'], $row['store_location_id']);
			
			$StoreLocationList[] = $row;

		}
		return $StoreLocationList;
	}
	
	public static function GetMacauStoreList($SearchText){
		
		$SearchSQL = "";
		if(strlen(trim($SearchText)) > 0){
			$SearchSQL .= " AND	( S.store_location_name_en LIKE '%" . trim($SearchText) . "%'";
			$SearchSQL .= " OR		S.store_location_name_tc LIKE '%" . trim($SearchText) . "%'";
			$SearchSQL .= " OR		S.store_location_tel_no LIKE '%" . trim($SearchText) . "%'";
			$SearchSQL .= " OR		S.store_location_address_en LIKE '%" . trim($SearchText) . "%'";
			$SearchSQL .= " OR		S.store_location_address_tc LIKE '%" . trim($SearchText) . "%' )";
		}
		
		/***
		 * According to .com.hk
		 * Default store on broadway not is searchable
		 */
		$StoreLocationList = array();
		
		$query = " SELECT * FROM	store_location S " .
				 " WHERE			S.area_list_id = '" . intval(MACAU_STORE_AREA_LIST_ID) . "'" . 
				 " AND				is_broadway = '" . 0 . "'" .
				 $SearchSQL .
				 " ORDER BY			S.store_location_id ASC";
		$result = ave_mysql_query($query, __FILE__, __LINE__, true);
		
		if($result->num_rows > 0){
		
			while($row = $result->fetch_assoc()){

				$row['search_key_tc'] = AddressTcMakeGoogleSearchKey($row['store_location_address_tc']);
				//echo $row['search_key_tc'] . "<br/>";
				$StoreLocationList[] = $row;

			}
			return $StoreLocationList;
		
		}
		else 
			return null;
	}
	
	public static function GetBroadwayStoreList($SearchText){
		
		$StoreLocationList = array();
		
		$query = " SELECT * FROM	store_location S " .
				 " WHERE		(	store_location_name_en		LIKE '%" . $SearchText . "%'" .
				 " OR				store_location_name_tc		LIKE '%" . $SearchText . "%' )" .
				 " AND				is_broadway					= '" . 1 . "'" .
				 " ORDER BY			S.store_location_id ASC";
		$result = ave_mysql_query($query, __FILE__, __LINE__, true);
		
		while($row = $result->fetch_assoc()){
			
			if( !is_array($StoreLocationList[intval($row['broadway_area_parent_id'])]) )
				$StoreLocationList[intval($row['broadway_area_parent_id'])] = array();
			
			$row['search_key_tc'] = AddressTcMakeGoogleSearchKey($row['store_location_address_tc']);
			
			array_push($StoreLocationList[intval($row['broadway_area_parent_id'])], $row);
			
		}
		return $StoreLocationList;
	}
	
	public static function GetDistrictList($AreaParentID){
		
		$AreaList = array();

		$query = " SELECT * FROM	area_list A " .
				 " WHERE A.area_parent_id = '" . intval($AreaParentID) . "'" .
				 " ORDER BY	A.area_list_id ASC";
		$result = ave_mysql_query($query, __FILE__, __LINE__, true);
		
		while($row = $result->fetch_assoc()){
			$AreaList[] = $row;
		}
		return $AreaList;
	}

//	public static function UpdateStoreLocationSearchKey($GoogleKey, $ID){
//		
//		$query = " UPDATE			store_location " .
//				 " SET				store_location_google_key_tc	= '" . trim($GoogleKey) . "'" . 
//				 " WHERE			store_location_id				= '" . intval($ID) . "'";
//		$result = ave_mysql_query($query, __FILE__, __LINE__, true);
//		
//	}
	
}

?>