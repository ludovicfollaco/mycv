<?php
    require_once('../controller/mycv/mycv.controller.php');
    use Model\Utilities\Utilities;
?>

<?php function mycvExperienceImgRight($experience, $i){ ?>
    <div class="container p-0 pb-5 px-2 m-0 m-sm-auto p-sm-auto">

        <?php if ($_SESSION['dataConnect']['type']==='Administrator'){ ?>
        <div class="border border-3 p-3">
        <?php } ?>

            <form method="post" id="formMyCv<?php echo $i; ?>" enctype="multipart/form-data"
                 style="
                    background: <?php echo htmlspecialchars($experience[$i]['background']); ?>;
                    border-radius: 8px;
                    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.55);">
                
                <!-- input hidden csrf -->
                <input
                    type="hidden"
                    name="csrf"
                    value="<?php echo $_SESSION['token']['csrf'];?>"
                >

                <div class="row m-0 p-0">
                    
                    <div class="container d-flex flex-column border rounded-3 m-0 p-0">

                        <!-- Start insert image right -->
                        <div class="d-flex" style= "background: #0f1f4dff;">
                            <?php mycvExperienceLogo($experience, $i) ?>
                            <?php mycvHeader($experience, $i) ?>
                        </div>

                        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start">

                            <div class="d-flex align-items-center w-100 p-3">

                                <?php mycvExperience($experience, $i) ?>

                            </div>

                            <div class="d-flex justify-content-center align-items-center m-auto p-3">

                                <?php mycvExperienceSlide($experience, $i) ?>

                            </div>
                                
                        </div>

                    </div>

                </div>
                <!-- Insert experience settings right -->
                <?php mycvExperienceSettings($experience, $i) ?>

            </form>

            <div class="m-0 py-5 px-0" style="background: transparent;"></div>

        <?php if ($_SESSION['dataConnect']['type']==='Administrator'){ ?>
        </div>
        <?php } ?>

    </div>

<?php } ?>

<?php function mycvExperienceImgLeft($experience, $i){ ?>

    <div class="container p-0 pb-5 px-2 m-0 m-sm-auto p-sm-auto">

        <?php if ($_SESSION['dataConnect']['type']==='Administrator'){ ?>
        <div class="border border-3 p-3">
        <?php } ?>

            <form method="post" id="formMyCv<?php echo $i; ?>" enctype="multipart/form-data"
                 style="
                    background: <?php echo htmlspecialchars($experience[$i]['background']); ?>;
                    border-radius: 8px;
                    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.55);">

                <!-- input hidden csrf -->
                <input
                    type="hidden"
                    name="csrf"
                    value="<?php echo $_SESSION['token']['csrf'];?>"
                >

                <div class="row m-0 p-0">
                    
                    <div class="container d-flex flex-column border rounded-3 m-0 p-0">

                        <!-- Start insert image right -->
                        <div class="d-flex" style= "background: #0f1f4dff;">
                            <?php mycvExperienceLogo($experience, $i) ?>
                            <?php mycvHeader($experience, $i) ?>
                        </div>

                        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start">

                            <div class="d-flex justify-content-center align-items-center m-auto p-3">

                                <?php mycvExperienceSlide($experience, $i) ?>

                            </div>

                            <div class="d-flex align-items-center w-100 p-3">
                                <?php mycvExperience($experience, $i) ?>

                            </div>
                                
                        </div>

                    </div>

                </div>

                <!-- Insert experience settings left -->
                <?php mycvExperienceSettings($experience, $i) ?>

            </form>

            <div class="m-0 py-5 px-0" style="background: transparent;"></div>

        <?php if ($_SESSION['dataConnect']['type']==='Administrator'){ ?>
        </div>
        <?php } ?>

    </div>

<?php } ?>

