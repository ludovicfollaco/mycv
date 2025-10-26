<?php
    use Model\UserForm\UserForm;
    use Model\Type\Type;
    use Model\Subscription\Subscription;
    use Model\Utilities\Utilities;
    
    $MyUserForm = new UserForm();
    
    $users = array("id_user" => 0);
    $MyTypes = array();
    $MySubscription = array();
    $btnUpdate = false; settype($btnUpdate, 'boolean');
    
    $urlImg = './img/common/avatar/';

//***********************************************************************************************
// Echapper les variables $_POST
//***********************************************************************************************

    resetOtherVarSession();

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        $MyUserForm->setBtnUserEdit(isset($_POST['btn_userEdit']) ? true : false); //Button in the table to edit a user (user.php)
        
        $MyUserForm->setBtnNavBarInsert(isset($_POST['btn_navBar_new']) ? true : false); //Button in the navigation bar to insert a new user

        $MyUserForm->setBtnMonCompte(isset($_POST['btn_monCompte']) ? true : false); //Button in the navigation bar
        $MyUserForm->getBtnMonCompte() ? $_SESSION['user']['updateMonCompte'] = true : $_SESSION['user']['updateMonCompte'] = false;

        $MyUserForm->setBtnInsert(isset($_POST['btn_userEdit_new']) ? true : false); //Button in the form to user (userEdit.php)

        $MyUserForm->setBtnDelete(isset($_POST['btn_userEdit_delete']) ? true : false); //Button in the form to user (userEdit.php)
        $MyUserForm->setBtnCancel(isset($_POST['btn_userEdit_cancel']) ? true : false); //Button in the form to user (userEdit.php)

        $MyUserForm->setBtnUpdate(isset($_POST['btn_userEdit_save']) ? true : false); //Button in the form to user (userEdit.php)
        $MyUserForm->setBtnUpdate1(isset($_POST['btn_userEdit_save_1']) ? true : false); //Button in the form to user (userEdit.php)
        $btnUpdate = $MyUserForm->getBtnUpdate1() ? true : $MyUserForm->getBtnUpdate();
        
        $MyUserForm->setBtnAvatar(isset($_POST['btn_avatar']) ? true : false); //Button in the form to suscribe a new user (adherer.php)

        $MyUserForm->setBtnVenusia(isset($_POST['btn_venusia']) ? true : false); //Button in the form to suscribe a new user (adherer.php)
        $MyUserForm->setBtnActarus(isset($_POST['btn_actarus']) ? true : false); //Button in the form to suscribe a new user (adherer.php)
        $MyUserForm->setBtnGoldorak(isset($_POST['btn_goldorak']) ? true : false); //Button in the form to suscribe a new user (adherer.php)
        
        $MyUserForm->setNewError(isset($_GET['newError']) ? filter_input('newError', INPUT_GET) : false);

        //Récupération des valeurs des inputs du formulaire
        $MyUserForm->setId(isset($_POST['txt_userEdit_id']) ? intval(Utilities::filterInput('txt_userEdit_id')) : 0); //input in the form to user (userEdit.php)
        $MyUserForm->setName(isset($_POST['txt_userEdit_name']) ? Utilities::filterInput('txt_userEdit_name') : ''); //input in the form to user (userEdit.php)
        $MyUserForm->setSurname(isset($_POST['txt_userEdit_surname']) ? Utilities::filterInput('txt_userEdit_surname') : ''); //input in the form to user (userEdit.php)
        $MyUserForm->setPseudo(isset($_POST['txt_userEdit_pseudo']) ? Utilities::filterInput('txt_userEdit_pseudo') : ''); //input in the form to user (userEdit.php)
        $MyUserForm->setEmail(isset($_POST['txt_userEdit_email']) ? Utilities::filterInput('txt_userEdit_email') : ''); //input in the form to user (userEdit.php)
        $MyUserForm->setPhone(isset($_POST['txt_userEdit_phone']) ? Utilities::filterInput('txt_userEdit_phone') : ''); //input in the form to user (userEdit.php)
        $MyUserForm->setType(isset($_POST['list_userEdit_type']) ? Utilities::filterInput('list_userEdit_type') : ''); //input in the form to user (userEdit.php)
        if(empty($MyUserForm->getType())){ $MyUserForm->setType('Member');}
        $MyUserForm->setAvatar(isset($_POST['txt_userEdit_avatar']) ? Utilities::filterInput('txt_userEdit_avatar') : 'avatar_membre_white.webp'); //input in the form to user (userEdit.php)
        $MyUserForm->setSubscription(isset($_POST['list_userEdit_subscription']) ? Utilities::filterInput('list_userEdit_subscription') : ''); //input in the form to user (userEdit.php)
        $MyUserForm->setPassword(isset($_POST['txt_userEdit_password']) ? Utilities::filterInput('txt_userEdit_password') : ''); //input in the form to user (userEdit.php)
    }else{
        Utilities::redirectToPage('accessMethod');
    }

