<?php

die("EXIT");

define('IN_CMS', true);
require_once('./common/config.php');
require_once('./common/common.php');

$SecurityLevel				= 0;
$LayoutID					= 273306;
$LayoutNewsRootID_EN		= 272632;
$LayoutNewsRootID_TC		= 277353;

$LayoutNewsTitleBlockDefID  = 273317;
$ShortContentBlockDefID		= 273318;
$ContentBlockDefID			= 273346;

$GroupID = array(
	29 => 278519,		//最新消息 (TC),		- 宣傳		- CITIZEN銅鑼灣專賣店開幕典禮
	30 => 272670,		//What's New (EN),	- Promotion - CITIZEN銅鑼灣專賣店開幕典禮
	31 => 278518,		//Events (EN),		- Promotion - MTR Hong Kong Race Walking 2009
	32 => 278520		//贊助活動 (TC),		- 宣傳		- 渣打馬拉松2013
	//34 <- for test only 1 article
);

$ImportCount = 0;

$query = " SELECT * FROM module_articles" .
		 " WHERE	is_published	= 1" .
		 " AND		group_id		!= 34" .
		 " AND		article_id > 736" .
		 " ORDER BY article_id ASC";
$result = ave_mysql_query($query, __FILE__, __LINE__, true);

while($row = $result->fetch_assoc()){

	//is_published			=> check. checked 380 = 1 , 32 = 0
	//new_window			=> check. checked all 0
	//pending				=> check. checked all 0

	//excerpt			= short content
	//content			= main content
	//publishing_date	= layout_news_date

	var_dump($row);
	
	$LayoutNewsAddPara = array();
	$LayoutNewsAddPara['security_level']			= $SecurityLevel;
	$LayoutNewsAddPara['object_meta_title']			= $row["title"];
	$LayoutNewsAddPara['object_friendly_url']		= $row["uripart"];
//	$LayoutNewsAddPara['object_lang_switch_id']		= '';
	
	if($row["language"] == "EN"){
		$LayoutNewsAddPara['layout_news_root_id'] = $LayoutNewsRootID_EN;
	}
	else if ($row["language"] == "TC"){
		$LayoutNewsAddPara['layout_news_root_id'] = $LayoutNewsRootID_TC;
	}
	
	$LayoutNewsAddPara['layout_news_category_id']	= $GroupID[$row['group_id']];
	$LayoutNewsAddPara['layout_news_title']			= $row["title"];
	$LayoutNewsAddPara['layout_news_date']			= $row["publishing_date"];
	$LayoutNewsAddPara['layout_id']					= $LayoutID;
	
	$LayoutNewsAddResult = ApiQuery('obj_man/layout_news_add.php', __LINE__, '', false, false, $LayoutNewsAddPara);
	
	if($LayoutNewsAddResult->result == "Success"){
		
		$LayoutNewsID = intval($LayoutNewsAddResult->layout_news_id);
		
		$LayoutNewsBlockAddPara = array();
		$LayoutNewsBlockAddPara['layout_news_id']			= $LayoutNewsID;
		$LayoutNewsBlockAddPara['security_level']			= $SecurityLevel;
		$LayoutNewsBlockAddPara['empty_all_block_content']	= 'N';

		$LayoutNewsBlockAddPara['block_def_id']		= $LayoutNewsTitleBlockDefID;
		$LayoutNewsBlockAddPara['block_content']	= $row["title"];
		$LayoutNewsTitleBlockAddResult = ApiQuery('obj_man/layout_news_block_add.php', __LINE__, '', false, false, $LayoutNewsBlockAddPara);
		if($LayoutNewsTitleBlockAddResult->result != "Success"){
			echo "Add Block Fail<br/>";
			var_dump($LayoutNewsAddPara);
			var_dump($LayoutNewsBlockAddPara);
			var_dump($LayoutNewsTitleBlockAddResult);
			die();
		}

		if(trim($row["excerpt"]) != ""){
		
			$LayoutNewsBlockAddPara['block_def_id']		= $ShortContentBlockDefID;
			$LayoutNewsBlockAddPara['block_content']	= $row["excerpt"];
			$ShortContentBlockAddResult = ApiQuery('obj_man/layout_news_block_add.php', __LINE__, '', false, false, $LayoutNewsBlockAddPara);
			if($ShortContentBlockAddResult->result != "Success"){
				echo "Add Block Fail<br/>";
				var_dump($LayoutNewsAddPara);
				var_dump($LayoutNewsBlockAddPara);
				var_dump($ShortContentBlockAddResult);
				die();
			}
		
		}
		
		$LayoutNewsBlockAddPara['block_def_id']		= $ContentBlockDefID;
		$LayoutNewsBlockAddPara['block_content']	= $row["content"];
		$ContentBlockAddResult = ApiQuery('obj_man/layout_news_block_add.php', __LINE__, '', false, false, $LayoutNewsBlockAddPara);
		if($ContentBlockAddResult->result != "Success"){
			echo "Add Block Fail<br/>";
			var_dump($LayoutNewsAddPara);
			var_dump($LayoutNewsBlockAddPara);
			var_dump($ContentBlockAddResult);
			die();
		}
	
		$ImportCount++;
		echo "Import Success";
		
	}
	else {
		echo "Add News Fail<br/>";
		var_dump($LayoutNewsAddPara);
		var_dump($LayoutNewsAddResult);
		die();
	}
	
	echo "<hr/>";
	//die();
	
}

echo "Total Import:" . $ImportCount;
 ?>