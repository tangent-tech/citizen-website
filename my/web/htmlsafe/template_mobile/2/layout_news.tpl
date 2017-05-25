{include file="`$CurrentLang->language_root->language_id`/header.tpl"}

	<div class="main">		
		<main>

			<div class="headingLv1Block noBorderTop">
				<h1 class="headingLv1">{$NewsList->object_name}</h1>
			</div>

			<article>
				<div class="container">
					<div class="news_article">
						
						{assign var=LayoutNewsTitle value=$LayoutNews->layout_news->layout->block_defs->block_def[0]->block_contents->block[0]->block_content}
						{assign var=DisplayTag value=$LayoutNews->layout_news->layout->block_defs->block_def[5]->block_contents->block[0]->block_content}
						{assign var=Content value=$LayoutNews->layout_news->layout->block_defs->block_def[4]->block_contents->block[0]->block_content}
						
						<p class="news_date">{$LayoutNews->layout_news->layout_news_date|date_format:"Y/m/d"}</p>
						
						<p class="icon_categoryBadge mg00">
							{if $LayoutNews->layout_news->layout_news_category_id|intval == $smarty.const.WHAT_NEWS_CATEGORY_ID}
								<img src="{$BASEURL}/images/common/icon_categoryBadge_news_01.jpg" width="96" height="18" alt="NEWS">
							{else if $LayoutNews->layout_news->layout_news_category_id|intval == $smarty.const.EVENT_NEWS_CATEGORY_ID}
								<img src="{$BASEURL}/images/common/icon_categoryBadge_events_01.jpg" width="96" height="18" alt="EVENTS">

							{else if $DisplayTag == "PRODUCT"}
								<img src="{$BASEURL}/images/common/icon_categoryBadge_product_01.gif" width="96" height="18" alt="PRODUCT">
							{else if $DisplayTag == "CORPORATE"}
								<img src="{$BASEURL}/images/common/icon_categoryBadge_corporate_01.gif" width="96" height="18" alt="CORPORATE">
							{else if $DisplayTag == "TECHNOLOGE"}
								<img src="{$BASEURL}/images/common/icon_categoryBadge_technology_01.gif" width="96" height="18" alt="TECHNOLOGE">
							{else if $DisplayTag == "TOPICS"}
								<img src="{$BASEURL}/images/common/icon_categoryBadge_topics_01.gif" width="96" height="18" alt="TOPICS">
							{/if}
						</p>
					  
						<h2 class="news_article_title">{$LayoutNewsTitle|nl2br}</h2>
							
						<div class="clearfix mt20">
							{$Content}
						</div>

					</div>
				</div>
			</article>

		</main>
	</div>

{include file="`$CurrentLang->language_root->language_id`/footer.tpl"}