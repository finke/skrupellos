<?php
/**
* @license http://www.gnu.org/licenses/gpl.html The GNU General Public License (GPL)
* @copyright (C) 2012 finke
* @version $Id$
*/

namespace skrupellos;

abstract class Menue{
	private static $menue = array();
	
	private static function load(){
		 $s = preg_replace("/[^a-z0-9-_\&=]/i", "", $_SERVER[ 'QUERY_STRING' ]);
		 $ar = null;
		 if (!empty($s)) {
			$fu = strpos($s, '&');
            $fi = strpos($s, '=');
            $ende = strlen($s);
			
			if ($fi !== false AND $fu !== false) {
				if ($fu < $fi) {
					$ende = $fu;
				} elseif ($fi < $fu) {
                    $ende = $fi;
                }
            } elseif ($fu !== false) {
                $ende = $fu;
            } elseif ($fi !== false) {
                $ende = $fi;
            }
            $qs = substr($s, 0, $ende);
            $ar = explode('-', $qs);
		 }
		if(empty($ar)){
			$ar = array(0 =>Main::getConfig('start_modul'));
		}
		self::$menue = $ar;
	}
	
	public static function get($pos){
		if(empty(self::$menue)) self::load();
		if(self::keyExist($pos)){
			return self::$menue[$pos];
		}
	}
	
	public static function getNext($x){
		if(empty(self::$menue)) self::load();
		
	}
	public static function getN($x){
		return self::getNext();
	}
	
	public static function getAll(){
		if(empty(self::$menue)) self::load();
		return self::$menue;
	}
	public static function getArray(){ return getAll();}
	
	public static function getString(){
		return implode('-', self::$menue);
	}
	
	public static function set($pos, $value){
		$pos = intval($pos);
		self::keyExist($pos);
		self::$menue[$pos] = $value;
	}
	
	private static function keyExist($pos){
		for($i = 0; $i < $pos; $i++){
			if(!isset($this->menue[$i])) return false;
		}
		return true;
	}
}