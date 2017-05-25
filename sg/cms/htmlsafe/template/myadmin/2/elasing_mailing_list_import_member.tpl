{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_elasing.tpl"}
<h1 class="PageTitle">匯入會員 &nbsp;
	<a href="elasing_mailing_list.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>電郵名單</a>
</h1>
<p>
	匯入地址:	{$ImportContact} <br />
	無效地址:	{$InvalidContact} <br />
	<br />
	<a href="elasing_mailing_list_edit.php?id={$smarty.request.id}" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 回上頁
	</a>
</p>

<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
