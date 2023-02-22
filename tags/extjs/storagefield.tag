<?
## storageField ##

$output = '{';
if(!empty($attribs['NAME'])){ $output .= 'name:\''.$attribs['NAME'].'\','; }
if(!empty($attribs['TYPE'])){ $output .= 'type:\''.$attribs['TYPE'].'\','; }
if(!empty($attribs['DATEFORMAT'])){ $output .= 'dateFormat:\''.$attribs['DATEFORMAT'].'\','; }
$output .= '}';
echo $output;
?>