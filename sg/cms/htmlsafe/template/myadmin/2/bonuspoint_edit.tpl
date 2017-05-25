{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_bonuspoint.tpl"}
<h1 class="PageTitle">編輯積分獎賞產品 &nbsp;
{if $IsBonusPointItemRemovable == true}
	<a onclick="return confirm('警告! \n 確定刪除？')" class="ui-state-default ui-corner-all MyButton" href="bonuspoint_delete.php?id={$smarty.request.id}">
		<span class="ui-icon ui-icon-trash"></span> 刪除
	</a>
{else}
	<a href="#" class="ui-state-disabled ui-state-default ui-corner-all MyButton">
		<span class="ui-icon ui-icon-trash"></span> 刪除
	</a>
{/if}
	<a class="ui-state-default ui-corner-all MyButton" href="bonuspoint_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 積分獎賞產品列表
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="bonuspoint_edit_act.php">
		<div id="BonusPointItemTabs">
			<ul>
				<li><a href="#BonusPointItemTabsPanel-CommonData">一般資料</a></li>
				{if $ObjectFieldsShow.object_seo_tab == 'Y'}<li><a href="#BonusPointItemTabsPanel-SEO">SEO</a></li>{/if}
				{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}<li><a href="#BonusPointItemTabsPanel-Permission">權限</a></li>{/if}
				{foreach from=$SiteLanguageRoots item=R}
				    <li><a href="#BonusPointItemTabsPanel-{$R.language_id}">{$R.language_longname|escape:'html'}</a></li>
				{/foreach}
			</ul>
			<div id="BonusPointItemTabsPanel-CommonData">
				<div class="AdminEditDetailsBlock">
					<table class="LeftHeaderTable">
						{include file="myadmin/`$CurrentLang['language_id']`/_object_common_edit.tpl"}
						<tr>
							<th> 參考名稱 </th>
							<td> <input type="text" name="bonus_point_item_ref_name" value="{$BonusPointItem.bonus_point_item_ref_name|escape:'html'}" size="80" maxlength="255" /> </td>
						</tr>
						<tr>
							<th>縮圖</th>
							<td>
								{if $BonusPointItem.object_thumbnail_file_id != 0}
									<img class="MediaSmallFile" {if $Site.site_product_media_small_width < 80}width="{$Site.site_product_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}/getfile.php?id={$BonusPointItem.object_thumbnail_file_id}" /> <br />
									<input type="checkbox" name="remove_thumbnail" value="Y" /> 刪除縮圖
									<br />
								{/if}
								<input type="file" name="thumbnail_file" />
							</td>
						</tr>
						<tr>
							<th>產品類別 </th>
							<td>
								<input type="radio" name="bonus_point_item_type" value="gift" {if $BonusPointItem.bonus_point_item_type != 'cash'}checked="checked"{/if}/> 禮品
								<input type="radio" name="bonus_point_item_type" value="cash" {if $BonusPointItem.bonus_point_item_type == 'cash'}checked="checked"{/if}/> 現金
							</td>
						</tr>
						<tr>
							<th>需要積分 </th>
							<td><input type="text" size="6" name="bonus_point_required" value="{$BonusPointItem.bonus_point_required}" /></td>
						</tr>
						<tr>
							<th>現金值 </th>
							<td>{$Site.currency_shortname} <input type="text" size="4" name="cash" value="{$BonusPointItem.cash}" /></td>
						</tr>
					</table>
				</div>
			</div>
			{if $ObjectFieldsShow.object_seo_tab == 'Y'}
				<div id="BonusPointItemTabsPanel-SEO">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_meta_edit.tpl"}
				</div>
			{/if}
			{if $Site.site_module_content_writer_enable == 'Y' && $IsContentAdmin}
				<div id="BonusPointItemTabsPanel-Permission">
					{include file="myadmin/`$CurrentLang['language_id']`/_object_permission_edit.tpl"}
				</div>
			{/if}						
			{foreach from=$SiteLanguageRoots item=R}
				<div id="BonusPointItemTabsPanel-{$R.language_id}">
					<div class="AdminEditDetailsBlock">
						<table class="LeftHeaderTable">
							<tr>
								<th>積分獎賞產品名稱</th>
								<td> <input type="text" name="bonus_point_item_name[{$R.language_id}]" value="{$BonusPointItemData[$R.language_id].bonus_point_item_name}" size="90" maxlength="255" /> </td>
							</tr>
							<tr>
								<th>積分獎賞產品描述</th>
								<td>
									{$EditorHTML[$R.language_id]}
								</td>
							</tr>
						</table>
					</div>
			   </div>
			{/foreach}
			<input type="hidden" name="id" value="{$smarty.request.id}" />
			<div class="ui-widget-header ui-corner-bottom">
				<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmEditBlock">
					<span class="ui-icon ui-icon-check"></span> 確認
				</a>
				<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock" EditorInstance="{foreach from=$SiteLanguageRoots item=R}ContentEditor{$R.language_id} {/foreach}">
					<span class="ui-icon ui-icon-cancel"></span> 重設
				</a>
			</div>
		</div>
	</form>
</div>

<div class="InnerContainer ui-widget ui-corner-all AdminEditDetailsBlock">
	<h2 class="ui-helper-reset ui-widget-header ui-corner-top InnerHeader">積分獎賞產品媒體</h2>
	<div class="InnerContent ui-widget-content ui-corner-bottom">
		<table id="MediaListTable-{$BonusPointItem.bonus_point_item_id}" class="TopHeaderTable ui-helper-reset AlignCenter SortTable">
			<tr class="ui-state-highlight nodrop nodrag">
				<th width="50">編號</th>
				<th width="250">媒體</th>
				<th>操作</th>
			</tr>
			{if $BonusPointItemMediaList|@count == 0}
				<tr class="nodrop nodrag">
					<td colspan="3">你可以上傳圖片或短片</td>
				</tr>
			{/if}
			{foreach from=$BonusPointItemMediaList item=M}
				<tr id="Media-{$M.media_id}" class="{if $M.object_is_enable == 'N'}DisabledRow{/if}">
					<td class="AlignCenter">{$M.media_id}</td>
					<td>
						{if $M.media_small_file_id != 0}
							<a href="{$smarty.const.BASEURL}getfile.php?id={$M.media_big_file_id}" target="_preview"><img class="MediaSmallFile" {if $Site.site_media_small_width < 80}width="{$Site.site_media_small_width}"{else}width="80"{/if} src="{$smarty.const.BASEURL}getfile.php?id={$M.media_small_file_id}" /><br class="MediaSmallFile" />{$M.filename}</a>
						{else}
							<a href="{$smarty.const.BASEURL}getfile.php?id={$M.media_big_file_id}" target="_preview">{$M.filename}</a>
						{/if}
					</td>
					<td class="AlignCenter">
						<a href="bonuspoint_media_set_highlight.php?parent_id={$smarty.request.id}&id={$M.media_id}" class="ui-state-default ui-corner-all MyButton">
							<span class="ui-icon ui-icon-image"></span> 縮圖
						</a>
						<a href="media_edit.php?id={$M.media_id}&parent_id={$smarty.request.id}&refer=bonuspoint_edit" class="ui-state-default ui-corner-all MyButton">
							<span class="ui-icon ui-icon-pencil"></span> 編輯
						</a>
						<a href="media_delete.php?id={$M.media_id}&parent_id={$smarty.request.id}&refer=bonuspoint_edit" onclick="return confirm('警告! \n 確定刪除？')" class="ui-state-default ui-corner-all MyButton">
							<span class="ui-icon ui-icon-trash"></span> 刪除
						</a>
					</td>
				</tr>
			{/foreach}
		</table>
		<br />
		<form enctype="multipart/form-data" name="FrmAddPhoto" id="FrmAddPhoto" method="post" action="media_add_act.php">
			<input type="file" name="media[]" multiple="true" />
			<input type="file" name="media[]" multiple="true" />
			<input type="file" name="media[]" multiple="true" />
			<input type="hidden" name="id" value="{$BonusPointItem.bonus_point_item_id}" />
			<input type="hidden" name="refer" value="bonuspoint_edit" />
			<br />
			{if $Site.site_product_media_watermark_big_file_id != 0 || $Site.site_product_media_watermark_small_file_id != 0}
				<input type="checkbox" name="AddWatermark" checked="checked" value="Y" /> 加入水印
				<br />
			{/if}
			<a href="#" class="ui-state-default ui-corner-all MySubmitButton MyButton" target="FrmAddPhoto">
				<span class="ui-icon ui-icon-circle-plus"></span> 新增媒體
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmAddPhoto">
				<span class="ui-icon ui-icon-cancel"></span> 重設
			</a>
		</form>
	</div>
</div>

{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
