<tr>
	<th>Last Modify Date</th>
	<td>{$TheObject.modify_date}</td>
</tr>
<tr>
	<th>Link</th>
	<td>
		{if $Site.site_friendly_link_enable == 'Y'}
			<a href="{$Site.site_address}{$TheObject.object_seo_url}?preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}" target="_blank">{$Site.site_address}{$TheObject.object_seo_url}?&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}</a>
		{else}
			{if $TheObject.object_link_id|intval > 0}
				<a href="{$Site.site_address}/load.php?link_id={$TheObject.object_link_id}&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}" target="_blank">{$Site.site_address}/load.php?link_id={$TheObject.object_link_id}&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}</a>
			{else}			
				<a href="{$Site.site_address}/load.php?id={$TheObject.object_id}&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}" target="_blank">{$Site.site_address}/load.php?id={$TheObject.object_id}&preview_key={$TheObject.object_id|object_preview_key:$Site.site_api_key}</a>
			{/if}
		{/if}
	</td>
</tr>
<tr>
	<th>Status</th>
	<td>
		<input type="radio" name="object_is_enable" value="Y" {if $TheObject.object_is_enable == 'Y'}checked="checked"{/if}/> Enable
		<input type="radio" name="object_is_enable" value="N" {if $TheObject.object_is_enable == 'N'}checked="checked"{/if}/> Disable

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
		<th> Security Level </th>
		<td> <input class="object_security_level" data-original_object_security_level="{$TheObject.object_security_level}" type="text" name="object_security_level" value="{$TheObject.object_security_level}" size="6" data-IsPublisher="{if $IsPublisher}1{else}0{/if}" /> </td>
	</tr>	
{/if}
{if $ObjectFieldsShow.object_archive_date == 'Y'}
	<tr>
		<th> Archive Date </th>
		<td> <input type="text" name="object_archive_date" class="DatePicker" value="{$TheObject.object_archive_date|date_format:'%Y-%m-%d'}" size="11" /> {html_select_time prefix=object_archive_date_ use_24_hours=true display_seconds=false time=$TheObject.object_archive_date}</td>
	</tr>
{/if}
{if $ObjectFieldsShow.object_publish_date == 'Y'}
	<tr>
		<th> Publish Date </th>
		<td> <input type="text" name="object_publish_date" class="DatePicker" value="{$TheObject.object_publish_date|date_format:'%Y-%m-%d'}" size="11" /> {html_select_time prefix=object_publish_date_ use_24_hours=true display_seconds=false time=$TheObject.object_publish_date}</td>
	</tr>
{/if}
{if $ObjectFieldsShow.object_lang_switch_id == 'Y'}
	<tr>
		<th> Language Matching ID </th>
		<td> <input type="text" name="object_lang_switch_id" value="{$TheObject.object_lang_switch_id|escape:'html'}" size="50" maxlength="255" /> </td>
	</tr>
{/if}
