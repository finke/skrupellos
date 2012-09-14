<?php
/**
* @license http://www.gnu.org/licenses/gpl.html The GNU General Public License (GPL)
* @copyright (C) 2012 finke
* @version $Id$
*/

namespace skrupellos;
require_once(PATH.'include/lib/class.my_smarty.php');

class Main{
	private static $header = array();
	private static $page;
	private $smarty;
	private static $config = array();
	
	public function __construct(){
		self::addHeader('Content-Type: text/html; charset=UTF-8');
		
		self::$page = array(
			'title' =>'',
			'head' =>'',
			'header' =>'',
			'nav' =>'',
			'body' => '',
			'footer' =>''
		);
		
		$this->smarty = new \MySmarty();
		
		//Mal Versuchen die DB aufzumachen um spätere Überraschungen zu vermeiden.
		try{
			$db = \DB::get();
		}catch(\PDOException $e){
			if($e->getCode() == 1045 || $e->getCode() == 1044){
				\Debug::log('Es Konnte keiner Verbindung mit der Datenbank aufgebaut werden. Bitte Überprüfen Sie die Zugangsdaten', E_USER_ERROR);
				$this->printPage();
				die();
			}
			throw $e;
		}
		$session = \Config::get('SESSION');
		if(empty($session)) $session = getConfig('title');
		session_name(preg_replace('#[^a-zA-Z0-9]#', '', $session).'SSID');
		session_start();		
	}
	
	public function __destruct(){
	}
	
	public static function addHeader($header){
		self::$header[] = $header;
	}
	
	public static function addContent($txt, $position = 'body'){
		if(array_key_exists($position, self::$page)){
			self::$page[$position] .= $txt;
		}
	}
	
	public static function addHHTMLHeader($string){
		self::addContent($string, 'head');
	}
	
	private function sendHeader(){
		if(!headers_sent()){
			foreach(self::$header as $header){
				header($header);
			}
		}
	}
	
	public function printPage(){
		$this->sendHeader();

		$tmp = \Debug::clear();
		self::$page['body'] .= '<div>';
		foreach($tmp as $t){
			self::$page['body'] .= '('.$t['lvl'].')'.$t['msg'];
		}
		self::$page['body'] .= '</div>';
		
		$this->smarty->assign('TITLE', self::$page['title']);
		$this->smarty->assign('HEAD', self::$page['head']);
		$this->smarty->assign('HEADER', self::$page['header']);
		$this->smarty->assign('NAV', self::$page['nav']);
		$this->smarty->assign('BODY', self::$page['body']);
		$this->smarty->assign('FOOTER', self::$page['footer']);
		
		$this->smarty->display('file:index.tpl');
	}
	
	public static function getConfig($key){
		if(array_key_exists($key, self::$config)){
			return self::$config[$key];
		}else{
			static $query = NULL;
				if($query === NULL) $query = \DB::get()->prepare("SELECT `value` FROM `skrupellos_config` WHERE `name` = :name");
			$query->bindValue(':name', $key, \PDO::PARAM_STR);
			$query->execute();
			if($result = $query->fetch(\PDO::FETCH_NUM)){
				self::$config[$key] = $result[0];
				$query->closeCursor();
				return $result[0];
			}
			$query->closeCursor();
			return NULL;
		}
	}
	
	public static function setConfig($key, $value){
		$tmp = self::getConfig($key);
		if($tmp === NULL)	return false;
		
		static $query = NULL;
		if($query === NULL) $query = \DB::get()->prepare("UPDATE `skrupellos_config` SET `value` = :value WHERE `name` = :name");
		$query->bindValue(':name', $key, \PDO::PARAM_STR);
		$query->bindValue(':value', $value, \PDO::PARAM_STR);
		if($query->execute() && $query->rowCount() == 1){
			self::$config[$key] = $value;
			$query->closeCursor();
			return $tmp;
		}
		$query->closeCursor();
		return false;
	}
	
	public function getStartPath(){
		return PATH.'include/content/inc.'.Menue::get(0).'.php';
	}
}
