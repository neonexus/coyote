<?
# Coyote Processor Class file

define('IN_COYOTE', true);

if(!function_exists('__autoload')){
	function __autoload($which){
		// This function insures we only load the classes we need
		if($which == 'CoyoteParser')
			require_once('parser.php');
		if($which == 'DbLibMySQL')
			require_once('dblib.php');
		if($which == 'CoyoteExt')
			require_once('ext.php');
	}
}

final class CoyoteProcessor{
	private static $num, $tag_files, $tag_info, $clean_cache_folder, $filters, $db_for_tags, $db_for_pages, $db;
	private static $tag_dir, $cache_dir, $main_dir, $db_tags_table, $db_pages_table, $db_perms_table;
	private static $load_ext, $system_dir;
	public static $ext;
	public static $tags, $server_path, $inc_dir;
	
	static function set_pages_table($table){
		if(empty(self::$db_pages_table))
			self::$db_pages_table = $table;
	} # End of set_pages_table()
	
	static function set_tags_table($table){
		if(empty(self::$db_tags_table))
			self::$db_tags_table = $table;
	} # End of set_tags_table()
	
	static function set_perms_table($table){
		if(empty(self::$db_perms_table))
			self::$db_perms_table = $table;
	} # End of set_tags_table()
	
	function __construct(){
		// First, we are going to need our configuration file
		require_once('config/main_config.php');
		
		if(self::$load_ext)
			self::$ext = new CoyoteExt;
		
		// Let`s save our self some headaches and clean out our cache folder, if need be
		if(self::$clean_cache_folder)
			$this->clean_cache(self::$cache_dir);
		
		self::$num = 1;
		
		self::$tags = array();
		
		// Do we need a database connection?
		if(self::$db_for_tags || self::$db_for_pages){
			self::$db = &new DbLibMySQL;
			self::$db->OpenConnection();
		}
		if(self::$db_for_tags)
			require_once('tags_in_db.php');
		else
			require_once('tags_in_file-debug.php');
		if(self::$db_for_tags && !self::$db_for_pages)
			self::$db->CloseConnection();
	} # End of CoyoteProcessor()
	
	static function add_filter(){
		$args = func_get_args();
		self::filter_loop(false, $args);
	} # End of add_filter()
	
	private static function filter_loop($remove, $args){
		$num = count($args);
		if($num > 0){
			$i = 0;
			do{
				$tmp = strtoupper($args[$i]);
				if($remove)
					unset(self::$filters[$tmp]);
				else
					self::$filters[$tmp] = true;
				++$i;
			} while($i < $num);
		}
	} # End of filter_loop()
	
	static function remove_filter(){
		$args = func_get_args();
		self::filter_loop(true, $args);
	} # End of remove_filter()
	
	static function do_include($file){
		if(is_string($file) && !empty($file)){
			if(is_file(self::$system_dir.$file))
				require(self::$system_dir.$file);
			else 
				die('<strong>ERROR:</strong> Could not include the file <strong>'.self::$system_dir.$file.'</strong>');
		} else {
			die('<strong>ERROR:</strong> Input paramater must be a <strong>string</strong> in <strong>CoyoteProcessor::do_include()</strong>');
		}
	} # End of do_include()
	
	private function tag_loop($dir){
		if(is_string($dir)){
			if ($handle = opendir($dir)){
				while (false !== ($file = readdir($handle))){
					if($file != '.' && $file != '..' && is_file($dir.$file)){
						if(!strpos($file, '~')){
							self::$tag_files[self::$num] = $dir.$file;
							++self::$num;
						}
					} else if($file != '.' && $file != '..' && is_dir($dir.$file.'/'))
						$this->tag_loop($dir.$file.'/');
				}
				closedir($handle);
			} else {
				die('<strong>ERROR:</strong> Could not open tag definition folder ('.$dir.').');
			}
		} else {
			die('<strong>ERROR:</strong> Input paramater must be a <strong>string</strong> in <strong>CoyoteProcessor::tag_loop()</strong>');
		}
	} # End of tag_loop()
	
