<?php namespace App\Controllers;
use App\Models\General;
use App\Models\User;
class C_Users extends BaseController
{
	public function index($user)
	{
		$account = User::qry_account_exists($user);
		$agent = $this->request->getUserAgent();
		if (count($account)) $account = $account[0];

		if (count($account) && $account['validate'] == 1) {
			$user_account = md5($account['user']);
			$partial_path = "images/avatars/avatar_$user_account.jpg";
			$path = file_exists($partial_path) ? "'".base_url()."/$partial_path?v=".rand()."'" : 'null';
			unset($account['user']);
			$images = General::qry_images_recover($user);
			$title = strtoupper($images[0]['nickname']).' AHORA EN ARTSBOOK-SITE';
			$metaimage = base_url().'/images/artworks/'.$images[0]['accessname'].'.'.$images[0]['extension'];
			$metas = ['img' => $metaimage, 'title' => $title];
			echo $this->layout_view('public','users/index',['path_image' => $path, 'images_list' => $images, 'info' => $account, 'metas'=> $metas, 'agent' => $agent]);

		}
		else if (count($account) && $account['validate'] == 0) {
			unset($account['user']);
			echo $this->layout_view('public','users/validate', ['info' => $account]);
		}
		else throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

	}
	public function account_validate($acount, $validatorcode)
	{
		$account = User::account_validate($acount);

		if (count($account)) {
			$user = $account[0];
			$validate = md5($user['id_user'].$user['account']).md5($user['pass'].$user['id_user']);
			if ($validate == $validatorcode) {
				$access = Users::login_validate_internal($user['account'], $user['pass']);
				if($access['access'] == 1){
					User::account_activate($user['id_user']);
					return redirect()->to(base_url().'/'.$user['account']);
				}
			}
			else echo "Parece que su llave de activación no es valida";

		}
		else echo "Lo sentimos parace que su llave de activación ya no es valida";


	}
	public function account_editinfo()
	{
		if (!empty($_SESSION['access']) && !empty($_POST['old']) && !empty($_POST['nickname']) && isset($_POST['is_new'])) {
			$user = $_SESSION['access'];
			$newpass = md5($_POST['new']);
			$verifypass = md5($_POST['old']);
			$message = User::account_edit($user['user_access'], $verifypass, $_POST['nickname'], $newpass, $_POST['is_new']);
			if ($message[0]['change'] == 'OK') Users::login_validate_internal($user['user_access'], ($_POST['is_new'] == '0' ? $verifypass : $newpass));

			return $this->response->setJSON($message[0]);

		}


	}
	public static function login_validate_internal($user, $pass)
	{
		$access = ['access' => false, 'account' => ''];
		$_SESSION = [];

		$res = User::qry_access($user, $pass);
		if (count($res)) {
			$typeaccess = "UNDEFINIED";

			$res = $res[0];
			if ($res['id_role'] == 'admin') $typeaccess = 'ADMINISTRADOR';
			else if ($res['id_role'] == 'common') $typeaccess = 'COMMON';

			session()->set([
				'access' => [
					'user' => $res['id_user'],
					'user_access' => $res['user'],
					'nickname' => $res['nickname'],
					'account' => $res['account'],
					'accesstype' => $typeaccess,
					'account_site' => base_url().'/'.$res['account'],
					'validate' => $res['validate'],
					'recreatepass' => $res['recreatepass']
				]
			]);
			$access['access'] = true;
			$access['account'] = $res['account'];
		}
		return $access;
	}

	public function settings()
	{
		$user = md5($_SESSION['access']['user_access']);
		$partial_path = "images/avatars/avatar_$user.jpg";
		$path = file_exists($partial_path) ? "'".base_url()."/$partial_path?v=".rand()."'" : 'null';
		echo view('users/settings', ['path_image' => $path]);
	}
}
