<?php
    use Model\CarBrand\CarBrand;
    use Model\CarModel\CarModel;
    use Model\CarEngine\CarEngine;
    use Model\CarForm\CarForm;
    use Model\Utilities\Utilities;
    
    $MyCarForm = new CarForm();
   
    $cars = array("id_car" => 0);
    $MyBrand = array();
    $MyModel = array();
    $MyEngine = array();
    
    $btnUpdate = false; settype($btnUpdate, 'boolean');
    $btnImage = false; settype($btnImage, 'boolean');
    $changeImage = false; settype($changeImage, 'boolean');

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        $MyCarForm->setBtnCarEdit(isset($_POST['btn_carEdit']) ? true : false); //Button in the table to edit a car (car.php)
            
        $MyCarForm->setBtnNavBarInsert(isset($_POST['btn_navBar_new']) ? true : false); //Button in the navigation bar to insert a new car
        
        $MyCarForm->setBtnInsert(isset($_POST['btn_carEdit_new']) ? true : false); //Button in the form to car (carEdit.php)
        $MyCarForm->setBtnDelete(isset($_POST['btn_carEdit_delete']) ? true : false); //Button in the form to car (carEdit.php)
        $MyCarForm->setBtnCancel(isset($_POST['btn_carEdit_cancel']) ? true : false); //Button in the form to car (carEdit.php)

        $MyCarForm->setBtnUpdate(isset($_POST['btn_carEdit_save']) ? true : false); //Button in the form to car (carEdit.php)
        $MyCarForm->setBtnUpdate1(isset($_POST['btn_carEdit_save_1']) ? true : false); //Button in the form to car (carEdit.php)
        $btnUpdate = $MyCarForm->getBtnUpdate1() ? true : $MyCarForm->getBtnUpdate();
        
        $MyCarForm->setBtnImage1(isset($_POST['btn_image1']) ? true : false); //Button in the form to suscribe a new car (adherer.php)
        $MyCarForm->setBtnImage2(isset($_POST['btn_image2']) ? true : false); //Button in the form to suscribe a new car (adherer.php)
        $MyCarForm->setBtnImage3(isset($_POST['btn_image3']) ? true : false); //Button in the form to suscribe a new car (adherer.php)
        $MyCarForm->setBtnImage4(isset($_POST['btn_image4']) ? true : false); //Button in the form to suscribe a new car (adherer.php)
        $MyCarForm->setBtnImage5(isset($_POST['btn_image5']) ? true : false); //Button in the form to suscribe a new car (adherer.php)

        $MyCarForm->setNewError(isset($_GET['newError']) ? Utilities::filterInput('newError', INPUT_GET) : false);

        $MyCarForm->setId(isset($_POST["txt_car_id"]) ? Utilities::filterInput("txt_car_id") : 0);
        $MyCarForm->setBrand(isset($_POST["list_carEdit_brand"]) ? Utilities::filterInput("list_carEdit_brand") : '');
        $MyCarForm->setModel(isset($_POST["list_carEdit_model"]) ? Utilities::filterInput("list_carEdit_model") : '');
        $MyCarForm->setEngine(isset($_POST["list_carEdit_engine"]) ? Utilities::filterInput("list_carEdit_engine") : '');
        $MyCarForm->setYear(isset($_POST["txt_carEdit_year"]) ? Utilities::filterInput("txt_carEdit_year") : 2000);
        
        $mileage = isset($_POST['txt_carEdit_mileage']) ? Utilities::filterInput('txt_carEdit_mileage') : '0 kms';
        $mileage = str_replace(" kms", "", $mileage);
        $MyCarForm->setMileage(intval($mileage));

        $price = isset($_POST["txt_carEdit_price"]) ? Utilities::filterInput("txt_carEdit_price") : '0 € TTC';
        $price = str_replace(" € TTC", "", $price);
        $MyCarForm->setPrice(intval($price));

        $MyCarForm->setSold(isset($_POST["list_carEdit_sold"]) ? Utilities::filterInput("list_carEdit_sold") : 'Oui');
        $MyCarForm->setDescription(isset($_POST["txt_carEdit_description"]) ? Utilities::filterInput("txt_carEdit_description") : '');
        
        $MyCarForm->setImage1(isset($_POST["txt_carEdit_image1"]) ? Utilities::filterInput("txt_carEdit_image1") : '_.webp');
        $MyCarForm->setImage2(isset($_POST["txt_carEdit_image2"]) ? Utilities::filterInput("txt_carEdit_image2") : '_.webp');
        $MyCarForm->setImage3(isset($_POST["txt_carEdit_image3"]) ? Utilities::filterInput("txt_carEdit_image3") : '_.webp');
        $MyCarForm->setImage4(isset($_POST["txt_carEdit_image4"]) ? Utilities::filterInput("txt_carEdit_image4") : '_.webp');
        $MyCarForm->setImage5(isset($_POST["txt_carEdit_image5"]) ? Utilities::filterInput("txt_carEdit_image5") : '_.webp');

        $btnImage = $MyCarForm->getBtnImage1() || $MyCarForm->getBtnImage2() || $MyCarForm->getBtnImage3() || $MyCarForm->getBtnImage4() || $MyCarForm->getBtnImage5();
    }else{
        Utilities::redirectToPage('accessMethod');
    }

    //***********************************************************************************************
    // CRUD
    //***********************************************************************************************
    
    if($MyCarForm->getBtnCarEdit()){

        $cars = $MyCarForm->getCurrentCar($MyCarForm->getId());
        $cars['message'] = $_SESSION['other']['message'];

        $MyBrand = myBrand();
        $MyModel = myModel();
        $MyEngine = myEngine();

        return;

    }elseif($MyCarForm->getBtnCancel()){

        Utilities::redirectToPage('car');

    }
    
    if(Utilities::ckeckCsrf()){

        if($btnUpdate){

            if($MyCarForm->getId() === 0){
                    
                $MyCarForm->setId($MyCarForm->insertCar());
                $cars = initTabcar($cars, $MyCarForm, $MyCarForm);

                return;

            }else{

                $updateCar = $MyCarForm->updateCar($MyCarForm->getId());
                $cars = initTabcar($cars, $MyCarForm, $MyCarForm);

                $cars['message'] = $_SESSION['other']['message'];
                
                $MyBrand = myBrand();
                $MyModel = myModel();
                $MyEngine = myEngine();

                return;
            }

        }elseif($MyCarForm->getBtnInsert() || $MyCarForm->getBtnNavBarInsert()){
            
            resetCarVar($MyCarForm);
            $cars = initTabCar($cars, $MyCarForm);

            $MyBrand = myBrand();
            $MyModel = myModel();
            $MyEngine = myEngine();

            return;

        }elseif($MyCarForm->getBtnDelete()){
                
            $deleteCar = $MyCarForm->deleteCar($MyCarForm->getId());
            Utilities::redirectToPage('car');

        }elseif($MyCarForm->getBtnCancel()){
        
            Utilities::redirectToPage('car');
    
        }elseif($btnImage){
            
            $uploadDirectory = './img/garageparrot/vehicle/';

            $_SESSION['car']['uploadImage1'] = $MyCarForm->getImage1();
            $_SESSION['car']['uploadImage2'] = $MyCarForm->getImage2();
            $_SESSION['car']['uploadImage3'] = $MyCarForm->getImage3();
            $_SESSION['car']['uploadImage4'] = $MyCarForm->getImage4();
            $_SESSION['car']['uploadImage5'] = $MyCarForm->getImage5();

            if (isset($_FILES["fileInput1"]) && $_FILES["fileInput1"]["error"] == UPLOAD_ERR_OK){

                $_SESSION['car']['uploadImage1'] = $_FILES["fileInput1"]["name"];
                $sourceFile = $_FILES["fileInput1"]["tmp_name"];
                $destinationFile = $uploadDirectory . basename($_FILES["fileInput1"]["name"]);
                unset($_FILES["fileInput1"]);
                
                $MyCarForm->setImage1($_SESSION['car']['uploadImage1']);

            }elseif (isset($_FILES["fileInput2"]) && $_FILES["fileInput2"]["error"] == UPLOAD_ERR_OK){

                $sourceFile = $_FILES["fileInput2"]["tmp_name"];
                $_SESSION['car']['uploadImage2'] = $_FILES["fileInput2"]["name"];
                $destinationFile = $uploadDirectory . basename($_FILES["fileInput2"]["name"]);
                unset($_FILES["fileInput2"]);
                
                $MyCarForm->setImage2($_SESSION['car']['uploadImage2']);

            }elseif (isset($_FILES["fileInput3"]) && $_FILES["fileInput3"]["error"] == UPLOAD_ERR_OK){

                $sourceFile = $_FILES["fileInput3"]["tmp_name"];
                $_SESSION['car']['uploadImage3'] = $_FILES["fileInput3"]["name"];
                $destinationFile = $uploadDirectory . basename($_FILES["fileInput3"]["name"]);
                unset($_FILES["fileInput3"]);
                
                $MyCarForm->setImage3($_SESSION['car']['uploadImage3']);

            }elseif (isset($_FILES["fileInput4"]) && $_FILES["fileInput4"]["error"] == UPLOAD_ERR_OK){

                $sourceFile = $_FILES["fileInput4"]["tmp_name"];
                $_SESSION['car']['uploadImage4'] = $_FILES["fileInput4"]["name"];
                $destinationFile = $uploadDirectory . basename($_FILES["fileInput4"]["name"]);
                unset($_FILES["fileInput4"]);
                
                $MyCarForm->setImage4($_SESSION['car']['uploadImage4']);

            }elseif (isset($_FILES["fileInput5"]) && $_FILES["fileInput5"]["error"] == UPLOAD_ERR_OK){

                $sourceFile = $_FILES["fileInput5"]["tmp_name"];
                $_SESSION['car']['uploadImage5'] = $_FILES["fileInput5"]["name"];
                $destinationFile = $uploadDirectory . basename($_FILES["fileInput5"]["name"]);
                unset($_FILES["fileInput5"]);
                
                $MyCarForm->setImage5($_SESSION['car']['uploadImage5']);

            }else{

                echo "<script>alert('Aucune image n'a été sélectionnée ou une erreur s'est produite.');</script>";
                
            }

            if(move_uploaded_file($sourceFile, $destinationFile)){

                echo "<script>alert('L\'image a été uploadée avec succès.');</script>";

            }else{

                echo "<script>alert('Désolé, une erreur s'est produite lors de l'upload de l'image.');</script>";
            
            }

            $cars = initTabCar($cars, $MyCarForm);
            $changeImage = true;
        }

    }else{
        $_SESSION['other']['errorForm'] = true;
        $_SESSION['other']['errorFormMessage'] = "Erreur de vérification CSRF";
        $cars['message'] = "Erreur de vérification CSRF";
    }
    
    //Fonction traitement de la BD pour récupérer les données destinées à l'input liste brand
    function myBrand():array{
        
        $Brand = new CarBrand();
        $myBrand = array();

        $myBrand = $Brand->getBrandList(1,'name', 'ASC', 0, 50);
        unset($Brand);

        return $myBrand;
    }
    //Fonction traitement de la BD pour récupérer les données destinées à l'input liste model
    function myModel():array{
        
        $Model = new CarModel();
        $myModel = array();

        $myModel = $Model->getModelList(1,'name', 'ASC', 0, 50);
        unset($Model);

        return $myModel;
    }
    //Fonction traitement de la BD pour récupérer les données destinées à l'input liste engine
    function myEngine():array{
        
        $Engine = new CarEngine();
        $myEngine = array();

        $myEngine = $Engine->getEngineList(1,'name', 'ASC', 0, 50);
        unset($Engine);

        return $myEngine;
    }
    
    //Fonction d'initialisation du tableau des données de l'utilisateur
    function initTabCar(array $cars, object $MyCarForm):array{        
        
        $cars['id_car'] = $MyCarForm->getId();
        $cars['brand'] = $MyCarForm->getBrand();
        $cars['model'] = $MyCarForm->getModel();
        $cars['engine'] = $MyCarForm->getEngine();
        $cars['year'] = $MyCarForm->getYear();
        $cars['mileage'] = $MyCarForm->getMileage();
        $cars['price'] = $MyCarForm->getPrice();
        $cars['sold'] = $MyCarForm->getSold();
        $cars['description'] = $MyCarForm->getDescription();
        $cars['image1'] = $MyCarForm->getImage1();
        $cars['image2'] = $MyCarForm->getImage2();
        $cars['image3'] = $MyCarForm->getImage3();
        $cars['image4'] = $MyCarForm->getImage4();
        $cars['image5'] = $MyCarForm->getImage5();

        return $cars;
    }

    //Fonction de réinitialisation des variables de l'utilisateur
    function resetCarVar(object $MyCarForm):void{
        
        $MyCarForm->setId(0);
        $MyCarForm->setBrand('_');
        $MyCarForm->setModel('_');
        $MyCarForm->setEngine('_');
        $MyCarForm->setYear(2000);
        $MyCarForm->setMileage(0);
        $MyCarForm->setPrice(0);
        $MyCarForm->setSold('Oui');
        $MyCarForm->setDescription('_');
        $MyCarForm->setImage1('_.webp');
        $MyCarForm->setImage2('_.webp');
        $MyCarForm->setImage3('_.webp');
        $MyCarForm->setImage4('_.webp');
        $MyCarForm->setImage5('_.webp');
    }

?>