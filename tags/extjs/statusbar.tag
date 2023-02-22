<?
## statusbar ##
## autoClear = ##
## busyIconCls = ##
## busyText = ##
## defaultIconCls = ##
## defaultText = ##
## iconCls = ##
## statusAlign = left ##
## text = ##

$output = '';

if(empty($attribs['RENDERTO']))
	$flag = true;
else
	$flag = false;

//require(CoyoteProcessor::$inc_dir.'ext_nesting.php');

if(!empty($attribs['AUTOCLEAR'])){ $output .= 'autoClear:'.$attribs['AUTOCLEAR'].','; }
if(!empty($attribs['BUSYICONCLS'])){ $output .= 'busyIconCls:\''.$attribs['BUSYICONCLS'].'\','; }
if(!empty($attribs['BUSYTEXT'])){ $output .= 'busyText:\''.$attribs['BUSYTEXT'].'\','; }
if(!empty($attribs['DEFAULTICONCLS'])){ $output .= 'defaultIconCls:\''.$attribs['DEFAULTICONCLS'].'\','; }
if(!empty($attribs['DEFAULTTEXT'])){ $output .= 'defaultText:\''.$attribs['DEFAULTTEXT'].'\','; }
if(!empty($attribs['ICONCLS'])){ $output .= 'iconCls:\''.$attribs['ICONCLS'].'\','; }
if($attribs['STATUSALIGN'] != 'left'){ $output .= 'statusAlign:\'right\','; }
if(!empty($attribs['TEXT'])){ $output .= 'text:\''.$attribs['TEXT'].'\','; }

if($flag)
	$attribs['RENDERTO'] = '';

$output .= CoyoteProcessor::$ext->run_boxComponent($attribs);

if(!empty($innerHTML)){
	$tmp = substr($innerHTML, 0, 1);
	if($tmp == '{'){
		$innerHTML = str_replace('}{', '},{', $innerHTML);
		$output .= 'items:['.$innerHTML.']';
	} else {
		$output .= $innerHTML;
	}
}

CoyoteProcessor::$ext->nest('StatusBar', '', $output, $parent, $attribs);
?>