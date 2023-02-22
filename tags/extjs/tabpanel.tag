<?
## tabpanel ##
## var = ##
## activeTab = 0 ##
## animScroll = true ##
## deferredRender = false ##
## enableTabScroll = false ##
## layoutOnTabChange = false ##
## minTabWidth = ##
## plain = false ##
## resizeTabs = false ##
## scrollDuration = ##
## scrollIncrement = ##
## scrollRepeatInterval = ##
## tabMargin = ##
## tabPosition = ##
## tabWidth = ##
## wheelIncrement = ##

$output = '';

//require(CoyoteProcessor::$inc_dir.'ext_nesting.php');
CoyoteProcessor::$ext->startNest($attribs);

$output .=  'activeTab:'.$attribs['ACTIVETAB'].',';
if($attribs['ANIMSCROLL'] != 'true'){ $output .= 'animScroll:false,'; }
if($attribs['DEFERREDRENDER'] == 'false'){ $output .= 'deferredRender:false,'; }
if($attribs['ENABLETABSCROLL'] != 'false'){ $output .= 'enableTabScroll:true,'; }
if($attribs['LAYOUTONTABCHANGE'] != 'false'){ $output .= 'layoutOnTabChange:true,'; }
if(!empty($attribs['MINTABWIDTH'])){ $output .=  'minTabWidth:'.$attribs['MINTABWIDTH'].','; }
if($attribs['PLAIN'] != 'false'){ $output .=  'plain:true,'; }
if($attribs['RESIZETABS'] != 'false'){ $output .= 'resizeTabs:true,'; }
if(!empty($attribs['SCROLLDURATION'])){ $output .= 'scrollDuration:'.$attribs['SCROLLDURATION'].','; }
if(!empty($attribs['SCROLLINCREMENT'])){ $output .= 'scrollIncrement:'.$attribs['SCROLLINCREMENT'].','; }
if(!empty($attribs['SCROLLREPEATINTERVAL'])){ $output .= 'scrollRepeatInterval:'.$attribs['SCROLLREPEATINTERVAL'].','; }
if(!empty($attribs['TABMARGIN'])){ $output .= 'tabMargin:'.$attribs['TABMARGIN'].','; }
if(!empty($attribs['TABPOSITION'])){ $output .= 'tabPosition:\''.$attribs['TABPOSITION'].'\','; }
if(!empty($attribs['TABWIDTH'])){ $output .= 'tabWidth:'.$attribs['TABWIDTH'].','; }
if(!empty($attribs['WHEELINCREMENT'])){ $output .= 'wheelIncrement:'.$attribs['WHEELINCREMENT'].','; }

$output .= CoyoteProcessor::$ext->run_panel($attribs);

if(!empty($innerHTML)){
	$tmp = substr($innerHTML, 0, 1);
	if($tmp == '{'){
		$innerHTML = str_replace('}{', '},{', $innerHTML);
		$output .= 'items:['.$innerHTML.']';
	}
}

CoyoteProcessor::$ext->nest('TabPanel', '', $output, $parent, $attribs);
?>