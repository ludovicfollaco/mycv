<?php
    require_once('../controller/common/page.controller.php');

    use Model\Car\Car;
    use Model\Utilities\Utilities;

    $MyCar = new Car();

    // Initialiser les variables pour paramètrer la clause where afin d'executer la requete SELECT pour rechercher le ou les contacts
    $brand_umpty = true;
    $model_umpty = true;
    $mileage_umpty = true;
    $price_umpty = true;

    $criteriaBrand = "";
    $criteriaModel = "";
    $criteriaMileage = "";
    $criteriaPrice = "";

    $criteria =  $_SESSION['car']['criteriaBrand'] != "Selectionnez une marque" || $_SESSION['car']['criteriaModel'] != "Selectionnez un modele" || $_SESSION['car']['criteriaMileage'] != "Selectionnez un kilometrage maxi" || $_SESSION['car']['criteriaPrice'] != "Selectionnez un prix maxi";
    
    if (isset($_POST['btn-SearchCar'])){

        $_SESSION['car']['criteriaBrand'] = "Selectionnez une marque";
        $_SESSION['car']['criteriaModel'] = "Selectionnez un modele";
        $_SESSION['car']['criteriaMileage'] = "Selectionnez un kilometrage maxi";
        $_SESSION['car']['criteriaPrice'] = "Selectionnez un prix maxi";

        if(isset($_POST['select_car_brand']) && $_POST['select_car_brand'] != "Selectionnez une marque"){

            $MyCar->setCriteriaBrand(Utilities::filterInput('select_car_brand'));
            $_SESSION['car']['criteriaBrand'] = $MyCar->getCriteriaBrand();
            
            $criteriaBrand = "`brand`.`name` LIKE '%" . $MyCar->getCriteriaBrand() . "%' ";

            unset($_POST['select_car_brand']);
            $brand_umpty = false;
        }

        if(isset($_POST['select_car_model']) && $_POST['select_car_model'] != "Selectionnez un modele"){

            $MyCar->setCriteriaModel(Utilities::filterInput('select_car_model'));
            $_SESSION['car']['criteriaModel'] = $MyCar->getCriteriaModel();

            $criteriaModel = "`model`.`name` LIKE '%" . $MyCar->getCriteriaModel() . "%' ";
            
            unset($_POST['select_car_model']);
            $model_umpty = false;
        }

        if(isset($_POST['select_car_mileage']) && $_POST['select_car_mileage'] != "Selectionnez un kilometrage maxi"){

            $MyCar->setCriteriaMileage(intval(Utilities::filterInput('select_car_mileage')));
            $_SESSION['car']['criteriaMileage'] = $MyCar->getCriteriaMileage();

            $criteriaMileage = "`car`.`mileage` <= '" . $MyCar->getCriteriaMileage() . "' ";

            unset($_POST['select_car_mileage']);
            $mileage_umpty = false;
        }

        if(isset($_POST['select_car_price']) && $_POST['select_car_price'] != "Selectionnez un prix maxi"){

            $MyCar->setCriteriaPrice(intval(Utilities::filterInput('select_car_price')));
            $_SESSION['car']['criteriaPrice'] = $MyCar->getCriteriaPrice();

            $criteriaPrice = "`car`.`price` <= '" . $MyCar->getCriteriaPrice() . "' ";

            unset($_POST['select_car_price']);
            $price_umpty = false;
        }

    }elseif($criteria){
            
            if($_SESSION['car']['criteriaBrand'] != "Selectionnez une marque"){
    
                $MyCar->setCriteriaBrand($_SESSION['car']['criteriaBrand']);
                $brand_umpty = false;
    
                $criteriaBrand = "`brand`.`name` LIKE '%" . $_SESSION['car']['criteriaBrand'] . "%'";
                
            }
    
            if($_SESSION['car']['criteriaModel'] != "Selectionnez un modele"){
    
                $MyCar->setCriteriaModel($_SESSION['car']['criteriaModel']);
                $model_umpty = false;
    
                $criteriaModel = "`model`.`name` LIKE '%" . $_SESSION['car']['criteriaModel'] . "%'";
            }
    
            if($_SESSION['car']['criteriaMileage'] != "Selectionnez un kilometrage maxi"){
    
                $MyCar->setCriteriaMileage(intval($_SESSION['car']['criteriaMileage']));
                $mileage_umpty = false;
    
                $criteriaMileage = "`car`.`mileage` <= '" . intval($_SESSION['car']['criteriaMileage']) . "'";
            }
    
            if($_SESSION['car']['criteriaPrice'] != "Selectionnez un prix maxi"){
    
                $MyCar->setCriteriaPrice(intval($_SESSION['car']['criteriaPrice']));
                $price_umpty = false;
    
                $criteriaPrice = "`car`.`price` <= '" . intval($_SESSION['car']['criteriaPrice']) . "'";
            }
    }

    $whereClause = clauseWhere($brand_umpty, $model_umpty, $mileage_umpty, $price_umpty, $criteriaBrand, $criteriaModel, $criteriaMileage, $criteriaPrice);
    
    $cars = $MyCar->getCarList($whereClause, 'price', 'ASC', $MyPage->getFirstProduct(), $MyPage->getProductPerPage());

    $_SESSION['pagination']['nbOfProduct'] = $MyPage->checkNumberOfProduct('car', $whereClause);
    $_SESSION['pagination']['nbOfPage'] = ceil($_SESSION['pagination']['nbOfProduct'] / $MyPage->getProductPerPage());
    //$MyPage->setNbOfPage($_SESSION['pagination']['nbOfPage']);

    unset($MyCar);

    //------------------------------------------------------------------------------------------------

    function clauseWhere(bool $brand_umpty, bool $model_umpty, bool $mileage_umpty, bool $price_umpty, string $criteriaBrand, string $criteriaModel, string $criteriaMileage, string $criteriaPrice):string{
        
        if(!$brand_umpty && !$model_umpty && !$mileage_umpty && !$price_umpty){//0000 - 0
        
            $whereClause = $criteriaBrand . ' AND ' . $criteriaModel . ' AND ' . $criteriaMileage . ' AND ' . $criteriaPrice;

        }elseif(!$brand_umpty && !$model_umpty && !$mileage_umpty && $price_umpty){//0001 - 1

            $whereClause = $criteriaBrand . ' AND ' . $criteriaModel . ' AND ' . $criteriaMileage;
                            
        }elseif(!$brand_umpty && !$model_umpty && $mileage_umpty && !$price_umpty){//0010 - 2

            $whereClause = $criteriaBrand . ' AND ' . $criteriaModel . ' AND ' . $criteriaPrice;
            
        }elseif(!$brand_umpty && !$model_umpty && $mileage_umpty && $price_umpty){//0011 - 3

            $whereClause = $criteriaBrand . ' AND ' . $criteriaModel;
            
        }elseif(!$brand_umpty && $model_umpty && !$mileage_umpty && !$price_umpty){//0100 - 4

            $whereClause = $criteriaBrand . ' AND ' . $criteriaMileage . ' AND ' . $criteriaPrice;
            
        }elseif(!$brand_umpty && $model_umpty && !$mileage_umpty && $price_umpty){//0101 - 5

            $whereClause = $criteriaBrand . ' AND ' . $criteriaMileage;

        }elseif(!$brand_umpty && $model_umpty && $mileage_umpty && !$price_umpty){//0110 - 6

            $whereClause = $criteriaBrand . ' AND ' . $criteriaPrice;
            
        }elseif(!$brand_umpty && $model_umpty && $mileage_umpty && $price_umpty){//0111 - 7

            $whereClause = $criteriaBrand;
            
        }elseif($brand_umpty && !$model_umpty && !$mileage_umpty && !$price_umpty){//1000 - 8

            $whereClause = $criteriaModel . ' AND ' . $criteriaMileage . ' AND ' . $criteriaPrice;
            
        }elseif($brand_umpty && !$model_umpty && !$mileage_umpty && $price_umpty){//1001 - 9

            $whereClause = $criteriaModel . ' AND ' . $criteriaMileage;

        }elseif($brand_umpty && !$model_umpty && $mileage_umpty && !$price_umpty){//1010 - 10

            $whereClause = $criteriaModel . ' AND ' . $criteriaPrice;

        }elseif($brand_umpty && !$model_umpty && $mileage_umpty && $price_umpty){//1011 - 11

            $whereClause = $criteriaModel;

        }elseif($brand_umpty && $model_umpty && !$mileage_umpty && !$price_umpty){//1100 - 12
                
            $whereClause = $criteriaMileage . ' AND ' . $criteriaPrice;

        }elseif($brand_umpty && $model_umpty && !$mileage_umpty && $price_umpty){//1101 - 13

            $whereClause = $criteriaMileage;

        }elseif($brand_umpty && $model_umpty && $mileage_umpty && !$price_umpty){//1110 - 14
                
            $whereClause = $criteriaPrice;

        }elseif($brand_umpty && $model_umpty && $mileage_umpty && $price_umpty){//1111 - 15

            $whereClause = '1';

        }

        return $whereClause;
    }

?>