	{foreach $Products->objects->product as $P}

		{if $P@index % 2 == 0}
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
								<img src="{$REMOTE_BASEURL}/getfile.php?id={$P->object_thumbnail_file_id}" height="141" alt="">
							{/if}
						</a>
					</div>
					<p class="lineup_brand">
						{ProductGetProductFatherCategoryName($P->parent_object_id)}
					</p>
					<p class="lineup_number">
						{$P->product_code}
					</p>
					<p class="lineup_price">{$MyCurrency}{$P->product_price|currencyformat}</p>
					<p class="btn_01 products_moreButton mt10">
					</p>
				</div>
			</li>

		{if $P@index % 2 == 1 || $P@last}
			</ul>
		{/if}

	{/foreach}