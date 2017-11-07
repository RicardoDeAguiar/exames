<?php
require_once("AppBaseController.php");
require_once("Model/Exame.php");

class ExameController extends AppBaseController
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
			$criteria = new ExameCriteria();
			
			$filter = RequestUtil::Get('filter');
			if ($filter) $criteria->AddFilter(
				new CriteriaFilter('Idexame,Nome,Valor'
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

				$exames = $this->Phreezer->Query('Exame',$criteria)->GetDataPage($page, $pagesize);
				$output->rows = $exames->ToObjectArray(true,$this->SimpleObjectParams());
				$output->totalResults = $exames->TotalResults;
				$output->totalPages = $exames->TotalPages;
				$output->pageSize = $exames->PageSize;
				$output->currentPage = $exames->CurrentPage;
			}
			else
			{
				// retornar todos os resultados
				$exames = $this->Phreezer->Query('Exame',$criteria);
				$output->rows = $exames->ToObjectArray(true, $this->SimpleObjectParams());
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
			$pk = $this->GetRouter()->GetUrlParam('idexame');
			$exame = $this->Phreezer->Get('Exame',$pk);
			$this->RenderJSON($exame, $this->JSONPCallback(), true, $this->SimpleObjectParams());
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

			$exame = new Exame($this->Phreezer);

			// $exame->Idexame = $this->SafeGetVal($json, 'idexame');

			$exame->Nome = $this->SafeGetVal($json, 'nome');
			$exame->Valor = $this->SafeGetVal($json, 'valor');

			$exame->Validate();
			$errors = $exame->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Verifique erros no formulário',$errors);
			}
			else
			{
				$exame->Save();
				$this->RenderJSON($exame, $this->JSONPCallback(), true, $this->SimpleObjectParams());
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

			$pk = $this->GetRouter()->GetUrlParam('idexame');
			$exame = $this->Phreezer->Get('Exame',$pk);

			// $exame->Idexame = $this->SafeGetVal($json, 'idexame', $exame->Idexame);

			$exame->Nome = $this->SafeGetVal($json, 'nome', $exame->Nome);
			$exame->Valor = $this->SafeGetVal($json, 'valor', $exame->Valor);

			$exame->Validate();
			$errors = $exame->GetValidationErrors();

			if (count($errors) > 0)
			{
				$this->RenderErrorJSON('Verifique erros no formulário',$errors);
			}
			else
			{
				$exame->Save();
				$this->RenderJSON($exame, $this->JSONPCallback(), true, $this->SimpleObjectParams());
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
						

			$pk = $this->GetRouter()->GetUrlParam('idexame');
			$exame = $this->Phreezer->Get('Exame',$pk);

			$exame->Delete();

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
