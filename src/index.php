<?php
//const HOME_PATH = '/1751707';
use utils\security;

const HOME_PATH = '/src';
/*const BD =  new \PDO('mysql:dbname=n46jolinfocegepl_1751707;host=localhost',
    'n46jolinfocegepl_1751707', '<3RickAstley');*/
const BD = new \PDO('mysql:dbname=test;host=host.docker.internal;port=3306',
            'root', 'root');

spl_autoload_register();
/*spl_autoload_register(function($className) {
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    if(file_exists(__DIR__ . 'index.php/' .  $className . '.php'))
        include_once __DIR__ . 'index.php/' .  $className . '.php';
});*/

header("X-Frame-Options: DENY");
header("Content-Security-Policy: frame-ancestors 'none'", false);
header_remove('x-powered-by');

Security::sessionStart();

$repo = new \repositories\userrepositorie;
//$repo->dropTable();
//$repo->createTable();
$repo->populateRole();
$repo->populateStatus();

if(!$_SERVER['SERVER_NAME'] == 'localhost'){
    if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === "off") {
        $location = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        header('Location: ' . $location);
        exit;
    }
}

if(isset($_COOKIE['authentification'])){
    $user = new \models\usermodel();
    $userrepo = new \repositories\userrepositorie;
    $user = $userrepo->getUserAuthByToken($_COOKIE['authentification']);
    if($user){
        $_SESSION['user'] = $user;
    }
}


$uri = $_SERVER['REQUEST_URI'];
$uri = substr($uri, 1);
$parts = explode('/', $uri);
$uri = array_shift($parts);

$controllerName = $parts[0] ?? 'home';

if (class_exists('\controllers\\' . $controllerName . 'controller')){
    $controllerName = '\controllers\\' . $controllerName . 'controller';
    $controller = new $controllerName();

    $actionName = $parts[1] ?? 'index';
    str_contains($actionName, 'verify?') ? $actionName = 'verify' : $actionName = $actionName;

    if (method_exists($controller, $actionName)) {

        $controller->$actionName();
    }
    else{
        $controller = new \controllers\homecontroller();
        $controller->index();
    }
}
else{
    $controller = new \controllers\homecontroller();
    $controller->index();
}
