{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}

<h1 class="PageTitle">Language Tree Copy</h1>

<p>
Note: You must create the language tree before copying. The new tree will be APPENDED to the language tree, NOT OVERWRITE.
</p>

<br />

<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="language_tree_copy_act.php">
	<select name="src_language_tree_id">
		{foreach from=$LanguageRootList item=L}<option value="{$L.language_id}">{$L.language_native|escape:'html'}</option>{/foreach}
	</select>	
	-&gt;
	<select name="dest_language_tree_id">
		{foreach from=$LanguageRootList item=L}<option value="{$L.language_id}">{$L.language_native|escape:'html'}</option>{/foreach}
	</select>
	<br />
	<br />
	<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
		<span class="ui-icon ui-icon-check"></span> Submit
	</a>
</form>


{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
