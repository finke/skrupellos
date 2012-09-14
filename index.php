<?php
/**
* @license http://www.gnu.org/licenses/gpl.html The GNU General Public License (GPL)
* @copyright (C) 2012 finke
* @version $Id$
*/

namespace skrupellos;

/**
* Deffinition, welche erkentlich macht, dass eine Page via index.php eingebunden wurde.
*/
define('MAIN', 'index');

/**
* Zeigt auf das Stammverzeichniss der Instalation
*/
define('PATH', dirname(__FILE__). '/');
define('ROOT', preg_replace('#[^a-z0-9\.\-_]#', '', strtolower($_SERVER['SERVER_NAME'])).dirname($_SERVER['SCRIPT_NAME']). '/');


$protokoll = 'http';
if(!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') $protokoll = 'https';	//Wenn moeglich https verwenden
/**
*Deffiniert die verwendete Protokollversion
**/
define('PROTOKOLL', $protokoll);


//!TODO Abfrage ob Install noch oder config noch nicht Existiert und abbrechen

require_once (PATH.'include/inc.config.php');
require_once (PATH.'include/func/func.main.php');

spl_autoload_register('skrupellos_autoloader');

$main = new Main();

$tmp = $main->getStartPath();

include $tmp;

$main->printPage();

