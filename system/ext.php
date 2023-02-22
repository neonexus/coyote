<?
// ExtJS class

if(!defined('IN_COYOTE'))
    die("Can not access this file directly!");
	
final class CoyoteExt{
	private $scripts, $blocks, $apps;
	private static $tag_vars;
	public $ext_is_defined = false;
	
	function __set($which, $what = ''){
		if(!empty($what))
			self::$tag_vars[$which] = $what;
		#else
			#unset(self::$tag_vars[$which]);
	} # End of __set()
	
	function __get($which){
		if(isset(self::$tag_vars[$which]))
			return self::$tag_vars[$which];
		else
			return null;
	} # End of __get()
	
	function __isset($which){
		if(isset(self::$tag_vars[$which]))
			return true;
		else
			return false;
	} # End of __isset()
	
	function __unset($which){
		unset(self::$tag_vars[$which]);
	} # End of __unset()
	
	function clear(){
		self::$tag_vars = "";
	} # End of clear()
	
	function script($what = '', $front = false){
		if(!empty($what)){
			if(!$front){
				if($_GET['json'] != 'true')
					$this->scripts .= "\n".$what;
				else
					$this->scripts .= $what;
			} else {
				if($_GET['json'] != 'true')
					$this->scripts = "\n".$what.$this->scripts;
				else
					$this->scripts = $what.$this->scripts;
			}
		} else {
			die('When using CoyoteExt::script($script), \'$script\' can not be empty!');
		}
	} # End of script()
	
	function block($what = '', $front = false){
		if(!empty($what)){
			if(!$front)
				$this->blocks .= $what;
			else
				$this->blocks = $what.$this->blocks;
		} else {
			die('When using CoyoteExt::block($block), \'$block\' can not be empty!');
		}
	} # End of block()
	
	function app($what = ''){
		if(!empty($what)){
			$this->apps .= (!empty($this->apps)) ? ',new app_'.$what.'()' : 'new app_'.$what.'()';
		} else {
			die('When using CoyoteExt::app($app), \'$app\' can not be empty!');
		}
	}
	
	function dump_javascript($doTags = false){
		$tmp_name = 'func_'.substr(MD5(rand(0, 100000000)), rand(0, 15), rand(1,17));
		$tmp = '';
		if($doTags)
			$tmp .= '<script type="text/javascript">';
		
		// The following insures our scripts are only allowed to run when the dom is fully loaded
		// Even if the page hasn't finished loading, our scripts can still run
		// This works for Firefox, Internet Explorer, and Safari
		// All other browsers will get a "window.onload" instruction
		// NOTE: I did not use Ext.onReady() because it is known to cause problems with large files in some browsers
		if($_GET['json'] != 'true'){
			$tmp .= <<<ENDIT
var alreadyrunflag=0;if (document.addEventListener){document.addEventListener("DOMContentLoaded",function(){alreadyrunflag=1;$tmp_name();},false);}else if(document.all&&!window.opera){document.write('<script type="text/javascript" id="contentloadtag" defer="defer" src="javascript:void(0)"><\/script>');var contentloadtag=document.getElementById("contentloadtag");contentloadtag.onreadystatechange=function(){if (this.readyState=="complete"){alreadyrunflag=1;$tmp_name();}}}else{if(/Safari/i.test(navigator.userAgent)){var _timer=setInterval(function(){if(/loaded|complete/.test(document.readyState)){clearInterval(_timer);alreadyrunflag=1;$tmp_name();}},10);}}window.onload=function(){setTimeout("if(!alreadyrunflag){ $tmp_name(); }",0);};
ENDIT;
			$tmp .= 'function '.$tmp_name.'(){';
			$tmp .= $this->scripts;
			$tmp .= '}';
		} else {
			$tmp .= $this->scripts;
		}
		if($doTags)
			$tmp .= '</script>';
		$this->scripts = '';
		return $tmp;
	} # End of dump()
	
	function dump_blocks(){
		$tmp = $this->blocks;
		$this->blocks = '';
		return $tmp;
	} # End of dump_blocks()
	
	function dump_apps(){
		$tmp = $this->apps;
		$this->apps = '';
		return $tmp;
	} # End of dump_apps()
	
