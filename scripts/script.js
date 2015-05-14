(function($){
$(function(){
	$('#find').autocomplete({
		source: 'ajaxfind.php',
		minLength:0,
		select:
			function(event, ui){
				document.location='index.php?tag='+ui.item.value;
			}
	});
});
})(jQuery);

function string_to_underscore_name(title)
{
	title.replace('/[\'"]/', '');
	title.replace('/[\'"]/', '');
	title.trim('_');
	title.toLowerCase();

	/*
	$string = preg_replace(, $string);
	$string = preg_replace('/[^a-zA-Z0-9]+/', '_', $string);
	$string = trim($string, '_');
	$string = strtolower($string);
	*/

	return title;
}

$(document).ready(function(){
  //for fading Public search label
	$("#license-form label").inFieldLabels({ fadeOpacity:0 });
	
	//for show/hide in Public License view
	$(".more-info").toggle(
		function(){
			$(this).parents("td").find("div").show();
		},
		function(){
			$(this).parents("td").find("div").hide();
	});

	$("#title").change(function(){
		$(this).val = string_to_underscore_name($(this).val);
	});
});