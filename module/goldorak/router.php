<?php
	//goldorak
    //router.php
	//author : Ludovic FOLLACO
	//checked to 2024-10-08_15:10
    use Model\Utilities\Utilities;

    $page = isset($_GET['page']) ? Utilities::escapeInput($_GET['page']) : 'home';
    
    if ($page === 'home'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        if($_SESSION['dataConnect']['pseudo'] != 'Guest'){
            Utilities::checkTokenJwt();
        }
        
        require_once('view/goldorak/home.php');
        return;

    }else if($page === 'events'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        require_once 'view/goldorak/events.php';

    }else if ($page === 'adherer'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        require_once 'view/goldorak/adherer.php';

    }else if ($page === 'user'){

        $_SESSION['other']['message'] = '';
        
        if($_SESSION['dataConnect']['type'] === 'Administrator'){

            Utilities::checkTokenJwt();
            require_once('view/common/user.php');
        
        }else{
            require_once('view/errorPage/accessPage.php');
        }
        return;

    }else if ($page === 'userEdit'){
          
        resetPageVarSession();
        resetOtherVarSession();

        if($_SESSION['dataConnect']['type'] != 'Guest'){
            Utilities::checkTokenJwt();
        }
        
        require_once('view/common/userEdit.php');
        return;

    }else if($page === 'media'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        if($_SESSION['dataConnect']['type'] != "Guest"){

            Utilities::checkTokenJwt();
            require_once 'view/goldorak/media.php';

        }else{

            require_once('view/errorPage/accessPage.php');

        }

    }else if ($page === 'commander'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        if($_SESSION['dataConnect']['subscription'] === "Goldorak" ){
            
            Utilities::checkTokenJwt();
            require_once 'view/goldorak/commander.php';

        }else{

            require_once('view/errorPage/accessPage.php');

        }

    }else if ($page === 'goldorakgo'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        if($_SESSION['dataConnect']['subscription'] != "Vénusia" ){
            
            Utilities::checkTokenJwt();
            require_once 'view/goldorak/goldorakgo.php';

        }else{

            require_once('view/errorPage/accessPage.php');

        }

    }else if ($page === 'connexion'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();
        resetDataConnectVarSession();

        require_once('view/common/connexion.php');
        return;

    }else if ($page === 'disconnect'){

        if($_SESSION['dataConnect']['type'] != "Guest"){

            resetUserVarSession();
            resetPageVarSession();
            resetOtherVarSession();
            resetDataConnectVarSession();
    
            Utilities::redirectToPage("home");
            return;
        }else{
            require_once 'view/errorPage/accessPage.php';
        }

    }else if ($page === 'userPwRequestNew'){
        
        require_once('view/common/userPwRequestNew.php');

    }else if ($page === 'userPwResetNew'){
        
        require_once('view/common/userPwResetNew.php');

    }else if ($page === 'timeExpired'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();
        resetDataConnectVarSession();

        require_once('view/errorPage/timeExpired.php');
        return;

    }else if ($page === 'errorJwtKey'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();
        resetDataConnectVarSession();

        require_once('view/errorPage/errorJwtKey.php');
        return;

    }else if ($page === 'errorJwtPseudo'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();
        resetDataConnectVarSession();

        require_once('view/errorPage/errorJwtPseudo.php');
        return;

    }else if ($page === 'userPwRequestNew'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();
        resetDataConnectVarSession();
        
        require_once('view/common/userPwRequestNew.php');
        return;

    }else if ($page === 'userPwResetNew'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();
        resetDataConnectVarSession();
        
        require_once('view/common/userPwResetNew.php');
        return;

    }else if ($page === 'accessMethod'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();
        
        require_once 'view/errorPage/accessMethod.php';
        return;

    }else if ($page === 'accessPage'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        require_once('view/errorPage/accessPage.php');
        return;

    }else if ($page === 'unknownPage'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        require_once('view/errorPage/unknownPage.php');
        return;

    }else{

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        if($_SESSION['dataConnect']['type'] != 'Guest'){
            Utilities::checkTokenJwt();
        }

        require_once('view/errorPage/unknownPage.php');
        return;
    }
?>