<?php function mycvExperienceUmpty(){
    
    if ($_SESSION['dataConnect']['type']==='Administrator'){
?>
        <div class="container p-0 pb-5 px-2 m-0 m-sm-auto p-sm-auto">

            <div class="border border-3 p-3">

                <form method="post" id="formMyCv" enctype="multipart/form-data">
                    
                    <!-- input hidden csrf -->
                    <input
                        type="hidden"
                        name="csrf"
                        value="<?php echo $_SESSION['token']['csrf'];?>"
                    >

                    <div class="row m-0 p-0">
                        
                        <div class="container d-flex flex-column border rounded-3 m-0 p-0">

                            <!-- Start insert image right -->
                            <div class="d-flex bg-dark">
                                <?php mycvExperienceLogoNew() ?>
                                <?php mycvHeaderNew() ?>
                            </div>

                            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start">

                                <div class="d-flex align-items-center w-100 p-3">
                                    <?php mycvExperienceNew() ?>

                                </div>

                                <div class="d-flex justify-content-center align-items-center m-auto p-3">

                                    <?php mycvExperienceSlideNew() ?>

                                </div>
                                    
                            </div>

                        </div>

                    </div>
                    <!-- Insert experience settings right -->
                    <?php mycvExperienceSettingsNew() ?>


                </form>

            </div>

        </div>
<?php
    }
}
?>

<?php
function mycvExperienceId($experience, $i){ 

    $id = Utilities::escapeInput($experience[$i]['id']);

    if ($_SESSION['dataConnect']['type']==='Administrator'){
?>
        <div class="d-flex flex-row align-items-center pb-3">

            <label
                class="form-label fs-4"
                for="id"
                style="width: 130px;"
            >Experience ID :</label>

            <input
                class="form-control fs-4 border border-black m-0 p-0 ps-2"
                type="text"
                id="id"
                name="id"
                style="width: 100px;"
                value="<?php echo $id; ?>"
            >

        </div>

<?php
    }
}
?>

<?php
function mycvHeader($experience, $i){

    $id = Utilities::escapeInput($experience[$i]['id']);
    if ($_SESSION['dataConnect']['type']==='Administrator'){
?>
    <div class="d-flex flex-column p-3">
        <!-- Start job -->
        <h3 class="text-light">
            <input
                class="form-control fs-4 ps-2 m-0 p-0 border border-black auto-resize-input"
                type="text"
                name="text_job_<?php echo $id; ?>"
                id="text_job_<?php echo $id; ?>"
                value="<?php echo Utilities::escapeInput($experience[$i]['job']); ?>"
                oninput="resizeInput(this)"
            >
        </h3>
        <!-- End job -->

        <!-- Start company -->
        <h4 class="d-flex flex-column flex-lg-row justify-content-start">
            <input
                class="form-control fs-4 ps-2 m-0 p-0 border border-black auto-resize-input"
                type="text"
                name="text_company_<?php echo $id; ?>"
                id="text_company_<?php echo $id; ?>"
                value="<?php echo Utilities::escapeInput($experience[$i]['company']); ?>"
                oninput="resizeInput(this)"
            >
            <input
                class="form-control fs-4 ps-2 m-0 p-0 border border-black auto-resize-input"
                type="text"
                name="text_contract_<?php echo $id; ?>"
                id="text_contract_<?php echo $id; ?>"
                value="<?php echo Utilities::escapeInput($experience[$i]['contract']); ?>"
                oninput="resizeInput(this)"
            >
        </h4>
        <!-- End company -->

        <!-- Start period -->
        <h4 class="d-flex flex-column flex-lg-row justify-content-start">
            <input
                class="form-control fs-4 ps-2 m-0 p-0 border border-black auto-resize-input"
                type="date"
                name="text_start_<?php echo $id; ?>"
                id="text_start_<?php echo $id; ?>"
                value="<?php echo Utilities::escapeInput($experience[$i]['start']); ?>"
                oninput="resizeInput(this)"
            >
            <input
                class="form-control fs-4 ps-2 m-0 p-0 border border-black auto-resize-input"
                type="date"
                name="text_end_<?php echo $id; ?>"
                id="text_end_<?php echo $id; ?>"
                value="<?php echo Utilities::escapeInput($experience[$i]['end']); ?>"
                oninput="resizeInput(this)"
            >
        </h4>
        <!-- End period -->

        <!-- Start place -->
        <h4 class="d-flex d-row justify-content-start">
            <input
                class="form-control fs-4 ps-2 m-0 p-0 border border-black auto-resize-input"
                type="text"
                name="text_place_<?php echo $id; ?>"
                id="text_place_<?php echo $id; ?>"
                value="<?php echo Utilities::escapeInput($experience[$i]['place']); ?>"
                oninput="resizeInput(this)"
            >
        </h4>
        <!-- End place -->
    </div>

<?php
    }else{
        //Start variable period
        $dateTimeStart = new DateTime(Utilities::escapeInput($experience[$i]['start']));
        $dateStart = $dateTimeStart->format('F Y');

        $dateTimeEnd = new DateTime(Utilities::escapeInput($experience[$i]['end']));
        $dateEnd = $dateTimeEnd->format('F Y');

        $interval = $dateTimeStart->diff($dateTimeEnd);
        $years = $interval->y;
        $months = $interval->m;
        $period = $years . ' an(s) ' . $months . ' mois';
        //End variable period
?>
    <div class="d-flex flex-column p-3">

        <h3 class="text-light">
            <?php echo Utilities::escapeInput($experience[$i]['job']); ?>
        </h3>

        <p class="m-0">
            <span class="text-light"><?php echo Utilities::escapeInput($experience[$i]['company']) . ' - ' . Utilities::escapeInput($experience[$i]['contract']); ?></span><br>
            <span class="text-light fs-5"><?php echo $dateStart . ' - ' . $dateEnd . ' : ' . $period;; ?></span><br>
            <span class="text-light fs-5"><?php echo Utilities::escapeInput($experience[$i]['place']); ?></span>
        </p>

    </div>

<?php
    }
}
?>

