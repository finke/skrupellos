<?php
/**
* @license http://www.gnu.org/licenses/gpl.html The GNU General Public License (GPL)
* @copyright (C) 2012 finke
* @version $Id$
*/

namespace db;

class MySQL extends \PDO implements \db\DB{
	public function __construct($msn, $user, $passwd, $option){
		$this->open($msn, $user, $passwd, $option);
	}

	public function __destruct(){
	}
	
	public function open($msn, $user, $passwd, $option){
			if(version_compare(PHP_VERSION, '5.3.6', '>=')) $msn .=', charset=UTF-8';
			else $option[PDO::MYSQL_ATTR_INIT_COMMAND] = "SET NAMES 'utf8'; SET CHARACTER SET 'utf8'";

			parent::__construct($msn, $user, $passwd, $option);		
	}
	
	public function close(){
	}

}