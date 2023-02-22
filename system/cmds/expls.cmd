<?
$user = strtolower($_SESSION['usr']);
$do_usertag = false;
// display proper current directory listing
if($_SESSION['usr'] == 'NeoNexus'){
	if($_SESSION['cd'] == '/'){
		$dir = '../';
	} else {
		$dir = '..'.$_SESSION['expcd'];
	}
} else {
	if($_SESSION['cd'] == '/'){
		$dir = '../user/'.$user.'/';
	} else {
		$dir = '../user/'.$user.$_SESSION['expcd'];
	}
}
if(!empty($_POST['anode'])){
	settype($_POST['anode'], 'int');
	$dir = $_SESSION['exp_dirs'][$_POST['anode']];
}
if(!empty($_SESSION['exp_last']))
	$j = $_SESSION['exp_last'];
else
	$j = 1;
$json['resp'] = array();
$files = array();
$dirs = array();
if($handle = @opendir($dir)){
	while(false !== ($file = readdir($handle))){
		if($file != '.' && $file != '..' && is_file($dir.$file)){
			$fcnt = count($files);
			$files[$fcnt]['fname'] = $file;
			$files[$fcnt]['size'] = byteConvert(filesize($dir.$file));
			$tmp = explode('.', $file);
			$files[$fcnt]['mytype'] = $tmp[count($tmp)-1];
			unset($tmp);
			$files[$fcnt]['lastmod'] = date("n/j/Y h:ia", filemtime($dir.$file));
			$files[$fcnt]['_is_leaf'] = true;
			//$files[$fcnt]['_level'] = 1;
			if(empty($_POST['anode']))
				$files[$fcnt]['_parent'] = null;
			else
				$files[$fcnt]['_parent'] = $_POST['anode'];
			$files[$fcnt]['_id'] = $j;
			++$j;
		} else if($file != '.' && $file != '..' && is_dir($dir.$file.'/')){
			$dcnt = count($dirs);
			$dirs[$dcnt]['fname'] = $file;
			//$dirs[$dcnt]['size'] = null;
			$dirs[$dcnt]['mytype'] = 'Folder';
			//$dirs[$dcnt]['lastmod'] = null;
			$dirs[$dcnt]['_is_leaf'] = false;
			//$dirs[$dcnt]['_level'] = 1;
			if(empty($_POST['anode']))
				$dirs[$dcnt]['_parent'] = null;
			else
				$dirs[$dcnt]['_parent'] = $_POST['anode'];
			$dirs[$dcnt]['_id'] = $j;
			$_SESSION['exp_dirs'][$j] = $dir.$file.'/';
			++$j;
		}
	}
	if(empty($_SESSION['exp_last']))
		$json['total'] = $j-1;
	else
		$json['total'] = ($j-1)-$_SESSION['exp_last'];
	$_SESSION['exp_last'] = $j;
	$cnt = count($dirs);
	for($i=0; $i<$cnt; ++$i){
		$json['resp'][] = $dirs[$i];
	}
	$cnt = count($files);
	for($i=0; $i<$cnt; ++$i){
		$json['resp'][] = $files[$i];
	}
} else {
	$json['success'] = false;
	$json['resp'] = 'Could not open folder ('.$_SESSION['expcd'].').';
	++$i;
}
if($json['total'] < 0){
	$json['resp'][0]['fname'] = 'This directory is empty.';
	$json['total'] = 1;
	$json['resp'][0]['_is_leaf'] = true;
	if(!empty($_POST['anode']))
		$json['resp'][0]['_parent'] = $_POST['anode'];
	else
		$json['resp'][0]['_parent'] = null;
}
	
function byteConvert($bytes){
	if ($bytes<=0)
		return '0 Bytes';
	$convention=1024; //[1000->10^x|1024->2^x]
	// in other words, use 1024 for the REAL convertion of bytes,
	// or use 1000 for the lame ass Windows calculation of bytes
	$s=array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB');
	$e=floor(log($bytes,$convention));
	return round($bytes/pow($convention,$e),2).' '.$s[$e];
}
?>