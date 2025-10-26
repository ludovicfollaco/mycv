<!DOCTYPE html>
<html lang="fr">

<head>
    
	<!-- Google tag manager -->
    <script src="js/common/tagManager.js"></script>
  
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-3FBFNJLCL1"></script>
	<script src="js/common/gtag.js"></script>

	<!-- ------------------------- META DATA ------------------------ -->
    <?php require_once('../module/garageparrot/head_MetaData.php'); ?>

	<!-- -------------------- TAB TITLE AND ICON -------------------- -->
    <title id="pageTitle">Garage V.PARROT by Ludovic FOLLACO</title>

	<link id='pageIcon' rel="icon" type="image/png image/webp image/jpg">

	<!-- <link rel="icon" href="img/common/icon/garage_75x75.webp" type="image/png image/webp image/jpg"> -->
	
	<script src="./js/garageparrot/titleTab.js"></script>
  
	<?php
		$url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		$canonical_url = str_replace("www.", "", $url);
	?>
	<link rel="canonical" href="<?php echo $canonical_url; ?>">

	<!-- --------------- STYLE SHEETS AND LIBRARY CSS --------------- -->
	<?php require_once('css/common/groupSheetStyle.php'); ?>
	
</head>