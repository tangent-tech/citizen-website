<?php
//	Please do NOT think this as an OOP object, I just use the class to group the related functions...
//	mysqli: DONE
//	magic_quote OFF: DONE

if (!defined('IN_CMS'))
	die("huh?");

class wishlist {
	public function __construct() {
		die('Do not create me. I am not an object!');
	}

	public static function AddProductToWishlist($ProductID, $UserID, $ProductOptionID = 0) {
		$query =	"	INSERT INTO wishlist " .
					"	SET		product_id				= '" . intval($ProductID) . "', " .
					"			product_option_id		= '" . intval($ProductOptionID) . "', " .
					"			user_id					= '" . intval($UserID) . "' " .
					"	ON DUPLICATE KEY UPDATE	user_id = '" . intval($UserID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function RemoveProductFromWishlist($ProductID, $UserID, $ProductOptionID = 0) {
		$query =	"	DELETE FROM wishlist " .
					"	WHERE	user_id					= '" . intval($UserID) . "' " .
					"		AND product_id				= '" . intval($ProductID) . "' " .
					"		AND	product_option_id		= '" . intval($ProductOptionID) . "'";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);
	}

	public static function GetWishlistList($UserID, $LanguageID, $CurrencyID, $UserSecurityLevel = 0) {
		$smarty = new mySmarty();
		$query =	"	SELECT		*, W.*, P.*, OL.*, O.*, L.* " .
					"	FROM		language L	JOIN product P						ON	(L.language_id = '" . intval($LanguageID) . "') " .
					"							JOIN wishlist W						ON	(P.product_id = W.product_id) " .
					"							JOIN object O						ON	(O.object_id = P.product_id) " .
					"							JOIN object_link OL 				ON	(O.object_id = OL.object_id AND OL.object_link_is_shadow = 'N') " .
					"							JOIN object PO 						ON	(OL.parent_object_id = PO.object_id) " .
					"							LEFT JOIN product_data D			ON	(D.language_id = L.language_id AND P.product_id = D.product_id) " .
					"							LEFT JOIN product_option POO		ON	(W.product_option_id = POO.product_option_id AND W.product_id = POO.product_id) " .
					"							LEFT JOIN product_option_data POD	ON	(POD.language_id = L.language_id AND W.product_option_id = POD.product_option_id) " .
					"	WHERE		O.object_is_enable = 'Y' " .
					"			AND O.object_security_level <= '" . intval($UserSecurityLevel) . "'" . $sql .
					"			AND	W.user_id = '" . intval($UserID) . "'" .
					"			AND	( PO.object_type = 'PRODUCT_ROOT' OR PO.object_type = 'PRODUCT_CATEGORY' ) " . $inventory_sql . 
					"	GROUP BY	P.product_id, W.product_option_id " .
					"	ORDER BY	W.wishlist_id DESC, P.product_id ASC ";
		$result = ave_mysqli_query($query, __FILE__, __LINE__, true);

		$XML = '';

		while ($myResult = $result->fetch_assoc()) {
			$myResult['object_seo_url'] = object::GetSeoURL($myResult, '', $LanguageID, null);
			$smarty->assign('Object', $myResult);
			$ProductXML = '<product>' . $smarty->fetch('api/object_info/PRODUCT.tpl') . '</product>';
			$XML = $XML . $ProductXML;
		}

		return "<product_list>" . $XML . "</product_list>";
	}
}