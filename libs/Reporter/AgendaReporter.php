<?php
require_once("verysimple/Phreeze/Reporter.php");

class AgendaReporter extends Reporter
{

	public $CustomFieldExample;

	public $Datahora;
	public $Nome;
	public $Idexame;
	public $Idpaciente;
	public $Obs;
	public $Resultado;

	static function GetCustomQuery($criteria)
	{
		$sql = "select
			'custom value here...' as CustomFieldExample
			,`agenda`.`dataHora` as Datahora
			,`agenda`.`nome` as Nome
			,`agenda`.`idExame` as Idexame
			,`agenda`.`idPaciente` as Idpaciente
			,`agenda`.`obs` as Obs
			,`agenda`.`resultado` as Resultado
		from `agenda`";

		$sql .= $criteria->GetWhere();
		$sql .= $criteria->GetOrder();

		return $sql;
	}
	
	static function GetCustomCountQuery($criteria)
	{
		$sql = "select count(1) as counter from `agenda`";

		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>