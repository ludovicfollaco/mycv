<!DOCTYPE html>
<html lang="fr">

<head>
    
	<!-- Google tag manager -->
    <script src="js/common/tagManager.js"></script>
  
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3FBFNJLCL1"></script>
    <script src="js/common/gtag.js"></script>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    
	<meta name="description" content="Médias exclusifs sur le site du Club Goldorak : musiques, vidéos, épisodes inédits, images HD, synopsis de la série et infos sur les intervenants.">
	<meta name="keywords" content="Média de Goldorak, Vidéo de Goldorak, Image de Goldorak, Episode de Goldorak, Générique de Goldorak, Histoie de Goldorak">

    <title id="pageTitle">Club Goldorak by Ludovic FOLLACO</title>

    <link id='pageIcon' rel="icon" type="image/png image/webp image/jpg">

    <script src="./js/goldorak/titleTab.js"></script>
  
    <?php
        $url = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $canonical_url = str_replace("www.", "", $url);
    ?>
    <link rel="canonical" href="<?php echo $canonical_url; ?>">
    
    <?php require_once('css/common/groupSheetStyle.php'); ?>

</head>