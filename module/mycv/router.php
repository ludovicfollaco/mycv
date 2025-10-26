<?php
	//mycv
    //router.php
	//author : Ludovic FOLLACO
	//checked to 2024-10-08_15:10
    use Model\Utilities\Utilities;

    $page = isset($_GET['page']) ? Utilities::escapeInput($_GET['page']) : 'home';
    
    if ($page === 'home'){

        resetOtherVarSession();

        if($_SESSION['dataConnect']['pseudo'] != 'Guest'){
            Utilities::checkTokenJwt();
        }
        
        require_once('view/mycv/home.php');
        return;

    }else if($page === 'mycv'){

        resetOtherVarSession();

        if($_SESSION['dataConnect']['pseudo'] != 'Guest'){
            Utilities::checkTokenJwt();
        }
        
        require_once('view/mycv/myCv.php');
        return;

    }else if($page === 'network'){

        resetOtherVarSession();
        
        require_once('view/mycv/network.php');
        return;

    }else if($page === 'contact'){

        resetOtherVarSession();
        
        require_once('view/common/contact.php');
        return;

    }else if($page === 'connexion'){

        resetOtherVarSession();
        resetDataConnectVarSession();

        require_once('view/common/connexion.php');
        return;

    }else if($page === 'disconnect'){

        if($_SESSION['dataConnect']['type'] != "Guest"){

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

        resetOtherVarSession();
        resetDataConnectVarSession();

        require_once('view/errorPage/timeExpired.php');
        return;

    }else if ($page === 'errorJwtKey'){

        resetOtherVarSession();
        resetDataConnectVarSession();

        require_once('view/errorPage/errorJwtKey.php');
        return;

    }else if ($page === 'errorJwtPseudo'){

        resetOtherVarSession();
        resetDataConnectVarSession();

        require_once('view/errorPage/errorJwtPseudo.php');
        return;

    }else if ($page === 'userPwRequestNew'){

        resetOtherVarSession();
        resetDataConnectVarSession();
        
        require_once('view/common/userPwRequestNew.php');
        return;

    }else if ($page === 'userPwResetNew'){

        resetOtherVarSession();
        resetDataConnectVarSession();
        
        require_once('view/common/userPwResetNew.php');
        return;

    }else if ($page === 'accessMethod'){

        resetOtherVarSession();
        
        require_once 'view/errorPage/accessMethod.php';
        return;

    }else if ($page === 'accessPage'){

        resetOtherVarSession();

        require_once('view/errorPage/accessPage.php');
        return;

    }else if ($page === 'unknownPage'){

        resetOtherVarSession();

        require_once('view/errorPage/unknownPage.php');
        return;

    }else{

        resetOtherVarSession();

        if($_SESSION['dataConnect']['type'] != 'Guest'){
            Utilities::checkTokenJwt();
        }

        require_once('view/errorPage/unknownPage.php');
        return;
    }

?>