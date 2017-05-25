{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_content.tpl"}
<h1 class="PageTitle">編輯網站區塊 - {$BlockDef.object_name|escape:'html'} &nbsp;
	<a onclick="return confirm('警告! \n 確定刪除？')" class="ui-state-default ui-corner-all MyButton" href="siteblock_delete.php?id={$smarty.request.id}">
		<span class="ui-icon ui-icon-trash"></span> 刪除
	</a>
	<a class="ui-state-default ui-corner-all MyButton" href="siteblock.php?language_id={$BlockContent.language_id}">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 網站區塊列表
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="siteblock_edit_act.php">
		<div id="SiteBlockTabs">
			<ul>
				<li><a href="#SiteBlockTabs-CommonData">一般資料</a></li>
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#SiteBlockTabs-Permission">權限</a></li>{/if}
			</ul>
			<div id="SiteBlockTabs-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						<tr>
							<th> 區塊名稱 </th>
							<td> {$BlockDef.block_definition_desc|escape:'html'} </td>
						</tr>
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						{if $BlockDef.block_definition_type == 'text'}
							<tr>
								<th> 參考名稱 </th>
								<td> <input type="text" name="object_name" value="{$BlockContent.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<th> 內容 </th>
								<td> <input type="text" name="block_content" value="{$BlockContent.block_content|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<th> 連結 </th>
								<td> <input type="text" name="block_link_url" value="{$BlockContent.block_link_url|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
						{elseif $BlockDef.block_definition_type == 'textarea'}
							<tr>
								<th> 參考名稱 </th>
								<td> <input type="text" name="object_name" value="{$BlockContent.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<th> 內容 </th>
								<td> <textarea name="block_content" cols="87" rows="5">{$BlockContent.block_content|escape:'html'}</textarea> </td>
							</tr>
							<tr>
								<th> 連結 </th>
								<td> <input type="text" name="block_link_url" value="{$BlockContent.block_link_url|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>				
						{elseif $BlockDef.block_definition_type == 'html'}
							<tr>
								<th> 參考名稱 </th>
								<td> <input type="text" name="object_name" value="{$BlockContent.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<th> 連結 </th>
								<td> <input type="text" name="block_link_url" value="{$BlockContent.block_link_url|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<td colspan="2"> {$EditorHTML} </td>
							</tr>
						{elseif $BlockDef.block_definition_type == 'image'}
							<tr>
								<th> 圖片補充文字內容(alt tag) </th>
								<td> <input type="text" name="object_name" value="{$BlockContent.object_name|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<th> 圖片 ({$BlockDef.block_image_width}px x {$BlockDef.block_image_height}px) </th>
								<td>
									{if $BlockContent.block_image_id != 0}
										<a href="{$smarty.const.BASEURL}/getfile.php?id={$BlockContent.block_image_id}" target="_preview" ><img {if $BlockDef.block_image_width < 800 && $BlockDef.block_image_width > 0}width="{$BlockDef.block_image_width}"{elseif $BlockDef.block_image_width > 0}width="800"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$BlockContent.block_image_id}" /></a> <br />
									{/if}
									<input type="file" name="block_image" />
								</td>
							</tr>
							<tr>
								<th> 圖片文字內容 </th>
								<td> <input type="text" name="block_content" value="{$BlockContent.block_content|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<th> 連結 </th>
								<td> <input type="text" name="block_link_url" value="{$BlockContent.block_link_url|escape:'html'}" size="90" maxlength="255" /> </td>
							</tr>
						{/if}
					</table>
				</div>
			</div>
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="SiteBlockTabs-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit.tpl"}
				</div>
			{/if}
			<input type="hidden" name="id" value="{$smarty.request.id}" />
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
