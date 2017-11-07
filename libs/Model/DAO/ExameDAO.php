<?php
require_once("verysimple/Phreeze/Phreezable.php");
require_once("ExameMap.php");

class ExameDAO extends Phreezable
{
	public $Idexame;

	public $Nome;

	public $Valor;


	public function GetNomeAgendas($criteria = null)
	{
		return $this->_phreezer->GetOneToMany($this, "FK_EXAME_AGENDA", $criteria);
	}


}
?>