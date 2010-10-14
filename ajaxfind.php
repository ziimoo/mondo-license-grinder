<?php
$like=$_GET['term'];
include('db.inc.php');
$res=$db->findAsYouType($like);
header('Content-type: text/javascript');
echo json_encode($res);