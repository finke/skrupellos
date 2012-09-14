<?php
/**
* @license http://www.gnu.org/licenses/gpl.html The GNU General Public License (GPL)
* @copyright (C) 2012 finke
* @version $Id$
*/

namespace skrupellos;

class Config{
	private static $config =  array(
	'db' => array(
		'type' => 'MySQL',
		'host' => 'localhost',
		'post' => '3306',
		'dbname' => '',
		'user' => '',
		'passwd' => ''
	),
	'player_color' => array(
		0  => '#1DC710',
		1  => '#E5E203',
		2  => '#EAA500',
		3  => '#875F00',
		4  => '#bb0000',
		5  => '#D700C1',
		6  => '#7D10C7',
		7  => '#101DC7',
		8  => '#049EEF',
		9  => '#10C79B'
	)
);

	public static function get($name){
		$name = explode('/', $name);
		$tmp = self::$config;
		while($lv = array_shift($name)){
			if(!empty($name)){
				if(array_key_exists($lv, $tmp)) $tmp = $tmp[$lv];
				else return NULL;
				
			}else{
				if(array_key_exists($lv, $tmp)) return $tmp[$lv];
				else return NULL;
			}
		}
		return NULL;
	}
	
	public function __get($name){
		return self::get();
	}
}


date_default_timezone_set('Europe/Berlin');
//Error Behandlung, bei bedarf aktivieren
ini_set('display_errors', 0);
ini_set('log_errors', 0);
ini_set('ignore_repeated_errors', 1);
ini_set('error_reporting', E_ALL | E_STRICT);
ini_set('error_log', PATH.'log/error.log');