<?php
require_once("DAO/PacienteDAO.php");
require_once("PacienteCriteria.php");

class Paciente extends PacienteDAO
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
		if (!$this->Validate()) throw new Exception('Unable to Save Paciente: ' .  implode(', ', $this->GetValidationErrors()));

		return true;
	}

}

?>
