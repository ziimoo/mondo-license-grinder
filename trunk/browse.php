<?php
require_once('db.inc.php');
$moreinsert='';
include('header.inc.php');
?>
<div class="optionalWrapper small fullpage">
<h1>License Information</h1>
	<?php include('a-z.inc.php'); ?>
	<form id="license-form">
		<div>
			<label for="find">Find license by package title</label>
			<input name="find" id="find" type="text" />	
		</div>
	</form>
<?php
if(!empty($msg)){
    echo '<div class="message">'.$msg.'</div>';
}
if(isset($_GET['initial'])){
	$initial=$_GET['initial'];
	$res=$db->findByInitial($initial);
	if($res){
		echo '<ul id="byinitial">';
		foreach($res as $row){
			echo '<li><a href="'.BASE_URL.$row['tag'].'">'.$row['title'].'</a></li>';
		}
		echo '</ul>';
	}

}else{
	$blurb=$db->getHTML('blurb');
	if(trim($blurb)){
		echo '<div id="blurb">'.$blurb.'</div>';
	}
	echo '</div>';
}
include('footer.inc.php');
