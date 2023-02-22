<?
$user = strtolower($_SESSION['usr']);
if($user == 'neonexus'){
	$dir = '..';
} else {
	$dir = '../user/'.$user;
}
//$_POST['val'] = mysql_real_escape_string($_POST['val']);
//$_POST['name'] = mysql_real_escape_string($_POST['name']);
if(!empty($_POST['val']) && !empty($_POST['name'])){
	if(get_magic_quotes_gpc()){
		$_POST['val'] = stripslashes($_POST['val']);
	}
	if(file_put_contents($dir.$_POST['name'], $_POST['val'], LOCK_EX)){
		$json['resp'] = 'File "'.$_POST['name'].'" was saved successfuly!';
	} else {
		$json['success'] = false;
		$json['resp'] = 'The file "'.$_POST['name'].'" could not be saved.<br/>Please try again.';
	}
} else {
	$json['resp'] = 'Did not understand the "nano_save" request...';
}
?>