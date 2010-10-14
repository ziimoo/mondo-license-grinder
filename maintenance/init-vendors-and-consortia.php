<?php
include '../db.inc.php';
foreach(array('vendor','consortium') as $t){
	$sql="DELETE FROM `$t` WHERE 1";
	$db->query($sql);
	$fh=fopen($t,'r');
	while($n=fgets($fh)){
		$n=trim($n);
		if($n){
			$sql="INSERT INTO `$t` SET `name`=?";
			$db->query($sql,$n);
		}
	}
	fclose($fh);
}
