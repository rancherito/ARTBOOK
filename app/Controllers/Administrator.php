<?php namespace App\Controllers;
use App\Models\General;
class Administrator extends BaseController
{
	public function index()
	{
		$images = General::qry_images_list();
		echo $this->layout_view('administrator','administrator/index',['images_list' => $images]);
	}

}