	function run_editorGridPanel(&$attribs){
		$output = '';
		
		if(!empty($attribs['AUTOENCODE'])){ $output .= 'autoEncode:'.$attribs['AUTOENCODE'].','; }
		if(!empty($attribs['CLICKSTOEDIT'])){ $output .= 'clicksToEdit:'.$attribs['CLICKSTOEDIT'].','; }
		
		$output .= $this->run_gridPanel($attribs);
		return $output;
	} # End of run_editorGridPanel()
	
	function run_gridPanel(&$attribs){
		$output = '';
		
		if(!empty($attribs['AUTOEXPANDCOLUMN'])){ $output .= 'autoExpandColumn:\''.$attribs['AUTOEXPANDCOLUMN'].'\','; }
		if(!empty($attribs['AUTOEXPANDMAX'])){ $output .= 'autoExpandMax:'.$attribs['AUTOEXPANDMAX'].','; }
		if(!empty($attribs['AUTOEXPANDMIN'])){ $output .= 'autoExpandMin:'.$attribs['AUTOEXPANDMIN'].','; }
		if(!empty($attribs['COLMODEL'])){ $output .= 'colModel:'.$attribs['COLMODEL'].','; }
		if(!empty($attribs['DEFERROWRENDER'])){ $output .= 'deferRowRender:'.$attribs['DEFERROWRENDER'].','; }
		if(!empty($attribs['DISABLESELECTION'])){ $output .= 'disableSelection:'.$attribs['DISABLESELECTION'].','; }
		if(!empty($attribs['ENABLECOLUMNHIDE'])){ $output .= 'enableColumnHide:'.$attribs['ENABLECOLUMNHIDE'].','; }
		if(!empty($attribs['ENABLECOLUMNMOVE'])){ $output .= 'enableColumnMove:'.$attribs['ENABLECOLUMNMOVE'].','; }
		if(!empty($attribs['ENABLECOLUMNRESIZE'])){ $output .= 'enableColumnResize:'.$attribs['ENABLECOLUMNRESIZE'].','; }
		if(!empty($attribs['ENABLEDRAGDROP'])){ $output .= 'enableDragDrop:'.$attribs['ENABLEDRAGDROP'].','; }
		if(!empty($attribs['ENABLEHDMENU'])){ $output .= 'enableHdMenu:'.$attribs['ENABLEHDMENU'].','; }
		if(!empty($attribs['HIDEHEADERS'])){ $output .= 'hideHeaders:'.$attribs['HIDEHEADERS'].','; }
		if(!empty($attribs['LOADMASK'])){ $output .= 'loadMask:'.$attribs['LOADMASK'].','; }
		if(!empty($attribs['MAXHEIGHT'])){ $output .= 'maxHeight:'.$attribs['MAXHEIGHT'].','; }
		if(!empty($attribs['MINCOLUMNWIDTH'])){ $output .= 'minColumnWidth:'.$attribs['MINCOLUMNWIDTH'].','; }
		if(!empty($attribs['SELMODEL'])){ $output .= 'selModel:'.$attribs['SELMODEL'].','; }
		if(!empty($attribs['STORE'])){ $output .= 'store:'.$attribs['STORE'].','; }
		if(!empty($attribs['STRIPEROWS'])){ $output .= 'stripeRows:'.$attribs['STRIPEROWS'].','; }
		if(!empty($attribs['TRACKMOUSEOVER'])){ $output .= 'trackMouseOver:'.$attribs['TRACKMOUSEOVER'].','; }
		if(!empty($attribs['VIEW'])){ $output .= 'view:'.$attribs['VIEW'].','; }
		if(!empty($attribs['VIEWCONFIG'])){ $output .= 'viewConfig:'.$attribs['VIEWCONFIG'].','; }
		
		$output .= $this->run_panel($attribs);
		return $output;
	} # End of run_gridPanel()
	
