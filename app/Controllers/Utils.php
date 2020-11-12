<?php namespace App\Controllers;

class Utils extends BaseController
{
	public function close_session()
	{
		$_SESSION = [];
		header('Location: '. base_url());
		exit;
	}
	public function test()
	{
		$test = '%y%\'; --';
		$data = query_database("SELECT * FROM  app.tb_images WHERE name LIKE ? AND extension = 'png' ;",[$test]);

		print_r($data);
	}

}
