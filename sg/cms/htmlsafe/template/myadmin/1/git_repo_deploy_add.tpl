{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">Add Git Deploy Point &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="git_repo_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Git Repo List
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="git_repo_edit.php?git_repo_id={$smarty.request.git_repo_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Edit Git Repo
	</a>
</h1>

<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Git Deploy Details</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="git_repo_deploy_add_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr>
						<th>
							Git Deploy Name <br />
							(recommend to use domain name)
						</th>
						<td> <input type="text" name="git_repo_deploy_name" value="{$smarty.request.git_repo_deploy_name}" size="50" /> </td>
					</tr>
					<tr>
						<th> Linux User of the deploy point (e.g. web123) </th>
						<td> <input type="text" name="git_repo_deploy_linux_user" value="{$smarty.request.git_repo_deploy_linux_user}" size="50" /> </td>
					</tr>
					<tr>
						<th>
							Branch Name <br />
							(Make sure the branch name is correct. System cannot check correctness here.)
						</th>
						<td> <input type="text" name="git_repo_deploy_branch" value="master" size="50" /> </td>
					</tr>
				</table>
			</div>
			<input type="hidden" name="git_repo_id" value="{$smarty.request.git_repo_id}" />
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