//***********************************************************************************************
// Déclaration et paramètrage des variables
//***********************************************************************************************

    if($MyUserForm->getBtnVenusia()){
        
        $_SESSION['dataConnect']['subscription'] = 'Vénusia';
        $MyUserForm->setSubscription('Vénusia');

        $_SESSION['user']['newMember'] = true;
        $MyUserForm->setNewMember(true);

        $MyUserForm->setBtnInsert(true);

    }elseif($MyUserForm->getBtnActarus()){
        
        $_SESSION['dataConnect']['subscription'] = 'Actarus';
        $MyUserForm->setSubscription('Actarus');

        $_SESSION['user']['newMember'] = true;
        $MyUserForm->setNewMember(true);

        $MyUserForm->setBtnInsert(true);

    }elseif($MyUserForm->getBtnGoldorak()){
        
        $_SESSION['dataConnect']['subscription'] = 'Goldorak';
        $MyUserForm->setSubscription('Goldorak');

        $_SESSION['user']['newMember'] = true;
        $MyUserForm->setNewMember(true);

        $MyUserForm->setBtnInsert(true);
    }

    //***********************************************************************************************
    // CRUD
    //***********************************************************************************************
        
    if($MyUserForm->getBtnUserEdit()){

        $users = $MyUserForm->getCurrentUser($MyUserForm->getId());
        $users['message'] = "";

        $MyType = myType();
        $MySubscription = mySubscription();

        return;

    }elseif($btnUpdate){
        
        if(!Utilities::ckeckCsrf()){
            
            $users = initTabUser($users, $MyUserForm);
            die('Erreur de vérification CSRF');

        }else{

            if($MyUserForm->getId() === 0){

                if(empty($MyUserForm->getType())){
                    $MyUserForm->setType('member');
                }

                $newUser = $MyUserForm->insertUser();

                if($newUser > 0){

                    $MyUserForm->setId($newUser);

                    $users = initTabUser($users, $MyUserForm);
                    $users['message'] = 'Le nouvel utilisateur a été ajouté avec succès.';
                    
                    $MyType = myType();
                    $MySubscription = mySubscription();

                    $_SESSION['user']['newMember'] = false;
                    $MyUserForm->setNewMember(false);

                    if($_SESSION['dataConnect']['type'] === 'Guest'){
                        $_SESSION['dataConnect']['id_user'] = $MyUserForm->getId();
                        $_SESSION['dataConnect']['pseudo'] = $MyUserForm->getPseudo();
                        $_SESSION['dataConnect']['avatar'] = $MyUserForm->getAvatar();
                        $_SESSION['dataConnect']['type'] = 'Member';
                        $_SESSION['dataConnect']['subscription'] = $MyUserForm->getSubscription();
                        $_SESSION['dataConnect']['password'] = '';
                        $_SESSION['dataConnect']['error'] = false;
                        $_SESSION['dataConnect']['connexion'] = true;
                    }

                    $_SESSION['token']['jwt']['tokenJwt'] = Utilities::tokenJwt($_SESSION['dataConnect']['pseudo'], $_SESSION['token']['jwt']['secretKey'], $_SESSION['token']['jwt']['delay']);
                    Utilities::redirectToPage('home');
                    
                    return;

                }else{

                    $users = initTabUser($users, $MyUserForm);
                    
                    $MyType = myType();
                    $MySubscription = mySubscription();

                    return;
                }

            }else{

                if($MyUserForm->getId() === 1){
                    $MyUserForm->setSubscription('Goldorak');
                    $MyUserForm->setType('Administrator');
                }

                $updateUser = $MyUserForm->updateUser($MyUserForm->getId());
                $users = initTabUser($users, $MyUserForm);

                $users['message'] = $_SESSION['other']['message'];
                
                $MyType = myType();
                $MySubscription = mySubscription();

                if ($_SESSION['user']['updateMonCompte']){

                    $_SESSION['dataConnect']['id_user'] = $MyUserForm->getId();
                    $_SESSION['dataConnect']['pseudo'] = $MyUserForm->getPseudo();
                    $_SESSION['dataConnect']['avatar'] = $MyUserForm->getAvatar();
                    $_SESSION['dataConnect']['type'] = 'Member';
                    $_SESSION['dataConnect']['subscription'] = $MyUserForm->getSubscription();
                    $_SESSION['dataConnect']['password'] = '';
                    $_SESSION['dataConnect']['error'] = false;
                    $_SESSION['dataConnect']['connexion'] = true;

                    $_SESSION['user']['updateMonCompte'] = false;
                }

                return;
            }
        }

    }elseif($MyUserForm->getBtnMonCompte()){ //Button in the navigation bar
        
        $MyUserForm->setId($_SESSION['dataConnect']['id_user']);

        $users = $MyUserForm->getCurrentUser($MyUserForm->getId());
        
        $users['message'] = $_SESSION['other']['message'];

        $MyType = myType();
        $MySubscription = mySubscription();

        $_SESSION['user']['updateMonCompte'] = true;

        return;

    }elseif($MyUserForm->getBtnInsert() || $MyUserForm->getBtnNavBarInsert()){
        
        $_SESSION['user']['newMember'] = true;
        
        $subscription = 'Vénusia'; settype($subscription, 'string');
        if(empty($MyUserForm->getSubscription())){
            $subscription = 'Vénusia';
        }else{
            $subscription = $MyUserForm->getSubscription();
        }

        resetUserVar($MyUserForm);
        $users = initTabUser($users, $MyUserForm);
        $users['subscription'] = $subscription;
        
        $MyType = myType();
        $MySubscription = mySubscription();
        
        return;

    }elseif($MyUserForm->getBtnDelete()){
        
        if(!Utilities::ckeckCsrf()){
            
            $users = initTabUser($users, $MyUserForm);
            die($_SESSION['other']['message']);

        }elseif($MyUserForm->getId() === 1){
            
            $users = initTabUser($users, $MyUserForm);
            $users['message'] = "Vous ne pouvez pas supprimer cet utilisateur.";
            $MyType = myType();
            $MySubscription = mySubscription();

            return;
        }
        else{

            $deleteUser = $MyUserForm->deleteUser($MyUserForm->getId());
            
            if (!$_SESSION['other']['error']){
                    
                resetUserVar($MyUserForm);
                $users = initTabUser($users, $MyUserForm);
                $users['message'] = $_SESSION['other']['message'];

                if($_SESSION['dataConnect']['type'] === 'Member'){

                    resetDataConnectVarSession();

                }

                $_SESSION['token']['jwt']['tokenJwt'] = Utilities::tokenJwt($_SESSION['dataConnect']['pseudo'], $_SESSION['token']['jwt']['secretKey'], $_SESSION['token']['jwt']['delay']);
                
                if($_SESSION['dataConnect']['type'] === 'Administrator'){
                    Utilities::redirectToPage('user');
                }else{
                    Utilities::redirectToPage('home');
                }

            }else{
                
                $users = initTabUser($users, $MyUserForm);
                $users['message'] = $_SESSION['other']['message'];
                
                $MyType = myType();
                $MySubscription = mySubscription();

                return;
            }

        }

    }elseif($MyUserForm->getBtnCancel()){
        
        Utilities::redirectToPage('user');

    }elseif($MyUserForm->getBtnAvatar()){

        if (Utilities::uploadImg('user', 'uploadAvatar','txt_userEdit_avatar','fileAvatar', $urlImg)){
            
            if($_SESSION['dataConnect']['type'] === 'Member'){
                $_SESSION['dataConnect']['avatar'] = $_SESSION['user']['uploadAvatar'];
            }

            $MyUserForm->setAvatar($_SESSION['user']['uploadAvatar']);
            
            $users = initTabUser($users, $MyUserForm);
            $users['message'] = "L'image a été téléchargée avec succès.";
        
            $MyType = myType();
            $MySubscription = mySubscription();

            return;

        }else{

            $users = initTabUser($users, $MyUserForm);
            $users['message'] = "Une erreur s'est produite lors de l'upload de l'image.";
        
            $MyType = myType();
            $MySubscription = mySubscription();

            return;
        }
    }

    if($MyUserForm->getNewError() && !$_SESSION['other']['errorForm']){

        $users = initTabUser($users, $MyUserForm);
        $users['message'] = "Veuillez remplir tous les champs du formulaire.";

        $MyType = myType();
        $MySubscription = mySubscription();

        $MyUserForm->setNewError(false);

        return;
    }

    //Fonction traitement de la BD pour récupérer les données destinées à l'input liste type
    function myType():array{
        
        $Types = new Type();
        $myType = array();

        $myType = $Types->getTypeList(1,'type', 'ASC', 0, 50);
        unset($Types);

        return $myType;
    }

    //Fonction de traitement de la BD pour récupérer les données destinées à l'input liste subscription
    function mySubscription():array{

        $Subscriptions = new Subscription();
        $MySubscription = array();

        $MySubscription = $Subscriptions->getSubscriptionList(1,'subscription', 'ASC', 0, 50);
        unset($Subscriptions);

        return $MySubscription;
    }

    //Fonction d'initialisation du tableau des données de l'utilisateur
    function initTabUser(array $users, object $MyUserForm):array{
        
        $users['id_user'] = $MyUserForm->getId();
        $users['name'] = $MyUserForm->getName();
        $users['surname'] = $MyUserForm->getSurname();
        $users['pseudo'] = $MyUserForm->getPseudo();
        $users['email'] = $MyUserForm->getEmail();
        $users['phone'] = $MyUserForm->getPhone();
        $users['type'] = $MyUserForm->getType();
        $users['avatar'] = $MyUserForm->getAvatar();
        $users['subscription'] = $MyUserForm->getSubscription();
        $users['password'] = $MyUserForm->getPassword();
        $users['message'] = "";

        return $users;
    }

    //Fonction de réinitialisation des variables de l'utilisateur
    function resetUserVar(object $MyUserForm):void{
        
        $MyUserForm->setId(0);
        $MyUserForm->setName('');
        $MyUserForm->setSurname('');
        $MyUserForm->setPseudo('');
        $MyUserForm->setEmail('');
        $MyUserForm->setPhone('## ## ## ## ##');
        $MyUserForm->setType('Member');
        $MyUserForm->setAvatar('avatar_membre_white.webp');
        $MyUserForm->setSubscription('Vénusia');
        $MyUserForm->setPassword('');
    }
?>