{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}

<h1 class="PageTitle">語言結構樹複製</h1>

<p>
注: 你必須先新增有關之語言結構樹後才可複製。複製目標之結構樹會添加新的內容，舊內容不會被覆蓋。
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
		<span class="ui-icon ui-icon-check"></span> 確定
	</a>
</form>


{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
