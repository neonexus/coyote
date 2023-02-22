<?
## datarow ##
## alias: datacolumn ##
## alias: dr ##
## alias: dc ##

$output = '';

if($tag_name == 'DATAROW' || $tag_name == 'DR'){
	$output .= '[';
	$innerHTML = str_replace('\'\'', '\',\'', $innerHTML);
	$output .= $innerHTML;
	$output .= ']';
} else {
	$output .= '\'';
	$output .= $innerHTML;
	$output .= '\'';
}

echo $output;

?>