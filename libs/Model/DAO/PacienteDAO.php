<?php
require_once("verysimple/Phreeze/Phreezable.php");
require_once("PacienteMap.php");

class PacienteDAO extends Phreezable
{
	public $Idpaciente;

	public $Nome;

	public $Datanasc;

	public $Logradouro;

	public $Numero;

	public $Bairro;

	public $Cidade;

	public $Uf;


	public function GetNomeAgendas($criteria = null)
	{
		return $this->_phreezer->GetOneToMany($this, "FK_PAC_AGENDA", $criteria);
	}


}
?>