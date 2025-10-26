<?php
    session_start();

    $local = isset($_SESSION['other']['local']) ? boolval($_SESSION['other']['local']) : false;

    if($local){
        $DB_HOST = 'localhost';
        $DB_NAME = 'garage_parrot';
        $DB_USER = 'root';
        $DB_PASS = '';
        $BD_PORT = '3307';
    }
    else{
        $DB_HOST = 'db5015199153.hosting-data.io';
        $DB_NAME = 'dbs12564096';
        $DB_USER = 'dbu1146568';
        $DB_PASS = 'MarLud7772!';
        $BD_PORT = '3306';
    }

    $bdd = null;

    try{

        $bdd = new PDO("mysql:host=$DB_HOST; dbname=$DB_NAME;charset=utf8mb4;port=$BD_PORT", $DB_USER, $DB_PASS);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    }catch(PDOException $e){
        echo "Erreur de connexion à la base de données :" . $e->getMessage() . "<br/>";
        die();
    }

    try{
        $stmt = $bdd->prepare("SELECT `car`.`id_car`, `brand`.`name` AS `brand`, `model`.`name` AS `model`, `engine`.`name` AS `motorisation`, `car`.`year`, `car`.`mileage`, `car`.`price`, `car`.`sold`, `car`.`description`, `car`.`image1`, `car`.`image2`, `car`.`image3`, `car`.`image4`, `car`.`image5`
                            FROM `car`
                            LEFT JOIN `brand` ON `car`.`id_brand` = `brand`.`id_brand` 
                            LEFT JOIN `model` ON `car`.`id_model` = `model`.`id_model` 
                            LEFT JOIN `engine` ON `car`.`id_engine` = `engine`.`id_engine`
                            WHERE 1
                            ORDER BY `price` ASC, `brand` ASC, `model` ASC, `motorisation` ASC, `mileage` ASC");

        $stmt->execute();

        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //header('Content-Type: application/json');

        echo json_encode($cars);

    }catch(PDOException $e){
        echo "Erreur de requête SQL dans car.api.php " . $e->getMessage() . "<br/>";
        die();
    }
?>