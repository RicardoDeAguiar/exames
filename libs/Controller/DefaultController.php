<?php
require_once("AppBaseController.php");

class DefaultController extends AppBaseController
{

	protected function Init()
	{
		parent::Init();

		// $this->RequirePermission(ExampleUser::$PERMISSION_USER,'SecureExample.LoginForm');
	}

	public function Home()
	{
		$this->Render();
	}

	public function Error404()
	{
		$this->Render();
	}

	public function ErrorFatal()
	{
		$this->Render();
	}

	public function ErrorApi404()
	{
		$this->RenderErrorJSON('Um ponto final da API desconhecido foi solicitado.');
	}

}
?>