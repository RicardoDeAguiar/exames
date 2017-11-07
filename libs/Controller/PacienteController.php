<?php
require_once("AppBaseController.php");
require_once("Model/Paciente.php");

class PacienteController extends AppBaseController
{

	protected function Init()
	{
		parent::Init();

		// $this->RequirePermission(ExampleUser::$PERMISSION_USER,'SecureExample.LoginForm');
	}

	public function ListView()
	{
		$this->Render();
	}

	public function Query()
	{
		try
		{
			$criteria = new PacienteCriteria();
			
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Idpaciente,Nome,Datanasc,Logradouro,Numero,Bairro,Cidade,Uf'
				, '%'.$filter.'%')
			);

			foreach (array_keys($_REQUEST) as $prop)
			{
				$prop_normal = ucfirst($prop);
				$prop_equals = $prop_normal.'_Equals';

				if (property_exists($criteria, $prop_normal))
				{
					$criteria->$prop_normal = RequestUtil::Get($prop);
				}
				elseif (property_exists($criteria, $prop_equals))
				{
					$criteria->$prop_equals = RequestUtil::Get($prop);
				}
			}

			$output = new stdClass();

 			$output->orderBy = RequestUtil::Get('orderBy');
 			$output->orderDesc = RequestUtil::Get('orderDesc') != '';
 			if ($output->orderBy) $criteria->SetOrder($output->orderBy, $output->orderDesc);

			$page = RequestUtil::Get('page');

			if ($page != '')
			{
				$pagesize = $this->GetDefaultPageSize();

				$pacientes = $this->Phreezer->Query('Paciente',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $pacientes->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $pacientes->TotalResults;
				$output->totalPages = $pacientes->TotalPages;
				$output->pageSize = $pacientes->PageSize;
				$output->currentPage = $pacientes->CurrentPage;
			}
			else
			{
				// retornar todos os resultados
				$pacientes = $this->Phreezer->Query('Paciente',$criteria);
				$output->rows = $pacientes->ToObjectArray(true, $this->SimpleObjectParams());
				$output->totalResults = count($output->rows);
				$output->totalPages = 1;
				$output->pageSize = $output->totalResults;
				$output->currentPage = 1;
			}


			$this->RenderJSON($output, $this->JSONPCallback());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	public function Read()
	{
		try
		{
			$pk = $this->GetRouter()->GetUrlParam('idpaciente');
			$paciente = $this->Phreezer->Get('Paciente',$pk);
			$this->RenderJSON($paciente, $this->JSONPCallback(), true, $this->SimpleObjectParams());
		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	public function Create()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$paciente = new Paciente($this->Phreezer);

			// $paciente->Idpaciente = $this->SafeGetVal($json, 'idpaciente');

			$paciente->Nome = $this->SafeGetVal($json, 'nome');
			$paciente->Datanasc = date('D-m-y H:i:s',strtotime($this->SafeGetVal($json, 'datanasc')));
			$paciente->Logradouro = $this->SafeGetVal($json, 'logradouro');
			$paciente->Numero = $this->SafeGetVal($json, 'numero');
			$paciente->Bairro = $this->SafeGetVal($json, 'bairro');
			$paciente->Cidade = $this->SafeGetVal($json, 'cidade');
			$paciente->Uf = $this->SafeGetVal($json, 'uf');

			$paciente->Validate();
			$errors = $paciente->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$paciente->Save();
				$this->RenderJSON($paciente, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}

	public function Update()
	{
		try
		{
						
			$json = json_decode(RequestUtil::GetBody());

			if (!$json)
			{
				throw new Exception('The request body does not contain valid JSON');
			}

			$pk = $this->GetRouter()->GetUrlParam('idpaciente');
			$paciente = $this->Phreezer->Get('Paciente',$pk);

			// $paciente->Idpaciente = $this->SafeGetVal($json, 'idpaciente', $paciente->Idpaciente);

			$paciente->Nome = $this->SafeGetVal($json, 'nome', $paciente->Nome);
			$paciente->Datanasc = date('D-m-y',strtotime($this->SafeGetVal($json, 'datanasc', $paciente->Datanasc)));
			$paciente->Logradouro = $this->SafeGetVal($json, 'logradouro', $paciente->Logradouro);
			$paciente->Numero = $this->SafeGetVal($json, 'numero', $paciente->Numero);
			$paciente->Bairro = $this->SafeGetVal($json, 'bairro', $paciente->Bairro);
			$paciente->Cidade = $this->SafeGetVal($json, 'cidade', $paciente->Cidade);
			$paciente->Uf = $this->SafeGetVal($json, 'uf', $paciente->Uf);

			$paciente->Validate();
			$errors = $paciente->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Verifique erros no formulário',$errors);
			}
			else
			{
				$paciente->Save();
				$this->RenderJSON($paciente, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{


			$this->RenderExceptionJSON($ex);
		}
	}

	public function Delete()
	{
		try
		{
						

			$pk = $this->GetRouter()->GetUrlParam('idpaciente');
			$paciente = $this->Phreezer->Get('Paciente',$pk);

			$paciente->Delete();

			$output = new stdClass();

			$this->RenderJSON($output, $this->JSONPCallback());

		}
		catch (Exception $ex)
		{
			$this->RenderExceptionJSON($ex);
		}
	}
}

?>
