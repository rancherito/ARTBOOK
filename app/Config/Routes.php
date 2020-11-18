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

$routes->add('test', function ()
{
	$email = \Config\Services::email();

	$email->setFrom('davidlive0159@gmail.com', 'ARTS BOOK');
	$email->setTo('febrero0159@gmail.com');
	$email->setSubject('Account Activation-GoPHP');
	$email->setMessage('Testing the email class.');
	if ($email->send()) {
		echo "Ni idea si envia :c";
	}
	else {
		$d = $email->printDebugger(['headers']);
		print_r($d);
	}
});

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
