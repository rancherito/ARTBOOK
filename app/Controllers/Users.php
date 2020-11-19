<?php namespace App\Controllers;
use App\Models\General;
class Users extends BaseController
{
	public function index($user)
	{
		$account = General::qry_account_exists($user);

		if (count($account)) {
			$images = General::qry_images_recover($user);
			$title = strtoupper($images[0]['nickname']).' AHORA EN ARTSBOOK-SITE';
			$metaimage = base_url().'/images/artworks/'.$images[0]['accessname'].'.'.$images[0]['extension'];
			$metas = ['img' => $metaimage, 'title' => $title];
			echo $this->layout_view('public','users/index',['images_list' => $images, 'info' => $account[0], 'metas'=> $metas]);
		}
		else throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

	}


}
