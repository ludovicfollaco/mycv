<?php
    use Model\GoldorakHome\GoldorakHome as HomeGoldorak;
	use Model\Utilities\Utilities;

    $homes = new HomeGoldorak();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){ //(Utilities::verifCsrf('csrf') && $_SERVER['REQUEST_METHOD'] === 'POST'){

        $btn_home_save = isset($_POST['btn_home_save']) ? true : false;
        unset($_POST['btn_home_save']);
    
        $btn_img_chapter1 = isset($_POST['btn_img_chapter1']) ? true : false;
        unset($_POST['btn_img_chapter1']);
    
        $btn_img_chapter2 = isset($_POST['btn_img_chapter2']) ? true : false;
        unset($_POST['btn_img_chapter2']);
        
        if($btn_home_save){
            $btn_home_save = false;
            saveHome($homes,'');
        }

        //***********************************************************************************************
        // traitement du téléchargement des images 
        //***********************************************************************************************

        if($btn_img_chapter1){

            $btn_img_chapter1 = false;

            if (Utilities::uploadImg('user', 'newImgChapter1','txt_img_chapter1','file_img_chapter1','./img/goldorak/picture/')){

                $home[0]['img_chapter1'] = $_SESSION['user']['newImgChapter1'];

            }else{

                echo "<script>alert('Désolé, une erreur s\'est produite lors de l\'upload de l\'image.');</script>";

            }

        }

        if($btn_img_chapter2){

            if (Utilities::uploadImg('user', 'newImgChapter2','txt_img_chapter2','file_img_chapter2','./img/goldorak/picture/')){

                $home[0]['img_chapter2'] = $_SESSION['user']['newImgChapter2'];

            }else{

                echo "<script>alert('Désolé, une erreur s\'est produite lors de l\'upload de l\'image.');</script>";

            }

        }

    }

    /*}elseif($_SESSION['dataConnect']['pseudo'] != 'Guest'){

        $_SESSION['dataConnect']['type'] = 'Guest';
        $_SESSION['dataConnect']['pseudo'] = 'Guest';
        $_SESSION['dataConnect']['avatar'] = 'avatar_membre_white.webp';
        $_SESSION['dataConnect']['subscription'] = 'Vénusia';
        $_SESSION['dataConnect']['connexion'] = false;
        
        timeExpired();

    }*/

    $home = $homes->getHome(1);

    function saveHome($object, $button = ''){

        $titre1 = isset($_POST['txt_titre1']) ? Utilities::filterInput('txt_titre1') : '';
        
        $titre_chapter1 = isset($_POST['txt_titre_chapter1']) ? Utilities::filterInput('txt_titre_chapter1') : '';
        $chapter1 = isset($_POST['txt_chapter1']) ? Utilities::filterInput('txt_chapter1') : '';
        
        if($button === 'btn_img_chapter1'){
            $img_chapter1 = $_SESSION['newImgChapter1'];
        }else{
            $img_chapter1 = isset($_POST['txt_img_chapter1']) ? Utilities::filterInput('txt_img_chapter1') : '';
        }

        $titre_chapter2 = isset($_POST['txt_titre_chapter2']) ? Utilities::filterInput('txt_titre_chapter2') : '';
        $chapter2 = isset($_POST['txt_chapter2']) ? Utilities::filterInput('txt_chapter2') : '';
        
        if($button === 'btn_img_chapter2'){
            $img_chapter2 = $_SESSION['newImgChapter2'];
        }else{
            $img_chapter2 = isset($_POST['txt_img_chapter2']) ? Utilities::filterInput('txt_img_chapter2') : '';
        }

        $object->setTitre1($titre1);

        $object->setTitre_Chapter1($titre_chapter1);
        $object->setChapter1($chapter1);
        $object->setImg_chapter1($img_chapter1);

        $object->setTitre_Chapter2($titre_chapter2);
        $object->setChapter2($chapter2);
        $object->setImg_chapter2($img_chapter2);

        $object->updateHome(1);
        
        if($button === 'btn_img_chapter1' || $button === 'btn_img_chapter1'){
            
            //routeToHomePage();
            Utilities::redirectToPage('home');
        }

    }

?>