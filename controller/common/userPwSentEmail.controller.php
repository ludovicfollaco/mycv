<?php
    use Model\Utilities\Utilities;
    use Model\User\User;
    use Model\DbConnect\DbConnect;

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $email = isset($_POST['email']) ? Utilities::escapeInput($_POST['email']) : die('Email requis');

        if(User::checkEmail($email)){

            // Générer un token unique
            $token = bin2hex(random_bytes(32));
            $timer_token = date('U') + 1800; // 30 minutes à partir de maintenant

            $configDb = DbConnect::configDbConnect();

            foreach ($configDb as $dbName => $configDbConnect){
                
                $bdd = DbConnect::connectDb($configDbConnect);

                // Insérer le token dans la base de données
                $stmt = $bdd->prepare('UPDATE `user` SET `token` = :token, `timer_token` = :timer_token WHERE email = :email');
                
                $stmt->bindParam(':token', $token, PDO::PARAM_STR);
                $stmt->bindParam(':timer_token', $timer_token, PDO::PARAM_INT);
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                
                $stmt->execute();

                $bdd = null;
            }
            // Créer le lien de réinitialisation du mot de passe
            $siteName = Utilities::checkAndReturnValueInUrl() === 'mycv' ? 'index' : Utilities::checkAndReturnValueInUrl();

            if(Utilities::checkIfLocal()){
                $url = sprintf('%s' . $siteName . '.php?page=userPwResetNew&token=%s', 'http://mycv/', $token);
            }else{
                $url = sprintf('%s' . $siteName . '.php?page=userPwResetNew&token=%s', 'https://www.follaco.fr/', $token);
            }

            // Envoyer l'email de réinitialisation du mot de passe
            $mail = new PHPMailer(true);
            
            try{
                $mail->isSMTP();
                $mail->Host = 'smtp.free.fr';
                $mail->SMTPAuth = true;
                $mail->Username = 'ludovic.follaco@free.fr';
                $mail->Password = 'MarLis123!';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Définir l'encodage des caractères
                $mail->CharSet = 'UTF-8';

                $mail->setFrom('ludovic.follaco@free.fr', 'Webmaster Ludovic FOLLACO');
                $mail->addAddress($email);

                $mail->isHTML(true);
                $mail->Subject = 'Réinitialisation de mot de passe';
                $mail->Body    = "Bonjour,<br><br>Cet email est sûr! Il est envoyé par le serveur du site de Ludovic FOLLACO pour que vous puissiez changer votre mot de passe.<br>
                                Respectueusement,<br>
                                Ludovic FOLLACO.<br><br>
                                Cliquez sur ce lien pour réinitialiser votre mot de passe :<br>
                                <a href='$url'>$url</a><br><br>
                                <span style='color:orange;'>PS :<br>
                                Si vous n'avez pas demandé de réinitialisation de mot de passe, veuillez ignorer cet email.<br>
                                Ne répondez pas à cet eMail, il est généré automatiquement par un robot.</span><br><br>
                                <span style='color:red;'>ATTENTION :<br>
                                Ne transférer jamais cet eMail à qui que ce soit, vous pourriez vous faire pirater votre compte.<br>
                                Ne partagez jamais votre mot de passe avec qui que ce soit.</span>";

                $mail->AltBody = "Cliquez sur ce lien pour réinitialiser votre mot de passe :<br>$url";

                $mail->send();
                $_SESSION['other']['error'] = false;
                $_SESSION['other']['message'] = 'Email de réinitialisation envoyé.';

            }catch(Exception $e){
                $_SESSION['other']['error'] = true;
                $_SESSION['other']['message'] = "Échec de l'envoi de l'email. Erreur: {$mail->ErrorInfo}";
            }
        }else{
            $_SESSION['other']['error'] = false;
            $_SESSION['other']['message'] = 'Aucun utilisateur trouvé avec cet email.';
        }
    }
?>