				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{if $Site.site_friendly_link_enable == 'Y'}
							<tr>
								<th> 搜索引擎友好網址 </th>
								<td> <input type="text" name="object_friendly_url" value="" size="60" maxlength="255" /> </td>
							</tr>
						{/if}
						<tr>
							<th> meta 標題 </th>
							<td> <input type="text" name="object_meta_title" value="" size="60" maxlength="255" /> </td>
						</tr>
						<tr>
							<th> meta 描述 </th>
							<td> <textarea name="object_meta_description" cols="57" rows="4"></textarea> </td>
						</tr>
						<tr>
							<th> meta 關鍵字 </th>
							<td> <textarea name="object_meta_keywords" cols="57" rows="4"></textarea> </td>
						</tr>
					</table>
				</div>
