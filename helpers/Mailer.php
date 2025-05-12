<?php
namespace Helpers; // Si vous utilisez des namespaces

class Mailer {
    public static function send($to, $subject, $message, $headers = '') {
        $defaultHeaders = "From: votre@email.com\r\n"; // Remplacez par votre adresse e-mail
        $defaultHeaders .= "Reply-To: votre@email.com\r\n";
        $defaultHeaders .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $allHeaders = $defaultHeaders . $headers;

        if (mail($to, $subject, $message, $allHeaders)) {
            return true; // L'e-mail a été envoyé avec succès
        } else {
            return false; // Erreur lors de l'envoi de l'e-mail
        }
    }
}
?>