	private function clean_cache($dir){
		if(is_string($dir)){
			if($handle = opendir($dir)){
				while(false !== ($file = readdir($handle))){
					if($file != '.' && $file != '..' && is_file($dir.$file) && $file != '32e5c799ecefe6216ad5485b7ff1b4c9.cache'){
						$diff = getTimeDifference(date("F d, Y H:i:s", filemtime($dir.$file)), date("F d, Y H:i:s"));
						if($diff['hours'] >= 1)
							unlink($dir.$file);
					} else if($file != '.' && $file != '..' && is_dir($dir.$file.'/') && $file != 'funcs') {
						$this->clean_cache($dir.$file.'/');
					}
				}
				closedir($handle);
			} else {
				die('<strong>ERROR:</strong> Could not open the cache folder for cleaning ('.$dir.').');
			}
		} else {
			die('<strong>ERROR:</strong> Input paramater must be a <strong>string</strong> in <strong>CoyoteProcessor::clean_cache()</strong>');
		}
	} # End of clean_cache()
	
	static function process($file_name1, $type = 'file', $do_echo = 'none'){
		static $parser;
		if(is_string($file_name1)){
			if(empty($parser)){
				$parser = new CoyoteParser;
			}
			if($type == 'file' || $type == 'db'){
				if(self::$db_for_pages){
					$file_name1 = mysql_real_escape_string($file_name1);
					self::$db->Query('SELECT data FROM '.self::$db_pages_table.' WHERE page="'.$file_name1.'" LIMIT 1');
					if(self::$db->GetNumRows() > 0){
						$file = self::$db->GetResult();
					} else {
						die('<strong>ERROR:</strong> Could not obtain page (<strong>'.$file_name1.'</strong>) data from MySQL server!');
					}
				} else {
					$file_name = self::$main_dir.self::safe_filename($file_name1);
					if(file_exists($file_name)){
						$file = file_get_contents($file_name);
					} else {
						die('<strong>ERROR:</strong> Could not open file <strong>'.$file_name1.'</strong> for processing!');
					}
				}
			} else {
				$file = $file_name1;
			}
			$file = str_replace('url://', self::$server_path, $file);
			$file = $parser->parse(&$file);
			if($file !== false){
				if($do_echo == 'echo'){
					$file = self::defaults(&$file);
					//ob_start("ob_gzhandler");
					echo self::run(&$file);
					//ob_end_flush();
				} else if($do_echo == 'return') {
					$file = self::defaults(&$file);
					return self::run(&$file);
				} else {
					return self::defaults(&$file);
				}
			} else {
				if($type != 'file')
					$file_name1 = '(Used passed data, unknown file)';
				if($type == 'db')
					$file_name1 = '(Used database data, WHERE page=\''.$file_name1.'\')';
				die($parser->error_dump().' in file <strong>'.$file_name1.'</strong>');
			}
		} else {
			die('<strong>ERROR:</strong> Input paramater must be a <strong>string</strong> in <strong>CoyoteProcessor::process()</strong>');
		}
	} # End of process()
	
	static function defaults($input){
		if(is_array($input)){
			$cnt = count($input);
			//for($i = 0; $i < $cnt; ++$i){
			$i = 0;
			do{
				$tag_name = $input[$i]['name'];
				if(!empty($input[$i]['children'])){
					$input[$i]['children'] = self::defaults($input[$i]['children']);
				}
				if(!empty(self::$tags[$tag_name])){
					$tag = (!empty(self::$tags[$tag_name]['parent'])) ? self::$tags[self::$tags[$tag_name]['parent']] : self::$tags[$tag_name];
					$tag['name'] = $tag_name;
					if(!empty(self::$tags[$tag_name]['parent']))
						$tag['parent'] =  self::$tags[$tag_name]['parent'];
					foreach($input[$i]['attr'] as $key => $value){
						if(!empty($key))
							$tag['attr'][$key] = $value;
					}
					$tag['level'] = $input[$i]['level'];
					if(!empty($input[$i]['children']))
						$tag['children'] = $input[$i]['children'];
					if(!empty($input[$i]['tagData']))
						$tag['tagData'] = $input[$i]['tagData'];
					//$tag['innerHTML'] = $input[$i]['innerHTML'];
					$input[$i] = $tag;
					unset($tag, $tag_name, $key, $value);
				}
				++$i;
			} while($i < $cnt);
			return $input;
		} else {
			die('<strong>ERROR:</strong> Input paramater must be an <strong>array</strong> in <strong>CoyoteProcessor::defaults()</strong>');
		}
	} # End of defaults()
	
