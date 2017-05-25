function InitEvent(event, ui) {
	$('.MyButton, .MyTinyButton, .MyInputButton, .Menu > li, .InnerTab > ul > li').hover(
		function() { $(this).addClass('ui-state-hover'); },
		function() { $(this).removeClass('ui-state-hover'); }
	);
	$('.DatePicker').datepicker({ dateFormat: 'yy-mm-dd', changeMonth: true, changeYear: true });
}

$(document).ready(function(){
	InitEvent();
});