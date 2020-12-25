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
				$image->resizeToShortSide(400);
				$image->crop(400, 400, true, ImageResize::CROPCENTER);
				$image->save("images/artworks_lite/$value");
			}
		}
		echo "finish!";
	}
	public function image()
	{
		$im = imagecreatefrompng('https://media.geeksforgeeks.org/wp-content/uploads/geeksforgeeks-9.png');
		imagealphablending($im, true); // setting alpha blending on
		imagesavealpha($im, true); // save alphablending setting (important)

		$size = min(imagesx($im), imagesy($im));

		$im2 = imagecrop($im, ['x' => 0, 'y' => 0, 'width' => 250, 'height' => 150]);
		if ($im2 !== FALSE) {
			$this->response->setContentType('image/png');
		    imagepng($im2);
		    imagedestroy($im2);
		}
		imagedestroy($im);
	}
}
