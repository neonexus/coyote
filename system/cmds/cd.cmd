<?
$user = strtolower($_SESSION['usr']);
if(empty($tmp[1])){
	$do_usertag = false;
	$json['resp'] = '['.$_SESSION['usr'].' @ '.$_SESSION['cd']."] cd\n";
} else {
	$tmp[1] = str_replace('../', '', $tmp[1], $cnt);
	$tmp[1] = str_replace('./', '', $tmp[1]);
	if($tmp[1] != '/' && !empty($tmp[1]))
		$tmp[1] = preg_replace('@(?:[\/\.]*)([a-z0-9_\-\/]+)/?@', '$1', $tmp[1]);
	else
		$tmp[1] = '/';
	
	if($cnt == 0 && $tmp[1] != '/')
		$_SESSION['cd'] .= $tmp[1].'/';
	else if($tmp[1] != '/')
		$_SESSION['cd'] = '/'.$tmp[1].'/';
	else
		$_SESSION['cd'] = '/';
	// display proper current directory listing
	if($_SESSION['usr'] == 'NeoNexus'){
		if($_SESSION['cd'] == '/'){
			$dir = '../';
		} else {
			$dir = '..'.$_SESSION['cd'];
		}
	} else {
		if($_SESSION['cd'] == '/'){
			$dir = '../user/'.$user.'/';
		} else {
			$dir = '../user/'.$user.$_SESSION['cd'];
		}
	}
	if(!is_dir($dir)){
		$json['resp'] = $_POST['cmd']."\n";
		$json['resp'] .= 'Directory "'.$_SESSION['cd'].'" does not exist.';
		$_SESSION['cd'] = '/';
	} else {	
		$json['resp'] = $_POST['cmd'];
	}
}
?>