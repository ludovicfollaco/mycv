<?php
    require_once('../controller/mycv/network.controller.php');
    use Model\Utilities\Utilities;
?>

<?php function mediaRight(array $network = [], int $item = 1, array $medias = []){ ?>
    <div class="container p-0 pb-5 px-2 m-0 m-sm-auto p-sm-auto">

        <?php if ($_SESSION['dataConnect']['type']==='Administrator'){ ?>
        <div class="border border-3 p-3">
        <?php } ?>

            <form method="post" id="formMyCv<?php echo $item; ?>" enctype="multipart/form-data"
                 style="
                    background: <?php echo htmlspecialchars($network[$item]['background']); ?>;
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
                        <div class="d-flex flex-column justify-content-center align-items-center text-center p-3 mb-1"
                            style="background: <?php echo htmlspecialchars($network[$item]['background_title']); ?>;">
                            <h2 class="text-white text-center">
                                <?php echo htmlspecialchars($network[$item]['newspaper']); ?>
                            </h2>
                            <span class="text-white text-center">
                                <?php echo htmlspecialchars($network[$item]['editor']) . ' - le ' . htmlspecialchars($network[$item]['date']); ?>
                            </span>
                        </div>

                        <!-- Start insert image right -->
                        <div class="d-flex flex-column justify-content-center align-items-center text-center p-3"
                            style="background:  #959cb1ff;">
                            <h2 class="fw-bold text-white text-center">
                                <?php echo htmlspecialchars($network[$item]['title']); ?>
                            </h2>
                            <h3 class="text-white text-center">
                                <?php echo htmlspecialchars($network[$item]['subtitle']); ?>
                            </h3>
                        </div>

                        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start">

                            <div class="d-flex align-items-center w-100 p-3">

                                <?php actuNetwork($network, $item) ?>

                            </div>

                            <div class="d-flex flex-column justify-content-center align-items-center m-auto p-3">
                                <span class="d-block text-center p-0 m-0">
                                    Cliquez sur l'image pour ouvrir la galerie
                                </span>
                                <?php
                                    if ($network[$item]['media_yesOrNo'] === "yes"){
                                        $pageID = Utilities::checkPage("page", "network");
                                        $sectionId = (int)Utilities::escapeInput($network[$item]['id']);
                                        slideFancyBox($pageID, $sectionId, $medias);
                                    }
                                ?>
                            </div>
                                
                        </div>

                        <a href="<?php echo htmlspecialchars($network[$item]['urlArticle']); ?>" class="btn btn-primary" target="_blank"><?php echo 'Voir l\'article complet sur ' . htmlspecialchars($network[$item]['newspaper']); ?></a>

                <!-- Insert network settings right -->

                    </div>

                </div>

                
                <?php //mycvNetworkSettings($network, $i) ?>

            </form>

            <div class="m-0 py-5 px-0" style="background: transparent;"></div>

        <?php if ($_SESSION['dataConnect']['type']==='Administrator'){ ?>
        </div>
        <?php } ?>

    </div>

<?php } ?>

<?php function mediaLeft(array $network = [], int $i = 0, array $medias = []){ ?>

    <div class="container p-0 pb-5 px-2 m-0 m-sm-auto p-sm-auto">

        <?php if ($_SESSION['dataConnect']['type']==='Administrator'){ ?>
        <div class="border border-3 p-3">
        <?php } ?>

            <form method="post" id="formMyCv<?php echo $i; ?>" enctype="multipart/form-data"
                 style="
                    background: <?php echo htmlspecialchars($network[$i]['background']); ?>;
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
                            <?php mycvNetworkLogo($network, $i) ?>
                            <?php mycvHeader($network, $i) ?>
                        </div>

                        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start">

                            <div class="d-flex justify-content-center align-items-center m-auto p-3">

                                <?php slideFancyBox($network, $i) ?>

                            </div>

                            <div class="d-flex align-items-center w-100 p-3">
                                <?php actuNetwork($network, $i) ?>

                            </div>
                                
                        </div>

                    </div>

                </div>

                <!-- Insert network settings left -->
                <?php mycvNetworkSettings($network, $i) ?>

            </form>

            <div class="m-0 py-5 px-0" style="background: transparent;"></div>

        <?php if ($_SESSION['dataConnect']['type']==='Administrator'){ ?>
        </div>
        <?php } ?>

    </div>

<?php } ?>

