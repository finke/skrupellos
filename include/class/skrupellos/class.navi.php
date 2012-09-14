<?php
/**
* @license http://www.gnu.org/licenses/gpl.html The GNU General Public License (GPL)
* @copyright (C) 2012 finke
* @version $Id$
*/

namespace skrupellos;

require_once(PATH.'include/lib/class.my_smarty.php');
//!TODO unbedingt nochmal überarbeiten
class Navi{
	protected $ar = array();
	
	public function __construct(){
	
	}
	
	public function __destruct(){
	
	}
	
	public function addGroup($name){
		if(!array_key_exists($name, $this->ar))	$this->ar[$name] = array();
	}
	
	public function addItem($name, $url, $group = ''){
		if(empty($group) || !array_key_exists($group, $this->ar)) $group = 0;
		if(empty($group)) throw new \Exception('Noch keine Gruppe angelegt', 6);
		
		if(substr($url, 0,1) == '/'){
			$url = PROTOKOLL.'://'.ROOT.substr($url, 1);
		}
		
		$this->ar[$group][$name] = $url;
	}
	
	public function getNavi(){
		$smarty = new \MySmarty();
		$smarty->assign('ARRAY', $this->ar);
		$smarty->assign('PROTOKOLL', PROTOKOLL);
		return $smarty->fetch('file:navi.tpl');
	}	
}