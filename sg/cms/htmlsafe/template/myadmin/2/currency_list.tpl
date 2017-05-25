{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_currency.tpl"}
	<div class="InnerContainer ui-widget ui-corner-all">
		<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">使用中的貨幣</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<p>* 請把基礎貨幣(即你在產品輸入之貨幣）設定為１ </p>

			{if $SiteCurrencyList|@count == 0}
				<p>沒有使用中之貨幣</p>
			{else}
				<table class="TopHeaderTable ui-helper-reset">
					<tr>
						<th>貨幣名稱</th>
						<th>匯率</th>
						<th></th>
					</tr>
					{foreach from=$SiteCurrencyList item=C}
						<tr>
							<td class="AlignCenter" width="300">{$C.currency_longname|escape:'html'} ({$C.currency_shortname|escape:'html'})</td>
							<td class="AlignCenter" width="100">{$C.currency_site_rate}</td>
							<td>
								<a href="currency_edit.php?id={$C.currency_id}" class="ui-state-default ui-corner-all MyButton">
									<span class="ui-icon ui-icon-pencil"></span> 編輯
								</a>
								<a href="currency_delete.php?id={$C.currency_id}" onclick='return confirm("警告! \n 確定刪除？")' class="ui-state-default ui-corner-all MyButton">
									<span class="ui-icon ui-icon-trash"></span> 刪除
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
		<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">並未使用的貨幣</h2>
		<div class="InnerContent ui-widget-content ui-corner-bottom">
			<table class="TopHeaderTable ui-helper-reset">
				{foreach from=$SiteCurrencyListNotEnabled item=C}
					<tr>
						<td class="AlignCenter" width="300">{$C.currency_longname|escape:'html'} ({$C.currency_shortname|escape:'html'})</td>
						<td>
							<a href="currency_add.php?id={$C.currency_id}" class="ui-state-default ui-corner-all MyButton">
								<span class="ui-icon ui-icon-circle-plus"></span> 新增
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
