<?
require_once(__DIR__ . "/../vendor/autoload.php");

(new \Application\Application(require_once(__DIR__ . "/../config/config.php")))->run();