	static function custom_eval($ourspecial_str, $somec_razyvariable = ""){
		if(is_string($ourspecial_str)){
			if(empty($somec_razyvariable)){
				// To help prevent internal changes to variables (coming from the file, aka the tag) from breaking the script, 
				// I`m using "variable variables", hence the double dollar signs and the long variable names
				$somec_razyvariable = self::getMicroTime();
				$somec_razyvariable .= rand(0, 1000000);
				$good2 = false;
			} else {
				$good2 = true;
			}
			//$somec_razyvariable = MD5($somec_razyvariable);
			//$$somec_razyvariable = self::$cache_dir.$somec_razyvariable.'.cache';
			$good = false;
			if(file_exists($$somec_razyvariable)){
				$diff = getTimeDifference(date("F d, Y H:i:s", filemtime($$somec_razyvariable)), date("F d, Y H:i:s"));
				if($diff['seconds'] >= 10){
					$good = false;
					//unlink($$somec_razyvariable);
					self::delete_cache($somec_razyvariable);
				} else {
					$good = true;
					//require_once($$somec_razyvariable);
					self::run_cache($somec_razyvariable);
					unset($ourspecial_str);
				}
			}
			if(!$good){
				//file_put_contents($$somec_razyvariable, $ourspecial_str);
				//require_once($$somec_razyvariable);
				self::write_cache($somec_razyvariable, $ourspecial_str);
				self::run_cache($somec_razyvariable);
				if(!$good2)
					self::delete_cache($somec_razyvariable);
					//unlink($$somec_razyvariable);
			}
		} else {
			die('<strong>ERROR:</strong> Input paramater must be a <strong>string</strong> in <strong>CoyoteProcessor::custom_eval()</strong>');
		}
	} # End of custom_eval()
	
	static function write_cache($name, $input, $overwrite = true){
		$name = self::$cache_dir.MD5($name).'.cache';
		if(!$overwrite){
			return file_put_contents($name, $input, LOCK_EX|FILE_APPEND);
		} else {
			return file_put_contents($name, $input, LOCK_EX);
		}
	} # End of write_cache()
	
	static function delete_cache($name){
		$name = self::$cache_dir.MD5($name).'.cache';
		@unlink($name);
		unset($name);
	} # End of delete_cache()
	
	static function read_cache($name){
		$name = self::$cache_dir.MD5($name).'.cache';
		return file_get_contents($name);
	} # End of read_cache()
	
	static function run_cache($name, $once = false){
		$name = self::$cache_dir.MD5($name).'.cache';
		if($once)
			require_once($name);
		else
			require($name);
		unset($name, $once);
	} # End of run_cache()
	
	static function is_cached($name){
		$name = self::$cache_dir.MD5($name).'.cache';
		return file_exists($name);
	} # End of is_cached()
	
