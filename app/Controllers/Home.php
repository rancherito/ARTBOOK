<?php namespace App\Controllers;
use App\Models\General;
use App\Models\User;
class Home extends BaseController
{
	public function index()
	{
		$agent = $this->request->getUserAgent();
		$images = General::qry_images_list();
		$feed = General::qry_feedpage();
		echo $this->layout_view('public','index',['images_list' => $images, 'feed' => $feed, 'agent' => $agent]);
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
