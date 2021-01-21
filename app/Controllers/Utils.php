<?php namespace App\Controllers;
use \Gumlet\ImageResize;

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
	public function resizeimage()
	{

		foreach (scandir('./images/artworks') as $key => $value) {
			if (!is_dir($value) && $value != ".gitkeep") {
				$image = new ImageResize("images/artworks/$value");
				ini_set('memory_limit', '300M');
				$image->resizeToWidth(400);
				$image->save("images/artworks_small/$value");

			}
		}
		echo "finish!";
	}
}
