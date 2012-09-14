<?php
/**
* @license http://www.gnu.org/licenses/gpl.html The GNU General Public License (GPL)
* @copyright (C) 2012 finke
* @version $Id$
*/

/**
 * access this object just via MyDB::getInstance()
 */
class DB{
	/**
	 * @var $db Speichert eine referenz auf die Datenbank klasse
	 */
	private static $db;
	
	public static function get(){
		if(!self::$db){
			$conf = \Config::get('db');
			switch($conf['type']){
				case 'MySQL':
				default:
					self::$db = new \db\MySQL('mysql:host='.$conf['host'].';dbname='.$conf['dbname'].';port='.$conf['port'], $conf['user'], $conf['passwd'] ,	array( PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
				break;
			}
		}else{
			return self::$db;
		}
	}
	
	public static function close(){
		if(!self::$db){
			self::$db->close();
			sel::$db = NULL;
		}
	}
}