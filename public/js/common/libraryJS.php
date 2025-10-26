<!-- -------- FILE ASSET JAVASCRIPT FOR BOOTSTRAP (STANDARD AND POPPER) --------- -->

<?php
    $home = strpos($_SERVER['REQUEST_URI'], 'home') !== false;
    $car = strpos($_SERVER['REQUEST_URI'], 'car') !== false;
    $mycv = strpos($_SERVER['REQUEST_URI'], 'page=mycv') !== false;
    $network = strpos($_SERVER['REQUEST_URI'], 'page=network') !== false;
?>

<script src="../js/assets/bootstrap.bundle.min.js"></script>

<?php if($home){ ?>

    <script src="../js/common/function.js"></script>
    <script src="../js/common/rating.js"></script>

<?php }else if($car || $mycv || $network){ ?>
    
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
        Fancybox.bind('[data-fancybox], .popup-gallery', {
            // Barre d’outils au format v5
            Toolbar: {
            display: {
                left:   ['infobar'],  // compteur
                middle: [],           // (vide)
                right:  ['zoom','slideshow','fullscreen','thumbs','close']
            }
            },

            Thumbs: { autoStart: false },
        });
        });
    </script>


<?php } ?>

<script src="../js/common/rgpd.js"></script>