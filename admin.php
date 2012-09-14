<?php
/**
* @license http://www.gnu.org/licenses/gpl.html The GNU General Public License (GPL)
* @copyright (C) 2012 finke
* @version $Id$
*/

namespace skrupellos;

/**
* Deffinition, welche erkentlich macht, dass eine Page via admin.php eingebunden wurde.
*/
define('MAIN', 'admin');

/**
* Zeigt auf das Stammverzeichniss der Instalation
*/
define('PATH', dirname(__FILE__). '/');

$protokoll = 'http';
if(!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off') $protokoll = 'https';	//Wenn moeglich https verwenden
/**
*Deffiniert die verwendete Protokollversion
**/
define('PROTOKOLL', $protokoll);

ini_set('display_errors', '0');