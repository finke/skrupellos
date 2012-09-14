<?php
/**
* @license http://www.gnu.org/licenses/gpl.html The GNU General Public License (GPL)
* @copyright (C) 2012 finke
* @version $Id$
*/
define('SMARTY_RESOURCE_CHAR_SET', 'UTF-8');

require('smarty/Smarty.class.php');

class MySmarty extends Smarty{
	function __construct(){
		parent::__construct();
		
		$this->setTemplateDir(PATH.'include/templates/');		
		$this->setConfigDir(PATH.'include/templates/config/');
		
        $this->setCompileDir(PATH.'cache/compile/');
        $this->setCacheDir(PATH.'cache/');
	}
}