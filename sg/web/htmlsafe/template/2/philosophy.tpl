{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>

			{*Key Visual*}
			{if $KeyVisual->block_image_id|intval > 0}
				<div class="keyvisualBlock">
					<img src="{$REMOTE_BASEURL}/getfile.php?id={$KeyVisual->block_image_id}" width="1000" alt="{$KeyVisual->block_content}">
				</div>
			{/if}
			
			<section class="mb100">
				<div class="container">
					<h2 class="headingLv2 mb50">
						我們的理念是不斷開拓腕錶新的領域，讓全世界顧客佩戴更頂級的腕錶。
					</h2>
					
					{if $MissionContent01->block_image_id|intval > 0}
						<div class="columnWrap column2 columnBlock_01 mb70 clearfix">
							<div class="column">
								<img src="{$REMOTE_BASEURL}/getfile.php?id={$MissionContent01->block_image_id}" width="480" height="320" alt="{$MissionContent01->object_name}">
							</div>
							<div class="column ">
								<p class="ml40 mt50 copy_text">{$MissionContent01->block_content|nl2br}</p>
							</div>
						</div>
					{/if}
						
					{if $MissionContent02->block_image_id|intval > 0}
						<div class="columnWrap column2 columnBlock_01 mb70 clearfix">
							<div class="column">
								<p class="mt50 mr40 copy_text">{$MissionContent02->block_content|nl2br}</p>
							</div>
							<div class="column">
							  <img src="{$REMOTE_BASEURL}/getfile.php?id={$MissionContent02->block_image_id}" width="480" height="320" alt="{$MissionContent02->object_name}">
							</div>
						</div>
					{/if}

					{if $MissionContent03->block_image_id|intval > 0}
						<div class="columnWrap column2 columnBlock_01 mb100 clearfix">
							<div class="column">
								<img src="{$REMOTE_BASEURL}/getfile.php?id={$MissionContent03->block_image_id}" width="480" height="320" alt="{$MissionContent03->object_name}">
							</div>
							<div class="column ">
							  <p class="ml40 mt50 copy_text">{$MissionContent03->block_content|nl2br}</p>
							</div>
						</div>
					{/if}

					<div>
					  <p class="copy_text align-center mb20">{$MiddleContent01->block_content|nl2br}</p>
					  <p class="copy_text align-center mb40">{$MiddleContent02->block_content|nl2br}</p>
					  <div class="align-center">
						  <img src="{$BASEURL}/images/philosophy/txt_philosophy_01.gif" width="497" height="30" alt="BETTER STARTS NOW">
					  </div>
					</div>

				</div>
			</section>

			<section>

				<div class="container">
					
					{if $Youtube->block_image_id|intval > 0}
						<div class="mb70">
							<a href="{$Youtube->block_link_url}" class="rollover_01 js-openModal">
								<img src="{$REMOTE_BASEURL}/getfile.php?id={$Youtube->block_image_id}" width="1000" height="400" alt="{$Youtube->object_name}" class="mb10">
							</a>
							<p class="link_01">
								<a href="{$Youtube->block_link_url}" class="js-openModal">{$Youtube->object_name}</a>
							</p>
						</div>
					{/if}

					<div class="gray_block mb70">
						<h2 class="headingLv2 align-left">關於 CITIZEN </h2>
						<p class="mb20">{$AboutCitizen01->block_content|nl2br}</p>
						<p>{$AboutCitizen02->block_content|nl2br}</p>
					</div>

					<div class="columnWrap mb50 column2 clearfix">
						
						{foreach $PickupLinkLine1 as $L1}
							<div class="column">
								<div class="special_image">
									<a href="{$L1->block_link_url}" class="rollover_01">
										<img src="{$REMOTE_BASEURL}/getfile.php?id={$L1->block_image_id}" width="480" height="264" alt="{$L1->object_name}">
									</a>
								</div>
								<p class="link_01"><a href="{$L1->block_link_url}">{$L1->object_name}</a></p>
							</div>
						{/foreach}

					</div>

					<div class="mb50">
						
						{foreach $PickupLinkLine2 as $L2}
							<a href="{$L2->block_link_url}" target="_blank" class="rollover_01">
								<img src="{$REMOTE_BASEURL}/getfile.php?id={$L2->block_image_id}" width="1000" height="320" alt="{$L2->object_name}" class="mb10">
							</a>
							<p class="link_01">
								<a href="{$L2->block_link_url}" target="_blank">
									{$L2->object_name}
									<img src="{$BASEURL}/images/common/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01">
								</a>
							</p>
						{/foreach}

					</div>

					<div class="columnWrap mb50 column2 clearfix">
						
						{foreach $PickupLinkLine3 as $L3}
							<div class="column">
								<div class="special_image">
									<a href="{$L3->block_link_url}" class="rollover_01">
										<img src="{$REMOTE_BASEURL}/getfile.php?id={$L3->block_image_id}" width="480" alt="{$L3->object_name}">
									</a>
								</div>
								<p class="link_01">
									<a href="{$L3->block_link_url}">{$L3->object_name}</a>
								</p>
							</div>
						{/foreach}

					</div>
				</div>
				  
			</section>

		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}