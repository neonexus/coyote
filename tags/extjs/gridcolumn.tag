<?
## gridColumn ##
## sortable = true ##

$output = '{';

if(!empty($attribs['ALIGN'])){ $output .= 'align:\''.$attribs['ALIGN'].'\','; }
if(!empty($attribs['CSS'])){ $output .= 'css:\''.$attribs['CSS'].'\','; }
if(!empty($attribs['DATAINDEX'])){ $output .= 'dataIndex:\''.$attribs['DATAINDEX'].'\','; }
if(!empty($attribs['EDITOR'])){ $output .= 'editor:'.$attribs['EDITOR'].','; }
if(!empty($attribs['FIXED'])){ $output .= 'fixed:'.$attribs['FIXED'].','; }
if(!empty($attribs['HEADER'])){ $output .= 'header:\''.$attribs['HEADER'].'\','; }
if(!empty($attribs['HIDDEN'])){ $output .= 'hidden:'.$attribs['HIDDEN'].','; }
if(!empty($attribs['HIDEABLE'])){ $output .= 'hideable:'.$attribs['HIDEABLE'].','; }
if(!empty($attribs['ID'])){ $output .= 'id:\''.$attribs['ID'].'\','; }
if(!empty($attribs['MENUDISABLED'])){ $output .= 'menuDisabled:'.$attribs['MENUDISABLED'].','; }
if(!empty($attribs['RENDERER'])){ $output .= 'renderer:'.$attribs['RENDERER'].','; }
if(!empty($attribs['RESIZABLE'])){ $output .= 'resizable:'.$attribs['RESIZABLE'].','; }
if(!empty($attribs['SORTABLE'])){ $output .= 'sortable:'.$attribs['SORTABLE'].','; }
if(!empty($attribs['TOOLTIP'])){ $output .= 'tooltip:\''.$attribs['TOOLTIP'].'\','; }
if(!empty($attribs['WIDTH'])){ $output .= 'width:'.$attribs['WIDTH'].','; }

$output .= '}';

echo $output;

?>