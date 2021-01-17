<?php
require_once './commons/connexion_BDD.php';
require_once './app/Router.php';

$router = new Router($bdd);

$router->reqUrl();


?>