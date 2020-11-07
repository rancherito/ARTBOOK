<?php namespace App\Controllers;

class Utils extends BaseController
{
	public function close_session()
	{
		$_SESSION = [];
		header('Location: '. base_url());
		exit;
	}

}
