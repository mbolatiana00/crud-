<?php

require "../vendor/autoload.php";

use Router\Router;
use App\Exceptions\NotFoundException;

define('VIEWS', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR);
define('BASE_URL', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/');
define('DB_NAME', 'restaurant');
define('DB_HOST', '127.0.0.1');
define('DB_USER', 'root');
define('DB_PWD', '');

$router = new Router($_GET['url'] ?? '/');


$router->get('/logout', 'App\Controllers\AuthController@logout');

$router->get('/login', 'App\Controllers\AuthController@login');
$router->post('/login', 'App\Controllers\AuthController@loginAuth');

$router->get('/register', 'App\Controllers\RegisterController@showRegister');
$router->post('/register', 'App\Controllers\RegisterController@registerAuth');

$router->get('/', 'App\Controllers\ProductController@index');
$router->get('/products/:id', 'App\Controllers\ProductController@show');


$router->get('/panier', 'App\controllers\PanierController@index');
$router->post('/panier/add', 'App\controllers\PanierController@add');
$router->get('/panier/count', 'App\controllers\PanierController@count');
$router->post('/panier/vider', 'App\controllers\PanierController@vider');
$router->post('/panier/delete', 'App\controllers\PanierController@viderUnSeul');

$router->get('/commande', 'App\controllers\CommandeController@index'); 
$router->post('/commande/valider', 'App\controllers\CommandeController@valider');
$router->get('/commande/confirmation/:id', 'App\controllers\CommandeController@confirmation');

$router->get('/historique', 'App\controllers\HistoriqueCommandeController@index');

$router->get('/admin', 'App\controllers\admin\AdminUserController@index');
$router->post('/admin/store', 'App\controllers\admin\AdminUserController@store');
$router->post('/admin/commandes/:id/valider', 'App\controllers\admin\AdminCommandeController@valider');

$router->get('/paiement', 'App\controllers\PaiementController@index');
$router->post('/paiement/store', 'PaiementController@store');
$router->get('/paiement/valider/:id', 'PaiementController@valider');
$router->get('/paiement/rejeter/:id', 'PaiementController@rejeter');


try {
    $router->run();
} catch (NotFoundException $e) {
    return $e->error404();
}