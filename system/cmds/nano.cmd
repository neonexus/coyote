<?
$user = strtolower($_SESSION['usr']);
if($user == 'neonexus'){
	$dir = '..';
} else {
	$dir = '../user/'.$user;
}
if(file_exists($dir.$_SESSION['cd'].$tmp[1])){
	$json['run'] = 'nano';
	$json['nano'] = file_get_contents($dir.$_SESSION['cd'].$tmp[1]);
	//$json['nano'] = htmlentities($json['nano']);
	$json['nano_name'] = $_SESSION['cd'].$tmp[1];
	$json['resp'] = 'nano '.$tmp[1];
	$temp = '';
	$temp = (strpos($tmp[1], '.php')) ? 'php' : '';
	if(empty($temp))
		$temp = (strpos($tmp[1], '.tag')) ? 'php' : '';
	if(empty($temp))
		$temp = (strpos($tmp[1], '.cmd')) ? 'php' : '';
	if(empty($temp))
		$temp = (strpos($tmp[1], '.js')) ? 'javascript' : '';
	if(empty($temp))
		$temp = (strpos($tmp[1], '.app')) ? 'xml' : '';
	if(empty($temp))
		$temp = 'xml';
	$json['nanoLan'] = $temp;
} else {
	$json['resp'] = 'Could not find the file "'.$tmp[1].'"!';
}
?>