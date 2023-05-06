<?php

namespace Classes;

use PHPMailer\PHPMailer\PHPMailer;

class Email {
    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }
    
    public function enviarConfirmacion() {
        // Crear el objeto de emial
        $mail = new PHPMailer();
        $mail->isSMTP();

        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '042a8b7bce241c';
        $mail->Password = 'b74637c43c58a9';

        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'Appsalon.com');
        $mail->Subject = 'Confirma tu cuenta';

        // Set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->email . " </strong>Has creado tu cuenta en AppSalon, porfavor confirma presionando el siguiente enlace</p>";
        $contenido .= "<p>Presiona Aquí: <a href='http://localhost:3000/confirmar-cuenta?token=" . $this->token . "'>Confirmar Cuenta</a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, ignora el mensaje</p>";
        $contenido .= '</html>';

        $mail->Body = $contenido;

        // Enviar mail
        $mail->send();
    }

    public function enviarInstrucciones() {

        // Crear el objeto de emial
        $mail = new PHPMailer();
        $mail->isSMTP();
 
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Port = 2525;
        $mail->Username = '042a8b7bce241c';
        $mail->Password = 'b74637c43c58a9';
 
        $mail->setFrom('cuentas@appsalon.com');
        $mail->addAddress('cuentas@appsalon.com', 'Appsalon.com');
        $mail->Subject = 'Confirma tu cuenta';
 
        // Set HTML
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $contenido = "<html>";
        $contenido .= "<p><strong>Hola " . $this->nombre . " </strong> Has solicitado restablecer tu password </p>";
        $contenido .= "<p>Presiona Aquí: <a href='http://localhost:3000/recuperar?token=" . $this->token . "'> Reestablecer Password </a></p>";
        $contenido .= "<p>Si tu no solicitaste esta cuenta, ignora el mensaje</p>";
        $contenido .= '</html>';
 
        $mail->Body = $contenido;
 
        // Enviar mail
        $mail->send(); 

    }
}