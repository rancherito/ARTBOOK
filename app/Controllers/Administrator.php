<?php namespace App\Controllers;
class Administrator extends BaseController
{
	public function index()
	{
		echo $this->layout_view('administrator','administrator/index');
	}
}
