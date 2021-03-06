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
$routes->get('artwork/upload', 'Home::artwork_upload');
$routes->get('artwork/view/(:alphanum)', 'Home::artwork_recover/$1');
$routes->add('user/login_fbauth', 'C_Users::login_fbauth');
$routes->add('user/login_gooauth', 'C_Users::login_gooauth');
$routes->add('user/activation/([a-zA-Z0-9_]+)/(:alphanum)', 'C_Users::account_validate/$1/$2');
$routes->add('events/challenges',  'C_Events::chanllenges_votes');
$routes->add('events/versus',  'C_Events::versus_list');
$routes->post('services/events/challenges/votes_save', 'C_Events');
$routes->post('services/events/versus/votes_save', 'Services::vs_artwork_choise');
$routes->post('services/getaccess', 'Services::login_validate');
$routes->post('services/account/create', 'Services::account_create');
//$routes->get('test/sms', 'Home::test_sms');

$routes->add('user/revocar',  function ()
{
	echo "Lamentamos que tegas que irte de nuestra plataforma :'c'";
});

$routes->add('user/politicas',  function ()
{
	echo "No spam, no contenido pornografico, banneo si se incumple las reglas basicas";
});

if (isset($_SESSION['access'])) {

	$routes->post('services/artwork/save', 'Services::artwork_save');
	$routes->post('services/artworks/recover', 'Services::artworks_recover');
	$routes->post('services/user/avatarsave', 'Services::avatar_save');
	$routes->post('service/events/versuslist_save', 'Services::event_versuslist_Save');
	$routes->post('service/events/apply_versus', 'Services::event_apply_versus');
	$routes->post('service/events/versuslist', 'Services::event_versus_list_recover');
	$routes->post('service/events/artworks_candidates', 'Services::artworks_candidates');
	$routes->post('service/artwork/like_save', 'Services::like_save');
	$routes->get('service/events/apply_list', 'Services::events_apply_list');
	$routes->post('service/user/sn_insta/save', 'Services::user_instagram_save');
	$routes->post('service/user/nickname/save', 'Services::nickname_save');

	$routes->add('user/settings', 'C_Users::settings');
	$routes->add('user/editinfo', 'C_Users::account_editinfo');


	if ($_SESSION['access']['accesstype'] == 'ADMINISTRADOR') {
		$routes->add('c', 'C_Controll');
		$routes->get('c/events', 'C_Controll::events');
		$routes->post('c/users', 'C_Controll::users_access');
		$routes->get('c/users', 'C_Controll::users');
		$routes->add('c/versus/results', 'C_Controll::versus_results');
		$routes->add('c/versus/participients', 'C_Controll::versus_participients');
		$routes->get('/services/artwork/list', 'Services::artwork_list');

	}
}

$routes->add('/([a-zA-Z0-9_]+)', 'C_Users::index/$1');
$routes->add('/events/versus/([a-zA-Z0-9_]+)', 'C_Events::versus_recover/$1');

$routes->add('emailview', function () {
	echo view('emailcard',['user'=>'CAFECONPATO','activate' => 'patarad']);
});


$routes->add('testemail', function ()
{
	$email = \Config\Services::email();
	$email->setFrom('davidlive0159@gmail.com', 'ARTS BOOK');
	$email->setTo('evopedro0159@gmail.com');
	$email->setSubject('Registros de artistas Art\'s Book');
	$email->setMessage('PATRAÑAS POR QUE NEIVAS MENSAJES XD XD XD '.base_url());

	if ($email->send()) {
		echo "se envio";
	}
	else {
		$data = $email->printDebugger(['headers']);
		print_r($data);
	}
});
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
