{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_discount_rule.tpl"}
<h1 class="PageTitle">Product Tagging Status</h1>
<p>
	Note: You will need to run this after finish updating the discount rule and products. <br />
	As this is a very computation intensive task, we cannot do this after every update automatically. <br />
	<br />
</p>

{if $Site['site_discount_product_link_update_status'] == 'job_done'}
	<a href="discount_product_link_update_act.php" class="ui-state-default ui-corner-all MyButton" onclick="confirm('Are you sure?')">
		<span class="ui-icon ui-icon-gear"></span> Update product tagging
	</a>					
{else}
	<p>Updating product tags... Please wait...</p>
{/if}
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}