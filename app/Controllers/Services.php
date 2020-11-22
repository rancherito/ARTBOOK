<?php namespace App\Controllers;
use App\Models\General;
use App\Models\User;
class Services extends BaseController
{
	public function account_create()
	{
		if (isset($_POST['user']) && isset($_POST['password']) && isset($_POST['email'])) {

			$res = [];
			$valid =
				preg_match("/^\w{4,16}$/i", $_POST['user']) &&
				filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
				preg_match("/.{8,20}/i", $_POST['password'])
				;
			if ($valid) {
				$user = $_POST['user'];
				$pass = md5($_POST['password']);
				$email_save = $_POST['email'];
				$ressql = User::account_create($user, $email_save, $pass);
				$key_generate = NULL;

				foreach ($ressql as $key => $value) {
					if($value['type_message'] == 'ERROR') $res[] = $value['message'];
					else if ($value['type_message'] == 'SUCCESS') $key_generate = $value['message'];
				}
				if (!is_null($key_generate)) {
					$key_validation = md5($key_generate.$user).md5($pass.$key_generate);
					$email = \Config\Services::email();

					$email->setFrom('davidlive0159@gmail.com', 'ARTS BOOK');
					$email->setTo($email_save);
					$email->setSubject('Registros de artistas Art\'s Book');
					$email->setMessage(view('emailcard',['user' => $user, 'activate' => base_url()."/user/activation/$user/$key_validation"]));
					$email->send();
				}
			}
			else $res[] = 'Se encontro formatos no validos';
			return $this->response->setJSON($res);
		}

	}
	public function login_validate()
	{
		if (!empty($_POST['user']) && !empty($_POST['password'])) {
			$pass = md5($_POST['password']);
			$access = Users::login_validate_internal($_POST['user'], $pass);
			return $this->response->setJSON($access);
		}
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
