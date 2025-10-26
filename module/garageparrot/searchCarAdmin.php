<?php
    use Model\CarBrand\CarBrand;
    use Model\CarModel\CarModel;
?>

<form action="" method="post">

    <!-- input hidden csrf -->
    <input type="hidden" name="csrf" value="<?php echo $_SESSION['token']['csrf'];?>">

    <div class="d-sm-flex justify-content-sm-between p-3 mx-2 mb-2 mt-2 mx-md-5 bgDark border border-secondary border-3 rounded-4">

        <div class="container d-flex flex-column">
            
        <label for="select_car_brand" class="form-label text-light">Marque :</label>
            <select class="form-select fw-bolder rounded-3" id="select_car_brand" name="select_car_brand" style="font-size: 1.6rem;">
            <?php
                if(isset($_POST['select_car_brand'])){
                    $_SESSION['car']['criteriaBrand'] = $_POST['select_car_brand'];
                }
            ?>
                <option value='<?php echo $_SESSION['car']['criteriaBrand']; ?>'><?php echo $_SESSION['car']['criteriaBrand']; ?></option>";
                <option value='Selectionnez une marque'>Selectionnez une marque</option>
            <?php
                $Brands = new CarBrand();
                $MyBrand = $Brands->getBrandList(1,'name', 'ASC', 0, 50);
                unset($Brands);
                for($i=0;$i != count($MyBrand)-1;$i++) { ?>
                    <option value="<?php echo $MyBrand[$i]['name']; ?>"><?php echo $MyBrand[$i]['name']; ?></option>
            <?php } ?>
            </select>

        </div>

        <div class="container d-flex flex-column">

        <label for="select_car_model" class="form-label text-light">Modèle :</label>
            <select class="form-select fw-bolder rounded-3" id="select_car_model" name="select_car_model" style="font-size: 1.6rem;">
            <?php
                if(isset($_POST['select_car_model'])){
                    $_SESSION['car']['criteriaModel'] = $_POST['select_car_model'];
                }
            ?>
                <option value='<?php echo $_SESSION['car']['criteriaModel']; ?>'><?php echo $_SESSION['car']['criteriaModel']; ?></option>";
                <option value='Selectionnez un modele'>Selectionnez un modele</option>";
            <?php
                $Models = new CarModel();
                if($_SESSION['car']['criteriaBrand'] != 'Selectionnez une marque'){
                    $MyModel = $Models->getModelList('`model`.`id_brand` = (SELECT `brand`.`id_brand` FROM `brand` WHERE `brand`.`name` = \'' . $_SESSION['car']['criteriaBrand'] . '\')','name', 'ASC', 0, 50);
                }else{
                    $MyModel = $Models->getModelList(1,'name', 'ASC', 0, 50);
                }
                unset($Models);
                for($i=0;$i != count($MyModel);$i++) { ?>
                    <option value="<?php echo $MyModel[$i]['name']; ?>"><?php echo $MyModel[$i]['name']; ?></option>
            <?php } ?>
            </select>

        </div>

        <div class="container d-flex flex-column">

        <label for="select_car_mileage" class="form-label text-light">Kms MAX :</label>
            <select class="form-select fw-bolder rounded-3" id="select_car_mileage" name="select_car_mileage" style="font-size: 1.6rem;">
            <?php if($_SESSION['car']['criteriaMileage'] != 'Selectionnez un kilometrage maxi'){?>
                    <option value='<?php echo $_SESSION['car']['criteriaMileage']; ?>'><?php echo $_SESSION['car']['criteriaMileage']; ?></option>";
            <?php } ?>
                <option value='Selectionnez un kilometrage maxi'>Selectionnez un kilometrage maxi</option>
                <option value="10000">10000 km</option>
                <option value="20000">20000 km</option>
                <option value="30000">30000 km</option>
                <option value="40000">40000 km</option>
                <option value="50000">50000 km</option>
                <option value="60000">60000 km</option>
                <option value="70000">70000 km</option>
                <option value="80000">80000 km</option>
                <option value="90000">90000 km</option>
                <option value="100000">100000 km</option>
                <option value="150000">150000 km</option>
                <option value="200000">200000 km</option>
            </select>

        </div>

        <div class="container d-flex flex-column">

            <label for="select_car_price" class="form-label text-light">Prix MAX :</label>
            <select class="form-select fw-bolder rounded-3" id="select_car_price" name="select_car_price" style="font-size: 1.6rem;">
            <?php if($_SESSION['car']['criteriaPrice'] != 'Selectionnez un prix maxi'){?>
                    <option value='<?php echo $_SESSION['car']['criteriaPrice']; ?>'><?php echo $_SESSION['car']['criteriaPrice']; ?></option>";
            <?php } ?>
                
                <option value='Selectionnez un prix maxi'>Selectionnez un prix maxi</option>
                <option value="2500">2500 €</option>
                <option value="5000">5000 €</option>
                <option value="6000">6000 €</option>
                <option value="7000">7000 €</option>
                <option value="8000">8000 €</option>
                <option value="9000">9000 €</option>
                <option value="10000">10000 €</option>
                <option value="12500">12500 €</option>
                <option value="15000">15000 €</option>
                <option value="15500">17500 €</option>
                <option value="20000">20000 €</option>
                <option value="25000">25000 €</option>
                <option value="30000">30000 €</option>
                <option value="35000">35000 €</option>
                <option value="40000">40000 €</option>
                <option value="45000">45000 €</option>
                <option value="50000">50000 € et +</option>
            </select>

        </div>
        
        <div class="container d-flex flex-column  w-50 w-sm-25">
            <label for="btn-SearchCar" class="form-label text-light text-dark">Rechercher</label>
            <button class="btn btn-lg btn-primary px-3 py-2" type="submit" id="btn-SearchCar" name="btn-SearchCar">Rechercher</button>
        </div>

    </div>
</form>