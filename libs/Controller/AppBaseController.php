<?php
require_once("verysimple/Phreeze/Controller.php");

class AppBaseController extends Controller
{

	static $DEFAULT_PAGE_SIZE = 10;

	protected function Init()
	{
		/*
		if ( !in_array($this->GetRouter()->GetUri(),array('login','loginform','logout')) )
		{
			require_once("App/ExampleUser.php");
			$this->RequirePermission(ExampleUser::$PERMISSION_ADMIN,'SecureExample.LoginForm');
		}
		//*/
	}

	protected function GetDefaultPageSize()
	{
		return self::$DEFAULT_PAGE_SIZE;
	}

	protected function JSONPCallback()
	{
		// return RequestUtil::Get('callback','');

		return '';
	}

	protected function SimpleObjectParams()
	{
		return array('camelCase'=>true);
	}

	protected function SafeGetVal($json, $prop, $default='')
	{
		return (property_exists($json,$prop))
			? $json->$prop
			: $default;
	}

	protected function RenderExceptionJSON(Exception $exception)
	{
		$this->RenderErrorJSON($exception->getMessage(),null,$exception);
	}

	protected function RenderErrorJSON($message, $errors = null, $exception = null)
	{
		$err = new stdClass();
		$err->success = false;
		$err->message = $message;
		$err->errors = array();

		if ($errors != null)
		{
			foreach ($errors as $key=>$val)
			{
				$err->errors[lcfirst($key)] = $val;
			}
		}

		if ($exception)
		{
			$err->stackTrace = explode("\n#", substr($exception->getTraceAsString(),1) );
		}

		@header('HTTP/1.1 401 Unauthorized');
		$this->RenderJSON($err,RequestUtil::Get('callback'));
	}

}
?>