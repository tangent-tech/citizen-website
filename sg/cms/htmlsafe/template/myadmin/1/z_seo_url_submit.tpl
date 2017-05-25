{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_z_seo.tpl"}
<h1 class="PageTitle">SEO Submit URL &nbsp;</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="z_seo_url_submit_act.php">
		<div class="AdminEditDetailsBlock">
			<table class="LeftHeaderTable">
				<tr>
					<th>Keyword</th>
					<td><input type="text" name="keyword" value="網頁設計, 設計" /></td>
				</tr>
				<tr>
					<th>New URL:</th>
					<td><input type="text" name="new_url" value="" /></td>
				</tr>		
			</table>
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
