<?php
require_once("AppBaseController.php");
require_once("App/ExampleUser.php");

class SecureExampleController extends AppBaseController
{

	protected function Init()
	{
		parent::Init();

	}
	
	public function UserPage()
	{
		$this->RequirePermission(ExampleUser::$PERMISSION_USER, 
				'SecureExample.LoginForm', 
				'O login é necessário para acessar a página de usuário',
				'Você não tem permissão para acessar a página de usuário segura');
		
		$this->Assign("currentUser", $this->GetCurrentUser());
		
		$this->Assign('page','userpage');
		$this->Render("SecureExample");
	}
	
	public function AdminPage()
	{
		$this->RequirePermission(ExampleUser::$PERMISSION_ADMIN, 
				'SecureExample.LoginForm', 
				'O login é necessário para acessar a página de administração',
				'Você não tem ermissão para acessar a página de administração');
		
		$this->Assign("currentUser", $this->GetCurrentUser());
		
		$this->Assign('page','adminpage');
		$this->Render("SecureExample");
	}
	
	public function LoginForm()
	{
		$this->Assign("currentUser", $this->GetCurrentUser());
		
		$this->Assign('page','login');
		$this->Render("SecureExample");
	}
	
	public function Login()
	{
		$user = new ExampleUser();
		
		if ($user->Login(RequestUtil::Get('username'), RequestUtil::Get('password')))
		{
			// sucesso no login
			$this->SetCurrentUser($user);
			$this->Redirect('SecureExample.UserPage');
		}
		else
		{
			// falha no login 
			$this->Redirect('SecureExample.LoginForm','Unknown username/password combination');
		}
	}
	
	public function Logout()
	{
		$this->ClearCurrentUser();
		$this->Redirect("SecureExample.LoginForm","You are now logged out");
	}

}
?>