<?php
    require_once ('../controller/mycv/home.controller.php');
    use Model\Utilities\Utilities;
?>

<div class="container-fluid m-0 p-0 fixed-top">
        <?php require_once('../module/mycv/navBar.php'); ?>
</div>

<header class="d-flex justify-content-center align-items-center">
    
    <form class="" method="post" id="formHome" enctype="multipart/form-data">
        
        <!-- input hidden csrf -->
        <input
            type="hidden"
            name="csrf"
            value="<?php echo $_SESSION['token']['csrf'];?>"
        >

        <div id="carouselExampleCaptions" class="carousel slide carousel-fade" data-bs-ride="carousel">

            <div class="carousel-inner">

                <div class="carousel-item active" data-bs-interval="10000">

                    <picture>
                        <source srcset="img/mycv/banner/productivite/productivite_480x100.webp" media="(max-width: 480px)" width="480" height="100">
                        <source srcset="img/mycv/banner/productivite/productivite_576x120.webp" media="(max-width: 576px)" width="576" height="120">
                        <source srcset="img/mycv/banner/productivite/productivite_768x160.webp" media="(max-width: 768px)" width="768" height="160">
                        <source srcset="img/mycv/banner/productivite/productivite_960x200.webp" media="(max-width: 960px)" width="960" height="200">
                        <source srcset="img/mycv/banner/productivite/productivite_1440x300.webp" media="(max-width: 1440px)" width="1440" height="300">
                        <source srcset="img/mycv/banner/productivite/productivite_1820x400.webp" media="(max-width: 1820px)" width="1820" height="400">
                        <source srcset="img/mycv/banner/productivite/productivite_1920x400.webp" media="(min-width: 1821px)" width="1920" height="400">
                        <img src="img/mycv/banner/productivite/productivite_1920x400.webp" class="d-block w-100" alt="image symbolisant la productivité" width="1920" height="400">
                    </picture>
                    
                    <div class="carousel-caption d-flex justify-content-center align-items-center">

                        <div class="divHeader text-white text-center p-0 px-3 pt-2 w-100">

                            <?php if ($_SESSION['dataConnect']['type']!='Administrator'){ ?>

                                <h2 class="titleHeader"><?php echo Utilities::escapeInput($home['home_title']); ?></h2>
                                <p class="subTitleHeader"><?php echo Utilities::escapeInput($home['home_subtitle']); ?></p>

                            <?php }elseif ($_SESSION['dataConnect']['type']==='Administrator'){ ?>

                                <h2>

                                    <input
                                        class="h1Header text-center"
                                        type="text"
                                        id="text_home_title"
                                        name="text_home_title"
                                        value="<?php echo Utilities::escapeInput($home['home_title']); ?>"
                                    >

                                </h2>

                                <p>

                                    <input
                                        class="h2Header text-center"
                                        type="text"
                                        id="text_home_subtitle"
                                        name="text_home_subtitle"
                                        value="<?php echo Utilities::escapeInput($home['home_subtitle']); ?>"
                                    >

                                </p>
                                
                            <?php } ?>
                            
                        </div>
                        
                    </div>

                </div>

                <div class="carousel-item">

                    <picture>
                        <source srcset="img/mycv/banner/connectivite/connectivite_480x100.webp" media="(max-width: 480px)" width="480" height="100">
                        <source srcset="img/mycv/banner/connectivite/connectivite_576x120.webp" media="(max-width: 576px)" width="576" height="120">
                        <source srcset="img/mycv/banner/connectivite/connectivite_768x160.webp" media="(max-width: 768px)" width="768" height="160">
                        <source srcset="img/mycv/banner/connectivite/connectivite_960x200.webp" media="(max-width: 960px)" width="960" height="200">
                        <source srcset="img/mycv/banner/connectivite/connectivite_1440x300.webp" media="(max-width: 1440px)" width="1440" height="300">
                        <source srcset="img/mycv/banner/connectivite/connectivite_1820x400.webp" media="(max-width: 1820px)" width="1820" height="400">
                        <source srcset="img/mycv/banner/connectivite/connectivite_1920x400.webp" media="(min-width: 1821px)" width="1920" height="400">
                        <img src="img/mycv/banner/connectivite/connectivite_1920x400.webp" class="d-block w-100" alt="image symbolisant la connectivité" width="1920" height="400">
                    </picture>

                    <div class="carousel-caption d-flex justify-content-center">

                        <div class="divHeader text-white text-center p-0 px-3 pt-3">

                            <h2 class="titleHeader">Développement, Connectivité, Performance</h2>
                            <p class="subTitleHeader">Accédez à une productivité sans égale</p>

                        </div>
                    
                    </div>

                </div>

                <div class="carousel-item">

                    <picture>
                        <source srcset="img/mycv/banner/agil/agil_480x100.webp" media="(max-width: 480px)" width="480" height="100">
                        <source srcset="img/mycv/banner/agil/agil_576x120.webp" media="(max-width: 576px)" width="576" height="120">
                        <source srcset="img/mycv/banner/agil/agil_768x160.webp" media="(max-width: 768px)" width="768" height="160">
                        <source srcset="img/mycv/banner/agil/agil_960x200.webp" media="(max-width: 960px)" width="960" height="200">
                        <source srcset="img/mycv/banner/agil/agil_1440x300.webp" media="(max-width: 1440px)" width="1440" height="300">
                        <source srcset="img/mycv/banner/agil/agil_1820x400.webp" media="(max-width: 1820px)" width="1820" height="400">
                        <source srcset="img/mycv/banner/agil/agil_1920x400.webp" media="(min-width: 1821px)" width="1920" height="400">
                        <img src="img/mycv/banner/agil/agil_1920x400.webp" class="d-block w-100" alt="image symbolisant la méthode agil" width="1920" height="400">
                    </picture>

                    <div class="carousel-caption d-flex justify-content-center">

                        <div class="divHeader text-white text-center p-0 px-3 pt-3">

                            <h2 class="titleHeader">Gestion de projet</h2>
                            <p class="subTitleHeader">Spécifications, Budget, Organisation, Qualité et Résultats</p>

                        </div>

                    </div>

                </div>

            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>

            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

        </div>

        <div class="container d-flex justify-content-center mt-5">

            <?php if ($_SESSION['dataConnect']['type']!='Administrator'){ ?>

                <h2 class="pb-5"><?php echo Utilities::escapeInput($home['home_title_page']); ?></h2>

            <?php } ?>

        </div>

        <?php if($_SESSION['dataConnect']['type'] === 'Administrator'){ ?>

            <div class="container d-flex justify-content-center p-0">

                <div class="row w-100">

                    <div class="container d-flex justify-content-center pb-5">

                        <?php if ($_SESSION['dataConnect']['type']==='Administrator'){ ?>

                            <h2 class="w-100">
                                <input
                                    class="text-center fs-2"
                                    type="text"
                                    name="text_home_title_page"
                                    id="text_home_title_page"
                                    style="width:100%; height: 40px;"
                                    value="<?php echo Utilities::escapeInput($home['home_title_page']); ?>"
                                >
                            </h2>

                        <?php } ?>

                    </div>
                    

                    <!-- Start button Save -->

                    <div class="container d-flex justify-content-center pb-5">

                        <input
                            class="btn btn-lg btn-success w-100"
                            type="submit"
                            name="btn_save_header"
                            id="btn_save_header"
                            value="Enregistrer"
                        >

                    </div>

                    <!-- End button Save -->

                </div>

            </div>

            <hr><br>

        <?php } ?>

    </form>

</header>