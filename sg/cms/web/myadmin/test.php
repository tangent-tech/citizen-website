<?php
define('IN_CMS', true);
require_once('../common/config.php');
require_once('../common/common.php');
require_once('../common/function.php');

class clsBB {
	public $clsAA = null;
	
	public function __construct(clsAA $clsAA = null) {
		$this->clsAA = $clsAA;
	}
	
	public function dump() {
		print_r($this->clsAA);
	}
}

class clsAA {
	public function __construct() {
		echo "clsAA construct called";
	}
	
	public $a = 1;
	public $b = 2;
}

$clsAA = new clsAA();

$clsBB1 = new clsBB($clsAA);

$clsBB2 = new clsBB(null);

$clsBB1->clsAA->a = 99;

$clsBB1->dump();

$clsBB2->clsAA->a = 100;

$clsBB2->dump();


die();

cmSite::setCurCmSiteID(13);
$cmLangRoot = new cmLangRoot(16901);
print_r($cmLangRoot->getCmInfo());

die();

$cmObjectLink = new cmObjectLink(12817);

var_dump($cmObjectLink->getCmInfo());

die();

$LangInfo = cmLangInfo::getLangInfo(99);
var_dump($LangInfo);

die();

class clsC {
	public function __construct() {
		$this->data = new data();
	}
	
	public function printData() {
		print_r($this->data);
	}
	
	public function getData() {
		return $this->data;
	}
	
	private $data;
}

//$C = new clsC();
//$C->printData();
//$C->getData()->a = 100;
//$C->printData();



class data {
	public $a = 1;
	public $b = 2;
}

$C = new clsC();
$C->getData()->c = 100;
$C->printData();
chopObjProperty($C->getData());
$C->printData();

die();

class clsA {
	protected function callMethod() {
		echo "clsA::callMethod <br />";
	}
	
	protected function callBig() {
		echo "clsA::callBig <br />";
		$this->callMethod();
	}
}

class clsB extends clsA {
	public function callMethod() {
		echo "clsB::callMethod <br />";
	}
	
	public function callBig() {
		echo "clsB::callBig <br />";
		parent::callBig();
		$this->callMethod();
	}
}

$clsB = new clsB();

$clsB->callBig();


die();

$album = new cmAlbum(16981);

var_dump($album->getCmInfo());



die();

$Site = site::GetSiteInfo(1);

$SiteRoot = object::GetObjectInfo($Site['site_root_id']);

object::UpdateStructuredSeoURL($SiteRoot, 0, $Site);

die();

$TheObject = product::GetProductGroupCacheObj(14672, 0);

var_dump($TheObject);

die();

$_SESSION['KCFINDER'] = array(
    'disabled' => false,
//	'uploadURL' => "/users/" . $user['username'] . "/upload",
   'uploadDir' => "userfiles"
);

die();

var_dump(product::IsProductUnderProductCategory(14663, 920, 'Y') == true); // HTC Desire 3
var_dump(product::IsProductUnderProductCategory(14663, 920, 'N') == true); // HTC Desire 3

var_dump(product::IsProductUnderProductCategory(932, 920, 'Y') == true); // Motorola Milestone 2
var_dump(product::IsProductUnderProductCategory(932, 920, 'N') == false); // Motorola Milestone 2

var_dump(product::IsProductUnderProductCategory(938, 920, 'Y') == true); // Sony Ericsson Xperia X8
var_dump(product::IsProductUnderProductCategory(938, 920, 'N') == false); // Sony Ericsson Xperia X8


//var_dump(product::GetProductGroupValidFieldList(1));
//product::DeleteProductCatRecursive(924, 1);

//	AND OL.object_link_is_shadow = 'N'

// SELECT * FROM object_link OL JOIN object O ON (OL.object_id = O.object_id) JOIN product P ON (P.product_id = O.object_id) WHERE O.object_type != 'PRODUCT'

// SELECT * FROM product_category C LEFT JOIN object_link OL ON (OL.object_id = C.product_category_id) WHERE OL.object_id IS NULL

//SELECT O.*, MIN(P.product_price) AS min_price FROM 
//	object_link OL	JOIN object O	ON (OL.object_id = O.object_id)
//					JOIN product P	ON (P.product_id = O.object_id)
//WHERE OL.parent_object_id = 920
//GROUP BY OL.shadow_parent_id
//ORDER BY min_price

?>
