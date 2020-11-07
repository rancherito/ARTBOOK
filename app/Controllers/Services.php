<?php namespace App\Controllers;
class Services extends BaseController
{
	public function validatelogin()
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

	//--------------------------------------------------------------------

}
