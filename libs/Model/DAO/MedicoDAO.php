<?php
require_once("verysimple/Phreeze/Phreezable.php");
require_once("MedicoMap.php");

class MedicoDAO extends Phreezable
{
	public $Idmedico;

	public $Nome;

	public $Crm;


	public function GetNomeAgendas($criteria = null)
	{
		return $this->_phreezer->GetOneToMany($this, "FK_MEDICO_AGENDA", $criteria);
	}


}
?>