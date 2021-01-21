<?php namespace App\Controllers;
use App\Models\General;
use App\Models\User;
use App\Models\M_Events;
use App\Models\M_App;

use \Gumlet\ImageResize;
use Hashids\Hashids;
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
			$access = C_Users::login_validate_internal($_POST['user'], $pass);
			return $this->response->setJSON($access);
		}
	}

	public function artwork_save()
	{
		$_POST = json_decode(file_get_contents("php://input"), true);

		if (!empty($_SESSION['access']['user']) && !empty($_POST['workname']) && !empty($_POST['image'])) {

			$author= $_SESSION['access']['user'];

			$name = trim($_POST['workname']);
			$description = trim($_POST['description']);
			$extension_change = ['jpeg' => 'jpg', 'jpg' => 'jpg', 'png' => 'png'];
			$img = $_POST['image'];
			$ext = substr(str_replace(';base64', '', explode(',',$img)[0]),'11');
			$img = str_replace("data:image/$ext;base64,", '', $img);
			$ext = $extension_change[$ext];
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);


			$key = General::qry_images_salvar('', '', $ext, 0, 0, $author, $author, $name);
			$key_value = $key[0]['KeyItem'];

			$hashids = new Hashids('', 0, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUW');
			$namefile = $hashids->encode($key_value.getdate()[0]);
			$file = "images/artworks/$namefile.$ext";
			file_put_contents($file, $data);
			list($ancho, $alto) = getimagesize($file);

			$image = new ImageResize($file);
			$image->resizeToShortSide(400);
			$image->crop(400, 400, true, ImageResize::CROPCENTER);
			$image->save("images/artworks_lite/$namefile.jpg");


			General::qry_images_salvar($key_value, $namefile, $ext, $alto, $ancho, $author, $author, $name,$description);

			$queryfiename = General::exists_image($key_value);
			if (count($queryfiename)) {
				$queryfiename = $queryfiename[0];
			}

			return $this->response->setJSON(['path' => base_url().'/'.$file, 'artwork_info' => $queryfiename]);
		}
	}
	public function artwork_list()
	{
		$images = M_App::qry_images_list(user_account());
		return $this->response->setJSON($images);
	}
	public function artworks_recover()
	{
		if (isset($_POST['account'])) {
			$images = General::qry_images_recover($_POST['account'], user_account());
			return $this->response->setJSON($images);
		}
	}
	public function avatar_save()
	{
		if (!empty($_POST['image'])) {
			$img = $_POST['image'];
			$img = str_replace("data:image/jpeg;base64,", '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			$namefile = 'avatar_'.md5($_SESSION['access']['user_access']);
			$file = "images/avatars/$namefile.jpg";
			file_put_contents($file, $data);
			return $this->response->setJSON(['path_image' => base_url()."/$file?v=".rand()]);
		}

	}
	public function event_versuslist_Save()
	{

		if (
			!empty($_POST['title']) &&
			!empty($_POST['description']) &&
			!empty($_POST['tag']) &&
			!empty($_POST['account']) &&
			isset($_POST['is_public']) &&
			$_POST['account'] == user_account()
		) {
			$regtitle = "/^[ \-0-9A-Za-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙñÑ,:.\/]+$/i";
			$regdescription = "/^[ \(\)\-0-9A-Za-zäÄëËïÏöÖüÜáéíóúáéíóúÁÉÍÓÚÂÊÎÔÛâêîôûàèìòùÀÈÌÒÙñÑ,:.\/\n]+$/i";

			$is_puplic = $_POST['is_public'] == '0' ? 'L' : 'P';
			$description = trim(preg_replace('/\s\s+/',"\n", $_POST['description']));
			$title = trim($_POST['title']);
			$tag = htmlspecialchars($_POST['tag'], ENT_QUOTES);

			if (preg_match($regtitle,$title) == 0) return $this->response->setJSON(['message' => 'No usar letras especiales en el titulo']);
			if (preg_match($regdescription, $description) == 0) return $this->response->setJSON(['message' => 'No usar letras especiales en la descripción']);

			$res = M_Events::qry_versus_register('0', $tag, $_SESSION['access']['user_access'], $title, substr($description, 0, 200), $is_puplic);
			if (count($res)) $res = $res[0];
			return $this->response->setJSON($res);


		}

	}
	public function event_apply_versus()
	{
		if (!empty($_POST['versus'])) {
			$image = empty($_POST['artwork']) ? '' : $_POST['artwork'];
			$res = M_Events::qry_versus_apply($_SESSION['access']['user_access'], $_POST['versus'], $image);
			if (count($res)) $res = $res[0];
			return $this->response->setJSON($res);
		}


	}
	public function event_versus_list_recover()
	{
		if (!empty($_POST['tag'])) {
			$res = M_Events::qry_versus_list($_POST['tag']);
			$res = array_map(function ($i)
			{
				$i['applicants'] = M_Events::qry_vs_participients($i['versus']);
				return $i;
			}, $res);
			return $this->response->setJSON($res);
		}
	}
	public function events_apply_list()
	{
		$user = $_SESSION['access']['user_access'];
		$res = M_Events::qry_events_apply_list($user);
		return $this->response->setJSON($res);
	}
	public function vs_artwork_choise()
	{
		$ip = getIPAddress();
		$user = !empty($_SESSION['access']) ? $_SESSION['access']['account'] : $ip;
		if (!empty($_POST['artwork']) && !empty($_POST['versus'])) {
			$res = M_Events::qry_vs_artwork_choise($user,  $_POST['artwork'], $_POST['versus']);
			if (count($res)) $res = $res[0];
			return $this->response->setJSON($res);
		}

	}
	public function artworks_candidates()
	{

		if (!empty($_POST['versus']) && is_access()) {
			$res = M_Events::qry_vs_artworks_candidates($_POST['versus'], user());
			return $this->response->setJSON($res);
		}
	}
	public function like_save()
	{
		if (!empty($_POST['artwork'])) {
			$res = M_App::qry_like_artwork_save($_POST['artwork'], user_account());
			if (count($res)) $res = $res[0];
			return $this->response->setJSON($res);
		}
	}
	public function user_instagram_save()
	{
		if (!empty($_POST['account'])  && !empty($_POST['url']) && $_POST['account'] == user_account()) {
			$message = User::qry_socialnetwork_save('INSTA', $_POST['url'], user_account());
			if (count($message)) $message = $message[0];
			return $this->response->setJSON($message);
		}

	}
	public function nickname_save()
	{
		if (!empty($_POST['nickname']) && !empty($_POST['account']) && $_POST['account'] == user_account()) {
			$nickname = trim($_POST['nickname']);
			if (preg_match("/^[\w ]{4,30}$/i", $nickname)) {
				$message = User::qry_nickname_save($nickname, user_account());
				if (count($message)) $message = $message[0];
				if (!empty($message['message']) && $message['message'] == 'OK') $_SESSION['access']['nickname'] = $nickname;
				return $this->response->setJSON($message);
			}
			else return $this->response->setJSON(['message' => 'CHARS_NOT_VALID']);
		}
		else return $this->response->setJSON(['message' => 'ERROR_DATA']);
	}

}
