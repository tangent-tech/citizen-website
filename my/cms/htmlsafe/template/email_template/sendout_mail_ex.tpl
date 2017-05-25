<p style="text-align: center;">
	<img src="{$smarty.const.BASEURL_ELASING}/tracker_getfile.php?ceid={$Subscriber.campaign_email_id}&key={$Subscriber.campaign_email_key}" /> <br />
	<a style="text-align: center;" href="{$smarty.const.BASEURL_ELASING}/tracker_get_link.php?ceid={$Subscriber.campaign_email_id}&key={$Subscriber.campaign_email_key}">
		<img style="text-align: center; border: 0" src="{$smarty.const.BASEURL_ELASING}/getfile.php?id={$ActiveCampaign.campaign_image_file_id}&ceid={$Subscriber.campaign_email_id}&key={$Subscriber.campaign_email_key}" />
	</a>
	<br />
	{$ActiveCampaign.campaign_content|nl2br} <br />
	<a style="text-align: center;" href="{$smarty.const.BASEURL_ELASING}/unsubscribe.php?ceid={$Subscriber.campaign_email_id}&key={$Subscriber.campaign_email_key}">Unsubscribe</a>
</p>