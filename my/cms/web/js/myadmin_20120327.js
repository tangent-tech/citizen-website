function DoubleConfirm(msg1, msg2) {
	var check1=confirm(msg1);
	if (check1) {
		var check2=confirm(msg2);
		if (check2) {
			return true;
		}
		else {
			return false;
		}
	}
	else {
		return false;
	}
}

jQuery.fromXMLString = function(strXML){
    if (window.DOMParser) {
        return jQuery(new DOMParser().parseFromString(strXML, "text/xml"));
    } else if (window.ActiveXObject) {
        var doc = new ActiveXObject("Microsoft.XMLDOM");
        doc.async = "false";
        doc.loadXML(strXML);
        return jQuery(doc);
    } else {
        return jQuery(strXML);
    }
};

function get_html_translation_table (table, quote_style) {
    var entities = {}, hash_map = {}, decimal = 0, symbol = '';
    var constMappingTable = {}, constMappingQuoteStyle = {};
    var useTable = {}, useQuoteStyle = {};

    // Translate arguments
    constMappingTable[0]      = 'HTML_SPECIALCHARS';
    constMappingTable[1]      = 'HTML_ENTITIES';
    constMappingQuoteStyle[0] = 'ENT_NOQUOTES';
    constMappingQuoteStyle[2] = 'ENT_COMPAT';
    constMappingQuoteStyle[3] = 'ENT_QUOTES';

    useTable       = !isNaN(table) ? constMappingTable[table] : table ? table.toUpperCase() : 'HTML_SPECIALCHARS';
    useQuoteStyle = !isNaN(quote_style) ? constMappingQuoteStyle[quote_style] : quote_style ? quote_style.toUpperCase() : 'ENT_COMPAT';

    if (useTable !== 'HTML_SPECIALCHARS' && useTable !== 'HTML_ENTITIES') {
        throw new Error("Table: "+useTable+' not supported');
        // return false;
    }

    entities['38'] = '&amp;';
    if (useTable === 'HTML_ENTITIES') {
        entities['160'] = '&nbsp;';
        entities['161'] = '&iexcl;';
        entities['162'] = '&cent;';
        entities['163'] = '&pound;';
        entities['164'] = '&curren;';
        entities['165'] = '&yen;';
        entities['166'] = '&brvbar;';
        entities['167'] = '&sect;';
        entities['168'] = '&uml;';
        entities['169'] = '&copy;';
        entities['170'] = '&ordf;';
        entities['171'] = '&laquo;';
        entities['172'] = '&not;';
        entities['173'] = '&shy;';
        entities['174'] = '&reg;';
        entities['175'] = '&macr;';
        entities['176'] = '&deg;';
        entities['177'] = '&plusmn;';
        entities['178'] = '&sup2;';
        entities['179'] = '&sup3;';
        entities['180'] = '&acute;';
        entities['181'] = '&micro;';
        entities['182'] = '&para;';
        entities['183'] = '&middot;';
        entities['184'] = '&cedil;';
        entities['185'] = '&sup1;';
        entities['186'] = '&ordm;';
        entities['187'] = '&raquo;';
        entities['188'] = '&frac14;';
        entities['189'] = '&frac12;';
        entities['190'] = '&frac34;';
        entities['191'] = '&iquest;';
        entities['192'] = '&Agrave;';
        entities['193'] = '&Aacute;';
        entities['194'] = '&Acirc;';
        entities['195'] = '&Atilde;';
        entities['196'] = '&Auml;';
        entities['197'] = '&Aring;';
        entities['198'] = '&AElig;';
        entities['199'] = '&Ccedil;';
        entities['200'] = '&Egrave;';
        entities['201'] = '&Eacute;';
        entities['202'] = '&Ecirc;';
        entities['203'] = '&Euml;';
        entities['204'] = '&Igrave;';
        entities['205'] = '&Iacute;';
        entities['206'] = '&Icirc;';
        entities['207'] = '&Iuml;';
        entities['208'] = '&ETH;';
        entities['209'] = '&Ntilde;';
        entities['210'] = '&Ograve;';
        entities['211'] = '&Oacute;';
        entities['212'] = '&Ocirc;';
        entities['213'] = '&Otilde;';
        entities['214'] = '&Ouml;';
        entities['215'] = '&times;';
        entities['216'] = '&Oslash;';
        entities['217'] = '&Ugrave;';
        entities['218'] = '&Uacute;';
        entities['219'] = '&Ucirc;';
        entities['220'] = '&Uuml;';
        entities['221'] = '&Yacute;';
        entities['222'] = '&THORN;';
        entities['223'] = '&szlig;';
        entities['224'] = '&agrave;';
        entities['225'] = '&aacute;';
        entities['226'] = '&acirc;';
        entities['227'] = '&atilde;';
        entities['228'] = '&auml;';
        entities['229'] = '&aring;';
        entities['230'] = '&aelig;';
        entities['231'] = '&ccedil;';
        entities['232'] = '&egrave;';
        entities['233'] = '&eacute;';
        entities['234'] = '&ecirc;';
        entities['235'] = '&euml;';
        entities['236'] = '&igrave;';
        entities['237'] = '&iacute;';
        entities['238'] = '&icirc;';
        entities['239'] = '&iuml;';
        entities['240'] = '&eth;';
        entities['241'] = '&ntilde;';
        entities['242'] = '&ograve;';
        entities['243'] = '&oacute;';
        entities['244'] = '&ocirc;';
        entities['245'] = '&otilde;';
        entities['246'] = '&ouml;';
        entities['247'] = '&divide;';
        entities['248'] = '&oslash;';
        entities['249'] = '&ugrave;';
        entities['250'] = '&uacute;';
        entities['251'] = '&ucirc;';
        entities['252'] = '&uuml;';
        entities['253'] = '&yacute;';
        entities['254'] = '&thorn;';
        entities['255'] = '&yuml;';
    }

    if (useQuoteStyle !== 'ENT_NOQUOTES') {
        entities['34'] = '&quot;';
    }
    if (useQuoteStyle === 'ENT_QUOTES') {
        entities['39'] = '&#39;';
    }
    entities['60'] = '&lt;';
    entities['62'] = '&gt;';


    // ascii decimals to real symbols
    for (decimal in entities) {
        symbol = String.fromCharCode(decimal);
        hash_map[symbol] = entities[decimal];
    }

    return hash_map;
}

function htmlentities (string, quote_style) {
    var hash_map = {}, symbol = '', tmp_str = '', entity = '';
    tmp_str = string.toString();

    if (false === (hash_map = this.get_html_translation_table('HTML_ENTITIES', quote_style))) {
        return false;
    }
    hash_map["'"] = '&#039;';
    for (symbol in hash_map) {
        entity = hash_map[symbol];
        tmp_str = tmp_str.split(symbol).join(entity);
    }

    return tmp_str;
}

function GetTime() {
  var curtime = new Date();
  var curhour = curtime.getHours();
  var curmin = curtime.getMinutes();
  var cursec = curtime.getSeconds();
  var time = "";

  if(curhour == 0) curhour = 12;
  time = (curhour > 12 ? curhour - 12 : curhour) + ":" +
         (curmin < 10 ? "0" : "") + curmin + ":" +
         (cursec < 10 ? "0" : "") + cursec + " " +
         (curhour > 12 ? "PM" : "AM");

  return time;
}

function resetEditors(sEditorName) {
    // If the editor API does not exist, there are no editors
    if (typeof sEditorName == "undefined") return;

    // Get the initial value
    var sInitialValue = document.getElementById(sEditorName).value;

    // Overwrite the editor's current value
    FCKeditorAPI.__Instances[sEditorName].SetHTML(sInitialValue);
}

function InitEvent(event, ui) {
	$('.MyButton, .MyTinyButton, .MyInputButton, .MyIconButton').hover(
		function() { $(this).addClass('ui-state-hover'); },
		function() { $(this).removeClass('ui-state-hover'); }
	);
	$('.DatePicker').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true });

	$('.Menu > li, .InnerTab > ul > li, tr').hover(
		function() { $(this).addClass('ui-state-active ui-state-hover-custom'); },
		function() { $(this).removeClass('ui-state-active ui-state-hover-custom'); }
	);
}

