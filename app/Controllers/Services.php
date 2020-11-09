<?php namespace App\Controllers;
use App\Models\General;
class Services extends BaseController
{
	public function login_validate()
	{
		$access = ['access' => false];
		if (!empty($_POST['user']) && !empty($_POST['password'])) {

			$access['access'] = strtolower($_POST['user']) == 'dlarico' && $_POST['password'] == '123';

			session()->set([
				'access' => [
					'nickname' => 'cafeconpato',
					'accesstype' => 'ADMINISTRADOR'
				]
			]);
		}

		return $this->response->setJSON($access);
	}
	public function artwork_save()
	{
		if (!empty($_POST['author']) && !empty($_POST['workname']) && !empty($_POST['image']) && isset($_POST['key'])) {

			$id_image = $_POST['key'];
			$name = trim($_POST['workname']);
			$extension_change = ['jpeg' => 'jpg', 'jpg' => 'jpg', 'png' => 'png'];
			$img = $_POST['image'];
			$ext = substr(str_replace(';base64', '', explode(',',$img)[0]),'11');
			$img = str_replace("data:image/$ext;base64,", '', $img);
			$ext = $extension_change[$ext];
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);

			$queryfiename = General::exists_image($id_image);
			if (count($queryfiename)) {
				$filename = $queryfiename[0]['filename'];
				unlink("images/artworks/$filename");
			}
			$key = General::qry_images_salvar($id_image, '', $ext, 0, 0, '1', '2', $name);
			$key_value = $key[0]['KeyItem'];

			$file = "images/artworks/".md5($key_value.$name).".$ext";
			file_put_contents($file, $data);
			list($ancho, $alto) = getimagesize($file);

			General::qry_images_salvar($key_value, md5($key_value.$name), $ext, $ancho, $alto, '1', '2', $name);

			return $this->response->setJSON(['key' => $key_value]);
		}
	}
	public function artwork_list()
	{
		$images = General::qry_images_list();
		return $this->response->setJSON($images);
	}
	//--------------------------------------------------------------------

}
