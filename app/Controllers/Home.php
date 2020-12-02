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
	private static function getIPAddress() {
		return isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
	}
	public function chanlenges_votes()
	{
		$ip = Home::getIPAddress();
		User::ipuser_save($ip);
		$list = General::qry_challenge_image_list('1');
		echo $this->layout_view('public','challenges', ['images' => $list]);
	}
	//--------------------------------------------------------------------

}