$(document).ready(function(){
	if (SystemMsg != '')
		$.jGrowl(SystemMsg, {life: 10000});
	if (ErrorMsg != '')
		$.jGrowl(ErrorMsg, {life: 10000});

	$('a.ScreenWidthSelection').click( function(ev) {
		ev.preventDefault();
		$.ajax({
			url: $(this).attr('href')
		});
		$('a.ScreenWidthSelection').removeClass('ui-state-active');
		$(this).addClass('ui-state-active');
		$('#Container').css('width', $(this).attr('data-width'));
	});

	$('a.MySubmitButton').click( function(ev) {
		ev.preventDefault();
		if ($(this).attr('target') != '') {
			$('#' + $(this).attr('target')).submit();
		}
	});

	$('a.MyResetButton').click( function(ev) {
		ev.preventDefault();
		if ($(this).attr('target') != '') {
			$('#' + $(this).attr('target')).each (function(){
				this.reset();
			});
		}
		if ($(this).attr('EditorInstance') != '') {
			jQuery.each($(this).attr('EditorInstance').split(' '), function() {
				resetEditors(this);
			});
		}
	});

	if ($.cookie("BtnToggleThumbnails") == 'N')
		$("#BtnToggleThumbnails").attr('data-Value', 'Y');
	else
		$("#BtnToggleThumbnails").attr('data-Value', 'N');
	$("#BtnToggleThumbnails").live('click', function(){
		if ($(this).attr('data-Value') == 'Y') {
			$(this).attr('data-Value', 'N');
			$.cookie("BtnToggleThumbnails", "N", { expires: 365 });
			$('img.MediaSmallFile').hide();
			$('br.MediaSmallFile').hide();
		}
		else {
			$(this).attr('data-Value', 'Y');
			$.cookie("BtnToggleThumbnails", "Y", { expires: 365 });
			$('img.MediaSmallFile').show();
			$('br.MediaSmallFile').show();
		}
	});
	$("#BtnToggleThumbnails").click();
	
//	$('tr.DisabledRow > td').not(".NoDisabledRow").addClass('ui-state-disabled');

/*
	$('#Menu > ul > li').filter(function (index) {
		return $(this).find('a').attr("href") == CurrentTab;
	}).addClass('ui-tabs-selected ui-state-active');
*/
	if (MyJS == 'product_tree' || MyJS == 'product_category_tree') {
		$('#PRODUCT_TREE').tree({
			lang : {
				new_node : "Untitled"
			},
			opened: ['OL_0'],
			ui : {
			    theme_name : "classic",
			    animation : "200"
			},
			rules : {
				// only nodes of type root can be top level nodes
				valid_children : [ "SITE_ROOT" ],
				drag_copy : "ctrl",
				multiple : false
			},
			types : {
				// all node types inherit the "default" node type
				"default" : {
					clickable	: true,
					renameable	: true,
					creatable	: true,
					draggable	: true,
					deletable	: false,
					max_children : -1,
					max_depth: -1,
					valid_children	: []
				},
				"SITE_ROOT" : {
					creatable	: false,
					renameable	: false,
					deletable	: false,
					draggable	: false,
					valid_children : [ "ENABLE_PRODUCT_ROOT", "DISABLE_PRODUCT_ROOT", "ENABLE_PRODUCT_ROOT_SPECIAL", "DISABLE_PRODUCT_ROOT_SPECIAL" ]
				},
				"ENABLE_PRODUCT_ROOT_SPECIAL" : {
					creatable	: false,
					renameable	: false,
					deletable	: false,
					draggable	: false,
					valid_children : [ "ENABLE_PRODUCT_SPECIAL_CATEGORY", "DISABLE_PRODUCT_SPECIAL_CATEGORY" ]
				},
				"DISABLE_PRODUCT_ROOT_SPECIAL" : {
					creatable	: false,
					renameable	: false,
					deletable	: false,
					draggable	: false,
					valid_children : [ "ENABLE_PRODUCT_SPECIAL_CATEGORY", "DISABLE_PRODUCT_SPECIAL_CATEGORY" ]
				},
				"ENABLE_PRODUCT_ROOT" : {
					renameable	: false,
					deletable	: false,
					valid_children : [ 	"ENABLE_PRODUCT_CATEGORY", "DISABLE_PRODUCT_CATEGORY",
										"ENABLE_PRODUCT", "DISABLE_PRODUCT" ]
				},
				"DISABLE_PRODUCT_ROOT" : {
					renameable	: false,
					deletable	: false,
					valid_children : [ 	"ENABLE_PRODUCT_CATEGORY", "DISABLE_PRODUCT_CATEGORY",
										"ENABLE_PRODUCT", "DISABLE_PRODUCT" ],
					icon : {
						image : "../js/jstree/disable_folder.png"
					}
				},
				"ENABLE_PRODUCT_SPECIAL_CATEGORY" : {
					deletable	: false,
					draggable	: false,
					valid_children : [ 	"ENABLE_PRODUCT", "DISABLE_PRODUCT" ]
				},
				"DISABLE_PRODUCT_SPECIAL_CATEGORY" : {
					deletable	: false,
					draggable	: false,
					valid_children : [ 	"ENABLE_PRODUCT", "DISABLE_PRODUCT" ]
				},
				"ENABLE_PRODUCT_CATEGORY" : {
					valid_children : [ 	"ENABLE_PRODUCT_CATEGORY", "DISABLE_PRODUCT_CATEGORY",
										"ENABLE_PRODUCT", "DISABLE_PRODUCT" ]
				},
				"DISABLE_PRODUCT_CATEGORY" : {
					valid_children : [ 	"ENABLE_PRODUCT_CATEGORY", "DISABLE_PRODUCT_CATEGORY",
										"ENABLE_PRODUCT", "DISABLE_PRODUCT" ],
					icon : {
						image : "../js/jstree/disable_folder.png"
					}
				},
				"ENABLE_PRODUCT" : {
					creatable	: false,
					valid_children : [],
					icon : {
						image : "../js/jstree/product.png"
					}
				},
				"DISABLE_PRODUCT" : {
					creatable	: false,
					valid_children : [],
					icon : {
						image : "../js/jstree/disable_product.png"
					}
				}
			},


			plugins : {
				contextmenu : {
					items : {
						create: false,
						rename: {},
						remove: {separator_after : true},
						insert_category : {
							label	: "Insert Category",
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('data-object_type') == 'PRODUCT_CATEGORY' || $(NODE).attr('data-object_type') == 'PRODUCT_ROOT' )
									return true;
								else
									return false;
							},
							action	: function (NODE, TREE_OBJ) {
								TREE_OBJ.create(
									{
										attributes : {"rel" : "ENABLE_PRODUCT_CATEGORY", "data-object_system_flag" : "normal", "data-object_type" : "PRODUCT_CATEGORY" }
									},
									NODE,
									"inside"
								);
							}
						},
						insert_product : {
							label	: "Insert Product",
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('data-object_type') == 'PRODUCT_CATEGORY' || $(NODE).attr('data-object_type') == 'PRODUCT_ROOT' )
									return true;
								else
									return false;
							},
							action	: function (NODE, TREE_OBJ) {
								TREE_OBJ.create(
									{
										attributes : {"rel" : "ENABLE_PRODUCT", "data-object_system_flag" : "normal", "data-object_type" : "PRODUCT" }
									},
									NODE,
									"inside"
								);
							}
						},

						set_enable : {
							label	: "Enable",
							icon	: "", // you can set this to a classname or a path to an icon like ./myimage.gif
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('rel').indexOf("DISABLE") >= 0)
									return true;
								return false;
							},
							action	: function (NODE, TREE_OBJ) {
								var response = $.ajax({
									type:	"POST",
									async:	false,
									url:	"product_tree_enable.php",
									dataType:	"xml",
									data:	"type=" + $(NODE).attr('data-object_type') +"&link_id=" + $(NODE).attr('data-object_link_id') + "&action=Y",
									error:	function (XMLHttpRequest, textStatus, errorThrown) {
										$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
									}
								}).responseText;

								var status = $.fromXMLString(response).find('status').eq(0).text();
								var msg = $.fromXMLString(response).find('msg').eq(0).text();
								var NewStatus = $.fromXMLString(response).find('new_status').eq(0).text();

								if (status == 'ok') {
									if (NewStatus == 'enable')
										TREE_OBJ.set_type('ENABLE_' + $(NODE).attr('data-object_type'), $(NODE));
									$.jGrowl(msg, {header: GetTime()});
								}
								else {
									$.jGrowl(msg);
								}
							},
							separator_before : true
						},
						set_disable : {
							label	: "Disable",
							icon	: "", // you can set this to a classname or a path to an icon like ./myimage.gif
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('rel').indexOf("ENABLE") >= 0)
									return true;
								return false;
							},
							action	: function (NODE, TREE_OBJ) {
								var response = $.ajax({
									type:	"POST",
									async:	false,
									url:	"product_tree_enable.php",
									dataType:	"xml",
									data:	"type=" + $(NODE).attr('data-object_type') +"&link_id=" + $(NODE).attr('data-object_link_id') + "&action=N",
									error:	function (XMLHttpRequest, textStatus, errorThrown) {
										$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
									}
								}).responseText;

								var status = $.fromXMLString(response).find('status').eq(0).text();
								var msg = $.fromXMLString(response).find('msg').eq(0).text();
								var NewStatus = $.fromXMLString(response).find('new_status').eq(0).text();

								if (status == 'ok') {
									if (NewStatus == 'disable')
										TREE_OBJ.set_type('DISABLE_' + $(NODE).attr('data-object_type'), $(NODE));
									$.jGrowl(msg, {header: GetTime()});
								}
								else {
									$.jGrowl(msg);
								}
							}
						}
					}
				}
			},


			callback: {
				"onload" : function(TREE_OBJ) {
					TREE_OBJ.open_all();
				},
				"onrename" : function(NODE, TREE_OBJ, RB) {
					var response = $.ajax({
						type:	"POST",
						async:	false,
						url:	"product_tree_rename.php",
						dataType:	"xml",
						data:	"link_id=" + $(NODE).attr('data-object_link_id') + "&obj_name=" + encodeURIComponent(TREE_OBJ.get_text(NODE)),
						error:	function (XMLHttpRequest, textStatus, errorThrown) {
							$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
						}
					}).responseText;

					var status = $.fromXMLString(response).find('status').eq(0).text();
					var msg = $.fromXMLString(response).find('msg').eq(0).text();

					if (status == 'ok') {
						$.jGrowl(msg, {header: GetTime()});
					}
					else {
						jQuery.tree.rollback(RB);
						$.jGrowl(msg, {header: GetTime(), sticky: true});
					}
				},
				"onmove" : function(NODE, REF_NODE, TYPE, TREE_OBJ, RB) {
					var response = $.ajax({
						type:	"POST",
						async:	false,
						url:	"product_tree_move.php",
						dataType:	"xml",
						data:	"link_id=" + $(NODE).attr('data-object_link_id') + "&ref_link_id=" + $(REF_NODE).attr('data-object_link_id') + "&move_type=" + TYPE,
						error:	function (XMLHttpRequest, textStatus, errorThrown) {
							$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
						}
					}).responseText;

					var status = $.fromXMLString(response).find('status').eq(0).text();
					var msg = $.fromXMLString(response).find('msg').eq(0).text();

					if (status == 'ok') {
						$.jGrowl(msg, {header: GetTime()});
					}
					else {
						jQuery.tree.rollback(RB);
						$.jGrowl(msg, {header: GetTime(), sticky: true});
					}
				},
				"oncreate" : function(NODE, REF_NODE, TYPE, TREE_OBJ, RB) {
					var response = $.ajax({
						type:	"POST",
						async:	false,
						url:	"product_tree_create.php",
						dataType:	"xml",
						data:	"new_object_type=" + $(NODE).attr('data-object_type') + "&ref_link_id=" + $(REF_NODE).attr('data-object_link_id') + "&create_type=" + TYPE,
						error:	function (XMLHttpRequest, textStatus, errorThrown) {
							$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
						}
					}).responseText;

					var status = $.fromXMLString(response).find('status').eq(0).text();
					var msg = $.fromXMLString(response).find('msg').eq(0).text();

					if (status == 'ok') {
						id = $.fromXMLString(response).find('id').eq(0).text();
						$(NODE).attr('data-object_id', id);
						link_id = $.fromXMLString(response).find('link_id').eq(0).text();
						$(NODE).attr('id', "OL_" + link_id);
						$(NODE).attr('data-object_link_id', link_id);
						$.jGrowl(msg, {header: GetTime()});
					}
					else {
						jQuery.tree.rollback(RB);
						$.jGrowl(msg, {header: GetTime(), sticky: true});
					}
				},
				"ondblclk" : function(NODE, TREE_OBJ) {
					if ($(NODE).attr('data-object_type') == 'PRODUCT_CATEGORY')
						$(location).attr('href', 'product_category_edit.php?link_id=' + $(NODE).attr('data-object_link_id'));
					else if ($(NODE).attr('data-object_type') == 'PRODUCT')
						$(location).attr('href', 'product_edit.php?link_id=' + $(NODE).attr('data-object_link_id'));
				}
			}
		});
	}

	if (MyJS == 'product_tree_special') {
		$('#PRODUCT_TREE').tree({
			lang : {
				new_node : "Untitled"
			},
			opened: ['OL_0'],
			ui : {
			    theme_name : "classic",
			    animation : "200"
			},
			rules : {
				// only nodes of type root can be top level nodes
				valid_children : [ "SITE_ROOT" ],
				drag_copy : "ctrl",
				multiple : false
			},
			types : {
				// all node types inherit the "default" node type
				"default" : {
					clickable	: true,
					renameable	: true,
					creatable	: false,
					draggable	: true,
					deletable	: false,
					max_children : -1,
					max_depth: -1,
					valid_children	: []
				},
				"SITE_ROOT" : {
					creatable	: false,
					renameable	: false,
					deletable	: false,
					draggable	: false,
					valid_children : [ "ENABLE_PRODUCT_ROOT_SPECIAL", "DISABLE_PRODUCT_ROOT_SPECIAL" ]
				},
				"ENABLE_PRODUCT_ROOT_SPECIAL" : {
					creatable	: false,
					renameable	: false,
					deletable	: false,
					draggable	: false,
					valid_children : [ "ENABLE_PRODUCT_SPECIAL_CATEGORY", "DISABLE_PRODUCT_SPECIAL_CATEGORY" ]
				},
				"DISABLE_PRODUCT_ROOT_SPECIAL" : {
					creatable	: false,
					renameable	: false,
					deletable	: false,
					draggable	: false,
					valid_children : [ "ENABLE_PRODUCT_SPECIAL_CATEGORY", "DISABLE_PRODUCT_SPECIAL_CATEGORY" ]
				},
				"ENABLE_PRODUCT_SPECIAL_CATEGORY" : {
				},
				"DISABLE_PRODUCT_SPECIAL_CATEGORY" : {
					icon : {
						image : "../js/jstree/disable_folder.png"
					}
				}				
			},

			plugins : {
				contextmenu : {
					items : {
						create: false,
						rename: {},
						remove: false,
						set_enable : {
							label	: "Enable",
							icon	: "", // you can set this to a classname or a path to an icon like ./myimage.gif
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('rel').indexOf("DISABLE") >= 0)
									return true;
								return false;
							},
							action	: function (NODE, TREE_OBJ) {
								var response = $.ajax({
									type:	"POST",
									async:	false,
									url:	"product_tree_enable.php",
									dataType:	"xml",
									data:	"type=" + $(NODE).attr('data-object_type') +"&link_id=" + $(NODE).attr('data-object_link_id') + "&action=Y",
									error:	function (XMLHttpRequest, textStatus, errorThrown) {
										$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
									}
								}).responseText;

								var status = $.fromXMLString(response).find('status').eq(0).text();
								var msg = $.fromXMLString(response).find('msg').eq(0).text();
								var NewStatus = $.fromXMLString(response).find('new_status').eq(0).text();

								if (status == 'ok') {
									if (NewStatus == 'enable')
										TREE_OBJ.set_type('ENABLE_' + $(NODE).attr('data-object_type'), $(NODE));
									$.jGrowl(msg, {header: GetTime()});
								}
								else {
									$.jGrowl(msg);
								}
							},
							separator_before : true
						},
						set_disable : {
							label	: "Disable",
							icon	: "", // you can set this to a classname or a path to an icon like ./myimage.gif
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('rel').indexOf("ENABLE") >= 0)
									return true;
								return false;
							},
							action	: function (NODE, TREE_OBJ) {
								var response = $.ajax({
									type:	"POST",
									async:	false,
									url:	"product_tree_enable.php",
									dataType:	"xml",
									data:	"type=" + $(NODE).attr('data-object_type') +"&link_id=" + $(NODE).attr('data-object_link_id') + "&action=N",
									error:	function (XMLHttpRequest, textStatus, errorThrown) {
										$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
									}
								}).responseText;

								var status = $.fromXMLString(response).find('status').eq(0).text();
								var msg = $.fromXMLString(response).find('msg').eq(0).text();
								var NewStatus = $.fromXMLString(response).find('new_status').eq(0).text();

								if (status == 'ok') {
									if (NewStatus == 'disable')
										TREE_OBJ.set_type('DISABLE_' + $(NODE).attr('data-object_type'), $(NODE));
									$.jGrowl(msg, {header: GetTime()});
								}
								else {
									$.jGrowl(msg);
								}
							}
						}
					}
				}
			},


			callback: {
				"onload" : function(TREE_OBJ) {
					TREE_OBJ.open_all();
				},
				"onrename" : function(NODE, TREE_OBJ, RB) {
					var response = $.ajax({
						type:	"POST",
						async:	false,
						url:	"product_tree_rename.php",
						dataType:	"xml",
						data:	"link_id=" + $(NODE).attr('data-object_link_id') + "&obj_name=" + encodeURIComponent(TREE_OBJ.get_text(NODE)),
						error:	function (XMLHttpRequest, textStatus, errorThrown) {
							$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
						}
					}).responseText;

					var status = $.fromXMLString(response).find('status').eq(0).text();
					var msg = $.fromXMLString(response).find('msg').eq(0).text();

					if (status == 'ok') {
						$.jGrowl(msg, {header: GetTime()});
					}
					else {
						jQuery.tree.rollback(RB);
						$.jGrowl(msg, {header: GetTime(), sticky: true});
					}
				},
				"onmove" : function(NODE, REF_NODE, TYPE, TREE_OBJ, RB) {
					var response = $.ajax({
						type:	"POST",
						async:	false,
						url:	"product_tree_move.php",
						dataType:	"xml",
						data:	"link_id=" + $(NODE).attr('data-object_link_id') + "&ref_link_id=" + $(REF_NODE).attr('data-object_link_id') + "&move_type=" + TYPE,
						error:	function (XMLHttpRequest, textStatus, errorThrown) {
							$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
						}
					}).responseText;

					var status = $.fromXMLString(response).find('status').eq(0).text();
					var msg = $.fromXMLString(response).find('msg').eq(0).text();

					if (status == 'ok') {
						$.jGrowl(msg, {header: GetTime()});
					}
					else {
						jQuery.tree.rollback(RB);
						$.jGrowl(msg, {header: GetTime(), sticky: true});
					}
				},
				"ondblclk" : function(NODE, TREE_OBJ) {
					if ($(NODE).attr('data-object_type') == 'PRODUCT_SPECIAL_CATEGORY')
						$(location).attr('href', 'product_category_special_edit.php?link_id=' + $(NODE).attr('data-object_link_id'));
				}
			}
		});
	}

	if (MyJS == 'language_tree') {
		var TheNode, TheTreeObj;
		var DialogSelectAlbum = $('#DialogSelectAlbum').dialog({
			title: 'Select Album',
			modal: true,
			autoOpen: false,
			buttons: {
				'Save': function() {
					$(this).dialog('close');
					TheTreeObj.create(
						{
							attributes : {"rel" : "ENABLE_ALBUM", "data-object_system_flag" : "normal", "data-object_type" : "ALBUM", "data-object_id" : $("select[name='SelectAlbum']").val()},
							data : $("select[name='SelectAlbum'] :selected").text()
						},
						TheNode,
						'inside'
					);
				},
				'Cancel': function() {$(this).dialog('close');}
			}
		});

		var DialogSelectProductRoot = $('#DialogSelectProductRoot').dialog({
			title: 'Select Product Tree',
			modal: true,
			autoOpen: false,
			buttons: {
				'Save': function() {
					$(this).dialog('close');
					TheTreeObj.create(
						{
							attributes : {"rel" : "ENABLE_PRODUCT_ROOT", "data-object_system_flag" : "normal", "data-object_type" : "PRODUCT_ROOT_LINK", "data-object_id" : $("select[name='SelectProductRoot']").val()},
							data : $("select[name='SelectProductRoot'] :selected").text()
						},
						TheNode,
						'inside'
					);
				},
				'Cancel': function() {$(this).dialog('close');}
			}
		});

		var DialogSelectNewsRoot = $('#DialogSelectNewsRoot').dialog({
			title: 'Select News Group',
			modal: true,
			autoOpen: false,
			buttons: {
				'Save': function() {
					$(this).dialog('close');
					TheTreeObj.create(
						{
							attributes : {"rel" : "ENABLE_NEWS_PAGE", "data-object_system_flag" : "normal", "data-object_type" : "NEWS_PAGE", "data-object_id" : $("select[name='SelectNewsRoot']").val()},
							data : $("select[name='SelectNewsRoot'] :selected").text()
						},
						TheNode,
						'inside'
					);
				},
				'Cancel': function() {$(this).dialog('close');}
			}
		});

		var DialogSelectLayoutNewsRoot = $('#DialogSelectLayoutNewsRoot').dialog({
			title: 'Select Layout News Group',
			modal: true,
			autoOpen: false,
			buttons: {
				'Save': function() {
					$(this).dialog('close');
					TheTreeObj.create(
						{
							attributes : {"rel" : "ENABLE_LAYOUT_NEWS_PAGE", "data-object_system_flag" : "normal", "data-object_type" : "LAYOUT_NEWS_PAGE", "data-object_id" : $("select[name='SelectLayoutNewsRoot']").val()},
							data : $("select[name='SelectLayoutNewsRoot'] :selected").text()
						},
						TheNode,
						'inside'
					);
				},
				'Cancel': function() {$(this).dialog('close');}
			}
		});

		$('#SITE_ROOT').tree({
			lang : {
				new_node : "Untitled"
			},
			opened: ['OL_0'],
			ui : {
			    theme_name : "classic",
			    animation : "200"
			},
			rules : {
				// only nodes of type root can be top level nodes
				valid_children : [ "SITE_ROOT" ],
				drag_copy : "ctrl",
				multiple : false
			},
			types : {
				// all node types inherit the "default" node type
				"default" : {
					clickable	: true,
					renameable	: true,
					creatable	: true,
					draggable	: true,
					deletable	: function (NODE) {
						if ($(NODE).is("#SITE_ROOT li[data-object_type='LIBRARY_ROOT'] li[id='" + $(NODE).attr('id') + "']" ))
							return false;
						if ($(NODE).children("ul").children("li").size() > 0)
							return false;
						else if ($(NODE).attr('data-object_system_flag') != 'normal')
							return false;
						return true;
					},
					max_children : -1,
					max_depth: -1,
					valid_children	: []
				},
				"SITE_ROOT" : {
					creatable	: false,
					renameable	: false,
					deletable	: false,
					draggable	: false,
					valid_children : [ "ENABLE_LANGUAGE_ROOT", "DISABLE_LANGUAGE_ROOT", "LIBRARY_ROOT" ]
				},
				"LIBRARY_ROOT" : {
					creatable	: false,
					renameable	: false,
					deletable	: false,
					draggable	: false,
					valid_children : [ "ALBUM_ROOT" ]
				},
				"ENABLE_LANGUAGE_ROOT" : {
					draggable	: false,
					renameable	: false,
					valid_children	: [ "ENABLE_FOLDER", "DISABLE_FOLDER"]
				},
				"DISABLE_LANGUAGE_ROOT" : {
					draggable	: false,
					renameable	: false,
					valid_children	: [ "ENABLE_FOLDER", "DISABLE_FOLDER"],
					icon : {
						image : "../js/jstree/disable_folder.png"
					}
				},
				"ALBUM_ROOT" : {
					renameable	: false,
					draggable	: false,
					valid_children	: [ "ENABLE_ALBUM", "DISABLE_ALBUM"]
				},
				"ENABLE_FOLDER" : {
					valid_children : [ 	"ENABLE_FOLDER", "DISABLE_FOLDER", "ENABLE_PAGE", "DISABLE_PAGE",
										"ENABLE_PRODUCT_ROOT", "DISABLE_PRODUCT_ROOT",
										"ENABLE_PRODUCT_ROOT_LINK", "DISABLE_PRODUCT_ROOT_LINK",
										"ENABLE_NEWS_PAGE", "DISABLE_NEWS_PAGE",
										"ENABLE_LAYOUT_NEWS_PAGE", "DISABLE_LAYOUT_NEWS_PAGE",
										"ENABLE_ALBUM", "DISABLE_ALBUM", "ENABLE_LINK", "DISABLE_LINK" ]
				},
				"DISABLE_FOLDER" : {
					valid_children : [ 	"ENABLE_FOLDER", "DISABLE_FOLDER", "ENABLE_PAGE", "DISABLE_PAGE",
										"ENABLE_PRODUCT_ROOT", "DISABLE_PRODUCT_ROOT",
										"ENABLE_PRODUCT_ROOT_LINK", "DISABLE_PRODUCT_ROOT_LINK",
										"ENABLE_NEWS_PAGE", "DISABLE_NEWS_PAGE",
										"ENABLE_LAYOUT_NEWS_PAGE", "DISABLE_LAYOUT_NEWS_PAGE",
										"ENABLE_ALBUM", "DISABLE_ALBUM", "ENABLE_LINK", "DISABLE_LINK" ],
					icon : {
						image : "../js/jstree/disable_folder.png"
					}
				},
				"ENABLE_PAGE" : {
					icon : {
						image : "../js/jstree/page.png"
					}
				},
				"DISABLE_PAGE" : {
					icon : {
						image : "../js/jstree/disable_page.png"
					}
				},
				"ENABLE_PRODUCT_ROOT" : {
					creatable	: false,
					icon : {
						image : "../js/jstree/product_root.png"
					}
				},
				"DISABLE_PRODUCT_ROOT" : {
					creatable	: false,
					icon : {
						image : "../js/jstree/disable_product_root.png"
					}
				},
				"ENABLE_PRODUCT_ROOT_LINK" : {
					creatable	: false,
					icon : {
						image : "../js/jstree/product_root.png"
					}
				},
				"DISABLE_PRODUCT_ROOT_LINK" : {
					creatable	: false,
					icon : {
						image : "../js/jstree/disable_product_root.png"
					}
				},
				"ENABLE_NEWS_PAGE" : {
					creatable	: false,
					icon : {
						image : "../js/jstree/news.png"
					}
				},
				"DISABLE_NEWS_PAGE" : {
					creatable	: false,
					icon : {
						image : "../js/jstree/disable_news.png"
					}
				},
				"ENABLE_LAYOUT_NEWS_PAGE" : {
					creatable	: false,
					icon : {
						image : "../js/jstree/news.png"
					}
				},
				"DISABLE_LAYOUT_NEWS_PAGE" : {
					creatable	: false,
					icon : {
						image : "../js/jstree/disable_news.png"
					}
				},
				"ENABLE_ALBUM" : {
					creatable	: false,
					icon : {
						image : "../js/jstree/album.png"
					}
				},
				"DISABLE_ALBUM" : {
					creatable	: false,
					icon : {
						image : "../js/jstree/disable_album.png"
					}
				},
				"ENABLE_LINK" : {
					creatable	: false,
					icon : {
						image : "../js/jstree/link.png"
					}
				},
				"DISABLE_LINK" : {
					creatable	: false,
					icon : {
						image : "../js/jstree/disable_link.png"
					}
				}
			},


			plugins : {
				contextmenu : {
					items : {
						create: false,
						rename: {
							visible : function(NODE, TREE_OBJ) {
								if ($(NODE).attr('data-object_system_flag') != 'normal' )
									return false;
								else {
									if(NODE.length != 1) return false;
										return TREE_OBJ.check("renameable", NODE);
								}
							}
						},
						set_as_index_object : {
							separator_after : true,
							label	: "Set As Index Page",
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('data-object_type') == 'PAGE' )
									return true;
								else
									return false;
							},
							action	: function (NODE, TREE_OBJ) {
								var response = $.ajax({
									type:	"POST",
									async:	false,
									url:	"language_tree_set_as_index_object.php",
									dataType:	"xml",
									data:	"link_id=" + $(NODE).attr('data-object_link_id'),
									error:	function (XMLHttpRequest, textStatus, errorThrown) {
										$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
									}
								}).responseText;

								var status = $.fromXMLString(response).find('status').eq(0).text();
								var msg = $.fromXMLString(response).find('msg').eq(0).text();

								if (status == 'ok') {
									$.jGrowl(msg, {header: GetTime()});
								}
								else {
									$.jGrowl(msg);
								}
							}
						},
						remove: false,
						insert_product : {
							label	: "Insert Product Tree",
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('data-object_type') == 'FOLDER' && $("select[name='SelectProductRoot'] option").size() > 0)
									return true;
								else
									return false;
							},
							action	: function (NODE, TREE_OBJ) {
								TheNode = NODE;
								TheTreeObj = TREE_OBJ;
								DialogSelectProductRoot.dialog('open');
							}
						},
						insert_folder : {
							label	: "Insert Folder",
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('data-object_type') == 'FOLDER' || $(NODE).attr('data-object_type') == 'LANGUAGE_ROOT' )
									return true;
								else
									return false;
							},
							action	: function (NODE, TREE_OBJ) {
								TREE_OBJ.create(
									{
										attributes : {"rel" : "ENABLE_FOLDER", "data-object_system_flag" : "normal", "data-object_type" : "FOLDER" }
									},
									NODE,
									"inside"
								);
							}
						},
						insert_page : {
							label	: "Insert Page",
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('data-object_type') == 'FOLDER')
									return true;
								else
									return false;
							},
							action	: function (NODE, TREE_OBJ) {
								TREE_OBJ.create(
									{
										attributes : {"rel" : "ENABLE_PAGE", "data-object_system_flag" : "normal", "data-object_type" : "PAGE" }
									},
									NODE,
									"inside"
								);
							}
						},
						insert_news : {
							label	: "Insert News Page",
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('data-object_type') == 'FOLDER' && $("select[name='SelectNewsRoot'] option").size() > 0)
									return true;
								else
									return false;
							},
							action	: function (NODE, TREE_OBJ) {
								TheNode = NODE;
								TheTreeObj = TREE_OBJ;
								DialogSelectNewsRoot.dialog('open');
							}
						},
						insert_layout_news : {
							label	: "Insert Layout News Page",
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('data-object_type') == 'FOLDER' && $("select[name='SelectLayoutNewsRoot'] option").size() > 0)
									return true;
								else
									return false;
							},
							action	: function (NODE, TREE_OBJ) {
								TheNode = NODE;
								TheTreeObj = TREE_OBJ;
								DialogSelectLayoutNewsRoot.dialog('open');
							}
						},
						insert_album : {
							label	: "Insert Album",
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('data-object_type') == 'FOLDER' && $("select[name='SelectAlbum'] option").size() > 0)
									return true;
								else
									return false;
							},
							action	: function (NODE, TREE_OBJ) {
								TheNode = NODE;
								TheTreeObj = TREE_OBJ;
								DialogSelectAlbum.dialog('open');
							}
						},
						insert_link : {
							label	: "Insert Link",
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('data-object_type') == 'FOLDER')
									return true;
								else
									return false;
							},
							action	: function (NODE, TREE_OBJ) {
								TREE_OBJ.create(
									{
										attributes : {"rel" : "ENABLE_LINK", "data-object_system_flag" : "normal", "data-object_type" : "LINK" }
									},
									NODE,
									"inside"
								);
							}
						},

						set_enable : {
							label	: "Enable",
							icon	: "", // you can set this to a classname or a path to an icon like ./myimage.gif
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('rel').indexOf("DISABLE") >= 0)
									return true;
								return false;
							},
							action	: function (NODE, TREE_OBJ) {
								var response = $.ajax({
									type:	"POST",
									async:	false,
									url:	"language_tree_enable.php",
									dataType:	"xml",
									data:	"type=" + $(NODE).attr('data-object_type') +"&link_id=" + $(NODE).attr('data-object_link_id') + "&action=Y",
									error:	function (XMLHttpRequest, textStatus, errorThrown) {
										$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
									}
								}).responseText;

								var status = $.fromXMLString(response).find('status').eq(0).text();
								var msg = $.fromXMLString(response).find('msg').eq(0).text();
								var NewStatus = $.fromXMLString(response).find('new_status').eq(0).text();

								if (status == 'ok') {
									if (NewStatus == 'enable')
										TREE_OBJ.set_type('ENABLE_' + $(NODE).attr('data-object_type'), $(NODE));
									$.jGrowl(msg, {header: GetTime()});
								}
								else {
									$.jGrowl(msg);
								}
							},
							separator_before : true
						},
						set_disable : {
							label	: "Disable",
							icon	: "", // you can set this to a classname or a path to an icon like ./myimage.gif
							visible	: function (NODE, TREE_OBJ) {
								if ($(NODE).attr('rel').indexOf("ENABLE") >= 0)
									return true;
								return false;
							},
							action	: function (NODE, TREE_OBJ) {
								var response = $.ajax({
									type:	"POST",
									async:	false,
									url:	"language_tree_enable.php",
									dataType:	"xml",
									data:	"type=" + $(NODE).attr('data-object_type') +"&link_id=" + $(NODE).attr('data-object_link_id') + "&action=N",
									error:	function (XMLHttpRequest, textStatus, errorThrown) {
										$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
									}
								}).responseText;

								var status = $.fromXMLString(response).find('status').eq(0).text();
								var msg = $.fromXMLString(response).find('msg').eq(0).text();
								var NewStatus = $.fromXMLString(response).find('new_status').eq(0).text();

								if (status == 'ok') {
									if (NewStatus == 'disable')
										TREE_OBJ.set_type('DISABLE_' + $(NODE).attr('data-object_type'), $(NODE));
									$.jGrowl(msg, {header: GetTime()});
								}
								else {
									$.jGrowl(msg);
								}
							}
						}
					}
				}
			},


			callback: {
				"onload" : function(TREE_OBJ) {
					TREE_OBJ.open_all();
				},
				"onrename" : function(NODE, TREE_OBJ, RB) {
					var response = $.ajax({
						type:	"POST",
						async:	false,
						url:	"language_tree_rename.php",
						dataType:	"xml",
						data:	"link_id=" + $(NODE).attr('data-object_link_id') + "&obj_name=" + encodeURIComponent(TREE_OBJ.get_text(NODE)),
						error:	function (XMLHttpRequest, textStatus, errorThrown) {
							$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
						}
					}).responseText;

					var status = $.fromXMLString(response).find('status').eq(0).text();
					var msg = $.fromXMLString(response).find('msg').eq(0).text();

					if (status == 'ok') {
						$.jGrowl(msg, {header: GetTime()});
					}
					else {
						jQuery.tree.rollback(RB);
						$.jGrowl(msg, {header: GetTime(), sticky: true});
					}
				},
				"onmove" : function(NODE, REF_NODE, TYPE, TREE_OBJ, RB) {

					if ($(NODE).attr('data-object_type') == 'PRODUCT_ROOT' && $(NODE).attr('data-object_system_flag') != 'normal') {
						jQuery.tree.rollback(RB);
						TREE_OBJ.create(
							{
								attributes : {"rel" : "ENABLE_PRODUCT_ROOT", "data-object_system_flag" : "normal", "data-object_type" : "PRODUCT_ROOT", "data-object_id" : $(NODE).attr('data-object_id')}
							},
							REF_NODE,
							TYPE
						);
					}
					else {
						var response = $.ajax({
							type:	"POST",
							async:	false,
							url:	"language_tree_move.php",
							dataType:	"xml",
							data:	"link_id=" + $(NODE).attr('data-object_link_id') + "&ref_link_id=" + $(REF_NODE).attr('data-object_link_id') + "&move_type=" + TYPE,
							error:	function (XMLHttpRequest, textStatus, errorThrown) {
								$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
							}
						}).responseText;

						var status = $.fromXMLString(response).find('status').eq(0).text();
						var msg = $.fromXMLString(response).find('msg').eq(0).text();

						if (status == 'ok') {
							$.jGrowl(msg, {header: GetTime()});
						}
						else {
							jQuery.tree.rollback(RB);
							$.jGrowl(msg, {header: GetTime(), sticky: true});
						}
					}
				},
				"oncreate" : function(NODE, REF_NODE, TYPE, TREE_OBJ, RB) {
					var response = $.ajax({
						type:	"POST",
						async:	false,
						url:	"language_tree_create.php",
						dataType:	"xml",
						data:	"new_object_type=" + $(NODE).attr('data-object_type') + "&ref_link_id=" + $(REF_NODE).attr('data-object_link_id') + "&create_type=" + TYPE + "&object_id=" + $(NODE).attr('data-object_id'),
						error:	function (XMLHttpRequest, textStatus, errorThrown) {
							$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
						}
					}).responseText;

					var status = $.fromXMLString(response).find('status').eq(0).text();
					var msg = $.fromXMLString(response).find('msg').eq(0).text();

					if (status == 'ok') {
						id = $.fromXMLString(response).find('id').eq(0).text();
						$(NODE).attr('data-object_id', id);
						link_id = $.fromXMLString(response).find('link_id').eq(0).text();
						$(NODE).attr('id', "OL_" + link_id);
						$(NODE).attr('data-object_link_id', link_id);
						$.jGrowl(msg, {header: GetTime()});
					}
					else {
						jQuery.tree.rollback(RB);
						$.jGrowl(msg, {header: GetTime(), sticky: true});
					}
				},
				"ondblclk" : function(NODE, TREE_OBJ) {
					if ($(NODE).attr('data-object_type') == 'FOLDER')
						$(location).attr('href', 'folder_edit.php?link_id=' + $(NODE).attr('data-object_link_id'));
					else if ($(NODE).attr('data-object_type') == 'PAGE')
						$(location).attr('href', 'page_edit.php?link_id=' + $(NODE).attr('data-object_link_id'));
					else if ($(NODE).attr('data-object_type') == 'NEWS_PAGE')
						$(location).attr('href', 'news_page_edit.php?link_id=' + $(NODE).attr('data-object_link_id'));
					else if ($(NODE).attr('data-object_type') == 'LAYOUT_NEWS_PAGE')
						$(location).attr('href', 'layout_news_page_edit.php?link_id=' + $(NODE).attr('data-object_link_id'));
					else if ($(NODE).attr('data-object_type') == 'LINK')
						$(location).attr('href', 'link_edit.php?link_id=' + $(NODE).attr('data-object_link_id'));
					else if ($(NODE).attr('data-object_type') == 'PRODUCT_ROOT')
						$(location).attr('href', 'product_root_link_edit.php?link_id=' + $(NODE).attr('data-object_link_id'));
					else if ($(NODE).attr('data-object_type') == 'PRODUCT_ROOT_LINK')
						$(location).attr('href', 'product_root_link_real_edit.php?link_id=' + $(NODE).attr('data-object_link_id'));
					else if ($(NODE).attr('data-object_type') == 'ALBUM')
						$(location).attr('href', 'album_link_edit.php?link_id=' + $(NODE).attr('data-object_link_id'));
				}
			}
		});
	}

	if (MyJS == 'page_edit') {
		$('#PageTabs').tabs({cookie: { expires: 365 }});

		var oldSibling;
		$("table.SortTable").tableDnD({
			scrollAmount: 30,
			onDragClass: "ui-state-highlight",
			onDragStart: function(table, row) {
				oldSibling=$(row).next();
			},
			onDrop: function(table, row) {
				var response = $.ajax({
					type:	"POST",
					async:	false,
					url:	"page_edit_sort_block_content.php",
					dataType:	"xml",
					data:	'table_id=' + $(table).attr('id') + '&link_id=' + $('input[name=link_id]').val() + '&' + $.tableDnD.serialize(),
					error:	function (XMLHttpRequest, textStatus, errorThrown) {
						$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
					}
				}).responseText;

				var status = $.fromXMLString(response).find('status').eq(0).text();
				var msg = $.fromXMLString(response).find('msg').eq(0).text();

				if (status == 'ok') {
					$.jGrowl(msg, {header: GetTime()});
				}
				else {
					$(row).insertBefore(oldSibling);
					$.jGrowl(msg, {header: GetTime(), sticky: true});
				}
        	}
		});
	}


	if (MyJS == 'siteblock') {
		var oldSibling;
		$("table.SortTable").tableDnD({
			scrollAmount: 30,
			onDragClass: "ui-state-highlight",
			onDragStart: function(table, row) {
				oldSibling=$(row).next();
			},
			onDrop: function(table, row) {
				var response = $.ajax({
					type:	"POST",
					async:	false,
					url:	"siteblock_sort_block_content.php",
					dataType:	"xml",
					data:	'table_id=' + $(table).attr('id') + '&' + $.tableDnD.serialize() + '&language_id=' + $('#language_id').val(),
					error:	function (XMLHttpRequest, textStatus, errorThrown) {
						$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
					}
				}).responseText;

				var status = $.fromXMLString(response).find('status').eq(0).text();
				var msg = $.fromXMLString(response).find('msg').eq(0).text();

				if (status == 'ok') {
					$.jGrowl(msg, {header: GetTime()});
				}
				else {
					$(row).insertBefore(oldSibling);
					$.jGrowl(msg, {header: GetTime(), sticky: true});
				}
        	}
		});
	}


	if (MyJS == 'layout_edit') {
		$("#TheSubmitButton").click(function(ev){
			ev.preventDefault();
			if ($(":checkbox.DeleteBlockDef:checked").length === 0) {
				$("#FrmEditBlock").submit();
			}
			else {
				var Answer = DoubleConfirm(TEXT_DELETE_BLOCK_WARNING, TEXT_100_SURE);
				if (Answer) {
					$("input[name='ChangeLayout']").val('yes');
					$("#FrmEditBlock").submit();
				}
			}
		});
	}

	if (MyJS == 'siteblock_def_list') {
		$("#TheSubmitButton").click(function(ev){
			ev.preventDefault();
			if ($(":checkbox.DeleteBlockDef:checked").length === 0) {
				$("#FrmEditBlock").submit();
			}
			else {
				var Answer = DoubleConfirm(TEXT_DELETE_BLOCK_WARNING, TEXT_100_SURE);
				if (Answer) {
					$("#FrmEditBlock").submit();
				}
			}
		});
	}

	if (MyJS == 'album_add') {
		$('#AlbumTabs').tabs({cookie: { expires: 365 }});
	}
	if (MyJS == 'album_edit') {
		$('#AlbumTabs').tabs({cookie: { expires: 365 }});
	}
	if (MyJS == 'media_edit') {
		$('#MediaTabs').tabs({cookie: { expires: 365 }});
	}
	if (MyJS == 'datafile_edit') {
		$('#DatafileTabs').tabs({cookie: { expires: 365 }});
	}
	if (MyJS == 'product_add') {
		$('#ProductTabs').tabs({cookie: { expires: 365 }});

		$("input[name='discount_type']:checked").live('change', function(){
			if ($(this).val() == '4')
				$('#ProductPriceLevelContainer').show();
			else
				$('#ProductPriceLevelContainer').hide();
		});
		$("input[name='discount_type']").change();

		$("#AddMoreProductPriceLevelLink").click(function() {
			var ExtraRow = $('.ProductPriceLevelInput').eq(0).clone();
			$("input[name='product_price_level_min[]']", ExtraRow).val('');
			$("input[name='product_price_level_price[]']", ExtraRow).val('');
			ExtraRow.appendTo('#ProductPriceLevelContainer > table');
			ExtraRow.show();
		});
		$("#AddMoreProductPriceLevelLink").click();
		$(".RemoveProductPriceLevelLink").click(function() {
			if ($(".RemoveProductPriceLevelLink").size() > 1)
				$(this).closest('tr').remove();
		});
	}
	if (MyJS == 'product_brand_add') {
		$('#ProductBrandTabs').tabs({cookie: { expires: 365 }});
	}
	if (MyJS == 'product_brand_edit') {
		$('#ProductBrandTabs').tabs({cookie: { expires: 365 }});
	}
	if (MyJS == 'product_root_link_edit') {
		$('#ProductRootLinkTabs').tabs({cookie: { expires: 365 }});
	}
	if (MyJS == 'product_root_link_real_edit') {
		$('#ProductRootLinkTabs').tabs({cookie: { expires: 365 }});
	}	
	if (MyJS == 'product_edit') {
		$('#ProductTabs').tabs({cookie: { expires: 365 }});

		$("input[name='discount_type']:checked").live('change', function(){
			if ($(this).val() == '4')
				$('#ProductPriceLevelContainer').show();
			else
				$('#ProductPriceLevelContainer').hide();
		});
		$("input[name='discount_type']").change();

		$("#AddMoreProductPriceLevelLink").click(function() {
			var ExtraRow = $('.ProductPriceLevelInput').eq(0).clone();
			$("input[name='product_price_level_min[]']", ExtraRow).val('');
			$("input[name='product_price_level_price[]']", ExtraRow).val('');
			ExtraRow.appendTo('#ProductPriceLevelContainer > table');
			ExtraRow.show();
		});
		$("#AddMoreProductPriceLevelLink").click();
		$(".RemoveProductPriceLevelLink").click(function() {
			if ($(".RemoveProductPriceLevelLink").size() > 1)
				$(this).closest('tr').remove();
		});

		var oldSibling;
		$("table.ProductOptionTable").tableDnD({
			scrollAmount: 30,
			onDragClass: "ui-state-highlight",
			onDragStart: function(table, row) {
				oldSibling=$(row).next();
			},
			onDrop: function(table, row) {
				var response = $.ajax({
					type:	"POST",
					async:	false,
					url:	"product_option_sort.php",
					dataType:	"xml",
					data:	'table_id=' + $(table).attr('id') + '&' + $.tableDnD.serialize(),
					error:	function (XMLHttpRequest, textStatus, errorThrown) {
						$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
					}
				}).responseText;

				var status = $.fromXMLString(response).find('status').eq(0).text();
				var msg = $.fromXMLString(response).find('msg').eq(0).text();

				if (status == 'ok') {
					$.jGrowl(msg, {header: GetTime()});
				}
				else {
					$(row).insertBefore(oldSibling);
					$.jGrowl(msg, {header: GetTime(), sticky: true});
				}
        	}
		});
		$("table.MediaListTable").tableDnD({
			scrollAmount: 30,
			onDragClass: "ui-state-highlight",
			onDragStart: function(table, row) {
				oldSibling=$(row).next();
			},
			onDrop: function(table, row) {
				var response = $.ajax({
					type:	"POST",
					async:	false,
					url:	"media_sort.php",
					dataType:	"xml",
					data:	'table_id=' + $(table).attr('id') + '&' + $.tableDnD.serialize(),
					error:	function (XMLHttpRequest, textStatus, errorThrown) {
						$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
					}
				}).responseText;

				var status = $.fromXMLString(response).find('status').eq(0).text();
				var msg = $.fromXMLString(response).find('msg').eq(0).text();

				if (status == 'ok') {
					$.jGrowl(msg, {header: GetTime()});
				}
				else {
					$(row).insertBefore(oldSibling);
					$.jGrowl(msg, {header: GetTime(), sticky: true});
				}
        	}
		});
		
		$("table.DatafileListTable").tableDnD({
			scrollAmount: 30,
			onDragClass: "ui-state-highlight",
			onDragStart: function(table, row) {
				oldSibling=$(row).next();
			},
			onDrop: function(table, row) {
				var response = $.ajax({
					type:	"POST",
					async:	false,
					url:	"datafile_sort.php",
					dataType:	"xml",
					data:	'table_id=' + $(table).attr('id') + '&' + $.tableDnD.serialize(),
					error:	function (XMLHttpRequest, textStatus, errorThrown) {
						$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
					}
				}).responseText;

				var status = $.fromXMLString(response).find('status').eq(0).text();
				var msg = $.fromXMLString(response).find('msg').eq(0).text();

				if (status == 'ok') {
					$.jGrowl(msg, {header: GetTime()});
				}
				else {
					$(row).insertBefore(oldSibling);
					$.jGrowl(msg, {header: GetTime(), sticky: true});
				}
        	}
		});
		
	}

	if (MyJS == 'product_category_edit') {
		$('#ProductCatTabs').tabs({cookie: { expires: 365 }});
		var oldSibling;
		$("#ObjectListTable").tableDnD({
			scrollAmount: 30,
			onDragClass: "ui-state-highlight",
			onDragStart: function(table, row) {
				oldSibling=$(row).next();
			},
			onDrop: function(table, row) {
				var response = $.ajax({
					type:	"POST",
					async:	false,
					url:	"product_sort.php",
					dataType:	"xml",
					data:	'table_id=' + $(table).attr('id') + '&' + $.tableDnD.serialize(),
					error:	function (XMLHttpRequest, textStatus, errorThrown) {
						$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
					}
				}).responseText;

				var status = $.fromXMLString(response).find('status').eq(0).text();
				var msg = $.fromXMLString(response).find('msg').eq(0).text();

				if (status == 'ok') {
					$.jGrowl(msg, {header: GetTime()});
				}
				else {
					$(row).insertBefore(oldSibling);
					$.jGrowl(msg, {header: GetTime(), sticky: true});
				}
        	}
		});
		
		$("table.MediaListTable").tableDnD({
			scrollAmount: 30,
			onDragClass: "ui-state-highlight",
			onDragStart: function(table, row) {
				oldSibling=$(row).next();
			},
			onDrop: function(table, row) {
				var response = $.ajax({
					type:	"POST",
					async:	false,
					url:	"media_sort.php",
					dataType:	"xml",
					data:	'table_id=' + $(table).attr('id') + '&' + $.tableDnD.serialize(),
					error:	function (XMLHttpRequest, textStatus, errorThrown) {
						$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
					}
				}).responseText;

				var status = $.fromXMLString(response).find('status').eq(0).text();
				var msg = $.fromXMLString(response).find('msg').eq(0).text();

				if (status == 'ok') {
					$.jGrowl(msg, {header: GetTime()});
				}
				else {
					$(row).insertBefore(oldSibling);
					$.jGrowl(msg, {header: GetTime(), sticky: true});
				}
        	}
		});		
	}

	if (MyJS == 'product_category_special_edit') {
		$('#ProductCatSpecialTabs').tabs({cookie: { expires: 365 }});
		var oldSibling;
		$("table.SortTable").tableDnD({
			scrollAmount: 30,
			onDragClass: "ui-state-highlight",
			onDragStart: function(table, row) {
				oldSibling=$(row).next();
			},
			onDrop: function(table, row) {
				var response = $.ajax({
					type:	"POST",
					async:	false,
					url:	"product_sort.php",
					dataType:	"xml",
					data:	'table_id=' + $(table).attr('id') + '&' + $.tableDnD.serialize(),
					error:	function (XMLHttpRequest, textStatus, errorThrown) {
						$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
					}
				}).responseText;

				var status = $.fromXMLString(response).find('status').eq(0).text();
				var msg = $.fromXMLString(response).find('msg').eq(0).text();

				if (status == 'ok') {
					$.jGrowl(msg, {header: GetTime()});
				}
				else {
					$(row).insertBefore(oldSibling);
					$.jGrowl(msg, {header: GetTime(), sticky: true});
				}
        	}
		});
	}

	if (MyJS == 'media_list') {
		var oldSibling;
		$("table.SortTable").tableDnD({
			scrollAmount: 30,
			onDragClass: "ui-state-highlight",
			onDragStart: function(table, row) {
				oldSibling=$(row).next();
			},
			onDrop: function(table, row) {
				var response = $.ajax({
					type:	"POST",
					async:	false,
					url:	"media_sort.php",
					dataType:	"xml",
					data:	'page_id=' + $(table).attr('data-page_id') + '&num_of_photos_per_page' + $(table).attr('data-num_of_photos_per_page') + '&table_id=' + $(table).attr('id') + '&' + $.tableDnD.serialize(),
					error:	function (XMLHttpRequest, textStatus, errorThrown) {
						$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
					}
				}).responseText;

				var status = $.fromXMLString(response).find('status').eq(0).text();
				var msg = $.fromXMLString(response).find('msg').eq(0).text();

				if (status == 'ok') {
					$.jGrowl(msg, {header: GetTime()});
				}
				else {
					$(row).insertBefore(oldSibling);
					$.jGrowl(msg, {header: GetTime(), sticky: true});
				}
        	}
		});
	}	
	
	if (MyJS == 'product_brand_list') {
		var oldSibling;
		$("table.SortTable").tableDnD({
			scrollAmount: 30,
			onDragClass: "ui-state-highlight",
			onDragStart: function(table, row) {
				oldSibling=$(row).next();
			},
			onDrop: function(table, row) {
				var response = $.ajax({
					type:	"POST",
					async:	false,
					url:	"product_brand_sort.php",
					dataType:	"xml",
					data:	'page_id=' + $(table).attr('data-page_id') + '&num_of_product_brand_per_page' + $(table).attr('data-num_of_product_brand_per_page') + '&table_id=' + $(table).attr('id') + '&' + $.tableDnD.serialize(),
					error:	function (XMLHttpRequest, textStatus, errorThrown) {
						$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
					}
				}).responseText;

				var status = $.fromXMLString(response).find('status').eq(0).text();
				var msg = $.fromXMLString(response).find('msg').eq(0).text();

				if (status == 'ok') {
					$.jGrowl(msg, {header: GetTime()});
				}
				else {
					$(row).insertBefore(oldSibling);
					$.jGrowl(msg, {header: GetTime(), sticky: true});
				}
        	}
		});
	}
	
	if (MyJS == 'product_brand_product_list') {
		var oldSibling;
		$("table.SortTable").tableDnD({
			scrollAmount: 30,
			onDragClass: "ui-state-highlight",
			onDragStart: function(table, row) {
				oldSibling=$(row).next();
			},
			onDrop: function(table, row) {
				var response = $.ajax({
					type:	"POST",
					async:	false,
					url:	"product_brand_product_list_sort.php",
					dataType:	"xml",
					data:	'page_id=' + $(table).attr('data-page_id') + '&num_of_products_per_page' + $(table).attr('data-num_of_products_per_page') + '&table_id=' + $(table).attr('id') + '&' + $.tableDnD.serialize(),
					error:	function (XMLHttpRequest, textStatus, errorThrown) {
						$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
					}
				}).responseText;

				var status = $.fromXMLString(response).find('status').eq(0).text();
				var msg = $.fromXMLString(response).find('msg').eq(0).text();

				if (status == 'ok') {
					$.jGrowl(msg, {header: GetTime()});
				}
				else {
					$(row).insertBefore(oldSibling);
					$.jGrowl(msg, {header: GetTime(), sticky: true});
				}
        	}
		});
	}

	if (MyJS == 'album_list') {
		var oldSibling;
		$("table.SortTable").tableDnD({
			scrollAmount: 30,
			onDragClass: "ui-state-highlight",
			onDragStart: function(table, row) {
				oldSibling=$(row).next();
			},
			onDrop: function(table, row) {
				var response = $.ajax({
					type:	"POST",
					async:	false,
					url:	"album_sort.php",
					dataType:	"xml",
					data:	'table_id=' + $(table).attr('id') + '&' + $.tableDnD.serialize(),
					error:	function (XMLHttpRequest, textStatus, errorThrown) {
						$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
					}
				}).responseText;

				var status = $.fromXMLString(response).find('status').eq(0).text();
				var msg = $.fromXMLString(response).find('msg').eq(0).text();

				if (status == 'ok') {
					$.jGrowl(msg, {header: GetTime()});
				}
				else {
					$(row).insertBefore(oldSibling);
					$.jGrowl(msg, {header: GetTime(), sticky: true});
				}
        	}
		});
	}

	if (MyJS == 'order_details') {
		$('#MyOrderTabs').tabs({cookie: { expires: 365 }});

		$('tr.MyOrderItem').click(function() {
		  window.location = 'product_edit.php?link_id=' + $(this).attr('data-object_link_id');
		});
	}

	if (MyJS == 'bonuspoint_add') {
		$('#BonusPointItemTabs').tabs({cookie: { expires: 365 }});
	}

	if (MyJS == 'member_edit') {
		$('#UserInfoTabs').tabs({cookie: { expires: 365 }});
	}

	if (MyJS == 'folder_edit') {
		$('#FolderTabs').tabs({cookie: { expires: 365 }});
	}

	if (MyJS == 'news_add') {
		$('#NewsTabs').tabs({cookie: { expires: 365 }});
	}

	if (MyJS == 'layout_news_add') {
		$('#LayoutNewsTabs').tabs({cookie: { expires: 365 }});
	}

	if (MyJS == 'news_edit') {
		$('#NewsTabs').tabs({cookie: { expires: 365 }});
	}

	if (MyJS == 'layout_news_edit') {
		$('#LayoutNewsTabs').tabs({cookie: { expires: 365 }});

		var oldSibling;
		$("table.SortTable").tableDnD({
			scrollAmount: 30,
			onDragClass: "ui-state-highlight",
			onDragStart: function(table, row) {
				oldSibling=$(row).next();
			},
			onDrop: function(table, row) {
				var response = $.ajax({
					type:	"POST",
					async:	false,
					url:	"layout_news_edit_sort_block_content.php",
					dataType:	"xml",
					data:	'table_id=' + $(table).attr('id') + '&id=' + $('input[name=id]').val() + '&' + $.tableDnD.serialize(),
					error:	function (XMLHttpRequest, textStatus, errorThrown) {
						$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
					}
				}).responseText;

				var status = $.fromXMLString(response).find('status').eq(0).text();
				var msg = $.fromXMLString(response).find('msg').eq(0).text();

				if (status == 'ok') {
					$.jGrowl(msg, {header: GetTime()});
				}
				else {
					$(row).insertBefore(oldSibling);
					$.jGrowl(msg, {header: GetTime(), sticky: true});
				}
        	}
		});
	}

	if (MyJS == 'news_page_edit') {
		$('#NewsPageTabs').tabs({cookie: { expires: 365 }});
	}

	if (MyJS == 'layout_news_page_edit') {
		$('#LayoutNewsPageTabs').tabs({cookie: { expires: 365 }});
	}

	if (MyJS == 'field_setting') {
		$('#FieldSettingTabs').tabs({cookie: { expires: 365 }});
	}

	if (MyJS == 'site_setting') {
		$('#SiteSettingTabs').tabs({cookie: { expires: 365 }});
	}

	if (MyJS == 'bonuspoint_edit') {
		$('#BonusPointItemTabs').tabs({cookie: { expires: 365 }});
		var oldSibling;
		$("table.SortTable").tableDnD({
			scrollAmount: 30,
			onDragClass: "ui-state-highlight",
			onDragStart: function(table, row) {
				oldSibling=$(row).next();
			},
			onDrop: function(table, row) {
				var response = $.ajax({
					type:	"POST",
					async:	false,
					url:	"media_sort.php",
					dataType:	"xml",
					data:	'table_id=' + $(table).attr('id') + '&' + $.tableDnD.serialize(),
					error:	function (XMLHttpRequest, textStatus, errorThrown) {
						$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
					}
				}).responseText;

				var status = $.fromXMLString(response).find('status').eq(0).text();
				var msg = $.fromXMLString(response).find('msg').eq(0).text();

				if (status == 'ok') {
					$.jGrowl(msg, {header: GetTime()});
				}
				else {
					$(row).insertBefore(oldSibling);
					$.jGrowl(msg, {header: GetTime(), sticky: true});
				}
        	}
		});
	}
	
	if (MyJS == 'stock_list') {
	 	$('.FrmCartAdd').ajaxForm();
	 	$('.FrmCartAdd').submit(function() { 
	 		var TheButton = $('a.MyButton', this);
			var options = { 
				dataType:	"xml",
				success:	function(response) {
					var status 	= $(response).find('status').text();
					var msg 	= $(response).find('msg').text();		
					
					if (status == 'Success') {
						$.jGrowl(msg, {header: GetTime()});
				    	TheButton.effect('transfer', { to: "#stock_in_out_cart_tab", className: "ui-effects-transfer" }, 1000);		
					}
					else
						$.jGrowl(msg, {header: GetTime(), sticky: true});
				}
			};
	    	$(this).ajaxSubmit(options);
	    	//$('a.MyButton', this).effect('transfer', { to: "#stock_in_out_cart_tab", className: "ui-effects-transfer" }, 500);		
		    return false;
		});
	}
	
	if (MyJS == 'stock_in_out_cart_details') {
		$('a.MyRemoveButton').click(function(ev) {
	 		ev.preventDefault();
			var response = $.ajax({
				type:	"GET",
				async:	false,
				url:	$(this).attr('href'),
				dataType:	"xml",
				error:	function (XMLHttpRequest, textStatus, errorThrown) {
					$.jGrowl("<strong>ERROR:</strong> Not connected to server." + textStatus, {header: GetTime(), sticky: true});
				}
			}).responseText;

			var status = $.fromXMLString(response).find('status').eq(0).text();
			var msg = $.fromXMLString(response).find('msg').eq(0).text();

			if (status == 'Success') {
				$(this).closest('tr').remove();
				$.jGrowl(msg, {header: GetTime()});
			}
			else {
				$.jGrowl(msg, {header: GetTime(), sticky: true});
			}
		});
		
		$('a.BtnConfirmStockInOut').click(function(ev) {
	 		ev.preventDefault();
			$("input[name='is_confirm_stock_in_out']").val('Y');
			if ($(this).attr('target') != '') {
				$('#' + $(this).attr('target')).submit();
			}
		});
	}
	
	if (MyJS == 'order_list') {
		$('#CustomizeHeadingWindow').dialog({ autoOpen: false });
		
		$('#BtnCustomizeHeading').click(function(ev) {
	 		ev.preventDefault();
	 		$('#CustomizeHeadingWindow').dialog('open');
		});
		
		$("#CustomizeHeadingWindow input").live('change', function(){
			if ($(this).is(":checked")) {
				$("." + $(this).attr('data-target_field')).show();
				$.cookie("CustomizeOrderList_" + $(this).attr('data-target_field'), "Y", { expires: 365 });
			}
			else {
				$("." + $(this).attr('data-target_field')).hide();
				$.cookie("CustomizeOrderList_" + $(this).attr('data-target_field'), "N", { expires: 365 });
			}
		});
		
		$("#CustomizeHeadingWindow input").trigger('change');
	}

	InitEvent();
});