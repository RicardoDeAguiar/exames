<?php
require_once("verysimple/Phreeze/Phreezable.php");
require_once("AgendaMap.php");

class AgendaDAO extends Phreezable
{
	public $Datahora;

	public $Nome;

	public $Idexame;

	public $Idpaciente;

	public $Obs;

	public $Resultado;


	public function GetNomeExame()
	{
		return $this->_phreezer->GetManyToOne($this, "FK_EXAME_AGENDA");
	}

	public function GetNomeMedico()
	{
		return $this->_phreezer->GetManyToOne($this, "FK_MEDICO_AGENDA");
	}

	public function GetNomePaciente()
	{
		return $this->_phreezer->GetManyToOne($this, "FK_PAC_AGENDA");
	}


}
?>