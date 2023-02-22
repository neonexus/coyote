<?
## label ##
## forId = ##
## text = ##

$output = '';

if(!empty($attribs['FORID'])){ $output .= 'forId:\''.$attribs['FORID'].'\','; }
if(!empty($innerHTML)){ $output .= 'html:"'.$innerHTML.'",'; }
if(!empty($attribs['TEXT'])){ $output .= 'text:\''.$attribs['TEXT'].'\','; }

$output .= CoyoteProcessor::$ext->run_boxComponent($attribs);

CoyoteProcessor::$ext->nest('Label', 'form.Label', $output, $parent, $attribs);
?>