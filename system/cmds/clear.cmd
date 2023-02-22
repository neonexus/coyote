<?
$_SESSION['cd'] = '/';
$_SESSION['expcd'] = '/';
$_SESSION['exp_dirs'] = '';
$_SESSION['exp_last'] = 0;
if(!empty($_SESSION['tmpusr'])){
	$_SESSION['usr'] = $_SESSION['tmpusr'];
	unset($_SESSION['tmpusr']);
	$json['resp'] = 'Logged out.';
} else {
	$json['resp'] = 'Wasn\'t logged in as anyone else...';
}
?>