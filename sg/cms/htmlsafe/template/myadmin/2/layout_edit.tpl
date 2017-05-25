{include file="myadmin/`$CurrentLang['language_id']`/header_inner.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/header_site_admin.tpl"}
<h1 class="PageTitle">編輯排版 &nbsp;
	<a class="ui-state-default ui-corner-all MyButton" href="layout_list.php">
		<span class="ui-icon ui-icon-arrowreturnthick-1-e"></span> 排版列表
	</a>
</h1>
<div class="InnerContainer ui-widget ui-corner-all">
	<h2 class="ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-top InnerHeader">排版詳情</h2>
	<form enctype="multipart/form-data" name="FrmEditBlock" id="FrmEditBlock" method="post" action="layout_edit_act.php">
		<div class="InnerContent ui-widget-content">
			<div class="AdminEditDetailsBlock">
				<table class="LeftHeaderTable">
					<tr>
						<th> 排版名稱 </th>
						<td> <input type="text" name="layout_name" value="{$Layout.layout_name|escape:'html'}" /> </td>
					</tr>
					<tr>
						<th> 排版預覽圖片 </th>
						<td>
							{if $Layout.layout_file_id != 0}
								<a href="{$smarty.const.BASEURL}/getfile.php?id={$Layout.layout_file_id}" target="_preview" class="PreviewImage"><img src="{$smarty.const.BASEURL}/getfile.php?id={$Layout.layout_file_id}" /></a> <br />
							{/if}
							<input type="file" name="layout_file" /> <br />
							<input type="checkbox" name="layout_file_delete" value="1" /> 刪除
						</td>
					</tr>
				</table>
				<hr />
				<table class="TopHeaderTable">
					<tr class="ui-state-highlight">
						<th class="AlignCenter" width="">區塊名稱</th>
						<th class="AlignCenter" width="">區塊描述</th>
						<th class="AlignCenter" width="80">區塊類別</th>
						<th class="AlignCenter" width="90">圖片寬度</th>
						<th class="AlignCenter" width="90">圖片高度</th>
						<th class="AlignCenter" width="50">刪除</th>
					</tr>
					{foreach from=$BlockDefs item=D}
						<tr>
							<td class="AlignCenter"><input size="32" type="text" name="object_name[{$D.block_definition_id}]" value="{$D.object_name|escape:'html'}" /></td>
							<td class="AlignCenter"><input size="50" type="text" name="block_definition_desc[{$D.block_definition_id}]" value="{$D.block_definition_desc|escape:'html'}" /></td>
							<td class="AlignCenter">
								{if $D.block_definition_type == 'image' || $D.block_definition_type == 'file'}
									{$D.block_definition_type}
									<input type="hidden" name="block_definition_type[{$D.block_definition_id}]" value="{$D.block_definition_type}" />
								{else}
									<select name="block_definition_type[{$D.block_definition_id}]">
										<option {if $D.block_definition_type == 'text'}selected="selected"{/if} value="text">text</option>
										<option {if $D.block_definition_type == 'textarea'}selected="selected"{/if} value="textarea">textarea</option>
										<option {if $D.block_definition_type == 'html'}selected="selected"{/if} value="html">html</option>
									</select>
								{/if}
							</td>
							<td class="AlignCenter">{if $D.block_definition_type == 'image'}<input size="3" type="text" name="block_image_width[{$D.block_definition_id}]" value="{$D.block_image_width}" />{else}-{/if}</td>
							<td class="AlignCenter">{if $D.block_definition_type == 'image'}<input size="3" type="text" name="block_image_height[{$D.block_definition_id}]" value="{$D.block_image_height}" />{else}-{/if}</td>
							<td class="AlignCenter"><input type="checkbox" class="DeleteBlockDef" name="block_def_delete[{$D.block_definition_id}]" value="1" /></td>
						</tr>
					{/foreach}
					{section name=foo loop=2} 
						<tr>
							<td class="AlignCenter"><input size="32" type="text" name="new_object_name[]" value="" /></td>
							<td class="AlignCenter"><input size="50" type="text" name="new_block_definition_desc[]" value="" /></td>
							<td class="AlignCenter">
								<select name="new_block_definition_type[]">
									<option value="text">text</option>
									<option value="textarea">textarea</option>
									<option value="html">html</option>
									<option value="image">image</option>
									<option value="file">file</option>
								</select>
							</td>
							<td class="AlignCenter"><input size="3" type="text" name="new_block_image_width[]" value="" /></td>
							<td class="AlignCenter"><input size="3" type="text" name="new_block_image_height[]" value="" /></td>
							<td class="AlignCenter">new</td>
						</tr>
					{/section}
				</table>
			</div>
			<input type="hidden" name="id" value="{$smarty.request.id}" />
			<input class="HiddenSubmit" type="submit" value="Submit" />
		</div>
		<div class="ui-widget-header ui-corner-bottom InnerHeader">
			<a id="TheSubmitButton" href="#" class="ui-state-default ui-corner-all MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-check"></span> 確定
			</a>
			<a href="#" class="ui-state-default ui-corner-all MyResetButton MyButton" target="FrmEditBlock">
				<span class="ui-icon ui-icon-cancel"></span> 重置
			</a>
		</div>
	</form>
</div>
{include file="myadmin/`$CurrentLang['language_id']`/footer_2ndlevel.tpl"}
{include file="myadmin/`$CurrentLang['language_id']`/footer_inner.tpl"}
