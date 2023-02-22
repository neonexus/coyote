<?
## hidden ##

$output = '';

//require(CoyoteProcessor::$inc_dir.'ext_nesting.php');
CoyoteProcessor::$ext->startNest($attribs);

$output .= CoyoteProcessor::$ext->run_field($attribs);

CoyoteProcessor::$ext->nest('Hidden', 'form.Hidden', $output, $parent, $attribs);
?>