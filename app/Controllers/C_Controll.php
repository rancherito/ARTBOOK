<?php namespace App\Controllers;
use App\Models\General;
use App\Models\User;
use App\Models\M_Events;
class C_Controll extends BaseController
{
	public function index()
	{
		$images = General::qry_images_list();
		$users = General::qry_simpleuser_list();
		echo $this->layout_view('administrator','controll/index',['images_list' => $images, 'users' => $users]);
	}
	public function users()
	{
		$users = User::qry_users_list();
		return $this->layout_view('controll','controll/users',['users' => $users]);
	}
	public function versus_results()
	{
		$list = M_Events::qry_events();
		echo $this->layout_view('controll','controll/versus_results',['event_list' => $list]);
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
