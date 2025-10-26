<?php
    use Model\Utilities\Utilities;

    $_SESSION['other']['local'] = true; //set to false if online server and to true if local server
    $_SESSION['debug']['monolog'] = false;
    
    resetOtherVarSession();

    if (!isset($_SESSION['dataConnect']['type'])){

        resetDataConnectVarSession();
        resetUserVarSession();        
        resetCarVarSession();
        resetPageVarSession();
        resetUploadImgVarSession();
        resetTokenJwtVarSession();
        $_SESSION['token']['csrf'] = bin2hex(random_bytes(32));
        $_SESSION['other']['messagePw']="";
    }

/********************** Functions reset variables ********************* */

    function resetTokenJwtVarSession(): void{

        $_SESSION['token']['jwt']['secretKey'] = bin2hex(random_bytes(32));
        $_SESSION['token']['jwt']['delay'] = 900;
        $_SESSION['token']['jwt']['tokenJwt'] = Utilities::tokenJwt($_SESSION['dataConnect']['pseudo'], $_SESSION['token']['jwt']['secretKey'], $_SESSION['token']['jwt']['delay']);
    }

    function resetUploadImgVarSession(): void{
        $_SESSION['image']['uploadImage'] = '_.png';
    }

    function resetDataConnectVarSession(): void{

        $_SESSION['dataConnect']['id_user'] = 0;
        $_SESSION['dataConnect']['pseudo'] = 'Guest';
        $_SESSION['dataConnect']['avatar'] = 'black_person.svg';
        $_SESSION['dataConnect']['type'] = 'Guest';
        $_SESSION['dataConnect']['subscription'] = 'Vénusia';
        $_SESSION['dataConnect']['password'] = '';
        $_SESSION['dataConnect']['error'] = false;
        $_SESSION['dataConnect']['connexion'] = false;
    }

    function resetUserVarSession(): void{

        $_SESSION['user']['criteriaName'] = '';
        $_SESSION['user']['criteriaPseudo'] = '';
        $_SESSION['user']['criteriaType'] = 'Selectionnez un type';

        $_SESSION['user']['subscription'] = 'Vénusia';

        $_SESSION['user']['newUser'] = false;
        //$_SESSION['user']['addUser'] = false;
        $_SESSION['user']['newMember'] = false;

        $_SESSION['user']['updateMonCompte'] = false;
        $_SESSION['user']['btn_monCompte'] = false;

        $_SESSION['user']['uploadAvatar'] = 'avatar_membre_white.webp';

    }

    function resetCarVarSession(): void{

        $_SESSION['car']['newCar'] = false;

        $_SESSION['car']['addCar'] = false;
        $_SESSION['car']['addBrand'] = false;
        $_SESSION['car']['addModel']=false;
        $_SESSION['car']['addEngine']=false;

        $_SESSION['car']['criteriaBrand'] = 'Selectionnez une marque';
        $_SESSION['car']['criteriaModel'] = 'Selectionnez un modele';
        $_SESSION['car']['criteriaMileage'] = 'Selectionnez un kilometrage maxi';
        $_SESSION['car']['criteriaPrice'] = 'Selectionnez un prix maxi';

        $_SESSION['car']['uploadImage1'] = '_.webp';
        $_SESSION['car']['uploadImage2'] = '_.webp';
        $_SESSION['car']['uploadImage3'] = '_.webp';
        $_SESSION['car']['uploadImage4'] = '_.webp';
        $_SESSION['car']['uploadImage5'] = '_.webp';

    }

    function resetPageVarSession(): void{

        $_SESSION['pagination']['thePage'] = 1;
        $_SESSION['pagination']['nbOfPage'] = 1;
        $_SESSION['pagination']['firstProduct'] = 0;
        $_SESSION['pagination']['productPerPage'] = 3;
        $_SESSION['pagination']['nbOfProduct'] = 1;
        $_SESSION['pagination']['NextOrPrevious'] = false;

    }

    function resetOtherVarSession(): void{

        $_SESSION['other']['uploadImage'] = '_.png';
        $_SESSION['other']['whereClause'] =  '1';
        $_SESSION['other']['errorForm'] = false;
        $_SESSION['other']['error'] = false;
        $_SESSION['other']['timeZone']="Europe/Paris";
        $_SESSION['other']['message']="";
    }
?>