<?php function networkUmpty(){
    
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
                                <?php mycvNetworkLogoNew() ?>
                                <?php mycvHeaderNew() ?>
                            </div>

                            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start">

                                <div class="d-flex align-items-center w-100 p-3">
                                    <?php mycvNetworkNew() ?>

                                </div>

                                <div class="d-flex justify-content-center align-items-center m-auto p-3">

                                    <?php mycvNetworkSlideNew() ?>

                                </div>
                                    
                            </div>

                        </div>

                    </div>
                    <!-- Insert network settings right -->
                    <?php mycvNetworkSettingsNew() ?>


                </form>

            </div>

        </div>
<?php
    }
}
?>

<?php
function mycvNetworkId($network, $i){ 

    $id = Utilities::escapeInput($network[$i]['id']);

    if ($_SESSION['dataConnect']['type']==='Administrator'){
?>
        <div class="d-flex flex-row align-items-center pb-3">

            <label
                class="form-label fs-4"
                for="id"
                style="width: 130px;"
            >Network ID :</label>

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
function mycvHeader($network, $i){

    $id = Utilities::escapeInput($network[$i]['id']);
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
                value="<?php echo Utilities::escapeInput($network[$i]['job']); ?>"
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
                value="<?php echo Utilities::escapeInput($network[$i]['company']); ?>"
                oninput="resizeInput(this)"
            >
            <input
                class="form-control fs-4 ps-2 m-0 p-0 border border-black auto-resize-input"
                type="text"
                name="text_contract_<?php echo $id; ?>"
                id="text_contract_<?php echo $id; ?>"
                value="<?php echo Utilities::escapeInput($network[$i]['contract']); ?>"
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
                value="<?php echo Utilities::escapeInput($network[$i]['start']); ?>"
                oninput="resizeInput(this)"
            >
            <input
                class="form-control fs-4 ps-2 m-0 p-0 border border-black auto-resize-input"
                type="date"
                name="text_end_<?php echo $id; ?>"
                id="text_end_<?php echo $id; ?>"
                value="<?php echo Utilities::escapeInput($network[$i]['end']); ?>"
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
                value="<?php echo Utilities::escapeInput($network[$i]['place']); ?>"
                oninput="resizeInput(this)"
            >
        </h4>
        <!-- End place -->
    </div>

<?php
    }else{
        //Start variable period
        /*$dateTimeStart = new DateTime(Utilities::escapeInput($network[$i]['date']));
        $dateStart = $dateTimeStart->format('F Y');

        $dateTimeEnd = new DateTime(Utilities::escapeInput($network[$i]['end']));
        $dateEnd = $dateTimeEnd->format('F Y');

        $interval = $dateTimeStart->diff($dateTimeEnd);
        $years = $interval->y;
        $months = $interval->m;
        $period = $years . ' an(s) ' . $months . ' mois';
        //End variable period
        */
?>
    <div class="d-flex flex-column p-3">

        <h3 class="text-light">
            <?php //echo Utilities::escapeInput($network[$i]['job']); ?>
        </h3>

        <p class="m-0">
            <span class="text-light"><?php //echo Utilities::escapeInput($network[$i]['company']) . ' - ' . Utilities::escapeInput($network[$i]['contract']); ?></span><br>
            <span class="text-light fs-5"><?php //echo $dateStart . ' - ' . $dateEnd . ' : ' . $period;; ?></span><br>
            <span class="text-light fs-5"><?php //echo Utilities::escapeInput($network[$i]['place']); ?></span>
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
function actuNetwork($network, $i){

    $id = Utilities::escapeInput($network[$i]['id']);
    $networkText = Utilities::escapeInput($network[$i]['article']);

    if ($_SESSION['dataConnect']['type']==='Administrator'){
?>
        <p class="w-100" style="text-align: justify; white-space: pre-line;">
            <textarea
                name="textarea_<?php echo $id; ?>"
                id="textarea_<?php echo $id; ?>"
                cols="1"
                rows="10"
                ><?php echo $networkText; ?></textarea>
        </p>
<?php
    }else{
        // Remplacer les tabulations par des espaces insécables pour l'affichage
        $networkText = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $networkText);
?>
        <p class="m-0 p-0 pe-3" style="text-align: justify; white-space: pre-line;">
            <?php echo $networkText; ?>
        </p>
<?php
    }
}
?>

<?php
function mycvNetworkNew(){
?>
    <p class="w-100" style="text-align: justify; white-space: pre-line;">
        <textarea
            class=""
            name="textarea_new"
            id="textarea_new"
            cols="1"
            rows="10"
            placeholder="Enter your network..."
        ></textarea>
    </p>
<?php
}
?>

<?php
function mycvNetworkButtonImg($network, $i){
    
    $id = Utilities::escapeInput($network[$i]['id']);
    
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
                        value="<?php echo Utilities::escapeInput($network[$i]['logo']);?>"
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
function mycvNetworkButtonImgNew(){
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
function mycvNetworkImg($network, $i){
    
    if ($network[$i]['img_yesOrNo'] === "yes"){ 
        $id = Utilities::escapeInput($network[$i]['id']);
?>
        <div class="d-none d-sm-block">
            
            <img
                class="rounded-3"
                id="media_<?php echo $id; ?>"
                name="media_<?php echo $id; ?>"
                src="img/mycv/network/<?php echo Utilities::escapeInput($network[$i]['media']);?>"
                alt="image de l'network <?php echo $id; ?>"
                style="
                        width: <?php echo Utilities::escapeInput($network[$i]['media_width']);?>;
                        height: <?php echo Utilities::escapeInput($network[$i]['media_height']);?>;
                        object-fit: <?php echo Utilities::escapeInput($network[$i]['media_objectFit']);?>;
                    "
            >

        </div>
<?php
    }
}
?>

<?php
function mycvNetworkImgNew(){
?>
    <div class="d-none d-sm-block">
        
        <img
            class="rounded-3"
            id="img_new"
            name="img_new"
            src="img/mycv/article/img_umpty_300x600.webp"
            alt="image de l'network new"
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
function slideFancyBox(int $pageId, int $sectionId, array $myMedias)
{
    $type;

    $resultMedia = array_values(array_filter($myMedias, function($item) use ($pageId) {
        return isset($item['page_id']) && (int)$item['page_id'] === (int)$pageId;
    }));

    if (empty($resultMedia)) return;

    $myMedia = [];
    foreach ($resultMedia as $m) {

        $show      = Utilities::escapeInput($m['show']);

        $url       = Utilities::escapeInput($m['url']);
        $folder    = Utilities::escapeInput($m['folder']);
        $media     = Utilities::escapeInput($m['media']); // ex: "0", "1", "2"
        $extension = Utilities::escapeInput($m['extension']);

        if ($extension !== "iframe") {
            $href = '../' . $url . $folder . '/' . $folder . '_' . $media . '.' . $extension;
        } else {
            $href = $url;
        }

        $alt       = Utilities::escapeInput($m['alt'] ?? '');
        $caption   = Utilities::escapeInput($m['caption'] ?? $alt);
        $width     = Utilities::escapeInput($m['width']);
        $maxWidth  = Utilities::escapeInput($m['maxWidth']);
        $height    = Utilities::escapeInput($m['height']);
        $objectFit = Utilities::escapeInput($m['objectFit']);
        $sort = Utilities::escapeInput($m['sort']);

        $myMedia[] = [
            'show'      => $show,
            'href'      => $href,
            'alt'       => $alt,
            'caption'   => $caption,
            'width'     => $width,
            'maxWidth'  => $maxWidth,
            'height'    => $height,
            'objectFit' => $objectFit,
            'extension' => $extension,
            'sort' => $sort,
        ];
    }
    usort($myMedia, function ($a, $b) {
        return strnatcmp($a['sort'], $b['sort']);
    });
    
    ?>
    <figure class="text-center my-3">

        <a
            href="<?php echo $myMedia[0]['href']; ?>"
            class         = "popup-gallery"
            data-fancybox = "car-gallery-<?php echo (int)$sectionId; ?>"
            data-caption  = "<?php echo $myMedia[0]['caption']; ?>"
        >
            <img class="slideshow border rounded shadow-sm"
                
                src="<?php echo $myMedia[0]['href']; ?>"
                alt="<?php echo $myMedia[0]['alt']; ?>"
                style="
                    width:      <?php echo $myMedia[0]['width'];     ?>;
                    max-width:  <?php echo $myMedia[0]['maxWidth'];  ?>;
                    height:     <?php echo $myMedia[0]['height'];    ?>;
                    object-fit: <?php echo $myMedia[0]['objectFit']; ?>;
                "
            >
        </a>

        <figcaption class="small text-muted mt-2">
            <?php echo $myMedia[0]['caption']; ?>
        </figcaption>

    </figure>
    <!-- Les autres items du même groupe (à partir de 1) -->
    <?php   for ($f = 1; $f < count($myMedia); $f++){ ?>
    
        <?php   if ($myMedia[$f]['show'] === 'yes'){

                    //$extension = Utilities::escapeInput($myMedia[$f]['extension']);
                    switch ($myMedia[$f]['extension']) {
                        case 'mp4':
                        case 'webm':
                        case 'ogg':
                            $type = 'video';
                            break;

                        case 'pdf':
                        case 'html':
                        case 'php':
                        case 'iframe':
                            $type = 'iframe';
                            break;

                        default:
                            $type = 'image'; // par défaut Fancybox le détectera aussi
                    }
                ?>

                    <a
                        href= "<?php echo $myMedia[$f]['href']; ?>"
                        data-fancybox= "car-gallery-<?php echo (int)$sectionId; ?>"
                        data-type= "<?php echo $type; ?>"
                        data-caption= "<?php echo $myMedia[$f]['caption']; ?>"
                        style="display:none"
                    >
                    
            <?php   if ($myMedia[$f]['extension'] !== "iframe"){ ?>
                        <img
                            src="<?php echo $myMedia[$f]['href']; ?>"
                            alt="<?php echo $myMedia[$f]['alt']; ?>"
                            data-caption= "<?php echo $myMedia[$f]['caption']; ?>"
                            style="
                                width:      <?php echo $myMedia[0]['width'];     ?>;
                                max-width:  <?php echo $myMedia[0]['maxWidth'];  ?>;
                                height:     <?php echo $myMedia[0]['height'];    ?>;
                                object-fit: <?php echo $myMedia[0]['objectFit']; ?>;
                            "
                        >
            <?php   } else { ?>
                        <iframe
                            src="<?php echo $myMedia[$f]['href']; ?>"
                            width="<?php echo htmlspecialchars($myMedia[$f]['width']); ?>"
                            height="<?php echo htmlspecialchars($myMedia[$f]['height']); ?>"
                            title="<?php echo $myMedia[$f]['alt']; ?>"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            referrerpolicy="strict-origin-when-cross-origin"
                            allowfullscreen
                        ></iframe>
            <?php   } ?>

                    </a>

        <?php   } ?>
    <?php   } ?>

<?php } ?>

<?php
function mycvNetworkSlideNew(){

    $imgPrefix = 'new';
    $folder = 'img/mycv/network/' . $imgPrefix . '/';
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
function mycvNetworkLogo($network, $i){

    $id = Utilities::escapeInput($network[$i]['id']);
?>
    <div class="d-none d-sm-block py-3 ps-3">
        
        <img
            class="rounded-3"
            id="text_logo_<?php echo $id; ?>"
            name="text_logo_<?php echo $id; ?>"
            src="img/mycv/logo/<?php echo Utilities::escapeInput($network[$i]['media']);?>"
            alt="<?php echo Utilities::escapeInput($network[$i]['media']);?> <?php echo $id; ?>"
            style="height:100px;"
        >

    </div>
<?php
}
?>

<?php
function mycvNetworkLogoNew(){
?>
    <div class="d-none d-sm-block py-3 ps-3">
        
        <img
            class="rounded-3"
            id="text_logo_new"
            name="text_logo_new"
            src="img/mycv/logo/new.webp"
            alt="image de l'network new"
            style="height:100px;"
        >

    </div>
<?php
}
?>

<?php
function mycvNetworkSettings($network, $i){
    
    if ($_SESSION['dataConnect']['type']==='Administrator'){ 
        $id = Utilities::escapeInput($network[$i]['id']);
?>
        <div class="container">

            <div class="row">

                <p class="pt-3 fw-bold">LOGO COMPANY</p>

                <?php mycvNetworkButtonImg($network, $i) ?>
            
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
                        <?php if (Utilities::escapeInput($network[$i]['img_yesOrNo']) === 'yes'){ echo 'checked'; } ?>
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
                        value="<?php echo Utilities::escapeInput($network[$i]['img']); ?>"
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
                    <option value="<?php echo Utilities::escapeInput($network[$i]['img_rightOrLeft']); ?>"><?php echo Utilities::escapeInput($network[$i]['img_rightOrLeft']); ?></option>
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
                    <option value="<?php echo Utilities::escapeInput($network[$i]['img_objectFit']); ?>"><?php echo Utilities::escapeInput($network[$i]['img_objectFit']); ?></option>
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
                        value="<?php echo Utilities::escapeInput($network[$i]['img_width']); ?>"
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
                        value="<?php echo Utilities::escapeInput($network[$i]['img_height']); ?>"
                    >
                    
                </div>
                <hr>
                <p class="fw-bold">OTHER SETTINGS</p>

                <!-- Insert Network Id right -->
                <?php mycvNetworkId($network, $i) ?>

                <div class="d-flex flex-row align-items-center pb-3">

                    <label
                        class="form-label fs-4"
                        for="sort_<?php echo $id; ?>"
                        style="width: 130px;"
                    >Network sort :</label>
                    <input
                        class="form-control fs-4 ps-2 m-0 p-0 border border-black"
                        type="text"
                        id="sort_<?php echo $id; ?>"
                        name="sort_<?php echo $id; ?>"
                        style="width: 100px;"
                        value="<?php echo Utilities::escapeInput($network[$i]['sort']); ?>"
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
                            value="Save network <?php echo $id; ?>"
                            style="width: 150px;"
                        >
                    </div>

                    <div class="d-flex justify-content-center p-0 pb-2">
                        <input
                            class="btn btn-lg btn-danger"
                            type="submit"
                            name="btn_delete_<?php echo $id; ?>"
                            id="btn_delete_<?php echo $id; ?>"
                            value="Delete network <?php echo $id; ?>"
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
function mycvNetworkSettingsNew(){
?>
    <div class="container">

        <div class="row">

            <p class="pt-3 fw-bold">LOGO COMPANY</p>

            <?php mycvNetworkButtonImgNew() ?>

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

            <!-- Insert Network Id right -->
            <?php //mycvNetworkId($network, $i) ?>

            <div class="d-flex flex-row align-items-center pb-3">

                <label
                    class="form-label fs-4"
                    for="sort_new"
                    style="width: 130px;"
                >Network sort :</label>
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
                        value="Save network new"
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