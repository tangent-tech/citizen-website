{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>
			
			{*Key Visual*}
			{if $MobileKeyVisual->block_image_id|intval > 0}
				<div class="keyvisualBlock mb50">
					<div class="mb30">
						<div class="align-center">
							<img src="{$REMOTE_BASEURL}/getfile.php?id={$MobileKeyVisual->block_image_id}" alt="{$MobileKeyVisual->object_name}">
						</div>
						<p class="mt20">
							<div class="container">
								{$MobileKeyVisual->block_content|nl2br}
							</div>
						</p>
					</div>
				</div>
			{/if}

			<section class="mb70">
				<div class="container">

					<h2 class="headingLv2 AboutUsHeading">
						Our role is <br>“To open new doors for the watch industries”
					</h2>

					{if $MissionContent01->block_image_id|intval > 0}
						{*<h2 class="headingLv2">{$MissionContent01->object_name}</h2>*}
						<div class="mb30">
							<p>{$MissionContent01->block_content|nl2br}</p>
							<div class="align-center mt15">
								<img src="{$REMOTE_BASEURL}/getfile.php?id={$MissionContent01->block_image_id}" alt="{$MissionContent01->object_name}">
							</div>
						</div>
					{/if}
					
					{if $MissionContent02->block_image_id|intval > 0}
						<div class="mb30">
							<p>{$MissionContent02->block_content|nl2br}</p>
							<div class="align-center mt15">
								<img src="{$REMOTE_BASEURL}/getfile.php?id={$MissionContent02->block_image_id}" alt="{$MissionContent02->object_name}">
							</div>
						</div>
					{/if}

					{if $MissionContent03->block_image_id|intval > 0}
						<div class="mb30">
							<p>{$MissionContent03->block_content|nl2br}</p>
							<div class="align-center mt15">
								<img src="{$REMOTE_BASEURL}/getfile.php?id={$MissionContent03->block_image_id}" alt="{$MissionContent03->object_name}">
							</div>
						</div>
					{/if}
					
					<div>
						<p class="copy_text align-center mb20">{$MiddleContent01->block_content|nl2br}</p>
						<p class="copy_text align-center mb40">{$MiddleContent02->block_content|nl2br}</p>
						<div class="align-center">
							<img src="{$BASEURL}/images/philosophy/txt_philosophy_01.gif" alt="BETTER STARTS NOW">
						</div>
					</div>

				</div>
			</section>

			<section>
				<div class="container">

					{if $Youtube->block_image_id|intval > 0}
						<div class="mb70">
							<div class="align-center">
								<a href="{$Youtube->block_link_url}" class="rollover_01 js-openModal">
									<img src="{$REMOTE_BASEURL}/getfile.php?id={$Youtube->block_image_id}" width="100%" alt="{$Youtube->object_name}" class="mb10">
								</a>
							</div>
							<p class="link_01">
								<a href="{$Youtube->block_link_url}" class="js-openModal">{$Youtube->object_name}</a>
							</p>
						</div>
					{/if}

					<div class="gray_block mb70">
						<h2 class="headingLv2 align-left">About Citizen</h2>
						<p class="mb20">{$AboutCitizen01->block_content|nl2br}</p>
						<p>{$AboutCitizen02->block_content|nl2br}</p>
					</div>
	
					{foreach $PickupLinkLine1 as $L1}

						<div class="mb15">
							<div class="align-center">
								<a href="{$L1->block_link_url}" class="rollover_01">
									<img src="{$REMOTE_BASEURL}/getfile.php?id={$L1->block_image_id}" alt="{$L1->object_name}">
								</a>
							</div>
							<p class="link_01"><a href="{$L1->block_link_url}">{$L1->object_name}</a></p>
						</div>

					{/foreach}
					
					{foreach $MobilePickupLinkLine2 as $L2}
						
						<div class="mb15">
							<div class="align-center">
								<a href="{$L2->block_link_url}" target="_blank" class="rollover_01">
									<img src="{$REMOTE_BASEURL}/getfile.php?id={$L2->block_image_id}" alt="{$L2->object_name}" class="mb10">
								</a>
							</div>
							<p class="link_01">
								<a href="{$L2->block_link_url}" target="_blank">
									{$L2->object_name}
									<img src="{$BASEURL}/images/common/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01">
								</a>
							</p>
						</div>
						
					{/foreach}

					{foreach $PickupLinkLine3 as $L3}
							
						<div class="mb15">
							<div class="align-center">
								<a href="{$L3->block_link_url}" class="rollover_01">
									<img src="{$REMOTE_BASEURL}/getfile.php?id={$L3->block_image_id}" alt="{$L3->object_name}">
								</a>
							</div>
							<p class="link_01">
								<a href="{$L3->block_link_url}">
									{$L3->object_name}
									<img src="{$BASEURL}/images/common/icon_brank_01.png" width="13" height="10" alt="" class="icon_brank_01">
								</a>
							</p>
						</div>
							
					{/foreach}

				</div>
			</section>

		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}