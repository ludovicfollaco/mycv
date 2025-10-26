<?php
    require_once('../controller/garageparrot/carEdit.controller.php');
?>

<section class="container">

    <form action="" method="post" id="formCarEdit" enctype="multipart/form-data">

        <!-- input hidden csrf -->
        <input type="hidden" name="csrf" value="<?php echo $_SESSION['token']['csrf'];?>">

        <table class="w-100">

            <tr class="m-0 p-0">

                <td class="m-0 p-0 pb-5">
                </td>

                <td class="d-flex flex-column flex-sm-row m-0 p-0 pb-5">

                    <div class="pe-2 pb-2 pb-sm-0">

                        <button
                            type="submit"
                            class="btn btn-lg btn-warning fs-4 px-2 mb-2"
                            id="btn_carEdit_cancel"
                            name="btn_carEdit_cancel"
                            onclick="retour()"
                            style="width: 100px;"
                        >
                            Retour
                        </button>

                        <button
                            type="submit"
                            class="btn btn-lg btn-success fs-4 px-2 mb-2"
                            id="btn_carEdit_save"
                            name="btn_carEdit_save"
                            style="width: 100px;"
                        >
                            Enregistrer
                        </button>

                    </div>

                    <div>

                        <button
                            type="submit"
                            class="btn btn-lg btn-info fs-4 px-2 mb-2"
                            id="btn_carEdit_new"
                            name="btn_carEdit_new"
                            style="width: 100px;"
                        >
                            Nouveau
                        </button>

                        <button
                            type="submit"
                            class="btn btn-lg btn-danger fs-4 px-2 mb-2"
                            id="btn_carEdit_delete"
                            name="btn_carEdit_delete"
                            onclick="confirmDelete()"
                            style="width: 100px;"
                        >
                            Supprimer
                        </button>

                    </div>

                </td>

            </tr>

            <tr class="m-0 p-0">

                <td class="text-end m-0 p-0">

                    <label class="form-label m-0 p-0 pe-3" for="txt_car_id">ID</label>

                </td>

                <td class="m-0 p-0">

                    <input
                        class="form-control-lg bg-light m-0 p-0 ps-3"
                        id="txt_car_id"
                        name="txt_car_id"
                        type="text"
                        style="font-size: 1.6rem;"
                        value=
                            "<?php
                                if(!empty($MyCarForm->getId())){
                                    echo $MyCarForm->getId();
                                }else{
                                    echo $cars['id_car'];
                                }
                            ?>"
                        aria-label="Disabled input example"
                        readonly
                    >

                </td>

            </tr>

            <tr>

                <td class="m-0 p-0">
                </td>

                <td class="m-0 p-0">

                    <label class="form-control-lg m-0 mb-2 p-0" id="labelMessageId">
                        Identifiant de l'annonce. Ce numèro est incrémenté automatiquement par la robot.
                    </label>

                </td>

            </tr>

            <tr class="m-0 p-0">

                <td class="text-end m-0 p-0">
                    <label class="form-label m-0 p-0 pe-3" for="list_carEdit_brand">Marque<span style="color:red;">*</span></label>
                </td>

                <td class="m-0 p-0">

                    <input
                        list="datalist_carEdit_brand"
                        name="list_carEdit_brand"
                        id="list_carEdit_brand"
                        class="form-control-lg m-0 p-0 ps-3 border border-black fs-4"
                        placeholder="Selectionnez une marquer"
                        oninput="validateInput('list_carEdit_brand','datalist_carEdit_brand','labelMessageBrand','Veuillez selectionner une valeur existante.')"
                        value="<?php echo $cars['brand']; ?>"
                    >
                    <datalist id="datalist_carEdit_brand">

                        <?php
                            for($i=0;$i != count($MyBrand);$i++) { ?>
                            <option value="<?php echo $MyBrand[$i]['name']; ?>">
                        <?php } ?>

                    </datalist>

                </td>

            </tr>

            <tr>

                <td class="m-0 p-0">
                </td>

                <td class="m-0 p-0">

                    <label class="form-control-lg m-0 mb-2 p-0" id="labelMessageBrand">
                        Veuillez selectionner une marque dans la liste de choix.
                    </label>

                </td>

            </tr>

            <tr class="m-0 p-0">

                <td class="text-end m-0 p-0">
                    <label class="form-label m-0 p-0 pe-3" for="list_carEdit_model">Modèle<span style="color:red;">*</span></label>
                </td>

                <td class="m-0 p-0">

                    <input
                        list="datalist_carEdit_model"
                        name="list_carEdit_model"
                        id="list_carEdit_model"
                        class="form-control-lg m-0 p-0 ps-3 border border-black fs-4"
                        placeholder="Selectionnez un modèle"
                        oninput="validateInput('list_carEdit_model','datalist_carEdit_model','labelMessageModel','Veuillez selectionner une valeur existante.')"
                        value= "<?php echo $cars['model']; ?>"
                    >

                    <datalist id="datalist_carEdit_model">

                        <?php for($i=0;$i != count($MyModel);$i++) { ?>
                            <option value="<?php echo $MyModel[$i]['name']; ?>">
                        <?php } ?>

                    </datalist>

                </td>

            </tr>

            <tr>

                <td class="m-0 p-0">
                </td>

                <td class="m-0 p-0">

                    <label class="form-control-lg m-0 mb-2 p-0" id="labelMessageModel">
                        Veuillez selectionner un modèle dans la liste de choix.
                    </label>

                </td>

            </tr>

            <tr class="m-0 p-0">

                <td class="text-end m-0 p-0">
                    <label class="form-label m-0 p-0 pe-3" for="list_carEdit_engine">Engine<span style="color:red;">*</span></label>
                </td>

                <td class="m-0 p-0">

                    <input
                        list="datalist_carEdit_engine"
                        name="list_carEdit_engine"
                        id="list_carEdit_engine"
                        class="form-control-lg m-0 p-0 ps-3 border border-black fs-4"
                        placeholder="Selectionnez un engine"
                        oninput="validateInput('list_carEdit_engine','datalist_carEdit_engine','labelMessageEngine','Veuillez selectionner une valeur existante.')"
                        value= "<?php echo $cars['engine']; ?>"
                    >

                    <datalist id="datalist_carEdit_engine">

                        <?php for($i=0;$i != count($MyEngine);$i++) { ?>
                            <option value="<?php echo $MyEngine[$i]['name']; ?>">
                        <?php } ?>

                    </datalist>

                </td>

            </tr>

            <tr>

                <td class="m-0 p-0">
                </td>

                <td class="m-0 p-0">

                    <label class="form-control-lg m-0 mb-2 p-0" id="labelMessageEngine">
                        Veuillez selectionner une motorisation dans la liste de choix.
                    </label>

                </td>

            </tr>

            <tr class="m-0 p-0">

                <td class="text-end m-0 p-0">
                    <label class="form-label m-0 p-0 pe-3" for="txt_carEdit_year">Année<span style="color:red;">*</span></label>
                </td>
                
                <td class="m-0 p-0">

                    <input
                        class="form-control-lg m-0 p-0 ps-3 border border-black"
                        id="txt_carEdit_year"
                        name="txt_carEdit_year"
                        type="text"
                        placeholder="Saisissez l'année de 1er mise en circulation"
                        style="font-size: 1.6rem;"
                        oninput="validateInput('txt_carEdit_year','','labelMessageYear','Veuillez saisir l\'année (à 4 chiffres) de 1er mise en circulation.')"
                        value= "<?php echo $cars['year']; ?>"
                    >

                </td>

            </tr>

            <tr>
                
                <td class="m-0 p-0">
                </td>

                <td class="m-0 p-0">

                    <label class="form-control-lg m-0 mb-2 p-0" id="labelMessageYear">
                        Saisissez l'année (à 4 chiffres) de 1er mise en circulation.
                    </label>

                </td>

            </tr>

            <tr class="m-0 p-0">

                <td class="text-end m-0 p-0">
                    <label class="form-label m-0 p-0 pe-3" for="txt_carEdit_mileage">Kilomètrage<span style="color:red;">*</span></label>
                </td>

                <td class="m-0 p-0">

                    <input
                        class="form-control-lg m-0 p-0 ps-3 border border-black"
                        id="txt_carEdit_mileage"
                        name="txt_carEdit_mileage"
                        type="text"
                        placeholder="Saisissez l'année de 1er mise en circulation"
                        style="font-size: 1.6rem;"
                        oninput="validateInput('txt_carEdit_mileage','','labelMessageMileage','Saisissez le kilomètrage (uniquement des chiffres).')"
                        value= "<?php echo $cars['mileage']; ?>"
                    >

                </td>

            </tr>

            <tr>

                <td class="m-0 p-0">
                </td>

                <td class="m-0 p-0">
                    <label class="form-control-lg m-0 mb-2 p-0" id="labelMessageMileage">
                        Saisissez le kilomètrage (uniquement des chiffres).
                    </label>
                </td>

            </tr>

            <tr class="m-0 p-0">

                <td class="text-end m-0 p-0">
                    <label class="form-label m-0 p-0 pe-3" for="txt_carEdit_price">Prix<span style="color:red;">*</span></label>
                </td>

                <td class="m-0 p-0">

                    <input
                        class="form-control-lg m-0 p-0 ps-3 border border-black"
                        id="txt_carEdit_price"
                        name="txt_carEdit_price"
                        type="text"
                        placeholder="Saisissez le prix"
                        style="font-size: 1.6rem;"
                        oninput="validateInput('txt_carEdit_price','','labelMessagePrice','Saisissez le prix (uniquement des chiffres).')"
                        value= "<?php echo $cars['price']; ?>"
                    >

                </td>

            </tr>

            <tr>

                <td class="m-0 p-0">
                </td>

                <td class="m-0 p-0">
                    <label class="form-control-lg m-0 mb-2 p-0" id="labelMessagePrice">
                        Saisissez le prix (uniquement des chiffres).
                    </label>
                </td>

            </tr>

            <tr class="m-0 p-0">

                <td class="text-end m-0 p-0">
                    <label class="form-label m-0 p-0 pe-3" for="list_carEdit_sold">Disponible<span style="color:red;">*</span></label>
                </td>

                <td class="m-0 p-0">

                    <input
                        list="datalist_carEdit_sold"
                        name="list_carEdit_sold"
                        id="list_carEdit_sold"
                        class="form-control-lg m-0 p-0 ps-3 border border-black fs-4"
                        placeholder="Selectionnez Oui ou Non"
                        oninput="validateInput('list_carEdit_sold','datalist_carEdit_sold','labelMessageSold','Selectionnez Oui ou Non pour indiquer la disponibilité')"
                        value= "<?php echo $cars['sold']; ?>"
                    >

                    <datalist id="datalist_carEdit_sold">

                        <option value="Oui">
                        <option value="Non">

                    </datalist>

                </td>

            </tr>

            <tr>

                <td class="m-0 p-0">
                </td>

                <td class="m-0 p-0">

                    <label class="form-control-lg m-0 mb-2 p-0" id="labelMessageSold">
                        Selectionnez Oui ou Non dans la liste de choix pour indiquer la disponibilité.
                    </label>
                    
                </td>

            </tr>

            <tr class="m-0 p-0">

                <td class="text-end m-0 p-0">
                    <label class="form-label m-0 p-0 pe-3" for="txt_carEdit_description">Description.<span style="color:red;">*</span></label>
                </td>

                <td class="m-0 p-0">

                    <textarea
                        class="form-control-lg m-0 p-0 ps-3 border border-black fs-4"
                        id="txt_carEdit_description"
                        name="txt_carEdit_description"
                        rows="3"
                        placeholder="Saisissez les options et une description"
                        oninput="validateInput('txt_carEdit_description','','labelMessageDescription','Saisissez les options et une description.')"
                    ><?php echo $cars['description'];?></textarea>

                </td>

            </tr>

            <tr>

                <td class="m-0 p-0">
                </td>

                <td class="m-0 p-0">
                    <label class="form-control-lg m-0 mb-2 p-0" id="labelMessageDescription">
                        Saisissez les options et une description..
                    </label>
                </td>

            </tr>
            
            <tr class="m-0 p-0">

                <div class="container">

                    <div class="row">

                        <td class="col-1 text-end">
                            <label class="form-label m-0 p-0 pe-3" for="txt_carEdit_image1">Image1<span style="color:red;">*</span></label>
                        </td>

                        <td class="col-11">

                            <div class="container m-0 p-0">

                                <div class="row">

                                    <div class="col-12 col-lg-3 pb-3 pb-lg-0">

                                        <input
                                            class="form-control-lg m-0 p-0 border border-black"
                                            id="txt_carEdit_image1"
                                            name="txt_carEdit_image1"
                                            type="text"
                                            placeholder="Saisissez le nom de l'image"
                                            style="font-size: 1.6rem;"
                                            oninput="validateInput('txt_carEdit_image1','','labelMessageImage1','Saisissez le nom de l\'image (sans caractères spéciaux sauf - et _) aux formats *.png ou *.jpg ou *.webp. Sinon, téléchargez une image depuis votre disque local. ATTENTION!!! Dimmentions image1 au ratio de 350px sur 180px.')"
                                            value= "<?php echo $cars['image1']; ?>"
                                        >

                                    </div>

                                    <div class="col-12 col-lg-5 d-flex align-items-center pb-3 pb-lg-0">
                                        
                                        <input
                                            class="fs-4"
                                            type="file"
                                            name="fileInput1"
                                            id="fileInput1"
                                            accept="image/jpeg, image/png, image/webp"
                                            directory="./img/garageparrot/vehicle/"
                                        >

                                    </div>

                                    <div class="col-12 col-lg-4 d-flex align-items-center pb-3 pb-lg-0">
                                        
                                        <input
                                            class="btn btn-lg btn-primary fs-4"
                                            type="submit"
                                            name="btn_image1"
                                            id="btn_image1"
                                            value="Télécharger"
                                        >

                                    </div>

                                </div>

                            </div>

                        </td>

                    </div>

                </div>

            </tr>

            <tr>

                <td class="m-0 p-0">
                </td>

                <td class="m-0 p-0">
                    <label class="form-control-lg m-0 mb-2 p-0" id="labelMessageImage1">
                        Saisissez le nom de l'image (sans caractères spéciaux sauf - et _) aux formats png, jpg et webp. Sinon, téléchargez une image depuis votre disque local. ATTENTION!!! Dimmentions image1 au ratio de 350px sur 180px.
                    </label>
                </td>

            </tr>
            
            <tr class="m-0 p-0">

                <div class="container"> 

                    <div class="row">

                        <td class="col-1 text-end">
                            <label class="form-label m-0 p-0 pe-3" for="txt_carEdit_image2">Image2<span style="color:red;">*</span></label>
                        </td>

                        <td class="col-11"> 

                            <div class="container m-0 p-0">

                                <div class="row">

                                    <div class="col-12 col-lg-3 pb-3 pb-lg-0">

                                        <input
                                            class="form-control-lg m-0 p-0 border border-black"
                                            id="txt_carEdit_image2"
                                            name="txt_carEdit_image2"
                                            type="text"
                                            placeholder="Saisissez le nom de l'image"
                                            style="font-size: 1.6rem;"
                                            oninput="validateInput('txt_carEdit_image2','','labelMessageimage2','Saisissez le nom de l\'image (sans caractères spéciaux sauf - et _) aux formats *.png ou *.jpg ou *.webp. Sinon, téléchargez une image depuis votre disque local. ATTENTION!!! Dimmentions image2 au ratio de 350px sur 180px.')"
                                            value= "<?php echo $cars['image2']; ?>"
                                        >

                                    </div>

                                    <div class="col-12 col-lg-5 d-flex align-items-center pb-3 pb-lg-0">
                                        
                                        <input
                                            class="fs-4"
                                            type="file"
                                            name="fileInput2"
                                            id="fileInput2"
                                            accept="image/jpeg, image/png, image/webp"
                                            directory="./img/garageparrot/vehicle/"
                                        >

                                    </div>

                                    <div class="col-12 col-lg-4 d-flex align-items-center pb-3 pb-lg-0">
                                        
                                        <input
                                            class="btn btn-lg btn-primary fs-4"
                                            type="submit"
                                            name="btn_image2"
                                            id="btn_image2"
                                            value="Télécharger"
                                        >

                                    </div>

                                </div>

                            </div>

                        </td>

                    </div>

                </div>

            </tr>

            <tr>

                <td class="m-0 p-0">
                </td>

                <td class="m-0 p-0">

                    <label class="form-control-lg m-0 mb-2 p-0" id="labelMessageImage2">
                        Saisissez le nom de l'image (sans caractères spéciaux sauf - et _) aux formats png, jpg et webp. Sinon, téléchargez une image depuis votre disque local.
                    </label>

                </td>

            </tr>
            
            <tr class="m-0 p-0">

                <div class="container">  

                    <div class="row">

                        <td class="col-1 text-end">
                            <label class="form-label m-0 p-0 pe-3" for="txt_carEdit_image3">Image3<span style="color:red;">*</span></label>
                        </td>

                        <td class="col-11"> 

                            <div class="container m-0 p-0">  

                                <div class="row">

                                    <div class="col-12 col-lg-3 pb-3 pb-lg-0">

                                        <input
                                            class="form-control-lg m-0 p-0 border border-black"
                                            id="txt_carEdit_image3"
                                            name="txt_carEdit_image3"
                                            type="text"
                                            placeholder="Saisissez le nom de l'image"
                                            style="font-size: 1.6rem;"
                                            oninput="validateInput('txt_carEdit_image3','','labelMessageimage3','Saisissez le nom de l\'image (sans caractères spéciaux sauf - et _) aux formats *.png ou *.jpg ou *.webp. Sinon, téléchargez une image depuis votre disque local. ATTENTION!!! Dimmentions image3 au ratio de 350px sur 180px.')"
                                            value= "<?php echo $cars['image3']; ?>"
                                        >

                                    </div>

                                    <div class="col-12 col-lg-5 d-flex align-items-center pb-3 pb-lg-0">
                                        
                                        <input
                                            class="fs-4"
                                            type="file"
                                            name="fileInput3"
                                            id="fileInput3"
                                            accept="image/jpeg, image/png, image/webp"
                                            directory="./img/garageparrot/vehicle/"
                                        >

                                    </div>

                                    <div class="col-12 col-lg-4 d-flex align-items-center pb-3 pb-lg-0">
                                        
                                        <input
                                            class="btn btn-lg btn-primary fs-4"
                                            type="submit"
                                            name="btn_image3"
                                            id="btn_image3"
                                            value="Télécharger"
                                        >
                                    
                                    </div>

                                </div>  

                            </div>

                        </td>

                    </div>

                </div>

            </tr>

            <tr>

                <td class="m-0 p-0">
                </td>

                <td class="m-0 p-0">

                    <label class="form-control-lg m-0 mb-2 p-0" id="labelMessageImage3">
                        Saisissez le nom de l'image (sans caractères spéciaux sauf - et _) aux formats png, jpg et webp. Sinon, téléchargez une image depuis votre disque local.
                    </label>

                </td>

            </tr>
            
            <tr class="m-0 p-0">

                <div class="container">  

                    <div class="row">

                        <td class="col-1 text-end">
                            <label class="form-label m-0 p-0 pe-3" for="txt_carEdit_image4">Image4<span style="color:red;">*</span></label>
                        </td>

                        <td class="col-11"> 

                            <div class="container m-0 p-0">  

                                <div class="row">

                                    <div class="col-12 col-lg-3 pb-3 pb-lg-0">

                                        <input
                                            class="form-control-lg m-0 p-0 border border-black"
                                            id="txt_carEdit_image4"
                                            name="txt_carEdit_image4"
                                            type="text"
                                            placeholder="Saisissez le nom de l'image"
                                            style="font-size: 1.6rem;"
                                            oninput="validateInput('txt_carEdit_image4','','labelMessageimage4','Saisissez le nom de l\'image (sans caractères spéciaux sauf - et _) aux formats *.png ou *.jpg ou *.webp. Sinon, téléchargez une image depuis votre disque local. ATTENTION!!! Dimmentions image4 au ratio de 350px sur 180px.')"
                                            value= "<?php echo $cars['image4']; ?>"
                                        >

                                    </div>

                                    <div class="col-12 col-lg-5 d-flex align-items-center pb-3 pb-lg-0">

                                        <input
                                            class="fs-4"
                                            type="file"
                                            name="fileInput4"
                                            id="fileInput4"
                                            accept="image/jpeg, image/png, image/webp"
                                            directory="./img/garageparrot/vehicle/"
                                        >

                                    </div>

                                    <div class="col-12 col-lg-4 d-flex align-items-center pb-3 pb-lg-0">

                                        <input
                                            class="btn btn-lg btn-primary fs-4"
                                            type="submit"
                                            name="btn_image4"
                                            id="btn_image4"
                                            value="Télécharger"
                                        >

                                    </div>

                                </div>  

                            </div>

                        </td>

                    </div>

                </div>

            </tr>

            <tr>

                <td class="m-0 p-0">
                </td>

                <td class="m-0 p-0">

                    <label class="form-control-lg m-0 mb-2 p-0" id="labelMessageImage4">
                        Saisissez le nom de l'image (sans caractères spéciaux sauf - et _) aux formats png, jpg et webp. Sinon, téléchargez une image depuis votre disque local.
                    </label>

                </td>

            </tr>
            
            <tr class="m-0 p-0">

                <div class="container">  

                    <div class="row">

                        <td class="col-1 text-end">
                            <label class="form-label m-0 p-0 pe-3" for="txt_carEdit_image5">Image5<span style="color:red;">*</span></label>
                        </td>

                        <td class="col-11"> 

                            <div class="container m-0 p-0">  

                                <div class="row">

                                    <div class="col-12 col-lg-3 pb-3 pb-lg-0">

                                        <input
                                            class="form-control-lg m-0 p-0 border border-black"
                                            id="txt_carEdit_image5"
                                            name="txt_carEdit_image5"
                                            type="text"
                                            placeholder="Saisissez le nom de l'image"
                                            style="font-size: 1.6rem;"
                                            oninput="validateInput('txt_carEdit_image5','','labelMessageimage5','Saisissez le nom de l\'image (sans caractères spéciaux sauf - et _) aux formats *.png ou *.jpg ou *.webp. Sinon, téléchargez une image depuis votre disque local. ATTENTION!!! Dimmentions image5 au ratio de 350px sur 180px.')"
                                            value= "<?php echo $cars['image5']; ?>"
                                        >

                                    </div>

                                    <div class="col-12 col-lg-5 d-flex align-items-center pb-3 pb-lg-0">

                                        <input
                                            class="fs-4"
                                            type="file"
                                            name="fileInput5"
                                            id="fileInput5"
                                            accept="image/jpeg, image/png, image/webp"
                                            directory="./img/garageparrot/vehicle/"
                                        >
                                    
                                    </div>

                                    <div class="col-12 col-lg-4 d-flex align-items-center pb-3 pb-lg-0">

                                        <input
                                            class="btn btn-lg btn-primary fs-4"
                                            type="submit"
                                            name="btn_image5"
                                            id="btn_image5"
                                            value="Télécharger"
                                        >

                                    </div>

                                </div>

                            </div>

                        </td>

                    </div>

                </div>

            </tr>

            <tr>

                <td class="m-0 p-0">
                </td>

                <td class="m-0 p-0">

                    <label class="form-control-lg m-0 mb-2 p-0" id="labelMessageImage5">
                        Saisissez le nom de l'image (sans caractères spéciaux sauf - et _) aux formats png, jpg et webp. Sinon, téléchargez une image depuis votre disque local.
                    </label>

                </td>

            </tr>

            <tr class="m-0 p-0">

                <td class="m-0 p-0 pb-5">
                </td>

                <td class="d-flex flex-column flex-sm-row m-0 p-0 pb-5">

                    <div class="pe-2 pb-2 pb-sm-0">

                        <button
                            type="submit"
                            class="btn btn-lg btn-warning fs-4 px-2 mb-2"
                            id="btn_carEdit_cancel"
                            name="btn_carEdit_cancel"
                            onclick="retour()"
                            style="width: 100px;"
                        >Retour
                        </button>

                        <button
                            type="submit"
                            class="btn btn-lg btn-success fs-4 px-2 mb-2"
                            id="btn_carEdit_save_1"
                            name="btn_carEdit_save_1"
                            style="width: 100px;"
                        >Enregistrer
                        </button>

                    </div>

                    <div>

                        <button
                            type="submit"
                            class="btn btn-lg btn-info fs-4 px-2 mb-2"
                            id="btn_carEdit_new"
                            name="btn_carEdit_new"
                            style="width: 100px;"
                        >Nouveau
                        </button>

                        <button
                            type="submit"
                            class="btn btn-lg btn-danger fs-4 px-2 mb-2"
                            id="btn_carEdit_delete"
                            name="btn_carEdit_delete"
                            onclick="confirmDelete()"
                            style="width: 100px;"
                        >Supprimer
                        </button>

                    </div>

                </td>

            </tr>

        </table>

    </form>

</section>

<script src="../js/common/function.js"></script>
<script src="../js/common/fetch.js"></script>
<script src="../js/carEdit.js"></script>
