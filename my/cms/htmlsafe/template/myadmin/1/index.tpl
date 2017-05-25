{include file="myadmin/`$CurrentLang['language_id']`/header.tpl"}
<div id="LoginContainer" class="InnerContainer ui-widget ui-widget-content ui-corner-all">
	<h1 class="InnerHeader ui-widget-header ui-helper-reset ui-corner-top" >{$smarty.const.CMS_PRODUCT_NAME} Admin Panel</h1>
	<div id="LoginContainerContent" class="InnerContent ui-widget-content ui-helper-reset ui-corner-bottom">
		{if $ErrorMsg != ''}
			<div class="AdminError ui-state-error ui-corner-all" style="padding: 0pt 0.7em;">
				<p>
					<span class="ui-icon ui-icon-alert" style="float: left; margin-right: 0.3em;"></span>
					{$ErrorMsg}
				</p>
			</div>
		{/if}
		<form action="login.php" method="post">
			<p> <label for="email">Email:</label> <input type="text" name="email" id="email" value="{$smarty.request.email|escape:'html'}" /> </p>
			<p> <label for="password">Password:</label> <input type="password" name="password" id="password" /> </p>
			<input class="ui-state-default ui-corner-all MyInputButton" type="submit" value="LOGIN" />
			<input class="ui-state-default ui-corner-all MyInputButton" type="reset" value="RESET" />
		</form>	
	</div>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer.tpl"}
