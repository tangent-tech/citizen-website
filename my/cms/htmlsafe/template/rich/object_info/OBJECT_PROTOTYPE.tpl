	<object_id>{$Object.object_id}</object_id>
	<object_link_id>{$Object.object_link_id}</object_link_id>
	<object_is_enable>{$Object.object_is_enable}</object_is_enable>
	<object_link_is_enable>{$Object.object_link_is_enable}</object_link_is_enable>
	<object_type>{$Object.object_type}</object_type>
	<object_security_level>{$Object.object_security_level}</object_security_level>
	<object_archive_date>{$Object.object_archive_date}</object_archive_date>
	<object_publish_date>{$Object.object_publish_date}</object_publish_date>
	<parent_object_id>{$Object.parent_object_id}</parent_object_id>
	<language_id>{$Object.language_id}</language_id>
	<object_name>{$Object.object_name|myxml}</object_name>
	<object_thumbnail_file_id>{$Object.object_thumbnail_file_id}</object_thumbnail_file_id>
	<object_meta_title>{$Object.object_meta_title|myxml}</object_meta_title>
	<object_meta_description>{$Object.object_meta_description|myxml}</object_meta_description>
	<object_meta_keywords>{$Object.object_meta_keywords|myxml}</object_meta_keywords>
	{if $Object.object_type != 'LINK'}
		<object_friendly_url>{$Object.object_friendly_url|ConvertToHyphen|myxml}</object_friendly_url>
	{else}
		<object_friendly_url>{$Object.object_friendly_url|myxml}</object_friendly_url>
	{/if}
	<object_seo_url>{$Object.object_seo_url|myxml}</object_seo_url>
	<object_lang_switch_id>{$Object.object_lang_switch_id|myxml}</object_lang_switch_id>
	<modify_date>{$Object.modify_date|myxml}</modify_date>
	<create_date>{$Object.create_date|myxml}</create_date>
	<counter_alltime>{$Object.counter_alltime}</counter_alltime>
	<object_vote_sum_1>{$Object.object_vote_sum_1}</object_vote_sum_1>
	<object_vote_count_1>{$Object.object_vote_count_1}</object_vote_count_1>
	<object_vote_average_1>{$Object.object_vote_average_1}</object_vote_average_1>
	<object_vote_sum_2>{$Object.object_vote_sum_2}</object_vote_sum_2>
	<object_vote_count_2>{$Object.object_vote_count_2}</object_vote_count_2>
	<object_vote_average_2>{$Object.object_vote_average_2}</object_vote_average_2>
	<object_vote_sum_3>{$Object.object_vote_sum_3}</object_vote_sum_3>
	<object_vote_count_3>{$Object.object_vote_count_3}</object_vote_count_3>
	<object_vote_average_3>{$Object.object_vote_average_3}</object_vote_average_3>
	<object_vote_sum_4>{$Object.object_vote_sum_4}</object_vote_sum_4>
	<object_vote_count_4>{$Object.object_vote_count_4}</object_vote_count_4>
	<object_vote_average_4>{$Object.object_vote_average_4}</object_vote_average_4>
	<object_vote_sum_5>{$Object.object_vote_sum_5}</object_vote_sum_5>
	<object_vote_count_5>{$Object.object_vote_count_5}</object_vote_count_5>
	<object_vote_average_5>{$Object.object_vote_average_5}</object_vote_average_5>
	<object_vote_sum_6>{$Object.object_vote_sum_6}</object_vote_sum_6>
	<object_vote_count_6>{$Object.object_vote_count_6}</object_vote_count_6>
	<object_vote_average_6>{$Object.object_vote_average_6}</object_vote_average_6>
	<object_vote_sum_7>{$Object.object_vote_sum_7}</object_vote_sum_7>
	<object_vote_count_7>{$Object.object_vote_count_7}</object_vote_count_7>
	<object_vote_average_7>{$Object.object_vote_average_7}</object_vote_average_7>
	<object_vote_sum_8>{$Object.object_vote_sum_8}</object_vote_sum_8>
	<object_vote_count_8>{$Object.object_vote_count_8}</object_vote_count_8>
	<object_vote_average_8>{$Object.object_vote_average_8}</object_vote_average_8>
	<object_vote_sum_9>{$Object.object_vote_sum_9}</object_vote_sum_9>
	<object_vote_count_9>{$Object.object_vote_count_9}</object_vote_count_9>
	<object_vote_average_9>{$Object.object_vote_average_9}</object_vote_average_9>
