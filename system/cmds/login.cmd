<?
if($tmp[0] == $switch){
	if(empty($_SESSION['tmpusr'])){
		if(!empty($tmp[1])){
			$do_usertag = false;
			$json['resp'] = '['.$tmp[1].' @ '.$_SESSION['cd'].'] Enter the password:';
			//$json['ignoreHist'] = true;
			$json['doPass'] = true;
			$_SESSION['cmd'] = 'login';
			$_SESSION['temp'] = $tmp[1];
		} else {
			$json['resp'] = 'What? Login as who?';
		}
	} else {
		$json['resp'] = 'Already logged in. Logout to login as a different user.';
	}
} else {
	if($tmp[0] == 'let_me_in!'){
		$_SESSION['tmpusr'] = $_SESSION['usr'];
		$_SESSION['usr'] = $_SESSION['temp'];
		unset($_SESSION['temp']);
		$json['resp'] = 'Password ok. Logged in as "'.$_SESSION['usr'].'"';
	} else {
		$json['resp'] = 'Invalid password.';
	}
}
?>