{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">新增相簿 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="album_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 相簿 </a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="album_add_act.php">
		<div id="AlbumTabs">
			<ul>
				<li><a href="#AlbumTabs-CommonData">一般資料</a></li>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#AlbumTabs-Permission">權限</a></li>{/if}
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#AlbumTabs-{$R.language_id}">{$R.language_longname}</a></li>
				{/foreach}
			</ul>
			<div id="AlbumTabs-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> 參考名稱 </th>
							<td> <input type="text" name="object_name" value="Untitled Album" size="90" maxlength="255" /> </td>
						</tr>
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_add.tpl"}
					</table>
				</div>
			</div>
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="AlbumTabs-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_add.tpl"}
				</div>
			{/if}
			{foreach from=$SiteLanguageRoots item=R}
				<div id="AlbumTabs-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							{if $ObjectFieldsShow.object_seo_tab == 'Y'}
								{if $Site.site_friendly_link_enable == 'Y'}
									<tr>
										<th> 搜索引擎友好網址 </th>
										<td> <input type="text" name="object_friendly_url[{$R.language_id}]" value="{$AlbumData[$R.language_id].object_friendly_url|escape:'html'}" maxlength="255" /> </td>
									</tr>
								{/if}
								<tr>
									<th> meta 標題 </th>
									<td> <input type="text" name="object_meta_title[{$R.language_id}]" value="{$AlbumData[$R.language_id].object_meta_title|escape:'html'}" size="50" maxlength="255" /> </td>
								</tr>
								<tr>
									<th> meta 描述 </th>
									<td> <textarea name="object_meta_description[{$R.language_id}]" cols="48" rows="4">{$AlbumData[$R.language_id].object_meta_description|escape:'html'}</textarea> </td>
								</tr>
								<tr>
									<th> meta 關鍵字 </th>
									<td> <textarea name="object_meta_keywords[{$R.language_id}]" cols="48" rows="4">{$AlbumData[$R.language_id].object_meta_keywords|escape:'html'}</textarea> </td>
								</tr>								
							{/if}							
							<tr>
								<th>相簿描述</th>
								<td><input type="text" name="album_desc[{$R.language_id}]" value="" size="90" maxlength="255" /></td>
							</tr>
						</table>
					</div>
			   </div>
			{/foreach}
			<div class="ui-widget-header ui-corner-bottom">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> 確認
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-cancel"></span> 重設
				</a>
			</div>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}