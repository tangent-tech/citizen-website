{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_z_seo.tpl"}
<h1 class="PageTitle">SEO Submit Article &nbsp;</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="z_seo_article_generate_act.php">
		<div class="AdminEditDetailsBlock">
			<table class="LeftHeaderTable">
				<tr>
					<th>Subject</th>
					<td><input type="text" name="content_title" value="{$TheArticle.z_seo_article_title}" /></td>
				</tr>
				<tr>
					<th>Content</th>
					<td><textarea name="content_input1" cols="60" rows="10">{$TheContent}</textarea></td>
				</tr>
				<tr>
					<th>Keyword</th>
					<td><input type="text" name="keyword" value="{$TheArticle.z_seo_keyword}" /></td>
				</tr>
				<tr>
					<th>New URL:</th>
					<td><input type="text" name="new_url" value="" /></td>
				</tr>
			</table>
			<input type="hidden" name="article_id" value="{$TheArticle.z_seo_article_id}" />
			{foreach from=$URL_Used item=UU}
				<input type="hidden" name="url_id[]" value="{$UU.z_seo_url_id}" />
			{/foreach}
		</div>
		<div class="ui-widget-header ui-corner-bottom">
			<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> Submit
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-cancel"></span> Reset
			</a>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
