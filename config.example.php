<?php
// Copy this file to config.php and fill in your own values.
// config.php is git-ignored: never commit real credentials.

define('APP_NAME', 'PROJETO');
define('APP_VERSION', 'V1.0.0');

// Database
define('MYSQL_SERVER',   'localhost');
define('MYSQL_DATABASE', 'php_store');
define('MYSQL_USER',     'root');
define('MYSQL_PASS',     '');
define('MYSQL_CHARSET',  'utf8');

// Email (SMTP via PHPMailer)
// EMAIL_KEY / EMAIL_IV: your own random AES-128-GCM key and IV.
// EMAIL_PASS_ENC: your SMTP password encrypted with EnviarEmail::criptografar_senha().
define('EMAIL_KEY',      'change-me');
define('EMAIL_IV',       'change-me');
define('EMAIL_PASS_ENC', 'change-me');
define('EMAIL_HOST',     'smtp.gmail.com');
define('EMAIL_FROM',     'you@example.com');
define('EMAIL_PORT',     '465');

define('BASE_URL', 'http://localhost/');
