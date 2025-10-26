<?php
    require_once('../module/common/debug.php'); // Debugging add-ons: Comment before uploading

    session_start();

    require_once('../vendor/autoload.php'); // add-on Vendor

    require_once('../module/common/variable.php'); // Superglobal variables (mainly from SESSION)
    require_once('../module/mycv/head.php'); // Load the marker <head>
?>

    
<body class="p-0 m-0" style="background: linear-gradient(180deg, #f8fafc 0%, #58647eff 100%);">
    
    <?php require_once('../module/common/tagManager.php'); // Google Tag Manager (noscript) ?>
    <?php require_once('../module/mycv/header.php'); // Load the marker <header> ?>

<main class=" p-0 mx-0 my-0">
    <?php require_once('../module/mycv/router.php'); // loaded the page router ?>
</main>

    <?php require_once('../module/mycv/footer.php');  // Load the marker <footer> ?>

    <?php require_once('../module/common/rgpd.php'); ?>

    <?php require_once('./js/common/libraryJS.php'); ?>

</body>

</html>

<?php
    
    //********************************************************************* */
    // Modèles de Syntaxes pour lmes annotations traçables dans Todo Tree
    //********************************************************************* */

    // @TODO : Add a comment to the code
    // @FIXME :
    // @BUG :
    // @HACK :
    // @NOTE :
    // @A_FAIRE :
    // @URGENT :
    // @IDÉE :

    //********************************************************************* */
?>