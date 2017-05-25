				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> 同時更改子項目權限 </th>
							<td>
								<select name="object_permission_propagate_children_depth">
									<option value="0">None</option>
									<option value="999999">All children
								</select>
							</td>							
						</tr>
						<tr>
							<th> 更改 </th>
							<td>
								<select name="object_permission_edit">
									{foreach $PermissionOption as $key => $value}
										<option value="{$key}" {if $TheObject.object_permission_edit == $key}selected="selected"{/if}>{$value}</option>
									{/foreach}
								</select>
							</td>
						</tr>
						<tr>
							<th> 刪除 </th>
							<td>
								<select name="object_permission_delete">
									{foreach $PermissionOption as $key => $value}
										<option value="{$key}" {if $TheObject.object_permission_delete == $key}selected="selected"{/if}>{$value}</option>
									{/foreach}
								</select>
							</td>
						</tr>

						<tr>
							<th> 擁有者 </th>
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
							<th> 群組 </th>
							<td>
								<select name="object_owner_content_admin_group_id">
									<option value="0">-</option>
									{foreach $ContentWriterGroupOptionList as $key => $value}
										<option value="{$key}" {if $TheObject.object_owner_content_admin_group_id == $key}selected="selected"{/if}>{$value}</option>
									{/foreach}
								</select>
							</td>
						</tr>
					</table>
				</div>
