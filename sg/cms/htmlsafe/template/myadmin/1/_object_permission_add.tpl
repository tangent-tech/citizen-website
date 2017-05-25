				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{if in_array($TheObject.object_type, $PermissionPropagateValidContainerObjectList)}
							<tr>
								<th> Browse </th>
								<td>
									<select name="object_permission_browse_children">
										{foreach $PermissionOption as $key => $value}
											<option value="{$key}" {if $TheObject.object_permission_browse_children == $key}selected="selected"{/if}>{$value}</option>
										{/foreach}
									</select>
								</td>
							</tr>
							<tr>
								<th> Add Child </th>
								<td>
									<select name="object_permission_add_children">
										{foreach $PermissionOption as $key => $value}
											<option value="{$key}" {if $TheObject.object_permission_add_children == $key}selected="selected"{/if}>{$value}</option>
										{/foreach}
									</select>
								</td>
							</tr>
						{/if}
						<tr>
							<th> Edit </th>
							<td>
								<select name="object_permission_edit">
									{foreach $PermissionOption as $key => $value}
										<option value="{$key}" {if $TheObject.object_permission_edit == $key}selected="selected"{/if}>{$value}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th> Delete </th>
							<td>
								<select name="object_permission_delete">
									{foreach $PermissionOption as $key => $value}
										<option value="{$key}" {if $TheObject.object_permission_delete == $key}selected="selected"{/if}>{$value}</option>
									{/foreach}
								</select>
							</td>
						</tr>

						<tr>
							<th> Owner </th>
							<td>
								<select name="object_owner_content_admin_id">
									<option value="0">-</option>
									{foreach $ContentAdminOptionList as $key => $value}
										<option value="{$key}" {if $TheObject.object_owner_content_admin_id == $key}selected="selected"{/if}>{$value}</option>
									{/foreach}
								</select>
							</td>
						</tr>						
						<tr>
							<th> Group </th>
							<td>
								<select name="object_owner_content_admin_group_id">
									<option value="0">-</option>
									{foreach $ContentWriterGroupOptionList as $key => $value}
										<option value="{$key}" {if $TheObject.object_owner_content_admin_group_id == $key}selected="selected"{/if}>{$value}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						{if $Site.site_module_workflow_enable == 'Y'}
							<tr>
								<th> Publisher </th>
								<td>
									<select name="object_publisher_content_admin_group_id">
										<option value="0">-</option>
										{foreach $ContentWriterGroupOptionList as $key => $value}
											<option value="{$key}" {if $TheObject.object_publisher_content_admin_group_id == $key}selected="selected"{/if}>{$value}</option>
										{/foreach}
									</select>
								</td>
							</tr>
						{/if}
					</table>
				</div>