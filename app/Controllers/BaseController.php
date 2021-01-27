<?php
namespace App\Controllers;
use Carbon\Carbon;
/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{

	protected $helpers = [];

	public function layout_view($layout, $view, $params = []){
		$data = array();
        $data['body'] = view($view, $params);
        return view('layouts/'.$layout,array_merge($params,$data));
	}
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		Carbon::setLocale('es');
		session();
		helper('tdatabase');
		helper('utils');
		parent::initController($request, $response, $logger);
		if (empty($_SESSION['current_date'])) $_SESSION['current_date'] = date('mdy');
		if ($_SESSION['current_date'] != date('mdy') || empty($_SESSION['user_time_zone'])) {
			$_SESSION['user_time_zone'] = getLocationInfoByIp();
			$_SESSION['user_min_diff_timezone'] = minuteDifferenceTimeZone();
		}
		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		// $this->session = \Config\Services::session();
	}

}
