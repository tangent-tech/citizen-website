The following form was sent from {$Site->site->site_name} <br />
<table>
{foreach from=$smarty.post key=k item=v}
	{if strval($k) != 'captcha' && strval($k) != 'return_link_id'}
		<tr>
			<td>{$k}:</td>
			<td>{$v}</td>
		</tr>
	{/if}
{/foreach}
</table>