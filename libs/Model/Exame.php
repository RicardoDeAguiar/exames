<?php
require_once("DAO/ExameDAO.php");
require_once("ExameCriteria.php");

class Exame extends ExameDAO
{

	public function Validate()
	{
		// $this->ResetValidationErrors();
		// $errors = $this->GetValidationErrors();
		// if ($error == true) $this->AddValidationError('FieldName', 'Error Information');
		// return !$this->HasValidationErrors();

		return parent::Validate();
	}

	public function OnSave($insert)
	{
		if (!$this->Validate()) throw new Exception('Unable to Save Exame: ' .  implode(', ', $this->GetValidationErrors()));

		return true;
	}

}

?>
