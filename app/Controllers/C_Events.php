<?php namespace App\Controllers;
use App\Models\General;
use App\Models\User;
class C_Events extends BaseController
{
	public function index()
	{
		$ip = getIPAddress();
		$user = !empty($_SESSION['access']) ? $_SESSION['access']['account'] : $ip;
		$res = General::qry_challenge_artwork_vote($user, $_POST['image'], $_POST['challenge']);
		if (count($res)) $res = $res[0];
		return $this->response->setJSON($res);
	}
	public function chanllenges_votes()
	{
		$event_tag = '$$';
		$ip = getIPAddress();
		User::ipuser_save($ip);
		$current = General::qry_challenge_current();
		if (count($current)) {
			$current = $current[0];
			$event_tag = $current['event_tag'];
		}
		$user = !empty($_SESSION['access']) ? $_SESSION['access']['account'] : $ip;

		$list = General::qry_challenge_image_list($event_tag, $user);
		echo $this->layout_view('public','challenges', ['images' => $list, 'challenge' => $current]);
	}
	public function versus_list()
	{
		return $this->layout_view('public', 'versus_list');
	}
}
