<?
if(!empty($_SESSION['tmpusr'])){
	$_SESSION['usr'] = $_SESSION['tmpusr'];
	unset($_SESSION['tmpusr']);
	$json['resp'] = 'Logged out.';
} else {
	$json['resp'] = 'Wasn\'t logged in as anyone else...';
}
?>