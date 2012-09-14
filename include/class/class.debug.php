<?php
/**
* @license http://www.gnu.org/licenses/gpl.html The GNU General Public License (GPL)
* @copyright (C) 2012 finke
* @version $Id$
*/
/**
 * Debug
 * Rein statiche Klasse, welche sich um eventuelles Debuging kuemmert
 *
 * @author finke <Surf-finke@gmx.de>
 * @copyright Copyright (c) 2012
 */
abstract class Debug{
	private static $inhalt = array();
	
	public static function log($msg, $lvl= E_USER_WARNING){
	self::$inhalt[] = array('msg' => $msg, 'lvl' => $lvl);
	}
	
	public static function getMessages(){
		return self::$inhalt;
	}
	
	public static function clear(){
		$tmp = self::$inhalt;
		self::$inhalt = array();
		return $tmp;
	}
}