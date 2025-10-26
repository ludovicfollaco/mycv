<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $send_ = false;

    $objet = htmlspecialchars($_POST['contact_objet']);
    $name = htmlspecialchars($_POST['contact_name']);
    $email = htmlspecialchars($_POST['contact_email']);
    $tel = htmlspecialchars($_POST['contact_tel']);
    $message = htmlspecialchars($_POST['contact_description']);

    // Email à envoyer à moi-même
    $mail = new PHPMailer(true);
    try{
        // Configuration du serveur SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.free.fr';
        $mail->SMTPAuth = true;
        $mail->Username = 'ludovic.follaco@free.fr';
        $mail->Password = 'MarLis123!';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Définir l'encodage des caractères
        $mail->CharSet = 'UTF-8';

        // Destinataires
        $mail->setFrom('ludovic.follaco@free.fr', 'Message depuis follaco.fr');
        $mail->addAddress('ludovic.follaco@free.fr');

        // Contenu de l'email
        $mail->isHTML(true);
        $mail->Subject = "$objet";
        $mail->Body    = "Objet: $objet<br>".
                         "Nom: $name<br>".
                         "Email: $email<br>".
                         "Téléphone: $tel<br><br>".
                         "Message:<br>$message";

        $mail->send();

        $send_ = true;

    }catch (Exception $e){

        echo "Une erreur s'est produite lors de l'envoi de votre message. Erreur: {$mail->ErrorInfo}";

    }

    // Email de confirmation à l'émetteur
    $confirm_mail = new PHPMailer(true);

    try {
        // Configuration du serveur SMTP
        $confirm_mail->isSMTP();
        $confirm_mail->Host = 'smtp.free.fr'; // Remplacez par votre serveur SMTP
        $confirm_mail->SMTPAuth = true;
        $confirm_mail->Username = 'ludovic.follaco@free.fr'; // Remplacez par votre adresse email
        $confirm_mail->Password = 'MarLis123!'; // Remplacez par votre mot de passe
        $confirm_mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $confirm_mail->Port = 587;

        // Définir l'encodage des caractères
        $confirm_mail->CharSet = 'UTF-8';

        // Destinataires
        $confirm_mail->setFrom('ludovic.follaco@free.fr', 'Ludovic FOLLACO');
        $confirm_mail->addAddress($email);

        // Contenu de l'email
        $confirm_mail->isHTML(true);
        $confirm_mail->Subject = "Confirmation de transmission de votre message";
        $confirm_mail->Body    = "Bonjour $name,<br><br>".
                                 "Votre message à bien était transmis, je vous répondrais dans les plus brefs délais.<br><br>".
                                 "Respectueusement,<br>".
                                 "Ludovic FOLLACO<br>".
                                 "+33 6 08 81 83 90<br><br>" .
                                 "------------------------------------------------------<br><br>" .
                                 "Objet: $objet<br>".
                                 "Nom: $name<br>".
                                 "Email: $email<br>".
                                 "Téléphone: $tel<br><br>".
                                 "Message:<br>$message";

        $confirm_mail->send();

        if($send_){
            echo "<script> alert('Votre message a bien été envoyé.'); </script>";
            
        }

    }catch(Exception $e){

        echo "Une erreur s'est produite lors de l'envoi de l'email de confirmation. Erreur: {$confirm_mail->ErrorInfo}";

    }
}
?>