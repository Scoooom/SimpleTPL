<?php
$a = new Discord2\Discord();

if (isset($_POST['loginkey'])) {
  setCookie("returnURL",$_POST['returnURL']);
  redirect($a->url());
} elseif (isset($_REQUEST['logoutkey'])) {
	\Discord2\User::destroyCookie();
	redirect("/index.html");
} else if (isset($_GET['code'])) {
	$a->init();
	$userData = json_decode($a->raw);
	logMsg(print_r($userData,1));
	$user =  \Discord2\Discord::get_user($userData->access_token)['data'];
	logMsg(print_r($user,1));
	$failed = empty($user['username']);
	if ($failed) {
        $ERR = '<div class="alert alert-danger" role="alert">Internal Error. Please try again.</div>';
		\Discord2\User::destroyCookie();
		include("loginPage.php");
		logMsg("Fetch Data Failed.....username is null");
		
	} else {
		logMsg((print_r($userData,1)).code(print_r($user,1)));
		
		try {
			$userObj = \Users\Users::LoadBy(["username"=>$user['username']])[0];//, $users->user_id, $users->avatar_id);
			logMsg(code(print_r($userObj,1)));
			$userObj->last_login = time();
			$userObj->avatar_id = $user['avatar'];
			$userObj->Save();
		} catch  (\Exceptions\ItemNotFound $e) {
			if (empty($user['avatar'])) {
				$user['avatar'] = 'default';
			}
			$newUser = \Users\Users::createUser($user['username'],$user['id'],$user['avatar']);
			logMsg($str);
		}
		
		$cookie = [$userData->access_token,$user['username']];
		\Discord2\Discord::setCookie($cookie);
		$return = $_COOKIE['returnURL'];
		unset($_COOKIE['returnURL']);
		\setcookie('returnURL', '', time() - 3600, '/'); // empty value and old timestamp
		redirect($return);
		die;
	} 
} else {
	include "loginPage.php";
}
/*
# Uncomment this for using it WITH email scope and comment line 32.
#get_user($email=True);

# Adding user to guild | (guilds.join scope)
# join_guild('SERVER_ID_HERE');

# Fetching user guild details | (guilds scope)
$_SESSION['guilds'] = get_guilds();

# Fetching user connections | (connections scope)
$_SESSION['connections'] = get_connections();

# Redirecting to home page once all data has been fetched
redirect("../index.php");
*/
