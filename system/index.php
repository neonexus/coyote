<?
# /coyote/system/index.php
# This file runs the Coyote processor

header("Expires: Sat, 05 Jul 1986 06:00:00 GMT");
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

require_once('coyote.php');
$Coyote = &new CoyoteProcessor;
$start = $Coyote->getMicroTime();

if(empty($_GET['file']))
	$file = 'desktop';
else
	$file = $_GET['file'];
	
//$file = file_get_contents('../'.$Coyote->safe_filename($file));
if(isset($_GET['run'])){
	$Coyote->run_cache($Coyote->safe_filename($_GET['run']));
} else {
	session_start();
	session_regenerate_id(true);
	if($file != 'index' && $file != 'desktop' && $file != 'orders'){
		$Coyote->add_filter('extincludes', 'desktop', 'desktop2');
	}
	$Coyote->process($file, 'file', 'echo');
	echo "\n".'<!-- Time:       '.($Coyote->getMicroTime() - $start).' -->'."\n";
	echo '<!-- Memory:     '.memory_get_usage().' -->'."\n";
	echo '<!-- Peak Memory:'.memory_get_peak_usage().' -->';
}
?>