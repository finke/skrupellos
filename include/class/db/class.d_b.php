<?php
/**
* @license http://www.gnu.org/licenses/gpl.html The GNU General Public License (GPL)
* @copyright (C) 2012 finke
* @version $Id$
*/

namespace db;

interface DB{
	public function open($msn, $user, $passwd, $option);
	public function close();
}
