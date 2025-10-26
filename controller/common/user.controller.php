<?php
    require_once('../controller/common/page.controller.php');

    use Model\User\User;
    use Model\Utilities\Utilities;
    //use Model\Page\Page;

    $MyUser = new User();
    //$MyPage = new Page();

    $name_umpty = true;
    $pseudo_umpty = true;
    $userType_umpty = true;
    
    $criteriaName = "";
    $criteriaPseudo = "";
    $criteriaType = "";

    $criteria =  $_SESSION['user']['criteriaName'] != "" || $_SESSION['user']['criteriaPseudo'] != "" || ($_SESSION['user']['criteriaType'] != "Selectionnez un type" && $_SESSION['user']['criteriaType'] != "");

    if (isset($_POST['btn-SearchUser'])){

        $_SESSION['user']['criteriaName'] = "";
        $_SESSION['user']['criteriaPseudo'] = "";
        $_SESSION['user']['criteriaType'] = "Selectionnez un type";
        
        if((isset($_POST['Text_User_Nom']) && $_POST['Text_User_Nom'] != "") || $_SESSION['user']['criteriaName'] != ""){

            $text_User_Nom = Utilities::filterInput('Text_User_Nom');
            unset($_POST['Text_User_Nom']);

            $MyUser->setCriteriaName($text_User_Nom);
            $_SESSION['user']['criteriaName'] = $text_User_Nom;
            $name_umpty = false;

            $criteriaName = "`user`.`name` LIKE '%" . $_SESSION['user']['criteriaName'] . "%' ";
        }

        if(isset($_POST['Text_User_Pseudo']) && $_POST['Text_User_Pseudo'] != ""){

            $text_User_Pseudo = Utilities::filterInput('Text_User_Pseudo');
            unset($_POST['Text_User_Pseudo']);

            $MyUser->setCriteriaPseudo($text_User_Pseudo);
            $_SESSION['user']['criteriaPseudo'] = $text_User_Pseudo;
            $pseudo_umpty = false;

            $criteriaPseudo = "`user`.`pseudo` LIKE '%" . $_SESSION['user']['criteriaPseudo'] . "%' ";
        }

        if(isset($_POST['Select_User_Type']) && ($_POST['Select_User_Type'] != "Selectionnez un type" && $_POST['Select_User_Type'] != "")){

            $select_User_Type = Utilities::filterInput('Select_User_Type');
            unset($_POST['Select_User_Type']);

            if($select_User_Type != 'Selectionnez un type'){
                
                $MyUser->setCriteriaType($select_User_Type);
                $_SESSION['user']['criteriaType'] = $select_User_Type;
                $userType_umpty = false;

                $criteriaType = "`user`.`id_type` = (SELECT `user_type`.`id_type` FROM `user_type` WHERE `user_type`.`type`='" . $_SESSION['user']['criteriaType'] . "')";
            }
        }
    }elseif($criteria){
        
        if($_SESSION['user']['criteriaName'] != ""){

            $MyUser->setCriteriaName($_SESSION['user']['criteriaName']);
            $name_umpty = false;

            $criteriaName = "`user`.`name` LIKE '%" . $_SESSION['user']['criteriaName'] . "%'";
        }

        if($_SESSION['user']['criteriaPseudo'] != ""){

            $MyUser->setCriteriaPseudo($_SESSION['user']['criteriaPseudo']);
            $pseudo_umpty = false;

            $criteriaPseudo = "`user`.`pseudo` LIKE '%" . $_SESSION['user']['criteriaPseudo'] . "%'";
        }

        if($_SESSION['user']['criteriaType'] != "Selectionnez un type"){

            $MyUser->setCriteriaType($_SESSION['user']['criteriaType']);
            $userType_umpty = false;

            $criteriaType = "`user`.`id_type` = (SELECT `user_type`.`id_type` FROM `user_type` WHERE `user_type`.`type`='" . $_SESSION['user']['criteriaType'] . "')";
        }
    }
    
    $whereClause = clauseWhere($name_umpty, $pseudo_umpty, $userType_umpty, $criteriaName, $criteriaPseudo, $criteriaType);

    $users = $MyUser->getUserList($whereClause, "'name'", 'ASC', $MyPage->getFirstProduct(), $MyPage->getProductPerPage());

    $_SESSION['pagination']['nbOfProduct'] = $MyPage->checkNumberOfProduct('user', $whereClause);
    $_SESSION['pagination']['nbOfPage'] = ceil($_SESSION['pagination']['nbOfProduct'] / $MyPage->getProductPerPage());

//-------------------------------------------------------------------------------------------------------------------------------------------------------

    function clauseWhere(bool $name_umpty, bool $pseudo_umpty, bool $userType_umpty, string $criteriaName, string $criteriaPseudo, string $criteriaType):string{
        
        if(!$name_umpty && !$pseudo_umpty && !$userType_umpty){ //000 = 0

            $whereClause = $criteriaName . ' AND ' . $criteriaPseudo . ' AND ' . $criteriaType;
                            
        }elseif(!$name_umpty && !$pseudo_umpty && $userType_umpty){ //001 = 1

            $whereClause = $criteriaName . ' AND ' . $criteriaPseudo;
            
        }elseif(!$name_umpty && $pseudo_umpty && !$userType_umpty){ //010 = 2

            $whereClause = $criteriaName . ' AND ' . $criteriaType;
            
        }elseif(!$name_umpty && $pseudo_umpty && $userType_umpty){ //011 = 3

            $whereClause = $criteriaName;

        }elseif($name_umpty && !$pseudo_umpty && !$userType_umpty){ //100 = 4

            $whereClause = $criteriaPseudo . ' AND ' . $criteriaType;
            
        }elseif($name_umpty && !$pseudo_umpty && $userType_umpty){ //101 = 5

            $whereClause = $criteriaPseudo;
            
        }elseif($name_umpty && $pseudo_umpty && !$userType_umpty){ //110 = 6

            $whereClause = $criteriaType;

        }elseif($name_umpty && $pseudo_umpty && $userType_umpty){ //111 = 7
        
            $whereClause = 1;

        }

        return $whereClause;
    }
?>