<?php namespace App\Controllers;
use App\Models\General;
use App\Models\User;
use App\Models\M_Events;
use App\Models\M_App;
class C_Controll extends BaseController
{
	public function index()
	{
		$images = M_App::qry_images_list(user_account());
		$users = General::qry_simpleuser_list();
		echo $this->layout_view('administrator','controll/index',['images_list' => $images, 'users' => $users]);
	}
	public function users()
	{
		$users = User::qry_users_list();
		return $this->layout_view('controll','controll/users',['users' => $users]);
	}
	public function versus_participients()
	{
		if (!empty($_GET['tag'])) {
			$participients = M_Events::qry_event_vs_participients($_GET['tag']);
			$event = M_Events::qry_events('2', $_GET['tag']);
			if (count($event)) $event = $event[0];
			$versus = [];
			foreach ($participients as $key => $participient) {
				if (empty($versus[$participient['versus']])) $versus[$participient['versus']] = [];
				$versus[$participient['versus']][] = $participient;
			}
			return $this->layout_view('controll','controll/versus_participients', ['versus' => $versus, 'event' => $event]);
		}
		else {
			return  "NO SELECCIONO NINGUN TAG DE EVENTO VALIDO";
		}
	}
	public function versus_results()
	{	$results = [];
		$list = [];
		$versus_list = [];
		$winners = [];
		if (empty($_GET['tag'])) {
			$list = M_Events::qry_events('2');
			if (count($list)) $results = M_Events::qry_vs_results($list[0]['event_tag']);
		}
		else $results = M_Events::qry_vs_results($_GET['tag']);

		foreach ($results as $key => $versus) {
			if(empty($versus_list[$versus['versus']])) $versus_list[$versus['versus']] = [];
			if(empty($winners[$versus['versus']])) $winners[$versus['versus']] = [];

			$versus_list[$versus['versus']][] = $versus;
			if ($versus['ranking'] == 1) {
				$winners[$versus['versus']][] = $versus;
			}
		}

		return $this->layout_view('controll','controll/versus_results',['versus_list' => $versus_list, 'winners' => $winners]);

	}
	public function events()
	{
		$list = M_Events::qry_events();
		echo $this->layout_view('controll','controll/events',['event_list' => $list]);
	}
	public function users_access()
	{
		if (!empty($_POST['user']) && !empty($_POST['pass']) && !empty($_POST['account'])) {
			$account = $_POST['account'];
			$access = C_Users::login_validate_internal($_POST['user'], $_POST['pass']);
			if($access['access'] == 1){
				return redirect()->to(base_url().'/'.$account);
			}
		}
		else {
			echo "FALTAN DATOS";
		}

	}
}
