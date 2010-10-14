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
});