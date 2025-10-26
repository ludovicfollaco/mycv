<?php
    require_once('../controller/garageparrot/car.controller.php');
    require_once('../module/garageparrot/searchCarAdmin.php');
    require_once('../module/common/select_page.php');

    use Model\Utilities\Utilities;
?>

<section class="m-5 d-flex flex-wrap justify-content-center">

<?php for($i=0; $i < count($cars);$i++) { ?>

<article class="mb-5 p-3 border rounded-4">
    
    <form action="../garageparrot.php?page=carEdit" method="post">

    <!-- input hidden csrf -->
    <input type="hidden" name="csrf" value="<?php echo $_SESSION['token']['csrf'];?>">
        
        <div class="d-flex justify-content-center div__Car--img">

            <a
                href="../img/garageparrot/vehicle/<?php echo Utilities::escapeInput($cars[$i]['image1']); ?>"
                class="popup-gallery"
                data-fancybox="car-gallery-<?php echo $i; ?>"
            >
                <img
                    src="../img/garageparrot/vehicle/<?php echo $cars[$i]['image1']; ?>"
                    alt="Image du véhicule"
                    style="width:350px;"
                >
            </a>

            <a
                href="../img/garageparrot/vehicle/<?php echo Utilities::escapeInput($cars[$i]['image2']); ?>"
                class="popup-gallery"
                data-fancybox="car-gallery-<?php echo $i; ?>"
            ></a>

            <a
                href="../img/garageparrot/vehicle/<?php echo Utilities::escapeInput($cars[$i]['image3']); ?>"
                class="popup-gallery"
                data-fancybox="car-gallery-<?php echo $i; ?>"
            ></a>

            <a
                href="../img/garageparrot/vehicle/<?php echo Utilities::escapeInput($cars[$i]['image4']); ?>"
                class="popup-gallery"
                data-fancybox="car-gallery-<?php echo $i; ?>"
            ></a>

            <a
                href="../img/garageparrot/vehicle/<?php echo Utilities::escapeInput($cars[$i]['image5']); ?>"
                class="popup-gallery"
                data-fancybox="car-gallery-<?php echo $i; ?>"
            ></a>

        </div>

        <div class="div__Car--data">

            <table class='table__Car--data'>

                <tr>

                    <td class="tdLabel text-end border border-0 pe-1">ID:</td>

                    <td class="tdText border border-0">
                        <input
                            type="text"
                            id='txt_car_id'
                            name='txt_car_id'
                            class="bgDark text-light text-start ps-2"
                            readonly
                            value='<?php echo Utilities::escapeInput($cars[$i]['id_car']);?>'
                        >
                    </td>

                </tr>

                <tr>

                    <td class="tdLabel text-end border border-0 pe-1">Marque:</td>

                    <td class="tdText border border-0">
                        <input
                            type="text"
                            name="txt_car_brand"
                            class="bg-secondary text-light text-start ps-2"
                            readonly
                            value='<?php echo Utilities::escapeInput($cars[$i]['brand']);?>'
                        >
                    </td>

                </tr>

                <tr>

                    <td class="tdLabel text-end border border-0 pe-1">Modèle:</td>

                    <td class="tdText border border-0">
                        <input
                            type="text"
                            name="txt_car_model"
                            class="bg-secondary text-light text-start ps-2"
                            readonly
                            value='<?php echo Utilities::escapeInput($cars[$i]['model']);?>'
                        >
                    </td>

                </tr>

                <tr>

                    <td class="tdLabel text-end border border-0 pe-1">Moteur:</td>

                    <td class="tdText border border-0">
                        <input
                            type="text"
                            name="txt_car_engine"
                            class="bg-secondary text-light text-start ps-2"
                            readonly
                            value='<?php echo Utilities::escapeInput($cars[$i]['engine']);?>'
                        >
                    </td>

                </tr>

                <tr>

                    <td class="tdLabel text-end border border-0 pe-1">Année:</td>

                    <td class="tdText border border-0">
                        <input
                            type="text"
                            name="txt_car_year"
                            class="bg-secondary text-light text-start ps-2"
                            readonly
                            value='<?php echo Utilities::escapeInput($cars[$i]['year']);?>'
                        >
                    </td>

                </tr>

                <tr>

                    <td class="tdLabel text-end border border-0 pe-1">Kilomètrage:</td>

                    <td class="tdText border border-0">
                        <input
                            type="text"
                            name="txt_car_mileage"
                            class="bg-secondary text-light text-start ps-2"
                            readonly
                            value='<?php echo Utilities::escapeInput($cars[$i]['mileage']);?> kms'
                        >
                    </td>

                </tr>

                <tr>

                    <td class="tdLabel text-end border border-0 pe-1">Prix:</td>

                    <td class="tdText border border-0">
                        <input
                            type="text"
                            name="txt_car_price"
                            class="bg-secondary text-light text-start ps-2"
                            readonly
                            value='<?php echo Utilities::escapeInput($cars[$i]['price']);?> € TTC'
                        >
                    </td>

                </tr>

                <tr>

                    <td class="tdLabel text-end border border-0 pe-1">Disponible:</td>

                    <td class="tdText border border-0">
                        <input
                            type="text"
                            name="txt_car_available"
                            class="bg-secondary text-light text-start ps-2"
                            readonly
                            value='<?php echo Utilities::escapeInput($cars[$i]['sold']);?>'
                        >
                    </td>

                </tr>

                <tr>

                    <td class="tdLabel text-end border border-0 pe-1">Description:</td>

                    <td class="tdText border border-0">
                        <textarea
                            class="bg-secondary text-light text-start ps-2"
                            id="txt_car_description"
                            name="txt_car_description"
                            rows="3"
                            placeholder="Options et description"
                            readonly><?php echo Utilities::escapeInput($cars[$i]['description']);?></textarea>
                    </td>

                </tr>

            </table>

        </div>

        <?php
        if($_SESSION['dataConnect']['type'] != 'Guest'){

        ?>

            <div class="d-flex justify-content-center my-2">

                <button type="submit" class='btn btn-primary fs-3 mt-3' name='btn_carEdit'>Editer</button>

            </div>

        <?php
        }
        ?>

    </form>

        <?php
        if($_SESSION['dataConnect']['type'] === 'Guest'){

        ?>

            <div class="d-flex justify-content-center my-2">

                <button type="button" class="btn btn-lg btn-primary" id="bt_car_contact" onclick="focusOnInput()">Nous contacter</button>

            </div>

        <?php
        }
        ?>

</article>

<?php } ?>

</section>

<?php require_once('../module/common/select_page.php'); ?>

<script>

    function focusOnInput(){

        document.getElementById('contact_description').value = "Bonjour, je souhaite prendre rendez-vous pour une présentation détaillé et un essai du véhicule xxxxxxxx ";
        document.getElementById('contact_name').focus();
        document.getElementById('bottom').scrollIntoView({ behavior: 'smooth' });
        
    }

</script>