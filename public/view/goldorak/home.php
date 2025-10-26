<?php
    require_once('../controller/goldorak/home.controller.php');
    use Model\Utilities\Utilities;
?>

<form method="post" id="formHome"  enctype="multipart/form-data">
    
    <!-- input hidden csrf -->
    <input type="hidden" name="csrf" value="<?php echo $_SESSION['token']['csrf'];?>">

    <!-- start of data save message -->

    <div class="container d-flex justify-content-center">
        <div class="text-center text-black bg-warning px-5 rounded-5" name="messageInputEmpty" id="messageInputEmpty1"></div>
    </div>

    <!-- end of data save message -->

    <!-- Start Titre 1 -->

    <div class="text-center">
        </br>
        <?php if ($_SESSION['dataConnect']['type']!='Administrator'){ ?>
            <h2><?php echo Utilities::escapeInput($home['titre1']); ?></h2>
        <?php } ?>
        <?php if ($_SESSION['dataConnect']['type']==='Administrator'){ ?>
            <h2><input class="text-center" type="text" name="txt_titre1" id="txt_titre1" value="<?php echo Utilities::escapeInput($home['titre1']); ?>"></h2>
        <?php } ?>
        </br>
    </div>

    <!-- End Titre 1 -->

    <div class="container">

        <div class="row m-2">

            <div class="d-flex flex-column flex-lg-row align-items-stretch m-0 p-0">
                
                <div class="col-12 col-lg-8 overflow-auto border rounded-3 m-0 p-3 me-3" style="max-height: 400px">

                    <div class="d-flex align-items-start">

                        <div class="">

                            <!-- Start Titre chapter1 -->

                            <?php if ($_SESSION['dataConnect']['type']!='Administrator'){ ?>
                                <h3><?php echo Utilities::escapeInput($home['titre_chapter1']); ?></h3>
                            <?php } ?>
                            <?php if ($_SESSION['dataConnect']['type']==='Administrator'){ ?>
                                <h3><input type="text" id="txt_titre_chapter1"  name="txt_titre_chapter1" value="<?php echo Utilities::escapeInput($home['titre_chapter1']); ?>"></h3>
                            <?php } ?>

                            <!-- End Titre chapter1 -->

                            <!-- Start Chapter 1 -->

                            <?php if ($_SESSION['dataConnect']['type']!='Administrator'){ ?>

                                <p class="p-0" style="text-align: justify;">
                                    <?php echo Utilities::escapeInput($home['chapter1']); ?>
                                </p>

                            <?php } ?>

                            <?php if ($_SESSION['dataConnect']['type']==='Administrator'){ ?>
                                
                                <p class="p-0" style="text-align: justify;">
<textarea name="txt_chapter1" id="txt_chapter1" cols="1" rows="12">
<?php echo Utilities::escapeInput($home['chapter1']); ?>
</textarea>
                                </p>

                            <!-- End Chapter 1 -->
                                
                            <!-- Start input end botton upload image chapter1 -->
                                
                                <div class="container">  
                                    <div class="row">
                                        <div class="container m-0 p-0">
                                            <div class="row">
                                                <div class="col-12 col-lg-5 pb-3 pb-lg-0">
                                                    <input class="form-control-lg bg-transparent text-light m-0 p-0 border border-black" id="txt_img_chapter1" name="txt_img_chapter1" type="text" placeholder="Saisissez le nom de l'image" readonly style="font-size: 1.6rem;" oninput="validateInput('txt_img_chapter1','','labelMessageimg_chapter1','Saisissez le nom de l\'image (sans useractères spéciaux sauf - et _) aux formats *.png ou *.jpg ou *.webp. Sinon, téléchargez une image depuis votre disque local. ATTENTION!!! Dimmentions image au ratio de 200px sur 450px.')"
                                                        value=
                                                        "<?php
                                                            echo Utilities::escapeInput($home['img_chapter1']);
                                                        ?>"
                                                    >
                                                </div>
                                                <div class="col-12 col-lg-5 d-flex align-items-center pb-3 pb-lg-0">
                                                    <input class="" type="file" name="file_img_chapter1" id="file_img_chapter1"  accept="image/jpeg, image/png, image/webp">
                                                </div>

                                                <div class="col-12 col-lg-2 d-flex align-items-center pb-3 pb-lg-0">
                                                    <input class="btn btn-lg btn-primary " type="button" name="btn_img_chapter1" id="btn_img_chapter1" value="Télécharger" style="width: 100px;">
                                                </div>
                                            </div>  
                                        </div>
                                    </div>
                                </div>

                            <!-- End input end botton upload image chapter1 -->

                            <?php } ?>


                        </div>

                        <!-- Start image Chapter 1 -->

                        <div class="d-none d-sm-block">
                            <img class="ms-3" id="img_chapter1" name="img_chapter1" src="../img/goldorak/picture/<?php echo Utilities::escapeInput($home['img_chapter1']); ?>" alt="Goldorak et Actarus" style="width:200px; height: 350px; object-fit: cover;">
                        </div>

                        <!-- End image Chapter 1 -->

                    </div>

                </div>

                <!-- start of comment area -->

                <div class="col-12 col-lg-4 overflow-auto border rounded-3 p-3 m-0 mt-3 mt-lg-0" style="max-height: 400px">
                    
                    <div class="accordion accordion-flush" id="accordionFlushExample">
                        <div class="accordion-item" style="background-color: transparent;">
                            
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed bg-dark text-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                                    Partagez votre expérience, laissez un commentaire!
                                </button>
                            </h2>

                            <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                                <div class="accordion-body text-light" style="text-align: justify;">
                                    <?php include "../module/common/commentForm.php"; ?>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="mt-3">
                        <?php include "../module/common/comment.php"; ?>
                    </div>

                </div>

                <!-- end of comment area -->

            </div>

        </div>
        
        <!-- start of data save message -->

        <div class="container d-flex justify-content-center">
            <div class="text-center text-black bg-warning px-5 rounded-5" name="messageInputEmpty" id="messageInputEmpty2"></div>
        </div>
        
        <!-- end of data save message -->

        <div class="row m-2">

            <div class="d-flex border rounded-3 m-0 p-0 px-3 my-5">

                <!-- Start image Chapter 2 -->

                <div class="d-none d-sm-block pt-3 pe-3 mb-3">
                    <img class="ms-3" id="img_chapter2" name="img_chapter2" src="../img/goldorak/picture/<?php echo Utilities::escapeInput($home['img_chapter2']); ?>" alt="Goldorak et Actarus" style="width:150px; height: 150px; object-fit: cover;">
                </div>

                <!-- End image Chapter 2 -->

                <div class="w-100 pt-3">

                <!-- Start Titre Chapter 2 -->

                    <?php if ($_SESSION['dataConnect']['type']!='Administrator'){ ?>
                        <h3><?php echo Utilities::escapeInput($home['titre_chapter2']); ?></h3>
                    <?php } ?>
                    <?php if ($_SESSION['dataConnect']['type']==='Administrator'){ ?>
                        <h3><input type="text" name="txt_titre_chapter2" id="txt_titre_chapter2" value="<?php echo Utilities::escapeInput($home['titre_chapter2']); ?>"></h3>
                    <?php } ?>

                <!-- End Titre Chapter 2 -->

                <!-- Début Chapter 2 -->

                    <?php if ($_SESSION['dataConnect']['type']!='Administrator'){ ?>
                        <p class="p-0 m-0" style="text-align: justify;">
                            <?php echo Utilities::escapeInput($home['chapter2']); ?>
                        </p>
                    <?php } ?>
                    <?php if ($_SESSION['dataConnect']['type']==='Administrator'){ ?>
                        <p class="p-0" style="text-align: justify;">
<textarea name="txt_chapter2" id="txt_chapter2" cols="1" rows="5">
<?php echo Utilities::escapeInput($home['chapter2']); ?>
</textarea>
                        </p>

                <!-- End Chapter 2 -->
                        
                    <!-- Start input end botton upload image chapter1 -->

                        <div class="container">  
                            <div class="row">
                                <div class="container m-0 p-0">
                                    <div class="row">
                                        <div class="col-12 col-lg-5 pb-3 pb-lg-0 d-flex align-items-center">
                                            <input class="form-control-lg bg-transparent text-light m-0 p-0 border border-black" id="txt_img_chapter2" name="txt_img_chapter2" type="text" placeholder="Saisissez le nom de l'image" readonly style="font-size: 1.6rem;" oninput="validateInput('txt_img_chapter2','','labelMessageimg_chapter2','Saisissez le nom de l\'image (sans useractères spéciaux sauf - et _) aux formats *.png ou *.jpg ou *.webp. Sinon, téléchargez une image depuis votre disque local. ATTENTION!!! Dimmentions image au ratio de 200px sur 450px.')"
                                                value=
                                                "<?php
                                                    echo Utilities::escapeInput($home['img_chapter2']);
                                                ?>"
                                            >
                                        </div>
                                        <div class="col-12 col-lg-5 d-flex align-items-center pb-3 pb-lg-0">
                                            <input class="" type="file" name="file_img_chapter2" id="file_img_chapter2" accept="jpeg, png, webp">
                                        </div>
                                        <div class="col-12 col-lg-2 d-flex align-items-center pb-3 pb-lg-0">
                                            <input class="btn btn-lg btn-primary mb-3" type="button" name="btn_img_chapter2" id="btn_img_chapter2" value="Télécharger" style="width: 100px;">
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    
                    <!-- End input end botton upload image chapter1 -->

                    <!-- Start button subscription -->

                    <div class="d-flex justify-content-end p-0 m-3 m-md-0 me-md-5 <?php echo ($_SESSION['dataConnect']['type'] === 'Administrator') ? 'd-none' : ''; ?>">
                        <button class="btn btn-primary btn-lg mt-0 btAdherer"><a class="text-light" href="goldorak.php?page=adherer">Adhérer</a></button>
                    </div>

                    <!-- End button subscription -->

                </div>

            </div>

        </div>

    </div>

    <?php if($_SESSION['dataConnect']['type'] === 'Administrator'){ ?>

    <div class="container">

        <div class="row">

            <!-- Start button Save -->

            <div class="container d-flex justify-content-center mb-2">
                <input class="btn btn-lg btn-success w-100" type="button" name="btn_home_save" id="btn_home_save" value="Enregistrer">
            </div>

            <!-- End button Save -->

            <!-- start of data save message -->

            <div class="container d-flex justify-content-center mb-5">
                <div class="text-center text-black bg-warning px-5 rounded-5" id="message"></div>
            </div>
            
            <!-- end of data save message -->

        </div>

    </div>

    <?php } ?>

</form>

<script src="../js/common/function.js"></script>
<script src="../js/goldorak/home.js"></script>