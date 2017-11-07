<?php
require_once("AppBaseController.php");
require_once("Model/Medico.php");

class MedicoController extends AppBaseController
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
			$criteria = new MedicoCriteria();
			
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Idmedico,Nome,Crm'
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

				$medicos = $this->Phreezer->Query('Medico',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $medicos->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $medicos->TotalResults;
				$output->totalPages = $medicos->TotalPages;
				$output->pageSize = $medicos->PageSize;
				$output->currentPage = $medicos->CurrentPage;
			}
			else
			{
				// retornar todos os resultados
				$medicos = $this->Phreezer->Query('Medico',$criteria);
				$output->rows = $medicos->ToObjectArray(true, $this->SimpleObjectParams());
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
			$pk = $this->GetRouter()->GetUrlParam('idmedico');
			$medico = $this->Phreezer->Get('Medico',$pk);
			$this->RenderJSON($medico, $this->JSONPCallback(), true, $this->SimpleObjectParams());
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
				throw new Exception('O corpo do pedido não contém JSON válido');
			}

			$medico = new Medico($this->Phreezer);

			// $medico->Idmedico = $this->SafeGetVal($json, 'idmedico');

			$medico->Nome = $this->SafeGetVal($json, 'nome');
			$medico->Crm = $this->SafeGetVal($json, 'crm');

			$medico->Validate();
			$errors = $medico->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Verifique erros no formulário',$errors);
			}
			else
			{
				$medico->Save();
				$this->RenderJSON($medico, $this->JSONPCallback(), true, $this->SimpleObjectParams());
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
				throw new Exception('O corpo do pedido não contém JSON válido');
			}

			$pk = $this->GetRouter()->GetUrlParam('idmedico');
			$medico = $this->Phreezer->Get('Medico',$pk);

			// $medico->Idmedico = $this->SafeGetVal($json, 'idmedico', $medico->Idmedico);

			$medico->Nome = $this->SafeGetVal($json, 'nome', $medico->Nome);
			$medico->Crm = $this->SafeGetVal($json, 'crm', $medico->Crm);

			$medico->Validate();
			$errors = $medico->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Verifique erros no formulário',$errors);
			}
			else
			{
				$medico->Save();
				$this->RenderJSON($medico, $this->JSONPCallback(), true, $this->SimpleObjectParams());
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
						

			$pk = $this->GetRouter()->GetUrlParam('idmedico');
			$medico = $this->Phreezer->Get('Medico',$pk);

			$medico->Delete();

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