<?php
function mycvHeaderNew(){
?>
    <div class="d-flex flex-column p-3">
        <!-- Start job -->
        <h3 class="text-light">
            <input
                class="form-control fs-4 m-0 p-0 border border-black auto-resize-input"
                type="text"
                name="text_job_new"
                id="text_job_new"
                placeholder="Enter your job title"
            >
        </h3>
        <!-- End job -->

        <!-- Start company -->
        <h4 class="d-flex flex-column flex-lg-row justify-content-start">
            <input
                class="form-control fs-4 m-0 p-0 border border-black auto-resize-input"
                type="text"
                name="text_company_new"
                id="text_company_new"
                placeholder="Enter the company name"
                oninput="resizeInput(this)"
            >
            <input
                class="form-control fs-4 m-0 p-0 border border-black auto-resize-input"
                type="text"
                name="text_contract_new"
                id="text_contract_new"
                placeholder="Enter the contract type"
                oninput="resizeInput(this)"
            >
        </h4>
        <!-- End company -->

        <!-- Start period -->
        <h4 class="d-flex flex-column flex-lg-row justify-content-start">
            <input
                class="form-control fs-4 m-0 p-0 border border-black auto-resize-input"
                type="date"
                name="text_start_new"
                id="text_start_new"
                placeholder="Enter the start date"
                oninput="resizeInput(this)"
            >
            <input
                class="form-control fs-4 m-0 p-0 border border-black auto-resize-input"
                type="date"
                name="text_end_new"
                id="text_end_new"
                placeholder="Enter the end date"
                oninput="resizeInput(this)"
            >
        </h4>
        <!-- End period -->

        <!-- Start place -->
        <h4 class="d-flex d-row justify-content-center">
            <input
                class="form-control fs-4 m-0 p-0 border border-black auto-resize-input"
                type="text"
                name="text_place_new"
                id="text_place_new"
                placeholder="Enter the place"
                oninput="resizeInput(this)"
            >
        </h4>
        <!-- End place -->
    </div>
<?php
}
?>

