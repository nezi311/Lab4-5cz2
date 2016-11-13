<?php
// bootstrap.php
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

// przykładowa konfiguracja za pomocą adnotacji w kodzie
$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/SRC"), $isDevMode);

// konfiguracja połączenia
$conn = array(
    'dbname' => 'testowa',
    'user' => 'user',
    'password' => '123456',
    'host' => 'localhost',
    'driver' => 'pdo_mysql',
    'charset' => 'utf8'
);

//stworzenie obiektu Entity Managera
$entityManager = EntityManager::create($conn, $config);
echo 'Połączenie z bazą';
?>
