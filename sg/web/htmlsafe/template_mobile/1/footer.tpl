
<div class="footer">
	<footer role="contentinfo">
		<ul class="footer_otherlink">
			
			{foreach $FooterOtherLink->object->objects->object as $FO}
				<li class="footer_otherlink_item">
					<a href="{$BASEURL}{$FO->object_seo_url}" target="_blank">{$FO->object_name}
						<img src="{$BASEURL}/images_mobile/common/icon_brank_03.png" width="13" height="10" alt="" class="icon_brank_01">
					</a>
				</li>
			{/foreach}

		</ul>
		<p class="footer_copyright">
			<small>Copyright CITIZEN WATCH CO., LTD<br>ALL RIGHTS RESERVED.</small>
		</p>
	</footer>
</div>

<p id="pagetop" class="pagetop"><a href=""></a></p>