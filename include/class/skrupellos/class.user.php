<?php
/**
* @license http://www.gnu.org/licenses/gpl.html The GNU General Public License (GPL)
* @copyright (C) 2012 finke
* @version $Id$
*/

namespace skrupellos;

class User{
	private $id;
	private $nick;
	private $email;
	private $avatar;
	private $hompage;
	private $sprache;
	
	public function __construct($value){
		$typ = \PDO::PARAM_STR;
		if(is_valid($value, 'int')){	$feld = 'id';  $typ = \PDO::PARAM_INT;
		}elseif(is_valid($value, 'nick')) $feld = 'nick';
		elseif(is_valid($value, 'email')) $feld = 'email';
		else throw Exception('Kann keinen User suchen, da weder eine gültige ID, eine gültige E-Mailadresse noch ein gültiger Nick angegeben wurde.', 0);
		$query = \DB::get()->prepare("SELECT `id`, `nick`, `email` , `avatar`, `sprache`, `hompage` FROM `user` WHERE `$feld` = :value");
		$query->bindValue(':value', $value, $typ);
		if($query->execute()){
			if($user = $query->fetch()){
				$this->id = $user['id'];
				$this->nick = $user['nick'];
				$this->email = $user['email'];
				$this->avatar = $user['avatar'];
				$this->hompage = $user['hompage'];
				$this->sprache = $user['sprache'];							
			}else throw new \Exception('Kein passenden User gefunden', 1);
		}else throw new \PDOException('Fehler beim Binden der Suchparameter', 2);
	
	}
	public function __destruct(){
	
	}
	
	//regist User
	public static function registUser($nick, $email, &$passwd = NULL){
		if(!is_valid($nick, 'nick') || !is_valid($email, 'email')) return NULL;		
		if(!is_valid($passwd, 'pwasswd') || empty($passwd)) $passwd = \PasswdCrypt::getRndString(10, \PasswdCrypt::WITH_NUMBERS);
		$query = \DB::get()->prepare("SELECT  COUNT(*) FROM `user` WHERE `nick` = :nick OR `email` = :email");		
		$query->bindValue(':nick', $nick, \PDO::PARAM_STR);
		$query->bindValue(':email', $email, \PDO::PARAM_STR);
		$query->execute();
		$query = $query->fetch(\PDO::FETCH_NUM);
		if($query[0] == 0){
			$crypt = new \PasswdCrypt();
			$query = \DB::get()->prepare("INSERT INTO `user` (`nick` , `password` , `email`) VALUES (:nick, :passwd, :email)");
			
			$query->bindValue(':nick', $nick, \PDO::PARAM_STR);
			$query->bindValue(':email', $email, \PDO::PARAM_STR);
			$query->bindValue(':passwd', $crypt->cryptPasswd($passwd), \PDO::PARAM_STR);
			
			if($query->execute() && $query->rowCount() == 1){
				return new User($nick);
			}
			throw new \Exception('Kann den User nicht anlegen', 4);
			return NULL;
		}
		throw new \Exception('Ein User mit diesen Daten existiert bereits', 3);
		return NULL;
	}
	
	public function setNewPasswd($neu){
		if(!is_valid($neu, 'passwd')) return false;
		$query = \DB::get()->prepare("UPDATE `user` SET `password` = :passwd WHERE `id` = :id");
		$query->bindValue(':id', $this->id, \PDO::PARAM_INT);
		
		$crypt = new \PasswdCrypt();
		$query->bindValue(':passwd', $crypt->cryptPasswd($neu), \PDO::PARAM_STR);
		
		return $query->execute();
	}
	
	public function validPasswd($passwd){
		if(!is_valid($passwd, 'passwd')) return false;
		$query = \DB::get()->prepare("SELECT `password` FROM `user` WHERE `id` = :id");
		$query->bindValue(':id', $this->id, \PDO::PARAM_INT);
		$query->execute();
		if($user = $query->fetch(\PDO::FETCH_NUM)){
			$crypt = new \PasswdCrypt();
			return $crypt->checkPasswd($passwd, $user[0]);
		}
		return false;
	}
	
}
