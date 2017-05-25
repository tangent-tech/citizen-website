<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{$TITLE|escape:'html'}</title>
<meta name="title" content="{$TITLE|escape:'html'}" />
<meta name="description" content="{$ObjectLink->object->object_meta_description|escape:'html'}" />
<meta name="keywords" content="{$ObjectLink->object->object_meta_keywords|escape:'html'}" />
<link href="{$smarty.const.BASEURL}/css/reset.css" rel="stylesheet" type="text/css" />
<link href="{$smarty.const.BASEURL}/css/{$CurrentLang->language_root->language_id}/style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="{$smarty.const.BASEURL}/js/prettyPhoto_3.1.2/css/prettyPhoto.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" type="text/css" media="screen" href="{$smarty.const.BASEURL}/js/superfish-1.4.8/css/superfish.css" />
<!-- link rel="stylesheet" type="text/css" media="screen" href="/js/jquery.ui.stars-3.0/jquery.ui.stars.css" /> -->
<link rel="stylesheet" type="text/css" media="screen" href="{$smarty.const.BASEURL}/js/jquery.ui.stars-3.0/css/crystal-stars.css" />
<style type="text/css">
{if $BackdropBlockContent != 0}
	div.Container {ldelim}
		background-image: url(/getfile.php?id={$BackdropBlockContent});
		background-repeat: no-repeat;
	{rdelim}
{/if}
</style>
<script type="text/javascript" src="{$smarty.const.BASEURL}/js/jquery-1.5.2.min.js"></script>
<script type="text/javascript" src="{$smarty.const.BASEURL}/js/jquery.cookie.js"></script>
<script type="text/javascript" src="{$smarty.const.BASEURL}/js/superfish-1.4.8/js/hoverIntent.js"></script>
<script type="text/javascript" src="{$smarty.const.BASEURL}/js/superfish-1.4.8/js/superfish.js"></script>
<script type="text/javascript" src="{$smarty.const.BASEURL}/js/superfish-1.4.8/js/supersubs.js"></script>
<script type="text/javascript" src="{$smarty.const.BASEURL}/js/prettyPhoto_3.1.2/js/jquery.prettyPhoto.js"></script>

{*
<script type="text/javascript" src="/js/prettyPhoto_2.5.6/js/jquery.prettyPhoto.js"></script>
<script type="text/javascript" src="/js/jquery-validate/jquery.validate.js"></script>
<script type="text/javascript" src="/js/jquery-validate/jquery.metadata.js"></script>
<script type="text/javascript" src="/js/jquery-validate/jquery.form.js"></script>
<script type="text/javascript" src="/js/jquery-validate/localization/messages_tw.js"></script>
<script type="text/javascript" src="/js/js_constant/{$CurrentLang->language_root->language_id}/constant.js"></script>
<script type="text/javascript" src="/js/jquery-ui-1.8.7.custom/js/jquery-ui-1.8.7.custom.min.js"></script>
<script type="text/javascript" src="/js/jquery.ui.stars-3.0/jquery.ui.stars.js"></script>
*}
<script type="text/javascript" src="{$smarty.const.BASEURL}/js/website.js"></script>
<script type="text/javascript">
	var MyJS = '{$MyJS}';
	var ObjID = '{$ObjectLink->object->object_id}';
	{$PageCustomJS};
</script>
</head>
<body>
	<div class="Container">
