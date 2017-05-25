				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{if $Site.site_friendly_link_enable == 'Y'}
							<tr>
								<th> Friendly URL </th>
								<td> <input type="text" name="object_friendly_url" value="" size="60" maxlength="255" /> </td>
							</tr>
						{/if}
						<tr>
							<th> Meta Title </th>
							<td> <input type="text" name="object_meta_title" value="" size="60" maxlength="255" /> </td>
						</tr>
						<tr>
							<th> Meta Description </th>
							<td> <textarea name="object_meta_description" cols="57" rows="4"></textarea> </td>
						</tr>
						<tr>
							<th> Meta Keywords </th>
							<td> <textarea name="object_meta_keywords" cols="57" rows="4"></textarea> </td>
						</tr>
					</table>
				</div>
