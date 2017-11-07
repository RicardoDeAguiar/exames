<?php
require_once("verysimple/Authentication/IAuthenticatable.php");
require_once("util/password.php");

class ExampleUser implements IAuthenticatable
{
	static $USERS;
	
	static $PERMISSION_ADMIN = 1;
	static $PERMISSION_USER = 2;
	
	public $Username = '';

	public function __construct()
	{
		if (!self::$USERS)
		{
			self::$USERS = Array(
				"demo"=>password_hash("pass",PASSWORD_BCRYPT),
				"admin"=>password_hash("admin",PASSWORD_BCRYPT)
			);
		}
	}

	public function IsAnonymous()
	{
		return $this->Username == '';
	}
	
	public function IsAuthorized($permission)
	{
		if ($this->Username == 'admin') return true;
		
		if ($this->Username == 'demo' && $permission == self::$PERMISSION_USER) return true;
		
		return false;
	}
	
	public function Login($username,$password)
	{
		foreach (self::$USERS as $un=>$pw)
		{
			if ($username == $un && password_verify($password,$pw))
			{
				$this->Username = $username;
				break;
			}
		}
		
		return $this->Username != '';
	}
	
}

?>