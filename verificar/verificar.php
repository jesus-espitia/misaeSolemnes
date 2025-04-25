<?php

require 'vendor/autoload.php';

$email = "jcdona904@gmail.com";

use SMTPValidateEmail\Validator as SmtpEmailValidator;

$validator = new SmtpEmailValidator($email, 'sender@example.org');

$results   = $validator->validate();

echo $results[$email]. "\n";
echo $results[$email] ? 'El email existe' : 'El email no existe';
