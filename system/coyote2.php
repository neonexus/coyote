<?
# /coyote/system/coyote2.php
# Codename Coyote Revision

# First, we check to see if we are using the proper portal protocol
if(!defined('PORTAL_USED')){
	die('You have been logged.');
} else {
	final class CoyoteProcessor{
		private $real_dir, $full_url, $force_https;
		function __construct(){
			# We NEED our configuration before we do anything else
			require_once('config/main.config');
			
			# Do we need to force https?
			if($this->force_https){
				if(preg_match('/^(|off|false|disabled)$/i',$_SERVER['HTTPS'])){
					header('Location: https://'.$this->full_url);
					die();
				} else {
					$this->full_url = 'https://'.$this->full_url;
				}
			} else {
				$this->full_url = 'http://'.$this->full_url;
			}
		}
	}
}
?>