<?php
function mycvExperience($experience, $i){

    $id = Utilities::escapeInput($experience[$i]['id']);
    $experienceText = Utilities::escapeInput($experience[$i]['experience']);

    if ($_SESSION['dataConnect']['type']==='Administrator'){
?>
        <p class="w-100" style="text-align: justify; white-space: pre-line;">
            <textarea
                name="textarea_<?php echo $id; ?>"
                id="textarea_<?php echo $id; ?>"
                cols="1"
                rows="10"
                ><?php echo $experienceText; ?></textarea>
        </p>
<?php
    }else{
        // Remplacer les tabulations par des espaces insécables pour l'affichage
        $experienceText = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $experienceText);
?>
        <p class="m-0 p-0 pe-3" style="text-align: justify; white-space: pre-line;">
            <?php echo $experienceText; ?>
        </p>
<?php
    }
}
?>

<?php
function mycvExperienceNew(){
?>
    <p class="w-100" style="text-align: justify; white-space: pre-line;">
        <textarea
            class=""
            name="textarea_new"
            id="textarea_new"
            cols="1"
            rows="10"
            placeholder="Enter your experience..."
        ></textarea>
    </p>
<?php
}
?>

<?php
function mycvExperienceButtonImg($experience, $i){
    
    $id = Utilities::escapeInput($experience[$i]['id']);
    
    if ($_SESSION['dataConnect']['type']==='Administrator'){
?>
        <div class="container px-3 pb-0 pb-lg-3">

            <div class="row">

                <div class="col-12 col-lg-5 pb-3 pb-lg-0">

                    <input
                        class="form-control fs-4 ps-2 border border-black m-0 p-0"
                        id="text_logo_<?php echo $id; ?>"
                        name="text_logo_<?php echo $id; ?>"
                        type="text"
                        placeholder="Saisissez le nom de l'image"
                        readonly
                        style="font-size: 1.6rem;"
                        oninput="validateInput('text_logo_','','labelMessageimg_chapter2','Saisissez le nom de l\'image (sans useractères spéciaux sauf - et _) aux formats *.png ou *.jpg ou *.webp. Sinon, téléchargez une image depuis votre disque local. ATTENTION!!! Dimmentions image au ratio de 200px sur 450px.')"
                        value="<?php echo Utilities::escapeInput($experience[$i]['logo']);?>"
                    >

                </div>

                <div class="col-12 col-lg-4 d-flex align-items-center pb-3 pb-lg-0">
                    
                    <input
                        class=""
                        type="file"
                        name="file_logo_<?php echo $id; ?>"
                        id="file_logo_<?php echo $id; ?>"
                        accept="image/jpeg, image/png, image/webp"
                    >

                </div>

                <div class="col-12 col-lg-2 d-flex align-items-center pb-3 pb-lg-0">
                    
                    <input
                        class="btn btn-lg btn-primary "
                        type="submit"
                        name="btn_logo_<?php echo $id; ?>"
                        id="btn_logo_<?php echo $id; ?>"
                        value="Upload logo <?php echo $id; ?>"
                        style="width: auto;"
                    >

                </div>

            </div>

        </div>
<?php
    }
}
?>

<?php
function mycvExperienceButtonImgNew(){
?>
    <div class="container px-3 pb-0 pb-lg-3">

        <div class="row">

            <div class="col-12 col-lg-5 pb-3 pb-lg-0">

                <input
                    class="form-control-lg bg-transparent m-0 p-0 border border-black"
                    id="text_logo_new"
                    name="text_logo_new"
                    type="text"
                    placeholder="Saisissez le nom de l'image"
                    readonly
                    style="font-size: 1.6rem;"
                    value="new.webp"
                    oninput="validateInput('text_logo_','','labelMessageimg_chapter2','Saisissez le nom de l\'image (sans useractères spéciaux sauf - et _) aux formats *.png ou *.jpg ou *.webp. Sinon, téléchargez une image depuis votre disque local. ATTENTION!!! Dimmentions image au ratio de 200px sur 450px.')"
                >

            </div>

            <div class="col-12 col-lg-4 d-flex align-items-center pb-3 pb-lg-0">
                
                <input
                    class=""
                    type="file"
                    name="file_logo_new"
                    id="file_logo_new"
                    accept="image/jpeg, image/png, image/webp"
                >

            </div>

            <div class="col-12 col-lg-2 d-flex align-items-center pb-3 pb-lg-0">
                
                <input
                    class="btn btn-lg btn-primary "
                    type="submit"
                    name="btn_logo_new"
                    id="btn_logo_new"
                    value="Upload logo new"
                    style="width: auto;"
                >

            </div>

        </div>

    </div>
<?php
}
?>

