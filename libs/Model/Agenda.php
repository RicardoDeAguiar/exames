<?php
require_once("DAO/AgendaDAO.php");
require_once("AgendaCriteria.php");

class Agenda extends AgendaDAO
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
		if (!$this->Validate()) throw new Exception('Unable to Save Agenda: ' .  implode(', ', $this->GetValidationErrors()));

		// OnSave must return true or Phreeze will cancel the save operation
		return true;
	}

}

?>
