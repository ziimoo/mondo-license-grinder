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
	console.log(title);
	var result = title.replace(/[\'"]/g, '');
	result = result.replace(/[^a-zA-Z0-9]+/g, '_');
	result = result.trim('_');

	return result;
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

	$("#title").keyup(function(){
		$('#tag').val(string_to_underscore_name($('#title').val()));
	});
});