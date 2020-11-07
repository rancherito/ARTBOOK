<?php namespace App\Controllers;
class Home extends BaseController
{
	public function index()
	{
		 echo $this->layout_view('public','index');
	}
	public function access()
	{
		return view('login');
	}
	//--------------------------------------------------------------------

}
