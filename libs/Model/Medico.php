<?php
require_once("DAO/MedicoDAO.php");
require_once("MedicoCriteria.php");

class Medico extends MedicoDAO
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

		if (!$this->Validate()) throw new Exception('Unable to Save Medico: ' .  implode(', ', $this->GetValidationErrors()));

		return true;
	}

}

?>
