<?php
include('../db.inc.php');
$fields=array(
	'e_reserves'=>'E-reserves',
	'course_pack'=>'Course Pack',
	'durable_url'=>'Durable URL',
	'ill_print'=>'ILL Print',
	'ill_electronic'=>'ILL Electronic',
	'ill_ariel'=>'ILL Ariel',
	'walk_in'=>'Walk-In',
	'alumni_access'=>'Alumni Access',
	'perpetual_access'=>'Perpetual Access',
	'password_required'=>'Password'
);
if(!empty($_POST['html'])){
	foreach($_POST['html'] as $k=>$v){
		$db->setHTML($k,$v);
	}
}else{
}
$moreinsert='<script type="text/javascript" src="'.BASE_URL.'scripts/staff.js"></script>
<script type="text/javascript" src="'.BASE_URL.'scripts/jquery.tinymce.js"></script>
';
include('../header.inc.php');
?>
<div class="optionalWrapper small fullpage">
<h1>Static Text for License Field Descriptions</h1>
<?php include('nav.inc.php'); ?>
<hr />
<form action="" method="post">
	<input type="submit" value="Update" />
	<table>
<?php
foreach($fields as $field=>$fieldname){
	$short=$db->getHTML($field.'-short');
	$long=$db->getHTML($field.'-long');
	echo '
		<tr>
			<th>'.$fieldname.'</th>
			<td class="bp">Short Text:<br />
				<textarea class="tinymce" name="html['.$field.'-short]">'.$short.'</textarea><br />
				Long Text: <br />
				<textarea class="tinymce" name="html['.$field.'-long]">'.$long.'</textarea>
			</td>
		</tr>';
}


?>
	</table>
	<input type="submit" value="Update" />
<form>
<script type="text/javascript">
$('.tinymce').tinymce({
	script_url:'../scripts/tinymce/jscripts/tiny_mce/tiny_mce.js'
});
$('tr:odd').css('backgroundColor','#ddd');
</script>
<?php include('../footer.inc.php')?>