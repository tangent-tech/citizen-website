<tr>
	<th>Status</th>
	<td>
		<input type="radio" name="object_is_enable" value="Y" checked="checked" /> Enable
		<input type="radio" name="object_is_enable" value="N" /> Disable

		{if $ObjectFieldsShow.object_security_level == 'N'}
			<input type="hidden" name="object_security_level" value="{$Site.site_default_security_level}" />
		{/if}
		{if $ObjectFieldsShow.object_archive_date != 'Y'}
			<input type="hidden" name="object_archive_date" 		value="{$smarty.const.OBJECT_DEFAULT_ARCHIVE_DATE|date_format:'%Y-%m-%d'}" />
			<input type="hidden" name="object_archive_date_Hour" 	value="{$smarty.const.OBJECT_DEFAULT_ARCHIVE_DATE|date_format:'%k'}" />
			<input type="hidden" name="object_archive_date_Minute"	value="{$smarty.const.OBJECT_DEFAULT_ARCHIVE_DATE|date_format:'%M'}" />
		{/if}
		{if $ObjectFieldsShow.object_publish_date != 'Y'}
			<input type="hidden" name="object_publish_date"			value="{$smarty.now|date_format:'%Y-%m-%d'}" />
			<input type="hidden" name="object_publish_date_Hour" 	value="{$smarty.now|date_format:'%k'}" />
			<input type="hidden" name="object_publish_date_Minute"	value="{$smarty.now|date_format:'%M'}" />
		{/if}
	</td>
</tr>
{if $ObjectFieldsShow.object_security_level != 'N'}
	{if $Site.site_module_workflow_enable != 'Y' || $IsPublisher}
		<tr>
			<th> Security Level </th>
			<td> <input type="text" name="object_security_level" value="{$Site.site_default_security_level}" size="6" /> </td>
		</tr>
	{/if}
{/if}
{if $ObjectFieldsShow.object_archive_date == 'Y'}
	<tr>
		<th> Archive Date </th>
		<td> <input type="text" name="object_archive_date" class="DatePicker" value="{$smarty.const.OBJECT_DEFAULT_ARCHIVE_DATE|date_format:'%Y-%m-%d'}" size="11" /> {html_select_time prefix=object_archive_date_ use_24_hours=true display_seconds=false time=$smarty.const.OBJECT_DEFAULT_ARCHIVE_DATE}</td>
	</tr>
{/if}
{if $ObjectFieldsShow.object_publish_date == 'Y'}
	<tr>
		<th> Publish Date </th>
		<td> <input type="text" name="object_publish_date" class="DatePicker" value="{$smarty.now|date_format:'%Y-%m-%d'}" size="11" /> {html_select_time prefix=object_publish_date_ use_24_hours=true display_seconds=false time=$smarty.now}</td>
	</tr>
{/if}
{if $ObjectFieldsShow.object_lang_switch_id == 'Y'}
	<tr>
		<th> Language Matching ID </th>
		<td> <input type="text" name="object_lang_switch_id" value="" size="60" maxlength="255" /> </td>
	</tr>
{/if}
