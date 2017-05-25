<tr>
	<th>最後修改日期</th>
	<td>{$TheObject.modify_date}</td>
</tr>
<tr>
	<th>預覧網址</th>
	<td>
		{if $Site.site_friendly_link_enable == 'Y'}
			<a href="http://{$Site.site_address}{$TheObject.object_seo_url}?preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}" target="_blank">http://{$Site.site_address}{$TheObject.object_seo_url}?&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}</a>
		{else}
			{if $TheObject.object_link_id|intval > 0}
				<a href="http://{$Site.site_address}/load.php?link_id={$TheObject.object_link_id}&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}" target="_blank">http://{$Site.site_address}/load.php?link_id={$TheObject.object_link_id}&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}</a>
			{else}			
				<a href="http://{$Site.site_address}/load.php?id={$TheObject.object_id}&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}" target="_blank">http://{$Site.site_address}/load.php?id={$TheObject.object_id}&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}</a>
			{/if}
		{/if}
	</td>
</tr>
<tr>
	<th>狀態</th>
	<td>
		<input type="radio" name="object_is_enable" value="Y" {if $TheObject.object_is_enable == 'Y'}checked="checked"{/if}/> 啟用
		<input type="radio" name="object_is_enable" value="N" {if $TheObject.object_is_enable == 'N'}checked="checked"{/if}/> 關閉

		{if $ObjectFieldsShow.object_security_level == 'N'}
			<input type="hidden" name="object_security_level" value="{$TheObject.object_security_level|escape:'html'}" />
		{/if}
		{if $ObjectFieldsShow.object_archive_date != 'Y'}
			<input type="hidden" name="object_archive_date" 		value="{$TheObject.object_archive_date|date_format:'%Y-%m-%d'}" />
			<input type="hidden" name="object_archive_date_Hour" 	value="{$TheObject.object_archive_date|date_format:'%k'}" />
			<input type="hidden" name="object_archive_date_Minute"	value="{$TheObject.object_archive_date|date_format:'%M'}" />
		{/if}
		{if $ObjectFieldsShow.object_publish_date != 'Y'}
			<input type="hidden" name="object_publish_date"			value="{$TheObject.object_publish_date|date_format:'%Y-%m-%d'}" />
			<input type="hidden" name="object_publish_date_Hour" 	value="{$TheObject.object_publish_date|date_format:'%k'}" />
			<input type="hidden" name="object_publish_date_Minute"	value="{$TheObject.object_publish_date|date_format:'%M'}" />
		{/if}
	</td>
</tr>
{if $ObjectFieldsShow.object_security_level != 'N'}
	<tr>
		<th> 安全級別 </th>
		<td> <input class="object_security_level" data-original_object_security_level="{$TheObject.object_security_level}" type="text" name="object_security_level" value="{$TheObject.object_security_level}" size="6" data-IsPublisher="{if $IsPublisher}1{else}0{/if}" /> </td>
	</tr>	
{/if}
{if $ObjectFieldsShow.object_archive_date == 'Y'}
	<tr>
		<th> 封存日期 </th>
		<td> <input type="text" name="object_archive_date" class="DatePicker" value="{$TheObject.object_archive_date|date_format:'%Y-%m-%d'}" size="11" /> {html_select_time prefix=object_archive_date_ use_24_hours=true display_seconds=false time=$TheObject.object_archive_date}</td>
	</tr>
{/if}
{if $ObjectFieldsShow.object_publish_date == 'Y'}
	<tr>
		<th> 發布日期 </th>
		<td> <input type="text" name="object_publish_date" class="DatePicker" value="{$TheObject.object_publish_date|date_format:'%Y-%m-%d'}" size="11" /> {html_select_time prefix=object_publish_date_ use_24_hours=true display_seconds=false time=$TheObject.object_publish_date}</td>
	</tr>
{/if}
{if $ObjectFieldsShow.object_lang_switch_id == 'Y'}
	<tr>
		<th> 語言配對識別碼  </th>
		<td> <input type="text" name="object_lang_switch_id" value="{$TheObject.object_lang_switch_id|escape:'html'}" size="50" maxlength="255" /> </td>
	</tr>
{/if}
