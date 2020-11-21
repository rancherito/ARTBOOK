<?php namespace Config;

$routes = Services::routes(true);

if (file_exists(SYSTEMPATH . 'Config/Routes.php')) require SYSTEMPATH . 'Config/Routes.php';

$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

session();
$routes->get('/', 'Home');
$routes->get('user/close', 'Utils::close_session');
$routes->add('user/login', 'Home::access');
$routes->add('user/activation/(:any)/(:alphanum)', function ($user, $key) {
	echo "$user $key";
});

$routes->post('services/getaccess', 'Services::login_validate');
$routes->post('services/account/create', 'Services::account_create');

$routes->add('recortar', 'Utils::image');

if (isset($_SESSION['access']) && $_SESSION['access']['accesstype'] == 'ADMINISTRADOR') {
	$routes->add('/administrador', 'Administrator');
	$routes->post('/services/artwork/save', 'Services::artwork_save');
	$routes->get('/services/artwork/list', 'Services::artwork_list');
	$routes->post('/services/artworks/recover', 'Services::artworks_recover');
}

$routes->add('/(:alphanum)', 'Users::index/$1');


if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
