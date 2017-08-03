<?php 
	error_reporting(E_ALL);
	require 'config.php';
	function Facebook()
	{
		
	}

	function google(){
		global $config;
		
		$id_token = $_POST['idToken'];

		require_once 'vendor/google-api-php-client/vendor/autoload.php';

		$client = new Google_Client(['client_id' => $config['gappid']]);
		
		$payload = $client->verifyIdToken($id_token);

		if ($payload) {
		  $data['openid'] =$payload['sub'];

		  $data['username'] =$payload['name'];

		  $data['head'] =$payload['picture'];

		  $user = login('google',$data);

		} else {
		  exit('Login failed');
		}
	}


	function login($type,$data){
		require_once 'include/db_class.php';

		$db = new Db_class();
		
		$db->setTable('user');
		
		$user = $db->find_all(" where logintype = '{$type}' and openid = '{$data['openid']}'");

		if(empty($user)){
			$data['logintype'] = $type;
			$db->add($data);
		}

		$user = $db->find_all(" where logintype = '{$type}' and openid = '{$data['openid']}'");

		session_start();

		$_SESSION['login'] = 1;

		$_SESSION['user'] = $user;

		exit(json_encode($user[0]));
	}

	@$_GET['a']();

?>