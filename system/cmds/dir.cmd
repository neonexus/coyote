<?
$user = strtolower($_SESSION['usr']);
$do_usertag = false;
$json['resp'] = '['.$_SESSION['usr'].' @ '.$_SESSION['cd']."] dir\n";
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
$i = 0;
if($handle = @opendir($dir)){
	while(false !== ($file = readdir($handle))){
		if($file != '.' && $file != '..' && is_file($dir.$file)){
			//$json['resp'] .= '[FILE] '.$file."\n";
			$files[] = $file;
			++$i;
		} else if($file != '.' && $file != '..' && is_dir($dir.$file.'/')){
			//$json['resp'] .= '[ DIR] '.$file."\n";
			$dirs[] = $file;
			++$i;
		}
	}
	closedir($handle);
	@sort($files);
	@sort($dirs);
	$cnt = count($dirs);
	for($i=0; $i<$cnt; ++$i){
		$json['resp'] .= '[ DIR] '.$dirs[$i]."\n";
	}
	$cnt = count($files);
	for($i=0; $i<$cnt; ++$i){
		$json['resp'] .= '[FILE] '.$files[$i]."\n";
	}
} else {
	$json['success'] = false;
	$json['resp'] = 'Could not open folder ('.$_SESSION['cd'].').';
	++$i;
}
if($i == 0)
	$json['resp'] .= 'This directory is empty.';
?>