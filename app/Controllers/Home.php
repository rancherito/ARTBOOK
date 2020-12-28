<?php namespace App\Controllers;
use App\Models\General;
use App\Models\User;
use App\Models\M_Events;
class Home extends BaseController
{
	public function index()
	{
		$current_events = M_Events::qry_events_current();
		$agent = $this->request->getUserAgent();
		$images = General::qry_images_list();
		$feed = General::qry_feedpage();
		echo $this->layout_view('public','index',['images_list' => $images, 'feed' => $feed, 'agent' => $agent, 'current_events' => $current_events]);
	}
	public function artwork_recover($artwork)
	{
		$res = General::qry_artwork_recover($artwork);
		if (count($res)) {
			$res = $res[0];
			$top_nine = General::qry_top9_artworks_list($res['account']);
			$metaimage = base_url().'/images/artworks_lite/'.$artwork.'.'.$res['extension'];
			$title = $res['name'].' por '.$res['nickname'];

			$metas = ['img' => $metaimage, 'title' => $title];
			if (!empty($res['description'])) $metas['description'] = $res['description'];

			echo $this->layout_view('publicv2','artwork',['artwork' => $res, 'others_artworks' => $top_nine, 'metas' => $metas]);
		}
		else throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
	}
	public function access()
	{
		if (isset($_SESSION['access'])) {
			header('Location: '.base_url());
			die();
		}

		return view('login');
	}
	public function artwork_upload()
	{
		echo $this->layout_view('publicv2','artwork/upload');
	}


	//--------------------------------------------------------------------

}
