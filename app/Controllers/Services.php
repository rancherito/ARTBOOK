<?php namespace App\Controllers;
use App\Models\General;
class Services extends BaseController
{
	public function login_validate()
	{
		$access = ['access' => false];
		$_SESSION = [];
		if (!empty($_POST['user']) && !empty($_POST['password'])) {
			$pass = md5($_POST['password']);
			$res = General::qry_access($_POST['user'],$pass);
			if (count($res)) {
				$typeaccess = "UNDEFINIED";

				$res = $res[0];
				if ($res['id_role'] == 'admin') $typeaccess = 'ADMINISTRADOR';
				else if ($res['id_role'] == 'common') $typeaccess = 'COMMON';

				session()->set([
					'access' => [
						'user' => $res['id_user'],
						'nickname' => $res['nickname'],
						'account' => $res['account'],
						'accesstype' => $typeaccess,
						'account_site' => base_url().'/'.$res['account']
					]
				]);
				$access['access'] = true;
			}
		}
		return $this->response->setJSON($access);
	}
	public function artwork_save()
	{
		$_POST = json_decode(file_get_contents("php://input"), true);

		if (!empty($_POST['author']) && !empty($_POST['workname']) && !empty($_POST['image']) && isset($_POST['key'])) {

			if ($_POST['author'] == 'current') $_POST['author'] = $_SESSION['access']['user'];

			$id_image = $_POST['key'];
			$name = trim($_POST['workname']);
			$description = trim($_POST['description']);
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
				if (file_exists("images/artworks/$filename")) {
					unlink("images/artworks/$filename");
				}
			}
			$key = General::qry_images_salvar($id_image, '', $ext, 0, 0, '1', '2', $name);
			$key_value = $key[0]['KeyItem'];

			$namefile = md5($key_value.$name.getdate()[0]);
			$file = "images/artworks/$namefile.$ext";
			file_put_contents($file, $data);
			list($ancho, $alto) = getimagesize($file);

			General::qry_images_salvar($key_value, $namefile, $ext, $alto, $ancho, $_POST['author'], '2', $name,$description);

			return $this->response->setJSON(['key' => $key_value]);
		}
	}
	public function artwork_list()
	{
		$images = General::qry_images_list();
		return $this->response->setJSON($images);
	}
	public function artworks_recover()
	{
		if (isset($_POST['account'])) {
			$images = General::qry_images_recover($_POST['account']);
			return $this->response->setJSON($images);
		}
	}
	//--------------------------------------------------------------------

}
