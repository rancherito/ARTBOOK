<?php namespace App\Controllers;
use App\Models\General;
use App\Models\User;
use App\Models\M_Events;
class Home extends BaseController
{
	public function index()
	{
		$list_versus = M_Events::qry_versus_current();
		$agent = $this->request->getUserAgent();
		$images = General::qry_images_list();
		$feed = General::qry_feedpage();
		echo $this->layout_view('public','index',['images_list' => $images, 'feed' => $feed, 'agent' => $agent, 'list_versus' => $list_versus]);
	}
	public function access()
	{
		if (isset($_SESSION['access'])) {
			header('Location: '.base_url());
			die();
		}

		return view('login');
	}


	//--------------------------------------------------------------------

}
