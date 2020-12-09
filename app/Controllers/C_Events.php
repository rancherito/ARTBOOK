<?php namespace App\Controllers;
use App\Models\General;
use App\Models\User;
use App\Models\M_Events;
class C_Events extends BaseController
{
	public function index()
	{
		$ip = getIPAddress();
		$user = !empty($_SESSION['access']) ? $_SESSION['access']['account'] : $ip;
		$res = M_Events::qry_challenge_artwork_vote($user, $_POST['image'], $_POST['challenge']);
		if (count($res)) $res = $res[0];
		return $this->response->setJSON($res);
	}
	public function chanllenges_votes()
	{
		$event_tag = '$$';
		$ip = getIPAddress();
		User::ipuser_save($ip);
		$current = M_Events::qry_challenge_current();
		if (count($current)) {
			$current = $current[0];
			$event_tag = $current['event_tag'];
		}
		$user = !empty($_SESSION['access']) ? $_SESSION['access']['account'] : $ip;

		$list = M_Events::qry_challenge_image_list($event_tag, $user);
		echo $this->layout_view('public','challenges', ['images' => $list, 'challenge' => $current]);
	}
	public function versus_list()
	{
		$list_versus = M_Events::qry_versus_current();
		$list_participients = [];
		foreach ($list_versus as $k => $v) {
			$list_participients[$v['event_tag']] = M_Events::qry_versus_list($v['event_tag']);
		}
		return $this->layout_view('public', 'versus_list',['list_versus' => $list_versus, 'list_participients' => $list_participients]);
	}
}
