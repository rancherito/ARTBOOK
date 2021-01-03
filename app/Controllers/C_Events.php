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
		$GLOBALS['vs_invitation'] = [];
		$GLOBALS['metas'] = [];

		foreach ($list_versus as $k => $v) {
			$list_participients[$v['event_tag']] = M_Events::qry_versus_list($v['event_tag']);

			$list_participients[$v['event_tag']] = array_map(function ($i)
			{
				$i['applicants'] = M_Events::qry_vs_participients($i['versus']);
				if (!empty($_GET['id']) && $i['versus'] == $_GET['id']){
					$GLOBALS['vs_invitation'] =  $i;
					$title = 'VERSUS: '.$i['name'];
					$description = 'Hola te invito a participar de un versus de dibujantes, el cual consiste en '."\n".$i['description'];
					$GLOBALS['metas'] = ['title' => $title, 'description' => $description];
				}
				return $i;
			},$list_participients[$v['event_tag']]);

		}
		return $this->layout_view('publicv2', 'events/inscriptions',['metas'=> $GLOBALS['metas'], 'list_versus' => $list_versus, 'list_participients' => $list_participients, 'invitation' => $GLOBALS['vs_invitation']]);
	}
	public function versus_recover($tag)
	{
		$res = M_Events::qry_versus_recover($tag);

		if (count($res)) {
			$res = $res[0];
			if ($res['event_voting_state'] == 'S') {
				$ip = getIPAddress();
				User::ipuser_save($ip);
				$user = !empty($_SESSION['access']) ? $_SESSION['access']['account'] : $ip;
				$list = M_Events::qry_vs_artworks($tag, $user);
				if (empty($_SESSION['access'])) {
					return $this->layout_view('public', 'events/pre_presentationvs',['data' => $res, 'participients' => $list]);
				}
				else return $this->layout_view('public', 'events/versustag',['data' => $res, 'participients' => $list]);
			}
			else {
				$list = M_Events::qry_vs_results($tag);

				$versus_list = [];
				$winners = [];
				$metas = [];
				$metas['title'] = $res['name']. ' - ARTSBOOK';
				$metas['description'] = $res['description'];
				foreach ($list as $key => $versus) {
					if(empty($versus_list[$versus['versus']])) $versus_list[$versus['versus']] = [];
					if(empty($winners[$versus['versus']])) $winners[$versus['versus']] = [];

					$versus_list[$versus['versus']][] = $versus;
					if ($versus['ranking'] == 1) {
						$winners[$versus['versus']][] = $versus;
					}
				}
				return $this->layout_view('publicv2', 'events/versustag_presentation',['metas' => $metas, 'data' => $res, 'versus_list' => $versus_list, 'winners' => $winners]);
			}
		}
		else {
			echo 'Lo sentimos no encontramos eventos con este tag';
		}
	}
}