	function run_panel(&$attribs){
		$output = '';
		if(!empty($attribs['ANIMCOLLAPSE'])){ $output .= 'animCollapse:'.$attribs['ANIMCOLLAPSE'].','; }
		if(!empty($attribs['APPLYTO'])){
			$attribs['APPLYTO'] = (strpos('.', $attribs['APPLYTO']) === false) ? "'".$attribs['APPLYTO']."'" : $attribs['APPLYTO'];
			$output .= 'applyTo:'.$attribs['APPLYTO'].',';
		}
		if(!empty($attribs['AUTOLOAD'])){ $output .= 'autoLoad:'.$attribs['AUTOLOAD'].','; }
		if(!empty($attribs['AUTOSCROLL'])){ $output .= 'autoScroll:'.$attribs['AUTOSCROLL'].','; }
		if(!empty($attribs['BASECLS'])){ $output .= 'baseCls:\''.$attribs['BASECLS'].'\','; }
		if(!empty($attribs['BBAR'])){ $output .= 'bbar:'.$attribs['BBAR'].','; }
		if(!empty($attribs['BODYBORDER'])){ $output .= 'bodyBorder:'.$attribs['BODYBORDER'].','; }
		if(!empty($attribs['BODYSTYLE'])){ $output .= 'bodyStyle:\''.$attribs['BODYSTYLE'].'\','; }
		if(!empty($attribs['BORDER'])){ $output .= 'border:'.$attribs['BORDER'].','; }
		if(!empty($attribs['BUTTONALIGN'])){ $output .= 'buttonAlign:\''.$attribs['BUTTONALIGN'].'\','; }
		if(!empty($attribs['BUTTONS'])){ $output .= 'buttons:'.$attribs['BUTTONS'].','; }
		if(!empty($attribs['COLLAPSED'])){ $output .= 'collapsed:'.$attribs['COLLAPSED'].','; }
		if(!empty($attribs['COLLAPSEFIRST'])){ $output .= 'collapseFirst:'.$attribs['COLLAPSEFIRST'].','; }
		if(!empty($attribs['COLLAPSIBLE'])){ $output .= 'collapsible:'.$attribs['COLLAPSIBLE'].','; }
		if(!empty($attribs['CONTENT'])){ $output .= 'contentEl:\''.$attribs['CONTENT'].'\','; }
		if(!empty($attribs['DISABLED'])){ $output .= 'disabled:'.$attribs['DISABLED'].','; }
		if(!empty($attribs['DRAGGABLE'])){ $output .= 'draggable:'.$attribs['DRAGGABLE'].','; }
		if(!empty($attribs['FRAME'])){ $output .= 'frame:'.$attribs['FRAME'].','; }
		if(!empty($attribs['HIDECOLLAPSETOOL'])){ $output .= 'hideCollapseTool:'.$attribs['HIDECOLLAPSETOOL'].','; }
		if(!empty($attribs['HTML'])){
			$attribs['HTML'] = str_replace("'", "\'", $attribs['HTML']);
			$output .= 'html:\''.$attribs['HTML'].'\',';
		}
		if(!empty($attribs['ICONCLS'])){ $output .= 'iconCls:\''.$attribs['ICONCLS'].'\','; }
		if(!empty($attribs['KEYS'])){ $output .= 'keys:'.$attribs['KEYS'].','; }
		if(!empty($attribs['MASKDISABLED'])){ $output .= 'maskDisabled:'.$attribs['MASKDISABLED'].','; }
		if(!empty($attribs['MINBUTTONWIDTH'])){ $output .= 'minButtonWidth:'.$attribs['MINBUTTONWIDTH'].','; }
		if(!empty($attribs['SHIM'])){ $output .= 'shim:'.$attribs['SHIM'].','; }
		if(!empty($attribs['TBAR'])){ $output .= 'tbar:'.$attribs['TBAR'].','; }
		
		if(!empty($attribs['TITLE'])){
			$attribs['TITLE'] = str_replace("'", "\'", $attribs['TITLE']);
			$output .= 'title:\''.$attribs['TITLE'].'\',';
		}
		
		if(!empty($attribs['TITLECOLLAPSE'])){ $output .= 'titleCollapse:'.$attribs['TITLECOLLAPSE'].','; }
		
		$output .= $this->run_container($attribs);
		return $output;
	} # End of run_panel()
	
