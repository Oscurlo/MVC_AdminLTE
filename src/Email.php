<?php

namespace Admin\MvcAdminLte;

use Config\AppConfig;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

final class Email
{
    private PHPMailer $mail;
    public ?bool $exceptions = false;
    public ?bool $showErrors = !AppConfig::PRODUCTION;

    public function __construct()
    {
        $this->mail = new PHPMailer(
            exceptions: $this->exceptions
        );

        $this->mail->isSMTP();
    }

    public function SMTPConfig(array $config)
    {
        [
            "host" => $host,
            "username" => $username,
            "password" => $password,
            "encryption" => $encryption,
            "port" => $port
        ] = $config;

        $this->mail->SMTPAuth = true;
        $this->mail->Host = $host;
        $this->mail->Username = $username;
        $this->mail->Password = $password;
        $this->mail->SMTPSecure = $encryption ?: "tls";
        $this->mail->Port = $port ?: 465;
    }

    /**
     * Mucho texto
     * 
     * @param string $mail correo del destinatario
     * @param string $name Nombre del destinatario (Opcional)
     * 
     * @return void No retorna Nada :)
     */
    public function setFrom(string $mail, string $name = ''): void
    {
        $this->mail->setFrom(
            address: $mail,
            name: $name
        );
    }

    /**
     * Mucho texto
     * 
     * @param string $mail correo del destinatario
     * @param string $name Nombre del destinatario (Opcional)
     * 
     * @return void No retorna Nada :)
     */
    public function setRecipient(string $mail, string $name = ''): void
    {
        $this->mail->addAddress(
            address: $mail,
            name: $name
        );
    }

    /**
     * Mucho texto
     * 
     * @param string $mail correo del destinatario
     * @param string $name Nombre del destinatario (Opcional)
     * 
     * @return void No retorna Nada :)
     */
    public function setReplyTo(string $mail, string $name = ''): void
    {
        $this->mail->addReplyTo(
            address: $mail,
            name: $name
        );
    }

    /**
     * Mucho texto
     * 
     * @param string $mail correo del destinatario
     * @param string $name Nombre del destinatario (Opcional)
     * 
     * @return void No retorna Nada :)
     */
    public function setCC(string $mail, string $name = ''): void
    {
        $this->mail->addCC(
            address: $mail,
            name: $name
        );
    }

    /**
     * Mucho texto
     * 
     * @param string $mail correo del destinatario
     * @param string $name Nombre del destinatario (Opcional)
     * 
     * @return void No retorna Nada :)
     */
    public function setBCC(string $mail, string $name = ''): void
    {
        $this->mail->addBCC(
            address: $mail,
            name: $name
        );
    }

    /**
     * Envia archivos adjuntos
     * 
     * @param string $path ruta del archivo
     * 
     * @return void No retorna Nada :)
     */
    public function setAttachment(string $path): void
    {
        if (file_exists($path))
            $this->mail->addAttachment(
                path: $path,
                name: basename($path)
            );
    }

    /**
     * Contenido del correo
     * 
     * @param string $subject Titulo
     * @param string $body Contenido
     * @param bool $isHTM si es html ¯\\_(ツ)_/¯
     */
    public function sendMail(string $subject, string $body, bool $isHTML = true): void
    {
        $this->mail->isHTML(
            isHtml: $isHTML
        );

        $this->mail->Subject = $subject;
        $this->mail->Body = $body;

        # De momento no lo voy a usar no entendi para q es 😓
        // $this->mail->AltBody = "";
    }

    public function send(): bool
    {
        try {
            return $this->mail->send();
        } catch (Exception $e) {
            # Si puede mostrar el error retorno el error caso contrario retorno false de q no se envio el correo

            if ($this->showErrors)
                throw $e;
            else
                return false;
        }
    }
}
