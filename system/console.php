<?
# console

session_start();
session_regenerate_id(true);

header("Expires: Sat, 05 Jul 1986 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

function __autoload($which){
	// This function insures we only load the classes we need
	if($which == 'Services_JSON')
		require_once('../json/JSON.php');
	if($which == 'CoyoteProcessor')
		require_once('coyote.php');
	if($which == 'CoyoteParser')
		require_once('parser.php');
	if($which == 'CoyoteExt')
		require_once('ext.php');
}

require_once('security.php');

if(!isset($_SESSION['cd'])){
	$_SESSION['cd'] = '/';
	$_SESSION['expcd'] = '/';
	$_SESSION['usr'] = 'NeoNexus';
}

// Future-friendly json_encode
if( !function_exists('json_encode') ) {
    function json_encode($data) {
        $json = new Services_JSON();
        return( $json->encode($data) );
    }
}

// Future-friendly json_decode
if( !function_exists('json_decode') ) {
    function json_decode($data) {
        $json = new Services_JSON();
        return( $json->decode($data) );
    }
}

$myArt .= '   ___                  _           ___                      _'."\n";
$myArt .= '  / __\___  _   _  ___ | |_ ___    / __\___  _ __  ___  ___ | | ___ '."\n";
$myArt .= ' / /  / _ \| | | |/ _ \| __/ _ \  / /  / _ \| \'_ \/ __|/ _ \| |/ _ \\'."\n";
$myArt .= '/ /__| (_) | |_| | (_) | ||  __/ / /__| (_) | | | \__ \ (_) | |  __/'."\n";
$myArt .= '\____/\___/ \__, |\___/ \__\___| \____/\___/|_| |_|___/\___/|_|\___|'."\n";
$myArt .= '            |___/'."\n";

//$myArt = addslashes($myArt);

if(!empty($_GET['cmd']) && empty($_POST['cmd']))
	$cmd = $_GET['cmd'];
else
	$cmd = $_POST['cmd'];

// let's get our data, decrypt it, and translate it
$c = decrypt($_POST['c'], $_SESSION['ckey1']);
$code = preg_replace(array('/^\((.*?)\)$/','/([a-z]+)\:/i'), array('$1','"$1":'), $c);
$c = json_decode($code);

if($c->s != $_SESSION['ckey1'] || $c->r != $_SESSION['ckey2']){
	die('Hacking attempt detected!!! You\'ve been logged.');
}

if(empty($cmd))
	$cmd = $c->cmd;

if(!empty($cmd)){
	$do_usertag = true;
	$json = array();
	$tmp = explode(' ', $cmd);
	if(!empty($_SESSION['cmd'])){
		$switch = $_SESSION['cmd'];
		unset($_SESSION['cmd']);
	}
	if(empty($switch))
		$switch = $tmp[0];
	if(file_exists('cmds/'.$switch.'.cmd')){
		require('cmds/'.$switch.'.cmd');
	} else {
		$json['resp'] = 'What do you mean "'.$tmp[0].'"? I don\'t understand that command!';
		unset($_SESSION['cmd']);
	}
	if(!isset($json['success']))
		$json['success'] = true;
	if($do_usertag && $json['success'])
		$json['resp'] = '['.$_SESSION['usr'].' @ '.$_SESSION['cd'].'] '.$json['resp'];
	if(get_magic_quotes_gpc() && is_string($json['resp'])){
		$json['resp'] = stripslashes($json['resp']);
	}
	$tmpk = $_SESSION['ckey2'];
	$_SESSION['ckey1'] = MD5(MD5(time()));
	$_SESSION['ckey2'] = MD5(time().$_SESSION['ckey1']);
	$json['a'] = $_SESSION['ckey1'];
	$json['b'] = $_SESSION['ckey2'];
	$json = json_encode($json);
	$json = encrypt($json, $tmpk);
	echo json_encode(array('json'=>$json));
} else {
	echo json_encode(array('resp'=>'Oh balls. Something went wrong...','success'=>false));
}
?>