<?php
function mycvExperienceImg($experience, $i){
    
    if ($experience[$i]['img_yesOrNo'] === "yes"){ 
        $id = Utilities::escapeInput($experience[$i]['id']);
?>
        <div class="d-none d-sm-block">
            
            <img
                class="rounded-3"
                id="img_<?php echo $id; ?>"
                name="img_<?php echo $id; ?>"
                src="img/mycv/experience/<?php echo Utilities::escapeInput($experience[$i]['img']);?>"
                alt="image de l'experience <?php echo $id; ?>"
                style="
                        width: <?php echo Utilities::escapeInput($experience[$i]['img_width']);?>;
                        height: <?php echo Utilities::escapeInput($experience[$i]['img_height']);?>;
                        object-fit: <?php echo Utilities::escapeInput($experience[$i]['img_objectFit']);?>;
                    "
            >

        </div>
<?php
    }
}
?>

<?php
function mycvExperienceImgNew(){
?>
    <div class="d-none d-sm-block">
        
        <img
            class="rounded-3"
            id="img_new"
            name="img_new"
            src="img/mycv/article/img_umpty_300x600.webp"
            alt="image de l'experience new"
            style="
                    width: 300px;
                    height: auto;
                    object-fit: cover;
                "
        >

    </div>
<?php
}
?>

<?php
function mycvExperienceSlide($experience, $i){

    if ($experience[$i]['img_yesOrNo'] === "yes"){

        $id = Utilities::escapeInput($experience[$i]['id']);
        $imgPrefix = Utilities::escapeInput($experience[$i]['img']);
        $folder = 'img/mycv/experience/' . $imgPrefix . '/';
        $numberFile = countFilesInFolder('./' .$folder);
?>
        <a
            href="<?php echo '../' . $folder . $imgPrefix; ?>_0.webp"
            class="popup-gallery"
            data-fancybox="car-gallery-<?php echo $id; ?>"
        >
        <figure>
            <img
                class="slideshow"
                src="<?php echo '../' . $folder . $imgPrefix; ?>_0.webp"
                alt="Image du véhicule"
                style="
                        width: <?php echo Utilities::escapeInput($experience[$i]['img_width']);?>;
                        max-width: 350px;
                        height: <?php echo Utilities::escapeInput($experience[$i]['img_height']);?>;
                        object-fit: <?php echo Utilities::escapeInput($experience[$i]['img_objectFit']);?>;
                    "
            >
            <figcaption class="text-center">Open gallery</figcaption>
        </figure>
        </a>
<?php
        for($f=1; $f<$numberFile; $f++){

            $url = $folder . $imgPrefix . '_' . $f . '.webp';

            if (file_exists('./' . $url)){
?>
                <a
                    href="<?php echo '../' . $url; ?>"
                    class="popup-gallery"
                    data-fancybox="car-gallery-<?php echo $id; ?>"
                ></a>
<?php
            }
        }
    }
}
?>

<?php
function mycvExperienceSlideNew(){

    $imgPrefix = 'new';
    $folder = 'img/mycv/experience/' . $imgPrefix . '/';
    $numberFile = countFilesInFolder('./' .$folder);
?>
    <a
        href="<?php echo '../' . $folder . $imgPrefix; ?>_0.webp"
        class="popup-gallery"
        data-fancybox="car-gallery-new"
    >
    <figure>
        <img
            class="slideshow"
            src="<?php echo '../' . $folder . $imgPrefix; ?>_0.webp"
            alt="Image du véhicule"
            style="width:100%;
                    height:100%;
                    object-fit:scale-down;
                "
        >
        <figcaption class="text-center">Open gallery</figcaption>
    </figure>
    </a>
<?php
    for($f=1; $f<$numberFile; $f++){

        $url = $folder . $imgPrefix . '_' . $f . '.webp';

        if (file_exists('./' . $url)){
?>
            <a
                href="<?php echo '../' . $url; ?>"
                class="popup-gallery"
                data-fancybox="car-gallery-new"
            ></a>
<?php
        }
    }
}
?>