	function run_container(&$attribs){
		$output = '';
		if(!empty($attribs['ACTIVEITEM'])){
			$output .= 'activeItem:';
			if(is_numeric($attribs['ACTIVEITEM']))
				$output .= $attribs['ACTIVEITEM'].',';
			else
				$output .= "'".$attribs['ACTIVEITEM']."',";
		}
		if(!empty($attribs['AUTODESTROY'])){ $output .= 'autoDestroy:'.$attribs['AUTODESTROY'].','; }
		if(!empty($attribs['BUFFERRESIZE'])){ $output .= 'bufferResize:'.$attribs['BUFFERRESIZE'].','; }
		if(!empty($attribs['DEFAULTTYPE'])){ $output .= 'defaultType:\''.$attribs['DEFAULTTYPE'].'\','; }
		if(!empty($attribs['DEFAULTS'])){ $output .= 'defaults:'.$attribs['DEFAULTS'].','; }
		if(!empty($attribs['HIDEBORDERS'])){ $output .= 'hideBorders:'.$attribs['HIDEBORDERS'].','; }
		if(!empty($attribs['LAYOUT'])){ $output .= 'layout:\''.$attribs['LAYOUT'].'\','; }
		if(!empty($attribs['LAYOUTCONFIG'])){ $output .= 'layoutConfig:{'.$attribs['LAYOUTCONFIG'].'},'; }
		if(!empty($attribs['MONITORRESIZE'])){ $output .= 'monitorResize:'.$attribs['MONITORRESIZE'].','; }
		
		$output .= $this->run_boxComponent($attribs);
		return $output;
	} # End of run_container()
	
	function run_boxComponent(&$attribs){
		$output = '';
		if(!empty($attribs['AUTOHEIGHT'])){ $output .= 'autoHeight:'.$attribs['AUTOHEIGHT'].','; }
		if(!empty($attribs['AUTOWIDTH'])){ $output .= 'autoWidth:'.$attribs['AUTOWIDTH'].','; }
		if(!empty($attribs['HEIGHT'])){ $output .= 'height:'.$attribs['HEIGHT'].','; }
		if(!empty($attribs['PAGEX'])){ $output .= 'pageX:'.$attribs['PAGEX'].','; }
		if(!empty($attribs['PAGEY'])){ $output .= 'pageY:'.$attribs['PAGEY'].','; }
		if(!empty($attribs['WIDTH'])){ $output .= 'width:'.$attribs['WIDTH'].','; }
		if(!empty($attribs['X'])){ $output .= 'x:'.$attribs['X'].','; }
		if(!empty($attribs['Y'])){ $output .= 'y:'.$attribs['Y'].','; }
		
		// These are not part of the boxComponent of EXTJS
		// but are provided for easier use within Coyote
		if(!empty($attribs['ANCHOR'])){ $output .= 'anchor:\''.$attribs['ANCHOR'].'\','; }
		if(!empty($attribs['REGION'])){ $output .= 'region:\''.$attribs['REGION'].'\','; }
		if(!empty($attribs['MARGINS'])){ $output .= 'margins:\''.$attribs['MARGINS'].'\','; }
		if(!empty($attribs['CMARGINS'])){ $output .= 'cmargins:\''.$attribs['CMARGINS'].'\','; }
		if(!empty($attribs['MINSIZE'])){ $output .= 'minSize:'.$attribs['MINSIZE'].','; }
		if(!empty($attribs['MAXSIZE'])){ $output .= 'maxSize:'.$attribs['MAXSIZE'].','; }
		if(!empty($attribs['COLUMNWIDTH'])){ $output .= 'columnWidth:'.$attribs['COLUMNWIDTH'].','; }
		if(!empty($attribs['ROWSPAN'])){ $output .= 'rowspan:'.$attribs['ROWSPAN'].','; }
		if(!empty($attribs['COLSPAN'])){ $output .= 'colspan:'.$attribs['COLSPAN'].','; }
		if(!empty($attribs['COLLAPSIBLESPLITTIP'])){ $output .= 'collapsibleSplitTip:\''.$attribs['COLLAPSIBLESPLITTIP'].'\','; }
		if(!empty($attribs['COLLAPSEMODE'])){ $output .= 'collapseMode:\''.$attribs['COLLAPSEMODE'].'\','; }
		if(!empty($attribs['FLOATABLE'])){ $output .= 'floatable:'.$attribs['FLOATABLE'].','; }
		if(!empty($attribs['SPLIT'])){ $output .= 'split:'.$attribs['SPLIT'].','; }
		if(!empty($attribs['SPLITTIP'])){ $output .= 'splitTip:\''.$attribs['SPLITTIP'].'\','; }
		if(!empty($attribs['USESPLITTIPS'])){ $output .= 'useSplitTips:'.$attribs['USESPLITTIPS'].','; }
		
		$output .= $this->run_component($attribs);
		return $output;
	} # End of run_boxComponent()
	
