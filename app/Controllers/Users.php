<?php namespace App\Controllers;
use App\Models\General;
use App\Models\User;
class Users extends BaseController
{
	public function index($user)
	{
		$account = User::qry_account_exists($user);
		if (count($account)) $account = $account[0];

		if (count($account) && $account['validate'] == 1) {
			$images = General::qry_images_recover($user);
			$title = strtoupper($images[0]['nickname']).' AHORA EN ARTSBOOK-SITE';
			$metaimage = base_url().'/images/artworks/'.$images[0]['accessname'].'.'.$images[0]['extension'];
			$metas = ['img' => $metaimage, 'title' => $title];
			echo $this->layout_view('public','users/index',['images_list' => $images, 'info' => $account, 'metas'=> $metas]);

		}
		else if (count($account) && $account['validate'] == 0) {
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


}
