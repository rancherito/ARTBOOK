<?php
	use Carbon\Carbon;
	use Carbon\CarbonInterface;
	function movil() { return '600px'; }
	function tablet() { return '992px'; }
	function desktop() { return '1200px'; }
	function secction($area)
	{
		include APPPATH.'Views/layouts/sections/'.$area.'.php';
	}
    if (! function_exists('get_image')){
        function get_image(string $ruta): string
        {
            return base_url().'/assets/images/'.$ruta;
        }

    }
	function minuteDifferenceTimeZone()
	{
		$now = Carbon::now(date_default_timezone_get());
		$emitted = Carbon::parse($now, $_SESSION['user_time_zone']);
		$diff = $now->diffInMinutes($emitted);
		return $diff; //outputs 3
	}
	function getLocationInfoByIp($ip_address = ''){
	    if (empty($ip_address)) {
	        $client  = @$_SERVER['HTTP_CLIENT_IP'];
	        $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	        $server  = @$_SERVER['SERVER_ADDR'];
	        $remote  = @$_SERVER['REMOTE_ADDR'];
	        if(!empty($client) && filter_var($client, FILTER_VALIDATE_IP)){
	            $ip = $client;
	        }elseif(!empty($forward) && filter_var($forward, FILTER_VALIDATE_IP)){
	            $ip = $forward;
	        }elseif(!empty($server) && filter_var($server, FILTER_VALIDATE_IP)){
	            $ip = $server;
	        }else{
	            $ip = $remote;
	        }
	    } else {
	        $ip = $ip_address;
	    }

		$result  = 'America/Lima';

		try {
			$ip_data = unserialize(file_get_contents("http://www.geoplugin.net/php.gp".($ip=='::1' ? '' : "?ip=$ip")));
		    if($ip_data && $ip_data['geoplugin_countryCode'] != null) $result = $ip_data['geoplugin_timezone'];
		} catch (\Exception $e) {}


	    return $result;
	}
	function layout_view($layout, $view, $params = []){
		$data = array();
        $data['body'] = view($view, $params);
        return view('layouts/'.$layout,array_merge($params,$data));
	}
    function generate_imageBase64($typeImage, $url, $nameVar_imageJs){
        $url_escudo = 'data:image/'.$typeImage.';base64,' . base64_encode(file_get_contents($url));
        echo /** @lang text */ "<script>let $nameVar_imageJs = new Image(); $nameVar_imageJs.src = '$url_escudo';</script>";
    }
	function getIPAddress() {
		return isset($_SERVER['HTTP_CLIENT_IP']) ? $_SERVER['HTTP_CLIENT_IP'] : isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];
	}
    function content_search_full($title,$description,$icon = 'fa fa-home')
    {
        echo '
            <div id="content_search_full" class="bg-primary-image">
                <div id="content_search_full_left">
                    <i class="' . $icon . '"></i>
                    <span class="title-2 c">'.$title.'</span>
                </div>
                <div id="content_search_full_right">
                    <span id="searchBox" style="box-shadow: none;"></span>
                    <span class="title-4" style="color: white;">'.$description.'</span>
                </div>
            </div>
            <script>

                const content_search_full = $(document.getElementById("content_search_full"));
                const search_module_box = $(document.getElementById("searchBox")).searchBox2();
                search_module_box.searchBox2_onselect(function(){
                   content_search_full.addClass("openMdule");
                });
            </script>
        ';
    }
	function bg_animate()
	{
		return '<div class="bg_animate" >
			<ul class="circles">
				<li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li>
			</ul>
		</div>';
	}
	function bg_animate_001()
	{
		return '<div class="bg_animate_001" >
			<ul class="circles">
				<li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li>
			</ul>
		</div>';
	}
	function bg_animate_002()
	{
		return '<div class="bg_animate_002" >
			<ul class="circles">
				<li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li>
			</ul>
		</div>';
	}
    function loader_content(){
        $waiters = [];
        $waiters[] = '
            <div class="lds-grid" id="loader_content"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
        ';
        echo '
        <div class="sk-folding-cube" id="loader_content">
            <div class="sk-cube1 sk-cube"></div>
            <div class="sk-cube2 sk-cube"></div>
            <div class="sk-cube4 sk-cube"></div>
            <div class="sk-cube3 sk-cube"></div>
        </div>
        ';
    }
	function bg_default($bg = '')
	{
		return '
		<div class="bg_full_default">
			<div class="bg_full_default_wrap_image">
				<img src="'.($bg == '' ? base_url().'/images/bg_003.jpg' : '').'">
			</div>
		</div>
		';
	}
	function isMovil()
	{
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		$movil = false;
		if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
		$movil = true;
		return $movil;
	}
	function dateFormatDefault($datestring)
	{
		return Carbon::parse($datestring)->add(minuteDifferenceTimeZone(), 'minute')->diffForHumans(['syntax' => CarbonInterface::DIFF_RELATIVE_TO_NOW,
    'options' => Carbon::JUST_NOW | Carbon::ONE_DAY_WORDS | Carbon::TWO_DAY_WORDS]);
	}
	function is_self_account($account)
	{
		return !empty($_SESSION['access']['account']) && $_SESSION['access']['account'] == $account && $_SESSION['access']['validate'] != 0;
	}
	function is_access()
	{
		return !empty($_SESSION['access']);
	}
	function user_account()
	{
		return empty($_SESSION['access']['account']) ? '' : $_SESSION['access']['account'];
	}
	function user_nickname()
	{
		return empty($_SESSION['access']['account']) ? '' : $_SESSION['access']['nickname'];
	}
	function user_site()
	{
		return empty($_SESSION['access']['account']) ? '' : $_SESSION['access']['account_site'];
	}
	function user_id()
	{
		return empty($_SESSION['access']['account']) ? '' : $_SESSION['access']['user'];
	}
	function user()
	{
		return empty($_SESSION['access']['account']) ? '' : $_SESSION['access']['user_access'];
	}
	function has_user_avatar($user_id = '', $noencript = false)
	{
		if($user_id == '') $user_id = user();
		$avatar = $noencript ? $user_id : md5($user_id);
		return file_exists("images/avatars/avatar_$avatar.jpg");
	}
	function user_avatar($user_id = '')
	{
		if($user_id == '') $user_id = user();

		$user_account = md5($user_id);
		$partial_path = "images/avatars/avatar_$user_account.jpg";
		return file_exists($partial_path) ?  base_url()."/$partial_path?v=".date("Ymd") : '';
	}
	function has_account_avatar($user_account)
	{
		return file_exists("images/avatars/avatar_$user_account.jpg");
	}
	function account_avatar($user_account)
	{
		$partial_path = "images/avatars/avatar_$user_account.jpg";
		return file_exists($partial_path) ?  base_url()."/$partial_path?v=".date("Ymd") : '';
	}
