<?php

namespace App\Tools;

// Importation de la classe PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Importation l'autoload de composer
require BASE_PATH.'/vendor/autoload.php';


class SendMail
{
    public static function sendMailToPassagers($to, $subject, $templateMail, $params)
    {
        // Instantiation de la classe PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuration du serveur SMTP
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            // Envoyer le mail via SMTP
            $mail->SMTPAuth   = true;                                   // Activer l'authentification SMTP
            $mail->Host       = $_ENV['SMTP_HOST'];                       // Spécifier le host SMTP
            $mail->Username   = $_ENV['SMTP_USER'];                     //SMTP username
            $mail->Password   = $_ENV['SMTP_PASSWORD'];                     //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            // Activer le cryptage SSL;
            $mail->Port       = $_ENV['SMTP_PORT'];                     // Port à utiliser pour la connexion


            // Expediteur et Destinataire
            $mail->setFrom($_ENV['SMTP_FROM_EMAIL'], $_ENV['SMTP_FROM_NAME']);       // Qui ENVOIE le mail
            $mail->addAddress($to, 'Passager');                          // Qui REÇOIT le mail

            // Encodage
            $mail->CharSet = 'UTF-8';
            $mail->Encoding = 'base64';

            //Content
            $mail->isHTML(true);                                  // Activer le format HTML
            $mail->Subject = $subject;                             // Sujet du mail

            // Chemin du modèle du mail
            $templatePath = BASE_PATH . "/Templates/Mails/" . $templateMail;

            // Exécution de PHP dans le fichier template
            ob_start();
            extract($params);  // Extraire les variables du tableau params
            include $templatePath; // Inclure le fichier template (le code PHP sera exécuté)
            $content = ob_get_clean(); // Récupérer le contenu du fichier template

            // Le contenu du mail
            $mail->Body = $content;

            // Envoi du mail
            $mail->send();
        } catch (Exception $e) {
            echo "Error dans l'envoie du mail. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
