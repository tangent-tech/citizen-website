
		{*Footer*}
		<div class="footer">
			<footer role="contentinfo">
				<div class="footer_outer">
					<div class="footer_inner">
						<div class="clearfix">
							<div class="footer_lineup">
								<dl class="footer_lineup_item">
									<dt>腕錶系列</dt>
									<dd><a href="{$BASEURL}{GetSeoUrl($smarty.const.SEARCH_PAGE_LINK_ID)}">搜尋腕錶</a></dd>
								</dl>
							</div>
							<div class="footer_brand">
								<ul class="footer_brand_inner">
									
									{foreach $FooterCategoryMenu->object->objects->object as $C}
										<li class="footer_brand_item">
											<a href="{$BASEURL}{$C->object_seo_url}">{$C->object_name}</a>
										</li>
									{/foreach}

								</ul>
							</div>
						</div>
						<div class="footer_gnavi">
							<nav role="navigation">
								<ul class="footer_gnavi_inner">

									{foreach $FooterMenu->object->objects->object as $F}
										<li class="footer_gnavi_item">
											<a href="{$BASEURL}{$F->object_seo_url}" target="_blank">
												{$F->object_name}
												<img src="{$BASEURL}/images/common/icon_brank_03.png" width="13" height="10" alt="" class="icon_brank_01">
											</a>
										</li>
									{/foreach}

									{*
									<li class="footer_gnavi_item">
										<a href="http://www.citizenwatch-global.com/index.html" target="_blank">
											GLOBAL<img src="{$BASEURL}/images/common/icon_brank_03.png" width="13" height="10" alt="" class="icon_brank_01">
										</a>
									</li>
									*}

								</ul>
							</nav>
						</div>
					</div>
				</div>
				<div class="footer_inner">
					<ul class="footer_sns clearfix">
						{foreach $FooterSocialLink as $L}
							<li class="footer_sns_item">
								<a href="{$L->block_link_url}" target="_blank" class="rollover_01" target="_blank">
									<img src="{$REMOTE_BASEURL}/getfile.php?id={$L->block_image_id}" {*width="101" height="25"*} alt="{$L->object_name}" title="{$L->block_content}">
								</a>
							</li>
						{/foreach}
					</ul>
					<ul class="footer_otherlink">
						{foreach $FooterOtherLink->object->objects->object as $FO}
							<li class="footer_otherlink_item">
								<a href="{$BASEURL}{$FO->object_seo_url}" target="_blank">
									{$FO->object_name}
									<img src="{$BASEURL}/images/common/icon_brank_03.png" width="13" height="10" alt="" class="icon_brank_01">
								</a>
							</li>
						{/foreach}
					</ul>
					<p class="footer_copyright"><small>Copyright CITIZEN WATCH CO., LTD ALL RIGHTS RESERVED.</small></p>
				</div>
			</footer>
		</div>

		<p id="pagetop" class="pagetop">
			<a href="##"></a>
		</p>

	</body>
</html>