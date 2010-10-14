(function($){
$(function(){

	$('#sel_vendor').change(
		function(){
			if($(this).val()>-1){
				$('#new_vendor').val('');
			}
		}
	);
	$('#sel_consortium').change(
		function(){
			if($(this).val()>-1){
				$('#new_consortium').val('');
			}
		}
	);
	$('#new_vendor').change(
		function(){
			if($(this).val()){
				$('#sel_vendor :selected').removeAttr('selected');
			}
		}
	);
	$('#new_consortium').change(
		function(){
			if($(this).val()){
				$('#sel_consortium :selected').removeAttr('selected');
			}
		}
	);

	$('#find').autocomplete({
		source: '../ajaxfind.php',
		minLength:0,
		select:
			function(event, ui){
				document.location='index.php?id='+ui.item.value;
			}
	});
	$('tr:even').addClass('alt');

});
})(jQuery);

function setAllRadios(val){
	jQuery('input[type=radio]').removeAttr('checked');
	jQuery('input[value='+val+']').attr('checked','checked');
}

function clearform(){
	(function($){
		$(':checked').removeAttr('checked');
		$('#sel_consortium option').removeAttr('selected');
		$('#sel_vendor option').removeAttr('selected');
		$('input[type=text]').val('');
		$('textarea').val('');c
		$('#id').val('-1');
		$('input[name=id]').val('-1');
		$('#cb_walk_in').attr('checked','checked');
	})(jQuery);
	return false;
}

function paulJosephStyleClear(){
	//rather than revert to page load state
	$('input[type=radio]').each(
		function(){
			if(this.value=='3'){
				$(this).attr('checked',true);
			}else{
				$(this).attr('checked',false);
			}
		}
	);
	$('#vendor option').attr('selected',false);
	$('#consortium option').attr('selected',false);
	return false;
}

function fiddleaction(action){
	(function($){
		$('form').attr('action',action);	
	})(jQuery);
	return true;
}

$(document).ready( function() {
	$("input[type=radio],input[type=checkbox],select,.field").focus( function(){
		$("input[type=radio],input[type=checkbox],select,.field")
		.parents("fieldset")
		.removeClass("focused");
		$(this)
		.parents("fieldset")
		.addClass("focused")
	});
});