	function run_component(&$attribs){
		$output = '';
		if(!empty($attribs['ALLOWDOMMOVE'])){ $output .= 'allowDomMove:'.$attribs['ALLOWDOMMOVE'].','; }
		if(!empty($attribs['APPLYTO'])){ $output .= 'applyTo:'.$attribs['APPLYTO'].','; }
		if(!empty($attribs['AUTOSHOW'])){ $output .= 'autoShow:'.$attribs['AUTOSHOW'].','; }
		if(!empty($attribs['CLS'])){ $output .= 'cls:\''.$attribs['CLS'].'\','; }
		if(!empty($attribs['CTCLS'])){ $output .= 'ctCls:\''.$attribs['CTCLS'].'\','; }
		if(!empty($attribs['DISABLED'])){ $output .= 'disabled:'.$attribs['DISABLED'].','; }
		if(!empty($attribs['DISABLEDCLASS'])){ $output .= 'disabledClass:'.$attribs['DISABLEDCLASS'].','; }
		if(!empty($attribs['HIDDEN'])){ $output .= 'hidden:'.$attribs['HIDDEN'].','; }
		if(!empty($attribs['HIDEMODE'])){ $output .= 'hideMode:\''.$attribs['HIDEMODE'].'\','; }
		if(!empty($attribs['HIDEPARENT'])){ $output .= 'hideParent:'.$attribs['HIDEPARENT'].','; }
		if(!empty($attribs['ID'])){ $output .= 'id:\''.$attribs['ID'].'\','; }
		if(!empty($attribs['OVERCLS'])){ $output .= 'overCls:\''.$attribs['OVERCLS'].'\','; }
		if(!empty($attribs['PLUGINS'])){ $output .= 'plugins:'.$attribs['PLUGINS'].','; }
		if(!empty($attribs['RENDERTO'])){ $output .= 'renderTo:'.$attribs['RENDERTO'].','; }
		if(!empty($attribs['STYLE'])){ $output .= 'style:\''.$attribs['STYLE'].'\','; }
		if(!empty($attribs['XTYPE'])){ $output .= 'xtype:\''.$attribs['XTYPE'].'\','; }
		return $output;
	} # End of run_component()
	
