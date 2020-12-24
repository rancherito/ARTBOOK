<?php namespace App\Controllers;
use App\Models\General;
use App\Models\User;
use Facebook\Facebook;
use App\Models\M_Events;
class C_Users extends BaseController
{
	public function index($user)
	{
		$account = User::qry_account_exists($user);
		$current_events = M_Events::qry_events_current();
		$agent = $this->request->getUserAgent();
		if (count($account)) $account = $account[0];

		if (count($account) && $account['validate'] == 1) {
			$user_account = md5($account['user']);
			$partial_path = "images/avatars/avatar_$user_account.jpg";
			$path = file_exists($partial_path) ?base_url()."/$partial_path?v=".date("Ymd") : '';
			unset($account['user']);
			$images = General::qry_images_recover($user);
			$title = strtoupper($images[0]['nickname']).' AHORA EN ARTSBOOK-SITE';
			$metaimage = base_url().'/images/artworks/'.$images[0]['accessname'].'.'.$images[0]['extension'];
			$metas = ['img' => $metaimage, 'title' => $title];
			echo $this->layout_view('basic','users/user',['current_events' => $current_events, 'path_image' => $path, 'images_list' => $images, 'info' => $account, 'metas'=> $metas, 'agent' => $agent]);

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
				$access = C_Users::login_validate_internal($user['account'], $user['pass']);
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
			if ($message[0]['change'] == 'OK') C_Users::login_validate_internal($user['user_access'], ($_POST['is_new'] == '0' ? $verifypass : $newpass));

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
	public function login_fb()
	{
		$fb = new Facebook([
			'app_id' => '3301610373300333',
			'app_secret' => '1b1091d319cee49b6f19096bd442261e',
			'default_graph_version' => 'v3.2',
		]);

		$helper = $fb->getRedirectLoginHelper();

		$permissions = ['email'];
		$loginUrl = $helper->getLoginUrl(base_url().'/user/login_fbauth', $permissions);
		echo '<a href="' . $loginUrl . '">Log in con Facebook!</a>';
	}
	public function login_fbauth()
	{
		$idapp = '3301610373300333';
		$fb = new Facebook([
			'app_id' => $idapp,
			'app_secret' => '1b1091d319cee49b6f19096bd442261e',
			'default_graph_version' => 'v3.2',
		]);



		$helper = $fb->getRedirectLoginHelper();
		try {
			$accessToken = $helper->getAccessToken();

		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			// When Graph returns an error
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			// When validation fails or other local issues
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		if (! isset($accessToken)) {
			if ($helper->getError()) {
				header('HTTP/1.0 401 Unauthorized');
				echo "Error: " . $helper->getError() . "\n";
				echo "Error Code: " . $helper->getErrorCode() . "\n";
				echo "Error Reason: " . $helper->getErrorReason() . "\n";
				echo "Error Description: " . $helper->getErrorDescription() . "\n";
			} else {
				header('HTTP/1.0 400 Bad Request');
				echo 'Bad request';
			}
			exit;
		}
		try {
			// Returns a `Facebook\FacebookResponse` object
			$response = $fb->get('/me?fields=id,name', $accessToken);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
			echo 'Graph returned an error: ' . $e->getMessage();
			exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
			echo 'Facebook SDK returned an error: ' . $e->getMessage();
			exit;
		}

		$user = $response->getGraphUser();
		$id = $user['id'];
		$account = dechex($user['id']);
		$nickname = explode(' ', $user['name'])[0];

		$res = User::accountfb_create($id, $nickname, $account);
		if (count($res)) {
			$pass = $res[0]['pass'];
			$account = $res[0]['account'];
			$access = C_Users::login_validate_internal("FB_$id", $pass);
			if($access['access'] == 1){
				//User::account_activate($user['id_user']);
				return redirect()->to(base_url().'/'.$account);
			}
		}
		//var_dump($accessToken->getValue());

		// The OAuth 2.0 client handler helps us manage access tokens
		//$oAuth2Client = $fb->getOAuth2Client();

		// Get the access token metadata from /debug_token
		//$tokenMetadata = $oAuth2Client->debugToken($accessToken);
		//echo '<h3>Metadata</h3>';
		//var_dump($tokenMetadata);
		/*$tokenMetadata->validateAppId($idapp); // Replace {app-id} with your app id
		$tokenMetadata->validateExpiration();

		if (! $accessToken->isLongLived()) {
		try {
		$accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
	} catch (Facebook\Exceptions\FacebookSDKException $e) {
	echo "<p>Error getting long-lived access token: " . $e->getMessage() . "</p>\n\n";
	exit;
}

echo '<h3>Long-lived</h3>';
var_dump($accessToken->getValue());
}

$_SESSION['fb_access_token'] = (string) $accessToken;*/

}
}
