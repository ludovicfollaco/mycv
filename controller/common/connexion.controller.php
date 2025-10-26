<?php
    use Model\Utilities\Utilities;
    use Model\User\User;

    if($_SERVER['REQUEST_METHOD'] === 'POST'){

        if(isset($_POST['envoyer'])){
    
            if(!Utilities::ckeckCsrf()){
                
                die($_SESSION['other']['message']);
    
            }else{

                $email = ''; settype($email, "string");
                $pw = ''; settype($pw, "string");
                $hashedPw = ''; settype($hashedPw, "string");
                $data = array(); settype($data, "array");

                if (isset($_POST["email"]) && empty($_POST["email"])) {
                    
                    $_SESSION['other']['error'] = true;
                    $_SESSION['other']['message'] = 'The Cell [email] is umpty!!!';
                    return;

                }else{

                    $email = Utilities::filterInput('email');

                    if(!User::checkEmail($email, Utilities::checkAndReturnValueInUrl())){
                        $_SESSION['other']['error'] = true;
                        $_SESSION['other']['message'] = 'This email is not existing!!!';
                        return;
                    }
                }

                if (isset($_POST["password"]) && empty($_POST["password"])) {

                    $_SESSION['other']['error'] = true;
                    $_SESSION['other']['message'] = 'The Cell [mot de passe] is umpty!!!';
                    return;

                }else{

                    $pw = Utilities::filterInput('password');
                    $hashedPw = User::checkPassword($email);

                    if(!password_verify($pw, $hashedPw)){
                        $_SESSION['other']['error'] = true;
                        $_SESSION['other']['message'] = 'This password is not correctly!!!';
                        return;
                    }
                }
            
                $data = User::checkUserConnect($email, $hashedPw);

                $_SESSION['dataConnect'] = $data;
                $_SESSION['dataConnect']['connexion'] = true;

                $_SESSION['token']['jwt']['tokenJwt'] = Utilities::tokenJwt($_SESSION['dataConnect']['pseudo'], $_SESSION['token']['jwt']['secretKey'], $_SESSION['token']['jwt']['delay']);
                
                Utilities::redirectToPage('home');
            }
        }
        unset($_POST['envoyer']);
    }
?>