	function run_field(&$attribs){
		$output = '';
		//if(empty($attribs['MSGTARGET'])){ $attribs['MSGTARGET'] = 'side'; }
		
		if(!empty($attribs['LABEL'])){ $attribs['FIELDLABEL'] = $attribs['LABEL']; }
		if(empty($attribs['FIELDLABEL']) && empty($attribs['LABELSEPARATOR'])){ $attribs['LABELSEPARATOR'] = ''; }
		
		if(!empty($attribs['AUTOCREATE'])){ $output .= 'autoCreate:'.$attribs['AUTOCREATE'].','; }
		if(!empty($attribs['CLEARCLS'])){ $output .= 'clearCls:\''.$attribs['CLEARCLS'].'\','; }
		if(!empty($attribs['FIELDCLASS'])){ $output .= 'fieldClass:\''.$attribs['FIELDCLASS'].'\','; }
		if(!empty($attribs['FIELDLABEL'])){ $output .= 'fieldLabel:\''.$attribs['FIELDLABEL'].'\','; }
		if(!empty($attribs['FOCUSCLASS'])){ $output .= 'focusClass:\''.$attribs['FOCUSCLASS'].'\','; }
		if(!empty($attribs['HIDELABEL'])){ $output .= 'hideLabel:'.$attribs['HIDELABEL'].','; }
		if(!empty($attribs['INPUTTYPE'])){ $output .= 'inputType:\''.$attribs['INPUTTYPE'].'\','; }
		if(!empty($attribs['INVALIDCLASS'])){ $output .= 'invalidClass:\''.$attribs['INVALIDCLASS'].'\','; }
		if(!empty($attribs['INVALIDTEXT'])){ $output .= 'invalidText:\''.$attribs['INVALIDTEXT'].'\','; }
		if(isset($attribs['LABELSEPARATOR'])){ $output .= 'labelSeparator:\''.$attribs['LABELSEPARATOR'].'\','; }
		if(!empty($attribs['LABELSTYLE'])){ $output .= 'labelStyle:\''.$attribs['LABELSTYLE'].'\','; }
		if(!empty($attribs['MSGFX'])){ $output .= 'msgFx:\''.$attribs['MSGFX'].'\','; }
		if(!empty($attribs['MSGTARGET'])){ $output .= 'msgTarget:\''.$attribs['MSGTARGET'].'\','; }
		if(!empty($attribs['NAME'])){ $output .= 'name:\''.$attribs['NAME'].'\','; }
		if(!empty($attribs['READONLY'])){ $output .= 'readOnly:'.$attribs['READONLY'].','; }
		if(!empty($attribs['TABINDEX'])){ $output .= 'tabIndex:'.$attribs['TABINDEX'].','; }
		if(!empty($attribs['VALIDATEONBLUR'])){ $output .= 'validateOnBlur:'.$attribs['VALIDATEONBLUR'].','; }
		if(!empty($attribs['VALIDATIONDELAY'])){ $output .= 'validationDelay:'.$attribs['VALIDATIONDELAY'].','; }
		if(!empty($attribs['VALIDATIONEVENT'])){ $output .= 'validationEvent:'.$attribs['VALIDATIONEVENT'].','; }
		if(!empty($attribs['VALUE'])){ $output .= 'value:\''.$attribs['VALUE'].'\','; }
		
		$output .= $this->run_boxComponent($attribs);
		return $output;
	} # End of run_filed()
	
	function run_textField(&$attribs){
		$output = '';
		if(!empty($attribs['ALLOWBLANK'])){ $output .= 'allowBlank:'.$attribs['ALLOWBLANK'].','; }
		if(!empty($attribs['BLANKTEXT'])){ $output .= 'blankText:\''.$attribs['BLANKTEXT'].'\','; }
		if(!empty($attribs['DISABLEKEYFILTER'])){ $output .= 'disableKeyFilter:'.$attribs['DISABLEKEYFILTER'].','; }
		if(!empty($attribs['EMPTYCLASS'])){ $output .= 'emptyClass:\''.$attribs['EMPTYCLASS'].'\','; }
		if(!empty($attribs['EMPTYTEXT'])){ $output .= 'emptyText:\''.$attribs['EMPTYTEXT'].'\','; }
		if(!empty($attribs['GROW'])){ $output .= 'grow:'.$attribs['GROW'].','; }
		if(!empty($attribs['GROWMAX'])){ $output .= 'growMax:'.$attribs['GROWMAX'].','; }
		if(!empty($attribs['GROWMIN'])){ $output .= 'growMin:'.$attribs['GROWMIN'].','; }
		if(!empty($attribs['MASKRE'])){ $output .= 'maskRe:'.$attribs['MASKRE'].','; }
		if(!empty($attribs['MAXLENGTH'])){ $output .= 'maxLength:'.$attribs['MAXLENGTH'].','; }
		if(!empty($attribs['MAXLENGTHTEXT'])){ $output .= 'maxLengthText:\''.$attribs['MAXLENGTHTEXT'].'\','; }
		if(!empty($attribs['MINLENGTH'])){ $output .= 'minLength:'.$attribs['MINLENGTH'].','; }
		if(!empty($attribs['MINLENGTHTEXT'])){ $output .= 'minLengthText:\''.$attribs['MINLENGTHTEXT'].'\','; }
		if(!empty($attribs['REGEX'])){ $output .= 'regex:'.$attribs['REGEX'].','; }
		if(!empty($attribs['REGEXTEXT'])){ $output .= 'regexText:\''.$attribs['REGEXTEXT'].'\','; }
		if(!empty($attribs['SELECTONFOCUS'])){ $output .= 'selectOnFocus:'.$attribs['SELECTONFOCUS'].','; }
		if(!empty($attribs['VTYPE'])){ $output .= 'vtype:\''.$attribs['VTYPE'].'\','; }
		if(!empty($attribs['VTYPETEXT'])){ $output .= 'vtypeText:\''.$attribs['VTYPETEXT'].'\','; }
		
		$output .= $this->run_field($attribs);
		return $output;
	} # End of run_textField()
	
