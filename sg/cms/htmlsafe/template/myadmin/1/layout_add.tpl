{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">Add Layout &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="layout_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> Layout List
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">Layout Details</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_add_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr>
						<th> Layout Name </th>
						<td> <input type="text" name="layout_name" value="" /> </td>
					</tr>
					<tr>
						<th> Layout Preview Image </th>
						<td> <input type="file" name="layout_file" /> </td>
					</tr>
				</table>
				<hr />
			<table class="TopHeaderTable">
				<tr class="ui-state-highlight">
					<th class="AlignCenter" width="">Block Name</th>
					<th class="AlignCenter" width="">Block Description</th>
					<th class="AlignCenter" width="80">Block Type</th>
					<th class="AlignCenter" width="80">Image Width</th>
					<th class="AlignCenter" width="80">Image Height</th>
				</tr>
				{section name=foo loop=5} 
					<tr>
						<td class="AlignCenter"><input size="32" type="text" name="object_name[]" value="" /></td>
						<td class="AlignCenter"><input size="50" type="text" name="block_definition_desc[]" value="" /></td>
						<td class="AlignCenter">
							<select name="block_definition_type[]">
								<option value="text">text</option>
								<option value="textarea">textarea</option>
								<option value="html">html</option>
								<option value="image">image</option>
								<option value="file">file</option>
							</select>
						</td>
						<td class="AlignCenter"><input size="3" type="text" name="block_image_width[]" value="300" /></td>
						<td class="AlignCenter"><input size="3" type="text" name="block_image_height[]" value="300" /></td>
					</tr>
				{/section}
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
