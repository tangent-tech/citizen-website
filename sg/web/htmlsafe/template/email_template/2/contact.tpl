The following form was sent from {$smarty.const.CLIENT_NAME} <br />
<table style="{ldelim}border: 1px solid #000; border-collapse: collapse;{rdelim}">
{foreach from=$smarty.post key=k item=v}
	<tr>
		<td style="{ldelim}border: 1px solid #000;{rdelim}">{$k}:</td>
		<td style="{ldelim}border: 1px solid #000;{rdelim}">{$v|nl2br}</td>
	</tr>
{/foreach}
</table>