<?php

class Auth_client_api {

	private static $auth_domain='https://auth.006.spb.ru';

	public static $domain = '';
	public static $hash = '';
	public static $user = array();
	
	public static $client_auth_link;
	public static $client_change_data;

	public function __construct() {
		self::$domain = $_SERVER['SERVER_NAME'];
		self::$hash = isset($_COOKIE['v6_auth']) ? $_COOKIE['v6_auth'] : '';
		//авторизация через get параметр
		if(isset($_GET['u_hash']) && $_GET['hash_auth']==md5(date('Y-m-d'))){
			self::$hash=$_GET['u_hash'];
		}
		self::$user = self::get_user();
		self::$client_auth_link=self::$auth_domain.'/?type=form&action=login&domain='.self::get_protocol().$_SERVER['SERVER_NAME'];
		self::$client_change_data=self::$auth_domain.'/?type=form&action=change_ava&hash='.self::$hash.'&domain='.self::get_protocol().$_SERVER['SERVER_NAME'];
	}
	
	private function get_protocol(){
		return (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === "on") ? 'https://' : 'http://';
	}

	private static function CurlInit($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$data = curl_exec($ch);
		return $data;
	}
	
	public static function get_users($array_id){
		$url = self::$auth_domain.'/?type=user&action=get_users&ids=' . implode($array_id,',');	
		$data = self::CurlInit($url);
		if($data){
			return json_decode($data);
		}
		return false;
	}

	public static function getAllUsers() {

		$url = self::$auth_domain.'/?type=user&action=get_all&domain=' . self::$domain;
		$data = self::CurlInit($url);
		if (trim($data) == 'no users') {
			return false;
		} else {
			return json_decode($data, true);
		}
	}

	public static function get_user_by_id($id) {
		$users = self::getAllUsers();
		for ($i = 0; $i < count($users); $i++) {
			if ($users[$i]['id'] == $id) {
				return $users[$i];
			}
		}
		return false;
	}

	public static function get_user() {

		if (trim(self::$hash) != '') {
			$url = self::$auth_domain.'/?type=user&action=get&hash=' . self::$hash;
			$data = self::CurlInit($url);
			
			if (trim($data) == 'auth error or bad hash') {
				return false;
			} else {
				return json_decode($data, true);
			}
		}
		return false;
	}

	public static function getProfile() {
		$url = self::$auth_domain.'/?type=form&action=profile';
		$data = self::CurlInit($url);
		if (trim($data) == '') {
			return false;
		} else {
			return $data;
		}
	}

	public function getLogin() {
		$url = self::$auth_domain.'/?type=form&action=login&domain=' . self::$domain;
		$data = $this->CurlInit($url);
		return $data;
	}

}

if(isset($_REQUEST['p_action'])){
	
	if($_REQUEST['p_action']=='fill_new_data'){
		//вызов пользовательского скрипта
		echo '<html><head></head><body><script>if(parent.$.fancybox!=undefined){parent.$.fancybox.close();}if(parent.$("#myModalLcEdit").modal!=undefined){parent.$("#myModalLcEdit").modal("hide");}parent.profile_data_update();window.close();</script></body></html>';	
	}
	
		
	if($_REQUEST['p_action']=='user_data'){
		//обновленные данные пользователя
		new Auth_client_api();
		echo json_encode(Auth_client_api::get_user());
	}
	
}else{
		
	if(isset($_GET['window_close'])){
		echo '<html><head></head><body><script>parent.$.fancybox.close();parent.location.reload();window.close();</script></body></html>';	
	}
	else if(isset($_GET['update_user_data'])){
		echo '<html><head></head><body><script>parent.$.fancybox.close();parent.profile_data_update();window.close();</script></body></html>';		
	}
	else{

		if (isset($_GET['cookie']) && trim($_GET['cookie']) != '') {
			setcookie('v6_auth', $_GET['cookie'], time() + (86400 * 3000), "/");
			echo '<html><head></head><body><script>if(parent.$.fancybox!=undefined){parent.$.fancybox.close();}parent.location.reload();window.close();</script></body></html>';
		} else {
			new Auth_client_api(); // для инициализации статичных переменных класса
		}

	}
	
}