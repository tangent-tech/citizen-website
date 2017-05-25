{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_super_admin.tpl"}
<h1 class="PageTitle">Edit Content Admin &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="content_admin_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Content Admin List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Content Admin Details</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="content_admin_edit_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr>
						<th>Status</th>
						<td>
							<input type="radio" name="content_admin_is_enable" value="Y" {if $TheContentAdmin.content_admin_is_enable == 'Y'}checked=checked{/if} /> Enable 
							<input type="radio" name="content_admin_is_enable" value="N" {if $TheContentAdmin.content_admin_is_enable == 'N'}checked=checked{/if} /> Disable						
						</td>
					</tr>
					<tr>
						<th> Email </th>
						<td> <input type="text" name="email" value="{$TheContentAdmin.email|escape:'html'}" /> </td>
					</tr>
					<tr>
						<th> Password </th>
						<td> <input type="password" name="password1" /> </td>
					</tr>
					<tr>
						<th> Retype Password</th>
						<td> <input type="password" name="password2" /> </td>
					</tr>
					<tr>
						<th> Site </th>
						<td>
							<select id="site_id" name="site_id">
								{foreach from=$Sites item=S}
								    <option value="{$S.site_id}"
										{if $S.site_id == $TheContentAdmin.site_id}selected="selected"{/if}
								    >{$S.site_name|escape:'html'}</option>
								{/foreach}
							</select>
						</td>
					</tr>
				</table>
			</div>
			<input type="hidden" name="id" value="{$TheContentAdmin.content_admin_id}" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
		</div>
		<div class="ui-widget-header ui-corner-bottom InnerHeader">
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
