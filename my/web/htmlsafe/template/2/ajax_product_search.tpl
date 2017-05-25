
			
		{if $smarty.request.product_custom_int_1|intval > 0}
			{assign var="noOfWatchesPerRow" value=5}
		{else}
			{assign var="noOfWatchesPerRow" value=2}
		{/if}

			{foreach $Products->objects->product as $P}

				{if $P@index % $noOfWatchesPerRow == 0}
					<ul  class="clearfix">
				{/if}

					<li class="column">
						<div class="lineup_inner js-itemBox">
							<div class="lineup_image">
								<a href="{$BASEURL}{$P->object_seo_url}">
									{if $P->product_custom_int_2|intval == 1}
										<span class="icon_new_01">NEW</span>
									{/if}
									{if $P->object_thumbnail_file_id|intval > 0}
										{*<img src="{$BASEURL}/images/common/preset.gif" data-src="{$REMOTE_BASEURL}/getfile.php?id={$P->object_thumbnail_file_id}" height="218" alt="">*}
										<img src="{$REMOTE_BASEURL}/getfile.php?id={$P->object_thumbnail_file_id}" height="218" alt="">
									{/if}
								</a>
							</div>
							<p class="lineup_brand">
								{ProductGetProductFatherCategoryName($P->parent_object_id)}
							</p>
							<p class="lineup_number">
								{$P->product_code}
								{*<input type="hidden" name="iid" value="CC9015-54E"><input type="hidden" name="pairid" value="00">*}
							</p>
							<p class="lineup_price">{$MyCurrency}{$P->product_price|currencyformat}</p>
							<p class="btn_01 products_moreButton mt10">
								{*
								<a href="" target="_blank">
									製品を見る
									<img src="{$BASEURL}/images/common/icon_brank_02.png" width="13" height="10" alt="" class="icon_brank_01">
								</a>
								*}
							</p>
							{*
							<ul class="lineup_btnList">
								<li class="lineup_btnItem">
									<div class="lineup_balloon">
									  <div class="limitText">
										<p>一度に比較できる製品は10点までです。</p>
									  </div>
									  <div class="numberText">
										  <p>比較表に追加しました。<br>あと<span class="js-remain">0</span>点追加できます。</p>
										  <p class="link_01 product_balloon_btnClear"><a href="javascript:;" class="js-removeCompare">取消</a></p>
									  </div>
									</div>
									<p class="lineup_btnAdd">
										<a href="/product/comparison/" class="js-addCompare">
										  <span class="normalText">比較する</span>
										  <span class="disabledText">比較表を見る</span>
										</a>
									</p>
								</li>
							</ul>
							*}
						</div>
					</li>

				{if $P@index % $noOfWatchesPerRow == $noOfWatchesPerRow - 1 || $P@last}
					</ul>
				{/if}

			{/foreach}