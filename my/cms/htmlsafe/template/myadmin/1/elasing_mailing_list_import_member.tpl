{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_elasing.tpl"}
<h1 class="PageTitle">Import Members &nbsp;
	<a href="elasing_mailing_list.php" class="ui-state-default ui-corner-all MyButton"><span class="ui-icon ui-icon-arrowreturnthick-1-e"></span>Mailing List</a>
</h1>
<p>
	Imported Address:	{$ImportContact} <br />
	Invalid	Address:	{$InvalidContact} <br />
	<br />
	<a href="elasing_mailing_list_edit.php?id={$smarty.request.id}" class="ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Back
	</a>
</p>

<br class="clearfloat" />
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
