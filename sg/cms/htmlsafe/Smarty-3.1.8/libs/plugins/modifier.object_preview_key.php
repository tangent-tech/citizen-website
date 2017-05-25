<?php

function smarty_modifier_object_preview_key($ObjID, $SiteApiKey)
{
   	return md5('cMs aVEego PreVieW kEy' . $SiteApiKey . $ObjID);
}

?>
