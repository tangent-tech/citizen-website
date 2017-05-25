{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_currency.tpl"}
	<div class="InnerContainer ui-widget ui-corner-all">
		<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Currency In Use</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<p>* Please set the base currency rate to 1 (i.e. The currency you enter for the product price.)</p>

			{if $SiteCurrencyList|@count == 0}
				<p>No currency is in use now.</p>
			{else}
				<table class="TopHeaderTable ui-helper-reset">
					<tr>
						<th>Currency Name</th>
						<th>Rate</th>
						<th></th>
					</tr>
					{foreach from=$SiteCurrencyList item=C}
						<tr>
							<td class="AlignCenter" width="300">{$C.currency_longname|escape:'html'} ({$C.currency_shortname|escape:'html'})</td>
							<td class="AlignCenter" width="100">{$C.currency_site_rate}</td>
							<td>
								<a href="currency_edit.php?id={$C.currency_id}" class="ui-state-default ui-corner-all MyButton">
									<span class="ui-icon ui-icon-pencil"></span> Edit
								</a>
								<a href="currency_delete.php?id={$C.currency_id}" onclick='return confirm("WARNING! \n Are you sure you want to delete?")' class="ui-state-default ui-corner-all MyButton">
									<span class="ui-icon ui-icon-trash"></span> delete
								</a>
							</td>
						</tr>
					{/foreach}
				</table>
			{/if}
			<br class="clearfloat" />
		</div>
	</div>
	<div class="InnerContainer ui-widget ui-corner-all">
		<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Currency Not In Use</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<table class="TopHeaderTable ui-helper-reset">
				{foreach from=$SiteCurrencyListNotEnabled item=C}
					<tr>
						<td class="AlignCenter" width="300">{$C.currency_longname|escape:'html'} ({$C.currency_shortname|escape:'html'})</td>
						<td>
							<a href="currency_add.php?id={$C.currency_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-circle-plus"></span> Add
							</a>
						</td>
					</tr>
				{/foreach}
			</table>
			<br class="clearfloat" />
		</div>
	</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
