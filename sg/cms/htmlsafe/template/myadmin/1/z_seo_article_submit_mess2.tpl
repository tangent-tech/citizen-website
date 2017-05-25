{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_z_seo.tpl"}
<h1 class="PageTitle">SEO Submit Article &nbsp;</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="z_seo_article_submit_mess2_act.php">
		<div class="AdminEditDetailsBlock">
			<table class="LeftHeaderTable">
				<tr>
					<td><input type="text" name="content_subject_1" value="{$TCSubject}" /></td>
					<td><input type="text" name="content_subject_2" value="{$SCSubject}" /></td>
				</tr>
				<tr>
					<td><textarea name="content_input1" cols="60" rows="10">{$TCNewContent}</textarea></td>
					<td><textarea name="content_input2" cols="60" rows="10">{$NewContent}</textarea></td>
				</tr>
				<tr>
					<td><input type="radio" name="content_input_no" value="1" /></td>
					<td><input type="radio" name="content_input_no" value="2" /></td>
				</tr>
				<tr>
					<td><input type="text" name="keyword_input_1" value="{$TCKeyword}" /></td>
					<td><input type="text" name="keyword_input_2" value="{$SCKeyword}" /></td>
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