	static function run($input, $int = 1, $parent = "", $breadcrumbs = ""){
		$output = "";
		if(is_array($input)){
			$cnt = count($input);
			//for($i = 0; $i < $cnt; ++$i){
			$i = 0;
			if(!empty($breadcrumbs) || !empty($parent))
				$breadcrumbs .= (!empty($breadcrumbs)) ? '/'.$parent : $parent;
			do{
				$innerHTML = (!empty($input[$i]['children'])) ? self::run($input[$i]['children'], $int+1, $input[$i]['name'], $breadcrumbs) : $input[$i]['tagData'];
				$tmp = (!empty($input[$i]['parent'])) ? $input[$i]['parent'] : $input[$i]['name'];
				if(!isset(self::$filters[$input[$i]['name']])){
					if(!empty($input[$i]['file'])){
						// We don`t have a filter in place, so run our tag
						if(!isset(self::$filters[$tmp])){
							if(!empty($input[$i]['attr'])){
								foreach($input[$i]['attr'] as $key => $val){
									$input[$i]['attr'][$key] = trim($val);
								}
							}
							//if(!function_exists('Coyote_'.$tmp)){
								//$output2 = self::$tag_info[$input[$i]['file']];
								//self::custom_eval($output2, $tmp);
							//}
							self::run_cache('internal_'.$tmp, true);
							ob_start();
							$tmp = 'Coyote_'.$tmp;
							call_user_func($tmp, $input[$i]['name'], $input[$i]['attr'], $innerHTML, $parent, $breadcrumbs);
							$output .= ob_get_clean();
							//ob_end_clean();
						}
					} else {
						// No filter in place, but tag wasn`t defined. Rebuild unknown tag
						$output .= '<'.strtolower($input[$i]['name']);
						if(!empty($input[$i]['attr'])){
							foreach($input[$i]['attr'] as $key => $val){
								$output .= ' '.strtolower($key).'="'.$val.'"';
							}
						}
						$output .= (!empty($innerHTML) || $input[$i]['name'] == 'DIV' || $input[$i]['name'] == 'SPAN') ? '>'.$innerHTML.'</'.strtolower($input[$i]['name']).'>' : '/>';
					}
				}
				++$i;
			} while($i < $cnt);
			unset($input, $output2, $innerHTML, $cnt, $count, $i, $key, $val, $tmp);
			if($int == 1){	
				// ExtJs replacement blocks
				if(strpos($output, '{{* blocks *}}') !== false){
					if($_GET['json'] != 'true'){
						$tmp = self::$ext->dump_blocks();
						$output = str_replace('{{* blocks *}}', $tmp, $output);
					} else {
						$output = str_replace('{{* blocks *}}', '', $output);
					}
				}
				if(strpos($output, '{{* javascript *}}') !== false){
					if($_GET['json'] != 'true')
						$tmp = self::$ext->dump_javascript(true);
					else
						$tmp = self::$ext->dump_javascript(false);
					if(strpos($tmp, '{{* apps *}}') !== false){
						$tmp = str_replace('{{* apps *}}', self::$ext->dump_apps(), $tmp);
					}
					/*if($_GET['json'] != 'true'){
						$name = MD5($tmp.self::getMicroTime());
						$tmp .= '<? CoyoteProcessor::delete_cache(\''.$name.'\'); ?>';
						self::write_cache($name, $tmp);
						$tmp = '<script language="javascript" src="'.self::$server_path.'system/index.php?run='.$name.'"></script>';
					}*/
					$output = str_replace('{{* javascript *}}', $tmp, $output);
				}
			}
			return $output;
		} else {
			die('<strong>ERROR:</strong> Input paramater must be an <strong>array</strong> in <strong>CoyoteProcessor::run()</strong>');
		}
	} # End of run()
	
	static function safe_filename($filename){
		if(is_string($filename)){
			$filename = str_replace('./', '', $filename);
			$filename = str_replace('../', '', $filename);
			return preg_replace('([^[:alnum:]._/])','_',$filename);
		} else {
			die('<strong>ERROR:</strong> Input paramater must be a <strong>string</strong> in <strong>CoyoteProcessor::safe_filename()</strong>');
		}
	} # End of safe_filename()
	
	static function getMicroTime(){
	    list($MicroSec, $Sec) = explode(' ', microtime());
	    return ((float)$MicroSec + (float)$Sec);
	} # End of getMicroTime()
} # End of class

function getTimeDifference($start, $end, $rtrn = "days"){
    /**
    * Function to calculate date or time difference.
    * Returns an array or false on error.
    *
    * @author       J de Silva                             <giddomains@gmail.com>
    * @copyright    Copyright 2005, J de Silva
    * @link         http://www.gidnetwork.com/b-16.html    Get the date / time difference with PHP
    * @param        string                                 $start
    * @param        string                                 $end
    * @param        string                                 $rtrn (added October 13, 2007 by NeoNexus DeMortis)
    * @return       array
    */
    $uts['start'] = strtotime($start);
    $uts['end'] = strtotime($end);
    if($uts['start']!==-1 && $uts['end']!==-1){
        if($uts['end'] >= $uts['start']){
            $diff = $uts['end'] - $uts['start'];
            if($days=intval(floor($diff/86400))){
                if($rtrn == "days")
                    $diff = $diff % 86400;
                else
                    $days = 0;
            }
            if($hours=intval(floor($diff/3600))){
                if($rtrn == "days" || $rtrn == "hours")
                    $diff = $diff % 3600;
                else
                    $hours = 0;
            }
            if($minutes=intval(floor($diff/60))){
                if($rtrn == "days" || $rtrn == "hours" || $rtrn == "minutes")
                    $diff = $diff % 60;
                else
                    $minutes = 0;
            }
            $diff = intval($diff);            
            return(array('days'=>$days, 'hours'=>$hours, 'minutes'=>$minutes, 'seconds'=>$diff));
        } else {
            trigger_error("Ending date/time is earlier than the start date/time<br/>Start: ".$uts['start']." End: ".$uts['end'], E_USER_WARNING);
        }
    } else {
        trigger_error("Invalid date/time data detected", E_USER_WARNING);
    }
    return(false);
} # End of getTimeDifference()
?>