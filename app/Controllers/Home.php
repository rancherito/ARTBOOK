<?php namespace App\Controllers;
use App\Models\General;
use App\Models\User;
use App\Models\M_Events;
use App\Models\M_App;
use telesign\sdk\messaging\MessagingClient;
class Home extends BaseController
{
	public function test_sms()
	{
		$customer_id = "DCFC62D1-BD46-4D11-81FC-FF8E7153C1C8";
		$api_key = "a5ce65HLd/GMG1i7C3I7nr7HBb5ivBL3/DqRWgF7mJImP+G6RTIt3XfS4fWBbm7QinST8PvW1RHY4LTyhyLHow==";
		$phone_number = "51941643518";
		$message = "You're scheduled for a dentist appointment at 2:30PM.";
		$message_type = "ARN";
		$messaging = new MessagingClient($customer_id, $api_key);
		$response = $messaging->message($phone_number, $message, $message_type);
		print_r($response);
		echo "SE ENVIO CON EXITO Xd";
	}
	public function index()
	{
		$current_events = M_Events::qry_events_current();
		$agent = $this->request->getUserAgent();
		$images = array_map(function ($artwork) {
			$artwork['has_avatar'] = has_user_avatar($artwork['user_avatar'], true);return $artwork;
		},M_App::qry_images_list());

		$new_images = array_map(function ($artwork) {
			$artwork['has_avatar'] = has_user_avatar($artwork['user_avatar'], true); return $artwork;
		},M_App::qry_images_new_list());


		$feed = General::qry_feedpage();
		return $this->layout_view('public','home',['images_feed' => $new_images,'images_list' => $images, 'feed' => $feed, 'agent' => $agent, 'current_events' => $current_events]);
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
