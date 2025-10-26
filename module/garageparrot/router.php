<?php
	//garageparrot
    //router.php
	//author : Ludovic FOLLACO
	//checked to 2024-10-08_15:10
    use Model\Utilities\Utilities;

    $page = isset($_GET['page']) ? Utilities::escapeInput($_GET['page']) : 'home';
    
    if ($page === 'home'){

        resetUserVarSession();
        resetCarVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        if($_SESSION['dataConnect']['pseudo'] != 'Guest'){
            Utilities::checkTokenJwt();
        }
        
        require_once('view/garageparrot/home.php');
        return;

    }else if($page === 'car'){

        resetUserVarSession();
        $_SESSION['other']['message'] = '';

        if($_SESSION['dataConnect']['type'] === 'Administrator' || $_SESSION['dataConnect']['type'] === 'User'){
            
            Utilities::checkTokenJwt();
            require_once('view/garageparrot/car_admin.php');

        }else{
            require_once('view/garageparrot/car.php');
        }
        return;

    }else if ($page === 'carEdit'){

        resetUserVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        if($_SESSION['dataConnect']['type'] === 'Administrator' || $_SESSION['dataConnect']['type'] === 'User'){
            
            Utilities::checkTokenJwt();
            require_once('view/garageparrot/car_edit.php');

        }else{
            require_once('view/errorPage/accessPage.php');
        }
        return;

    }else if ($page === 'user'){

        resetCarVarSession();
        $_SESSION['other']['message'] = '';
        
        if($_SESSION['dataConnect']['type'] === 'Administrator'){

            Utilities::checkTokenJwt();
            require_once('view/common/user.php');
        
        }else{
            require_once('view/errorPage/accessPage.php');
        }
        return;

    }else if ($page === 'userEdit'){

        resetCarVarSession();            
        resetPageVarSession();
        resetOtherVarSession();

        if($_SESSION['dataConnect']['type'] === 'Administrator'){

            Utilities::checkTokenJwt();
            require_once('view/common/userEdit.php');

        }else{
            require_once('view/errorPage/accessPage.php');
        }
        return;

    }else if ($page === 'connexion'){

        resetUserVarSession();
        resetCarVarSession();
        resetPageVarSession();
        resetOtherVarSession();
        resetDataConnectVarSession();

        require_once('view/common/connexion.php');
        return;

    }else if ($page === 'disconnect'){

        if($_SESSION['dataConnect']['type'] != "Guest"){

            resetUserVarSession();
            resetCarVarSession();
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

    }else if ($page === 'accessMethod'){
        
        require_once 'view/errorPage/accessMethod.php';

    }else if ($page === 'accessPage'){
        
        require_once 'view/errorPage/accessPage.php';

    }else if ($page === 'unknownPage'){
        
        require_once 'view/errorPage/unknownPage.php';

    }else if ($page === 'timeExpired'){

        resetUserVarSession();
        resetCarVarSession();
        resetPageVarSession();
        resetOtherVarSession();
        resetDataConnectVarSession();

        require_once('view/errorPage/timeExpired.php');
        return;

    }else if ($page === 'errorJwtKey'){

        resetUserVarSession();
        resetCarVarSession();
        resetPageVarSession();
        resetOtherVarSession();
        resetDataConnectVarSession();

        require_once('view/errorPage/errorJwtKey.php');
        return;

    }else if ($page === 'errorJwtPseudo'){

        resetUserVarSession();
        resetCarVarSession();
        resetPageVarSession();
        resetOtherVarSession();
        resetDataConnectVarSession();

        require_once('view/errorPage/errorJwtPseudo.php');
        return;

    }else if ($page === 'userPwRequestNew'){

        resetUserVarSession();
        resetCarVarSession();
        resetPageVarSession();
        resetOtherVarSession();
        resetDataConnectVarSession();
        
        require_once('view/common/userPwRequestNew.php');
        return;

    }else if ($page === 'userPwResetNew'){

        resetUserVarSession();
        resetCarVarSession();
        resetPageVarSession();
        resetOtherVarSession();
        resetDataConnectVarSession();
        
        require_once('view/common/userPwResetNew.php');
        return;

    }else if ($page === 'accessMethod'){

        resetUserVarSession();
        resetCarVarSession();
        resetPageVarSession();
        resetOtherVarSession();
        
        require_once 'view/errorPage/accessMethod.php';
        return;

    }else if ($page === 'accessPage'){

        resetUserVarSession();
        resetCarVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        require_once('view/errorPage/accessPage.php');
        return;

    }else if ($page === 'unknownPage'){

        resetUserVarSession();
        resetCarVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        require_once('view/errorPage/unknownPage.php');
        return;

    }else if ($page === 'kanban'){

        resetUserVarSession();
        resetCarVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        require_once('view/garageparrot/kanban.php');
        return;

    }else if ($page === 'mokup'){

        resetUserVarSession();
        resetCarVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        require_once('view/garageparrot/mokup.php');
        return;

    }else if ($page === 'api'){

        require_once('../api/garageparrot/car.api.php');
        return;

    }else{

        resetUserVarSession();
        resetCarVarSession();
        resetPageVarSession();
        resetOtherVarSession();

        if($_SESSION['dataConnect']['type'] != 'Guest'){
            Utilities::checkTokenJwt();
        }

        require_once('view/errorPage/unknownPage.php');
        return;
    }
?>