<?php
function mycvExperienceLogo($experience, $i){

    $id = Utilities::escapeInput($experience[$i]['id']);
?>
    <div class="d-none d-sm-block py-3 ps-3">
        
        <img
            class="rounded-3"
            id="text_logo_<?php echo $id; ?>"
            name="text_logo_<?php echo $id; ?>"
            src="img/mycv/logo/<?php echo Utilities::escapeInput($experience[$i]['logo']);?>"
            alt="image de l'experience <?php echo $id; ?>"
            style="height:100px;"
        >

    </div>
<?php
}
?>

<?php
function mycvExperienceLogoNew(){
?>
    <div class="d-none d-sm-block py-3 ps-3">
        
        <img
            class="rounded-3"
            id="text_logo_new"
            name="text_logo_new"
            src="img/mycv/logo/new.webp"
            alt="image de l'experience new"
            style="height:100px;"
        >

    </div>
<?php
}
?>

<?php
function mycvExperienceSettings($experience, $i){
    
    if ($_SESSION['dataConnect']['type']==='Administrator'){ 
        $id = Utilities::escapeInput($experience[$i]['id']);
?>
        <div class="container">

            <div class="row">

                <p class="pt-3 fw-bold">LOGO COMPANY</p>

                <?php mycvExperienceButtonImg($experience, $i) ?>
            
                <hr>

                <p class="fw-bold">SILDESHOW SETTINGS</p>
            
                <div class="d-flex text-start">
                        
                    <label
                        class="form-label fs-4"
                        for="img_yesOrNo_<?php echo $id; ?>"
                        style="width: 130px;"
                    >Show slideshow :</label>

                    <input
                        class="form-check-input fs-4 ps-2 m-0 p-0 border border-black d-flex text-start"
                        type="checkbox"
                        id="img_yesOrNo_<?php echo $id; ?>"
                        name="img_yesOrNo_<?php echo $id; ?>"
                        style="width: 20px; height: 20px;"
                        value="yes"
                        <?php if (Utilities::escapeInput($experience[$i]['img_yesOrNo']) === 'yes'){ echo 'checked'; } ?>
                    >
                </div>

                <div class="d-flex flex-row align-items-center">

                    <label
                        class="form-label fs-4"
                        for="img_prefix_<?php echo $id; ?>"
                        style="width: 130px;"
                    >Image prefix :</label>
                    <input
                        class="form-control fs-4 ps-2 m-0 p-0 border border-black"
                        type="text"
                        id="img_prefix_<?php echo $id; ?>"
                        name="img_prefix_<?php echo $id; ?>"
                        style="width: 100px;"
                        value="<?php echo Utilities::escapeInput($experience[$i]['img']); ?>"
                    >
                    
                </div>

                <div class="d-flex flex-row align-items-center">

                    <label
                        class="form-label fs-4"
                        for="img_rightOrLeft_<?php echo $id; ?>"
                        style="width: 130px;"
                    >Right or left :</label>
                    <select
                        class="form-select fs-4 ps-2 m-0 p-0 border border-black"
                        id="img_rightOrLeft_<?php echo $id; ?>"
                        name="img_rightOrLeft_<?php echo $id; ?>"
                        style="width: 100px;"
                    >
                    <option value="<?php echo Utilities::escapeInput($experience[$i]['img_rightOrLeft']); ?>"><?php echo Utilities::escapeInput($experience[$i]['img_rightOrLeft']); ?></option>
                    <option value="right">right</option>
                    <option value="left">left</option>
                    </select>

                </div>

                <div class="d-flex flex-row align-items-center">

                    <label
                        class="form-label fs-4"
                        for="img_objectFit_<?php echo $id; ?>"
                        style="width: 130px;"
                    >Object-fit :</label>
                    <select
                        class="form-select fs-4 ps-2 m-0 p-0 border border-black"
                        id="img_objectFit_<?php echo $id; ?>"
                        name="img_objectFit_<?php echo $id; ?>"
                        style="width: 100px;"
                    >
                    <option value="<?php echo Utilities::escapeInput($experience[$i]['img_objectFit']); ?>"><?php echo Utilities::escapeInput($experience[$i]['img_objectFit']); ?></option>
                    <option value="cover">cover</option>
                    <option value="contain">contain</option>
                    <option value="fill">fill</option>
                    <option value="none">none</option>
                    <option value="scale-down">scale-down</option>
                    </select>

                </div>

                <div class="d-flex flex-row align-items-center">

                    <label
                        class="form-label fs-4"
                        for="img_width_<?php echo $id; ?>"
                        style="width: 130px;"
                    >Width :</label>
                    <input
                        class="form-control fs-4 ps-2 m-0 p-0 border border-black"
                        type="text"
                        id="img_width_<?php echo $id; ?>"
                        name="img_width_<?php echo $id; ?>"
                        style="width: 100px;"
                        value="<?php echo Utilities::escapeInput($experience[$i]['img_width']); ?>"
                    >
                    
                </div>

                <div class="d-flex flex-row align-items-center pb-3">

                    <label
                        class="form-label fs-4"
                        for="img_height_<?php echo $id; ?>"
                        style="width: 130px;"
                    >Height :</label>
                    <input
                        class="form-control fs-4 ps-2 m-0 p-0 border border-black"
                        type="text"
                        id="img_height_<?php echo $id; ?>"
                        name="img_height_<?php echo $id; ?>"
                        style="width: 100px;"
                        value="<?php echo Utilities::escapeInput($experience[$i]['img_height']); ?>"
                    >
                    
                </div>
                <hr>
                <p class="fw-bold">OTHER SETTINGS</p>

                <!-- Insert Experience Id right -->
                <?php mycvExperienceId($experience, $i) ?>

                <div class="d-flex flex-row align-items-center pb-3">

                    <label
                        class="form-label fs-4"
                        for="sort_<?php echo $id; ?>"
                        style="width: 130px;"
                    >Experience sort :</label>
                    <input
                        class="form-control fs-4 ps-2 m-0 p-0 border border-black"
                        type="text"
                        id="sort_<?php echo $id; ?>"
                        name="sort_<?php echo $id; ?>"
                        style="width: 100px;"
                        value="<?php echo Utilities::escapeInput($experience[$i]['sort']); ?>"
                    >
                    
                </div>
                <hr>
                <div class="d-flex flex-column flex-md-row justify-content-center pb-3">
                    <div class="d-flex justify-content-center p-0 pb-2 pe-md-3">
                        <input
                            class="btn btn-lg btn-primary"
                            type="submit"
                            name="btn_save_<?php echo $id; ?>"
                            id="btn_save_<?php echo $id; ?>"
                            value="Save experience <?php echo $id; ?>"
                            style="width: 150px;"
                        >
                    </div>

                    <div class="d-flex justify-content-center p-0 pb-2">
                        <input
                            class="btn btn-lg btn-danger"
                            type="submit"
                            name="btn_delete_<?php echo $id; ?>"
                            id="btn_delete_<?php echo $id; ?>"
                            value="Delete experience <?php echo $id; ?>"
                            style="width: 150px;"
                        >
                    </div>

                </div>

            </div>

        </div>
<?php
    }
}
?>

