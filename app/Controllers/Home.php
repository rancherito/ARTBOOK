<?php namespace App\Controllers;
use App\Models\General;
class Home extends BaseController
{
	public function index()
	{
		$images = General::qry_images_list();
		 echo $this->layout_view('public','index',['images_list' => $images]);
	}
	public function access()
	{
		return view('login');
	}
	//--------------------------------------------------------------------

}