	function run_triggerField(&$attribs){
		$output = '';
		if(!empty($attribs['HIDETRIGGER'])){ $output .= 'hideTrigger:'.$attribs['HIDETRIGGER'].','; }
		if(!empty($attribs['TRIGGERCLASS'])){ $output .= 'triggerClass:\''.$attribs['TRIGGERCLASS'].'\','; }
		
		$output .= $this->run_textField($attribs);
		return $output;
	} # End of run_triggerField()
	
	function run_comboBox(&$attribs){
		$output = '';
		
		if(!empty($attribs['ALLQUERY'])){ $output .= 'allQuery:\''.$attribs['ALLQUERY'].'\','; }
		if(!empty($attribs['DISPLAYFIELD'])){ $output .= 'displayField:\''.$attribs['DISPLAYFIELD'].'\','; }
		if(!empty($attribs['EDITABLE'])){ $output .= 'editable:'.$attribs['EDITABLE'].','; }
		if(!empty($attribs['FORCESELECTION'])){ $output .= 'forceSelection:'.$attribs['FORCESELECTION'].','; }
		if(!empty($attribs['HANDLEHEIGHT'])){ $output .= 'handleHeight:'.$attribs['HANDLEHEIGHT'].','; }
		if(!empty($attribs['HIDDENID'])){ $output .= 'hiddenId:\''.$attribs['HIDDENID'].'\','; }
		if(!empty($attribs['HIDDENNAME'])){ $output .= 'hiddenName:\''.$attribs['HIDDENNAME'].'\','; }
		if(!empty($attribs['ITEMSELECTOR'])){ $output .= 'itemSelector:\''.$attribs['ITEMSELECTOR'].'\','; }
		if(!empty($attribs['LAZYINIT'])){ $output .= 'lazyInit:'.$attribs['LAZYINIT'].','; }
		if(!empty($attribs['LAZYRENDER'])){ $output .= 'lazyRender:'.$attribs['LAZYRENDER'].','; }
		if(!empty($attribs['LISTALIGN'])){ $output .= 'listAlign:\''.$attribs['LISTALIGN'].'\','; }
		if(!empty($attribs['LISTCLASS'])){ $output .= 'listClass:\''.$attribs['LISTCLASS'].'\','; }
		if(!empty($attribs['LISTWIDTH'])){ $output .= 'listWidth:'.$attribs['LISTWIDTH'].','; }
		if(!empty($attribs['LOADINGTEXT'])){ $output .= 'loadingText:\''.$attribs['LOADINGTEXT'].'\','; }
		if(!empty($attribs['MAXHEIGHT'])){ $output .= 'maxHeight:'.$attribs['MAXHEIGHT'].','; }
		if(!empty($attribs['MINCHARS'])){ $output .= 'minChars:'.$attribs['MINCHARS'].','; }
		if(!empty($attribs['MINHEIGHT'])){ $output .= 'minHeight:'.$attribs['MINHEIGHT'].','; }
		if(!empty($attribs['MINLISTWIDTH'])){ $output .= 'minListWidth:'.$attribs['MINLISTWIDTH'].','; }
		if(!empty($attribs['MODE'])){ $output .= 'mode:\''.$attribs['MODE'].'\','; }
		if(!empty($attribs['PAGESIZE'])){ $output .= 'pageSize:'.$attribs['PAGESIZE'].','; }
		if(!empty($attribs['QUERYDELAY'])){ $output .= 'queryDelay:'.$attribs['QUERYDELAY'].','; }
		if(!empty($attribs['QUERYPARAM'])){ $output .= 'queryParam:\''.$attribs['QUERYPARAM'].'\','; }
		if(!empty($attribs['RESIZABLE'])){ $output .= 'resizable:'.$attribs['RESIZABLE'].','; }
		if(!empty($attribs['SELECTONFOCUS'])){ $output .= 'selectOnFocus:'.$attribs['SELECTONFOCUS'].','; }
		if(!empty($attribs['SELECTEDCLASS'])){ $output .= 'selectedClass:\''.$attribs['SELECTEDCLASS'].'\','; }
		if(!empty($attribs['SHADOW'])){ $output .= 'shadow:'.$attribs['SHADOW'].','; }
		if(!empty($attribs['STORE'])){ $output .= 'store:'.$attribs['STORE'].','; }
		
		$output .= $this->run_triggerField($attribs);
		return $output;
	} # End of run_comboBox()
	
