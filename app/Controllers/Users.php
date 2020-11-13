<?php namespace App\Controllers;
use App\Models\General;
class Users extends BaseController
{
	public function index($user)
	{
		$account = General::qry_account_exists($user);

		if (count($account)) {
			$images = General::qry_images_recover($user);
			echo $this->layout_view('public','users/index',['images_list' => $images, 'info' => $account[0]]);
		}
		else {
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
		}
	}


}
