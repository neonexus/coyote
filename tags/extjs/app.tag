<?
## app ##
## iconCls = bogus ##
## layout = fit ##
## maximizable = true ##
## resizable = true ##
## modal = false ##
## plain = false ##
## border = false ##
// defaults = {autoHeight:true}

if(!empty($attribs['ID']) && !empty($attribs['NAME'])){
	if(empty($attribs['TITLE']))
		$attribs['TITLE'] = $attribs['NAME'];

if(!empty(CoyoteProcessor::$ext->content_id) && empty($attribs['CONTENT']))
	$attribs['CONTENT'] = CoyoteProcessor::$ext->content_id;
	
	$output = <<<ENDIT
app_{$attribs['NAME']}=Ext.extend(Ext.app.Module,{id:'{$attribs['ID']}',init:function(){this.launcher={text:'{$attribs['TITLE']}',iconCls:'{$attribs['ICONCLS']}',handler:this.createWindow,scope:this}},createWindow:function(){var desktop = this.app.getDesktop();var win=desktop.getWindow('{$attribs['ID']}');if(!win){win=desktop.createWindow({
ENDIT;

	$attribs['ANIMCOLLAPSE'] = 'false';
	$attribs['SHIM'] = 'false';

	$output .= 'constrainHeader:true,';
	if(!empty($attribs['DEFAULTBUTTON'])){ $output .= 'defaultButton:'.$attribs['DEFAULTBUTTON'].','; }
	if(!empty($attribs['ELEMENTS'])){ $output .= 'elements:\''.$attribs['ELEMENTS'].'\','; }
	if($attribs['MAXIMIZABLE'] == 'true'){ $output .= 'maximizable:true,'; }
	if(!empty($attribs['MINHEIGHT'])){ $output .= 'minHeight:'.$attribs['MINHEIGHT'].','; }
	if(!empty($attribs['MINWIDTH'])){ $output .= 'minWidth:'.$attribs['MINWIDTH'].','; }
	if($attribs['MODAL'] != 'false'){ $output .= 'modal:true,'; }
	if($attribs['PLAIN'] != 'false'){ $output .= 'plain:true,'; }
	if($attribs['RESIZABLE'] != 'true'){ $output .= 'resizable:false,'; }
	if(!empty($attribs['RESIZEHANDLES'])){ $output .= 'resizeHandles:\''.$attribs['RESIZEHANDLES'].'\','; }
	
	$output .= CoyoteProcessor::$ext->run_panel($attribs);
	
	if(!empty($innerHTML)){
		$tmp = substr($innerHTML, 0, 1);
		if($tmp == '{'){
			$innerHTML = str_replace('}{', '},{', $innerHTML);
			$output .= 'items:['.$innerHTML.']';
		} else {
			$output .= $innerHTML;
		}
	}
	
	$output .= '});}win.show();}});';
	
	CoyoteProcessor::$ext->script($output);
	
	CoyoteProcessor::$ext->app($attribs['NAME']);
	unset($tmp, $output);
}
?>