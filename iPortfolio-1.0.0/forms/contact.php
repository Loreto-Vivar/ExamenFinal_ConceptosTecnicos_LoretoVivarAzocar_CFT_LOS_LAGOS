<?php
// Dirección de correo electrónico que recibirá los mensajes
$receiving_email_address = 'lore.yazocarv@gmail.com';

if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);
} else {
    die('Unable to load the "PHP Email Form" Library!');
}

// Instancia de la clase PHP_Email_Form
$contact = new PHP_Email_Form;
$contact->ajax = true;

// Configura el destinatario del correo
$contact->to = $receiving_email_address;

// Verifica y filtra las entradas del formulario
if (isset($_POST['name'], $_POST['email'], $_POST['subject'], $_POST['message'])) {
    $contact->from_name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $contact->from_email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $contact->subject = filter_var($_POST['subject'], FILTER_SANITIZE_STRING);

    if (!$contact->from_email) {
        die('Error: Invalid email address!');
    }

    // Añade los mensajes
    $contact->add_message($contact->from_name, 'From');
    $contact->add_message($contact->from_email, 'Email');
    $contact->add_message(filter_var($_POST['message'], FILTER_SANITIZE_STRING), 'Message', 10);

    // Configuración opcional para SMTP
    /*
    $contact->smtp = array(
        'host' => 'smtp.gmail.com', // Cambiar según tu proveedor SMTP
        'username' => 'lore.yazocarv@gmail.com',
        'password' => 'tu-contraseña',
        'port' => '587' // Usualmente 587 para TLS o 465 para SSL
    );
    */

    // Enviar el correo
    echo $contact->send();
} else {
    die('Error: Missing required form fields!');
}
?>
