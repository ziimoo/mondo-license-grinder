<?php
header('Content-type: text/html; charset=UTF-8');
echo '<!DOCTYPE html>';
echo '
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>License Information</title>
		<link rel="stylesheet" href="'.BASE_URL.'uikit-2.20.3/css/uikit.min.css" type="text/css" />
		<link rel="stylesheet" href="'.BASE_URL.'stylesheets/jquery-ui.css" type="text/css" />
		<link rel="stylesheet" href="'.BASE_URL.'stylesheets/license.css" type="text/css" />
		<script type="text/javascript" src="'.JQUERY.'"></script>
		<script type="text/javascript" src="'.BASE_URL.'uikit-2.20.3/js/uikit.min.js"></script>
		<script type="text/javascript" src="'.JQUERYUI.'"></script>
		<script type="text/javascript" src="'.BASE_URL.'scripts/jquery.infieldlabel.min.js"></script>
		<script type="text/javascript" src="'.BASE_URL.'scripts/script.js"></script>
		'.$moreinsert.'
	</head>
	<body>

	<div class="uk-container uk-container-center uk-margin-top uk-margin-large-bottom">

	<h1>Test</h1>

';