				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{if $Site.site_friendly_link_enable == 'Y'}
							<tr>
								<th> Friendly URL </th>
								<td> <input type="text" name="object_friendly_url" value="{$TheObject.object_friendly_url|escape:'html'}" maxlength="255" /> </td>
							</tr>
						{/if}
						<tr>
							<th> Meta Title </th>
							<td> <input type="text" name="object_meta_title" value="{$TheObject.object_meta_title|escape:'html'}" size="50" maxlength="255" /> </td>
						</tr>
						<tr>
							<th> Meta Description </th>
							<td> <textarea name="object_meta_description" cols="48" rows="4">{$TheObject.object_meta_description|escape:'html'}</textarea> </td>
						</tr>
						<tr>
							<th> Meta Keywords </th>
							<td> <textarea name="object_meta_keywords" cols="48" rows="4">{$TheObject.object_meta_keywords|escape:'html'}</textarea> </td>
						</tr>
					</table>
				</div>
