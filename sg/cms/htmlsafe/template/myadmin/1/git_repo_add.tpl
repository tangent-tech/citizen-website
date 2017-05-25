{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">Add Git Repo &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="git_repo_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Git Repo List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Git Details</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="git_repo_add_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr>
						<th colspan="2" class="ui-state-highlight AlignCenter">Linux User must be unique</th>
					</tr>
					<tr>
						<th>
							Git Repo Name <br />
							(recommend to use domain name)
						</th>
						<td> <input type="text" name="git_repo_name" value="{$smarty.request.git_repo_name}" size="50" /> </td>
					</tr>
					<tr>
						<th> Linux User (e.g. web123) </th>
						<td> <input type="text" name="git_repo_linux_user" value="{$smarty.request.git_repo_linux_user}" size="50" /> </td>
					</tr>
					<tr>
						<th> Auto Deploy On Push</th>
						<td>
							<input type="radio" name="git_repo_auto_deploy_on_push" value="Y" {if $smarty.request.git_repo_auto_deploy_on_push == 'Y'}checked=checked{/if} /> Yes 
							<input type="radio" name="git_repo_auto_deploy_on_push" value="N" {if $smarty.request.git_repo_auto_deploy_on_push == 'N'}checked=checked{/if} /> No						
						</td>
					</tr>
				</table>
			</div>
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
