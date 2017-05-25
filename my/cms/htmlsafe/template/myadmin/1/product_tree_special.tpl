{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">Special Category &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="product_tree.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> {$Site.site_label_product|ucwords} Tree
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all">
	<div id="PRODUCT_TREE">
		<ul>
			<li rel="SITE_ROOT" id="OL_0" data-object_type="SITE_ROOT" data-object_link_id="0" data-object_id="{$Site.site_root_id}" data-object_system_flag="system"><a href="#"><ins>&nbsp;</ins></a>
				{$ProductTree}
			</li>
		</ul>
	</div>
	<br class="clearfloat" />
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