	function nest($type1, $type2, &$output, &$parent, &$attribs){
		if(empty($type2))
			$type2 = $type1;
		if($parent != 'EXT' && $parent != 'ITEM' && $parent != 'JSON' && !empty($parent)){
			//$output = preg_replace('/xtype\:\'(?:[a-z0-9]+)\',/i', '', $output);
			$output = preg_replace('/renderTo\:\'(?:[a-z0-9]+)\',/i', '', $output);
			$output = '{xtype:\''.strtolower($type1).'\','.$output.'}';
			$this->content_id = '';
			echo $output;
		} else {
			if($parent != 'ITEM' && !empty($parent)){
				if(!empty($attribs['NS'])){
					$output = 'Ext.ns(\''.$attribs['NS'].'\');'.$attribs['NS'].'=new Ext.'.$type2.'({'.$output.'});';
				} else if(!empty($attribs['VAR'])){
					$output = 'var '.$attribs['VAR'].'=new Ext.'.$type2.'({'.$output.'});';
				} else {
					$output = 'new Ext.'.$type2.'({'.$output.'});';
				}
				$this->script($output);
			} else {
				// if the 'renderto' attribute wasn't set in our xml file, remove it
				if($attribs['RENDERTOFLAG'] === true)
					$output = preg_replace('/renderTo\:\'(?:[a-z0-9]+)\',/i', '', $output);
				$output = 'new Ext.'.$type2.'({'.$output.'});';
				// did we need to create a Javascript namespace?
				if(!empty($attribs['NS'])){
					$output = 'Ext.ns(\''.$attribs['NS'].'\');'.$attribs['NS'].'='.$output;
				} else if(!empty($attribs['VAR'])){
					$output = 'var '.$attribs['VAR'].'='.$output;
				}
				echo $output;
			}
		}
	} # End of nest()
	
	function startNest(&$attribs){
		if(empty($attribs['VAR'])){
			//$attribs['VAR'] = 'myEl'.substr(MD5(rand(1, 100000000)), rand(0, 15), rand(3,17));
			$flag = false;
		} else {
			$tmp = 'myEl'.substr(MD5(rand(1, 100000000)), rand(0, 15), rand(3,17));
			$flag = true;
		}

		if(!empty($attribs['RENDERTO'])){
			$attribs['RENDERTOFLAG'] = false;
			$attribs['RENDERTO'] = (strpos('.', $attribs['RENDERTO']) === false) ? "'".$attribs['RENDERTO']."'" : $attribs['RENDERTO'];
			CoyoteProcessor::$ext->content_id = $attribs['RENDERTO'];
		} else {
			$attribs['RENDERTOFLAG'] = true;
			if(!$flag){
				//$attribs['RENDERTO'] = "'".$attribs['VAR']."'";
				//CoyoteProcessor::$ext->block('<div id="'.$attribs['VAR'].'"></div>');
				//CoyoteProcessor::$ext->content_id = $attribs['VAR'];
			} else {
				$attribs['RENDERTO'] = "'".$tmp."'";
				CoyoteProcessor::$ext->block('<div id="'.$tmp.'"></div>');
				CoyoteProcessor::$ext->content_id = $tmp;
			}
		}
	} # End of startNest()
} # End of class CoyoteExt
?>