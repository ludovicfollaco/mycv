<?php
    use Model\Utilities\Utilities;
    use Model\DbConnect\DbConnect;

    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pwChange']) && $_POST['pwChange'] === 'envoyer'){

        $token = isset($_POST['token']) ? Utilities::filterInput('token') : die('Token requis');
        unset($_POST['token']);

        if(isset($_POST['password'])){

            $password = Utilities::filterInput('password');
            unset($_POST['password']);

            $passwordRegex = '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[\/\*\-\.\!\?\@])[A-Za-z\d\/\*\-\.\!\?\@]{13,}$/';

            if(preg_match($passwordRegex, $password)){

                if(isset($_POST['confirm_password'])){

                    $confirm_password = Utilities::filterInput('confirm_password');
                    unset($_POST['confirm_password']);

                    if($password === $confirm_password){
                        
                        $new_password = password_hash($password, PASSWORD_DEFAULT);

                        $configDb = DbConnect::configDbConnect();
            
                        foreach ($configDb as $dbName => $configDbConnect){
                            
					        $bdd = DbConnect::connectDb($configDbConnect);

                            try{

                                $stmt = $bdd->prepare('SELECT COUNT(*) FROM `user` WHERE `token` = :token');
                                $stmt->bindParam(':token', $token, PDO::PARAM_STR);
                                $stmt->execute();

                                $checkToken = $stmt->fetchColumn();

                                if($checkToken){

                                    $stmt = $bdd->prepare('SELECT `email`, `timer_token` FROM `user` WHERE `token` = :token');
                                    $stmt->bindParam(':token', $token, PDO::PARAM_STR);
                                    $stmt->execute();

                                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                    if($result){

                                        if($result['timer_token'] >= date('U')){

                                            $newToken = bin2hex(random_bytes(32));
                                            $timer_token = date('U');

                                            $stmt = $bdd->prepare('UPDATE `user` SET `password` = :new_password, `token` = :newToken , `timer_token` = :timer_token WHERE `email` = :email');

                                            $stmt->bindParam(':new_password', $new_password, PDO::PARAM_STR);
                                            $stmt->bindParam(':newToken', $newToken, PDO::PARAM_STR);
                                            $stmt->bindParam(':timer_token', $timer_token, PDO::PARAM_INT);
                                            $stmt->bindParam(':email', $result['email'], PDO::PARAM_STR);

                                            $stmt->execute();

                                            $_SESSION['other']['error'] = false;
                                            $_SESSION['other']['messagePw'] = 'Mot de passe réinitialisé avec succès.';
                                            
                                            $bdd = null;

                                            if ($dbName === 'mycv'){
                                                Utilities::redirectToPage('connexion');
                                            }

                                        }else{
                                            $_SESSION['other']['error'] = false;
                                            $_SESSION['other']['messagePw'] = 'Timer expiré.';
                                        }
                                    }

                                }else{
                                    $_SESSION['other']['error'] = false;
                                    $_SESSION['other']['messagePw'] = 'Token invalide.';
                                }

                            }catch(PDOException $e){
                                $_SESSION['other']['error'] = true;
                                $_SESSION['other']['messagePw'] = 'Error query : ' . $e->getMessage() . '<br>';
                            }
                        }
                    }else{
                        $_SESSION['other']['error'] = false;
                        $_SESSION['other']['messagePw'] = 'Les mots de passe ne correspondent pas.';
                    }
                }
            }else{
                $_SESSION['other']['error'] = false;
                $_SESSION['other']['messagePw'] = 'Le mot de passe doit contenir au moins 13 caractères,<br>
                                                   dont une majuscule, une minuscule, un chiffre et<br>
                                                   un caractère spécial parmis les suivants /*-.!?@';
            }
        }

        $page = 'userPwResetNew&token=' . $token;
        Utilities::redirectToPage($page);
    }

?>