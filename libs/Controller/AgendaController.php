<?php
require_once("AppBaseController.php");
require_once("Model/Agenda.php");

class AgendaController extends AppBaseController
{

	protected function Init()
	{
		parent::Init();
		
		//se a autenticação for necessária para este controlador inteiro, por exemplo:
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
			$criteria = new AgendaCriteria();
			
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Datahora,Nome,Idexame,Idpaciente,Obs,Resultado'
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

				$agendas = $this->Phreezer->Query('Agenda',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $agendas->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $agendas->TotalResults;
				$output->totalPages = $agendas->TotalPages;
				$output->pageSize = $agendas->PageSize;
				$output->currentPage = $agendas->CurrentPage;
			}
			else
			{
				// retornar todos os resultados
				$agendas = $this->Phreezer->Query('Agenda',$criteria);
				$output->rows = $agendas->ToObjectArray(true, $this->SimpleObjectParams());
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
			$pk = $this->GetRouter()->GetUrlParam('datahora');
			$agenda = $this->Phreezer->Get('Agenda',$pk);
			$this->RenderJSON($agenda, $this->JSONPCallback(), true, $this->SimpleObjectParams());
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

			$agenda = new Agenda($this->Phreezer);


			$agenda->Datahora = date('Y-m-d H:i:s',strtotime($this->SafeGetVal($json, 'datahora')));
			$agenda->Nome = $this->SafeGetVal($json, 'nome');
			$agenda->Idexame = $this->SafeGetVal($json, 'idexame');
			$agenda->Idpaciente = $this->SafeGetVal($json, 'idpaciente');
			$agenda->Obs = $this->SafeGetVal($json, 'obs');
			$agenda->Resultado = $this->SafeGetVal($json, 'resultado');

			$agenda->Validate();
			$errors = $agenda->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$agenda->Save(true);
				$this->RenderJSON($agenda, $this->JSONPCallback(), true, $this->SimpleObjectParams());
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

			$pk = $this->GetRouter()->GetUrlParam('datahora');
			$agenda = $this->Phreezer->Get('Agenda',$pk);


			// Esta é uma chave primária. descomente se a atualização for permitida
			// $agenda->Datahora = $this->SafeGetVal($json, 'datahora', $agenda->Datahora);

			// Esta é uma chave primária. descomente se a atualização for permitida
			// $agenda->Nome = $this->SafeGetVal($json, 'nome', $agenda->Nome);

			// Esta é uma chave primária. descomente se a atualização for permitida
			// $agenda->Idexame = $this->SafeGetVal($json, 'idexame', $agenda->Idexame);

			// Esta é uma chave primária. descomente se a atualização for permitida
			// $agenda->Idpaciente = $this->SafeGetVal($json, 'idpaciente', $agenda->Idpaciente);

			$agenda->Obs = $this->SafeGetVal($json, 'obs', $agenda->Obs);
			$agenda->Resultado = $this->SafeGetVal($json, 'resultado', $agenda->Resultado);

			$agenda->Validate();
			$errors = $agenda->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Please check the form for errors',$errors);
			}
			else
			{
				$agenda->Save();
				$this->RenderJSON($agenda, $this->JSONPCallback(), true, $this->SimpleObjectParams());
			}


		}
		catch (Exception $ex)
		{

			if (is_a($ex,'NotFoundException'))
			{
				return $this->Create();
			}

			$this->RenderExceptionJSON($ex);
		}
	}

	public function Delete()
	{
		try
		{
						

			$pk = $this->GetRouter()->GetUrlParam('datahora');
			$agenda = $this->Phreezer->Get('Agenda',$pk);

			$agenda->Delete();

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
