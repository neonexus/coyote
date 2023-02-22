<?
## item ##
## var = ##

$output = '';

if(!empty($attribs['VAR'])){
	$output .= 'var '.$attribs['VAR'].'=';
	$output .= $innerHTML;
	CoyoteProcessor::$ext->script($output);
}
?>