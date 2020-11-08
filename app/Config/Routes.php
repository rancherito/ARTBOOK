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
$routes->get('close', 'Utils::close_session');
$routes->add('login', 'Home::access');
$routes->post('services/getaccess', 'Services::login_validate');



if (isset($_SESSION['access']) && $_SESSION['access']['accesstype'] == 'ADMINISTRADOR') {
	$routes->add('/administrator', 'Administrator');
	$routes->post('/services/artwork/save', 'Services::artwork_save');
}



if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
