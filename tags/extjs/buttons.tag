<?
## buttons ##

$innerHTML = str_replace('}{', '},{', $innerHTML);

CoyoteProcessor::$ext->buttons = '['.$innerHTML.']';
?>
