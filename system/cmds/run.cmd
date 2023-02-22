<?
$file = 'apps/'.$tmp[1].'.app';
if(file_exists('../'.$file)){
	//$json['app'] = trim(file_get_contents('http://localhost/coyote/system/?file='.$file.'&json=true'));
	$json['app'] = file_get_contents('../'.$file);
	
	//require('coyote.php');
	$Coyote = new CoyoteProcessor;
	$_GET['json'] = true;
	$json['app'] = $Coyote->process($json['app'], 'data', 'return');
	unset($Coyote);
	$json['run'] = 'app';
	$json['resp'] = 'run '.$tmp[1];
} else {
	$json['resp'] = 'Could not find the application \''.$tmp[1].'\'';
	$json['success'] = false;
}
if(strpos($json['app'], '<strong>ERROR:</strong>') !== false){
	$json['success'] = false;
	$json['app'] = explode('<strong>ERROR:</strong> ', $json['app']);
	$json['resp'] = $json['app'][1];
	unset($json['app']);
}
?>