<?php
function mycvExperienceSettingsNew(){
?>
    <div class="container">

        <div class="row">

            <p class="pt-3 fw-bold">LOGO COMPANY</p>

            <?php mycvExperienceButtonImgNew() ?>

            <hr>

            <p class="fw-bold">SILDESHOW SETTINGS</p>
        
            <div class="d-flex text-start">
                    
                <label
                    class="form-label fs-4"
                    for="img_yesOrNo_new"
                    style="width: 130px;"
                >Show slideshow :</label>

                <input
                    class="d-flex text-start"
                    type="checkbox"
                    id="img_yesOrNo_new"
                    name="img_yesOrNo_new"
                    style="width: 20px; height: 20px;"
                    value="yes"
                    checked
                >
            </div>

            <div class="d-flex flex-row align-items-center">

                <label
                    class="form-label fs-4"
                    for="img_prefix_new"
                    style="width: 130px;"
                >Image prefix :</label>
                <input
                    class="form-control fs-5"
                    type="text"
                    id="img_prefix_new"
                    name="img_prefix_new"
                    style="width: 100px;"
                    value="new"
                >
                
            </div>

            <div class="d-flex flex-row align-items-center">

                <label
                    class="form-label fs-4"
                    for="img_rightOrLeft_new"
                    style="width: 130px;"
                >Right or left :</label>
                <select
                    class="form-select"
                    id="img_rightOrLeft_new"
                    name="img_rightOrLeft_new"
                    style="width: 100px;"
                >
                <option value="right">right</option>
                <option value="left">left</option>
                </select>

            </div>

            <div class="d-flex flex-row align-items-center">

                <label
                    class="form-label fs-4"
                    for="img_objectFit_new"
                    style="width: 130px;"
                >Object-fit :</label>
                <select
                    class="form-select"
                    id="img_objectFit_new"
                    name="img_objectFit_new"
                    style="width: 100px;"
                >
                <option value="cover">cover</option>
                <option value="contain">contain</option>
                <option value="fill">fill</option>
                <option value="none">none</option>
                <option value="scale-down">scale-down</option>
                </select>

            </div>

            <div class="d-flex flex-row align-items-center">

                <label
                    class="form-label fs-4"
                    for="img_width_new"
                    style="width: 130px;"
                >Width :</label>
                <input
                    class="form-control fs-5"
                    type="text"
                    id="img_width_new"
                    name="img_width_new"
                    style="width: 100px;"
                    value="300px"
                >
                
            </div>

            <div class="d-flex flex-row align-items-center pb-3">

                <label
                    class="form-label fs-4"
                    for="img_height_new"
                    style="width: 130px;"
                >Height :</label>
                <input
                    class="form-control fs-5"
                    type="text"
                    id="img_height_new"
                    name="img_height_new"
                    style="width: 100px;"
                    value="auto"
                >
                
            </div>
            <hr>
            <p class="fw-bold">OTHER SETTINGS</p>

            <!-- Insert Experience Id right -->
            <?php //mycvExperienceId($experience, $i) ?>

            <div class="d-flex flex-row align-items-center pb-3">

                <label
                    class="form-label fs-4"
                    for="sort_new"
                    style="width: 130px;"
                >Experience sort :</label>
                <input
                    class="form-control fs-5"
                    type="text"
                    id="sort_new"
                    name="sort_new"
                    style="width: 100px;"
                    value="100"
                >
                
            </div>
            <hr>
            <div class="d-flex flex-column flex-md-row justify-content-center pb-3">
                <div class="d-flex justify-content-center p-0 pb-2 pe-md-3">
                    <input
                        class="btn btn-lg btn-primary"
                        type="submit"
                        name="btn_save_new"
                        id="btn_save_new"
                        value="Save experience new"
                        style="width: 150px;"
                    >
                </div>

            </div>

        </div>

    </div>
<?php
}
?>

<?php

function countFilesInFolder($folder){

    $files = array_diff(scandir($folder), array('.', '..'));
    $numberFile = 0;

    foreach ($files as $file) {
        if (is_file($folder . DIRECTORY_SEPARATOR . $file)) {
            $numberFile++;
        }
    }

    return $numberFile;
}

?>

<script>
    function resizeInput(input) {
        input.style.width = 'auto'; // Réinitialiser la largeur pour obtenir la largeur correcte
        input.style.width = (input.scrollWidth + 2) + 'px'; // Ajuster la largeur en fonction du contenu
    }

    // Initial resize for inputs with pre-filled values
    document.querySelectorAll('.auto-resize-input').forEach(function(input) {
        resizeInput(input);
    });
</script>