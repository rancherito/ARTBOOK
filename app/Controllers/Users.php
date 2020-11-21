<?php namespace App\Controllers;
use App\Models\General;
use App\Models\User;
class Users extends BaseController
{
	public function index($user)
	{
		$account = User::qry_account_exists($user);
		if (count($account)) $account = $account[0];

		if (count($account) && $account['validate'] == 1) {
			$images = General::qry_images_recover($user);
			$title = strtoupper($images[0]['nickname']).' AHORA EN ARTSBOOK-SITE';
			$metaimage = base_url().'/images/artworks/'.$images[0]['accessname'].'.'.$images[0]['extension'];
			$metas = ['img' => $metaimage, 'title' => $title];
			echo $this->layout_view('public','users/index',['images_list' => $images, 'info' => $account, 'metas'=> $metas]);

		}
		else if (count($account) && $account['validate'] == 0) {
			echo $this->layout_view('public','users/validate', ['info' => $account]);
		}
		else throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

	}


}
