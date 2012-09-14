<?php

function skrupellos_autoloader($class){	
	$a = explode('\\', $class);
	$tmp = '';
	$class = PATH. 'include/class/';
	while($tmp = array_shift($a)){
		if(!empty($a)){
			$class .= $tmp.'/';
		}else{
			$tmp = lcfirst($tmp);
			$class_name = 'class.';
			$tmp =  str_split($tmp);
			foreach($tmp as $t){
				if(ctype_upper($t)){
					$t = '_' . strtolower($t);
				}
				$class_name .=$t;
			}
			$class .= $class_name . '.php';
		}
	}
	@include_once($class);
}

function is_valid($var, $mode = 'num'){
	if(empty($var)) return false;
	switch($mode){
		case 'num':
			if(is_numeric($var))  return true;
		break;
		case 'int':
			if(preg_match('/^[0-9]*$/', $var))  return true;
		break;
		case 'nick':
			if(preg_match('/^[a-zA-Z0-9_]{5,12}$/', $var)) return true;
		break;
		case 'email':
			if(preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $var)) return true;
		break;
		case 'passwd':
			$i = 0;
			if(preg_match('#[0-9]#', $var)) $i++;
			if(preg_match('#[a-z]#', $var)) $i++;
			if(preg_match('#[A-Z]#', $var)) $i++;
			if(preg_match('#[,\.+-§&\$%/\(\)\#=]#',$var)) $i++;
			if(strlen($var)>= 14) $i++;
			if(strlen($var)>= 8 && $i >= 2 ) return true;
		break;
	}
	return false;
}

function escape($var, $mode = 'string'){
	if(empty($var)) return '';
	switch($mode){
		case 'num':
			return floatval($var);
		break;
		case 'int':
			return intval($var);
		break;
		case 'email':
		break;
		case 'sql':
		break;
		case 'nick':
		break;
		case 'string':
		default:
	}
	return '';
}
