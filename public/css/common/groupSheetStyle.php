<link rel='stylesheet' type='text/css' href='../css/common/reset.css'>
<link rel='stylesheet' type='text/css' href='../css/common/rgpd.css'>

<style>
  /* Fancybox toujours au-dessus de tout */
  .fancybox__container { z-index: 2147483647 !important; }

  /* Ta bannière cookies a l’ID #cookieConsent */
  #cookieConsent { z-index: 999 !important; }

  .bgDark { background-color: #343a40; }

  html { font-family: Verdana, Tahoma, sans-serif; font-size: 62.5%; }
  body, p, h5, h6, .btn, .accordion-button, .form-select, .form-text { font-size: 1.6rem; }
  h1 { font-size: 3.2rem; }
  h2, legend { font-size: 2.4rem; }
  h3 { font-size: 1.8rem; }
  h4 { font-size: 1.7rem; }
</style>

<?php
    $current_url = $_SERVER['REQUEST_URI'];
    $goldorak = strpos($current_url, 'goldorak') !== false;
    $garageParrot = strpos($current_url, 'garageparrot') !== false;
    $index = strpos($current_url, 'index') !== false;
    $commander = strpos($current_url, 'commander') !== false;
    $home = strpos($current_url, 'home') !== false;
    $car = strpos($current_url, 'car') !== false;
    $mycv = strpos($current_url, 'page=mycv') !== false;
    $network = strpos($current_url, 'page=network') !== false;
?>

<!-- ------------------------------- LIBRARY CSS -------------------------------- -->
<link rel='stylesheet' type='text/css' href='../css/assets/bootstrap.min.css'>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">-->

<?php if(!$index){ ?>

    <?php if($home){ ?>

        <link rel='stylesheet' type='text/css' href='../css/common/rating_comment.css'>

    <?php } ?>

<?php } ?>

<?php if($goldorak){ ?>

    <link rel='stylesheet' type='text/css' href='../css/goldorak/style_navbar.css'>
    <link rel='stylesheet' type='text/css' href='../css/goldorak/goldorak_style.css'>

    <?php if($commander){ ?>

        <link rel='stylesheet' type='text/css' href='../css/goldorak/goldorak_commander.css'>

    <?php } ?>

<?php }elseif($garageParrot){ ?>

    <link rel='stylesheet' type='text/css' href='../css/garageparrot/style_navbar.css'>
    <link rel='stylesheet' type='text/css' href='../css/garageparrot/garage_parrot_style.css'>

    <?php if($car){ ?>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

        <script>
            window.addEventListener('load', () => {
                const ok = Array.from(document.styleSheets).some(s => (s.href||'').includes('fancybox.css'));
                console.log('Fancybox CSS chargée ?', ok);
            });
        </script>
        
    <?php } ?>

<?php }else{ ?>

    <link rel='stylesheet' type='text/css' href='../css/mycv/style_navbar.css'>
    <link rel='stylesheet' type='text/css' href='../css/mycv/myCv_style.css'>

    <?php if($mycv || $network){ ?>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />

        <script>
            window.addEventListener('load', () => {
                const ok = Array.from(document.styleSheets).some(s => (s.href||'').includes('fancybox.css'));
                console.log('Fancybox CSS chargée ?', ok);
            });
        </script>

    <?php } ?>

<?php } ?>
