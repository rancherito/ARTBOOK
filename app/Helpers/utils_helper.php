<?php
	function movil() { return '600px'; }
	function tablet() { return '992px'; }
	function desktop() { return '1200px'; }
    if (! function_exists('get_image')){
        function get_image(string $ruta): string
        {
            return base_url().'/assets/images/'.$ruta;
        }

    }
	function get_ciclo()
	{
		return isset($_SESSION['cepre_admin']['user']['ciclo']) ? $_SESSION['cepre_admin']['user']['ciclo'] : 'null';
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
	function bg_animate_001()
	{
		return '<div class="bg_animate_001" >
			<ul class="circles">
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
				<li></li>
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
