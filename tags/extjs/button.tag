<?
## button ##
## alias: submit ##
## alias: reset ##
## var = ##
## allowDepress = true ##
## clickEvent = ##
## enableToggle = false ##
## handleMouseEvents = true ##
## handler = ##
## icon = ##
## iconCls = ##
## menu = ##
## menuAlign = ##
## minWidth = ##
## pressed = false ##
## repeat = ##
## scope = ##
## tabIndex = ##
## text = ##
## toggleGroup = ##
## toggleHandler = ##
## tooltip = ##

$output = '';	

//require(CoyoteProcessor::$inc_dir.'ext_nesting.php');
CoyoteProcessor::$ext->startNest($attribs);

if(!empty($attribs['HANDLER'])){ $attribs['HANDLER'] = 'function(){'.$attribs['HANDLER'].'}'; }

if($attribs['ALLOWDEPRESS'] != 'true'){ $output .= 'allowDepress:false,'; }
if(!empty($attribs['CLICKEVENT'])){ $output .= 'clickEvent:\''.$attribs['CLICKEVENT'].'\','; }
if($attribs['ENABLETOGGLE'] != 'false'){ $output .= 'enableToggle:true,'; }
if($attribs['HANDLEMOUSEEVENTS'] != 'true'){ $output .= 'handleMouseEvents:false,'; }
if(!empty($attribs['HANDLER'])){ $output .= 'handler:'.$attribs['HANDLER'].','; }
if(!empty($attribs['ICON'])){ $output .= 'icon:\''.$attribs['ICON'].'\','; }
if(!empty($attribs['ICONCLS'])){ $output .= 'iconCls:\''.$attribs['ICONCLS'].'\','; }
if(!empty($attribs['MENU'])){ $output .= 'menu:'.$attribs['MENU'].','; }
if(!empty($attribs['MENUALIGN'])){ $output .= 'menuAlign:\''.$attribs['MENUALIGN'].'\','; }
if(!empty($attribs['MINWIDTH'])){ $output .= 'minWidth:'.$attribs['MINWIDTH'].','; }
if($attribs['PRESSED'] != 'false'){ $output .= 'pressed:true,'; }
if(!empty($attribs['REPEAT'])){ $output .= 'repeat:'.$attribs['REPEAT'].','; }
if(!empty($attribs['SCOPE'])){ $output .= 'scope:'.$attribs['SCOPE'].','; }
if(!empty($attribs['TABINDEX'])){ $output .= 'tabIndex:'.$attribs['TABINDEX'].','; }
if(!empty($attribs['TEXT'])){ $output .= 'text:\''.$attribs['TEXT'].'\','; }
if(!empty($attribs['TOGGLEGROUP'])){ $output .= 'toggleGroup:\''.$attribs['TOGGLEGROUP'].'\','; }
if(!empty($attribs['TOGGLEHANDLER'])){ $output .= 'toggleHandler:'.$attribs['TOGGLEHANDLER'].','; }
if(!empty($attribs['TOOLTIP'])){ $output .= 'tooltip:\''.$attribs['TOOLTIP'].'\','; }
$tag_name = strtolower($tag_name);
if($tag_name != 'button'){ $output .= 'type:\''.$tag_name.'\','; }

$output .= CoyoteProcessor::$ext->run_component($attribs);

CoyoteProcessor::$ext->nest('Button', '', $output, $parent, $attribs);
?>