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
$routes->add('user/activation/([a-zA-Z0-9_]+)/(:alphanum)', 'Users::account_validate/$1/$2');

$routes->add('emailview', function () {
	echo view('emailcard',['user'=>'CAFECONPATO','activate' => 'patarad']);
});

$routes->post('services/getaccess', 'Services::login_validate');
$routes->post('services/account/create', 'Services::account_create');

$routes->add('recortar', 'Utils::image');

if (isset($_SESSION['access'])) {

	$routes->post('/services/artwork/save', 'Services::artwork_save');
	$routes->post('/services/artworks/recover', 'Services::artworks_recover');

	if ($_SESSION['access']['accesstype'] == 'ADMINISTRADOR') {
		$routes->add('/administrador', 'Administrator');
		$routes->get('/services/artwork/list', 'Services::artwork_list');
	}
}

$routes->add('/([a-zA-Z0-9_]+)', 'Users::index/$1');


if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
