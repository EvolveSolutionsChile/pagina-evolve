<?php
  /**
  * Requires the "PHP Email Form" library
  * The "PHP Email Form" library is available only in the pro version of the template
  * The library should be uploaded to: vendor/php-email-form/php-email-form.php
  * For more info and help: https://bootstrapmade.com/php-email-form/
  */

  // Configura la dirección receptora en la variable de entorno EVOLVE_CONTACT_EMAIL.
  $receiving_email_address = getenv('EVOLVE_CONTACT_EMAIL');

  if (!$receiving_email_address) {
    http_response_code(503);
    die('El formulario de contacto aún no tiene configurado un correo receptor.');
  }

  if( file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php' )) {
    include( $php_email_form );
  } else {
    http_response_code(500);
    die('No fue posible cargar el servicio de correo del formulario.');
  }

  $contact = new PHP_Email_Form;
  $contact->ajax = true;
  
  $contact->to = $receiving_email_address;
  $contact->from_name = $_POST['name'];
  $contact->from_email = $_POST['email'];
  $contact->subject = $_POST['subject'];

  // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
  /*
  $contact->smtp = array(
    'host' => 'example.com',
    'username' => 'example',
    'password' => 'pass',
    'port' => '587'
  );
  */

  $contact->add_message( $_POST['name'], 'Nombre');
  $contact->add_message( $_POST['email'], 'Correo electrónico');
  !empty($_POST['phone']) && $contact->add_message($_POST['phone'], 'Teléfono');
  !empty($_POST['organization']) && $contact->add_message($_POST['organization'], 'Empresa u organización');
  $contact->add_message( $_POST['message'], 'Mensaje', 10);

  echo $contact->send();
?>
