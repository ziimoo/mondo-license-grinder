<?php
/* Manage a simple controlled vocabulary */
include('../db.inc.php');
if($_POST){
	$vocab=$_POST['v'];
	$selected=$_POST['id'];
	$names=$_POST['name'];
	if($selected){
		$ids=array_keys($selected);
		if(!$db->cvMerge($vocab,$ids,$_POST['mergename'])){
			echo '<div class="message">Merge failed -- did you supply a merge name?</div>';
		}
	}
	foreach($names as $id=>$name){
		$db->cvUpdate($vocab,$id,$name);
	}
}

$vocab=$_GET['v'];
if($vocab=='consortium'){
	$plural='consortia';
}else{
	$plural=$vocab.'s';
}
$v=$db->getAssoc($vocab);
//if(!$v)die('Vocabulary not found');
$t='<table class="cv"><tr><th>Name</th><th>Merge</th></tr>';
$t.='
	<tr>
		<td><input type="text" name="name[-1]" value="" size="80" autocomplete="" /></td>
		<td>(New)</td>
	</tr>';
foreach($v as $id=>$name){
	$t.='
	<tr>
		<td><input type="text" name="name['.$id.']" value="'.htmlspecialchars($name).'" size="80" /></td>
		<td><input type="checkbox" name="id['.$id.']" value="1"></td>
	</tr>';
}
$t.='
	<tr>
		<td><input type="text" name="name[-2]" value="" size="80" autocomplete="" /></td>
		<td>(New)</td>
	</tr>';

$t.='</table>';
require_once('../config.php');
$moreinsert='<script type="text/javascript" src="'.BASE_URL.'scripts/staff.js"></script>';
include('../header.inc.php');
?>
<div class="optionalWrapper small fullpage">
<h1>Manage <?php echo ucfirst($plural); ?></h1>
<?php include('nav.inc.php'); ?>
<hr />
<?php
echo '<form action="" method="post">';
echo '<input type="hidden" name="v" value="'.$vocab.'" />';
echo $t;
echo '<hr />';
echo '<input type="submit" value="Update and Merge Selected" name="action" /> under the name: <input name="mergename" type="text" />';
echo '</form>';
?>
</div>
<?php include('../footer.inc.php')?>