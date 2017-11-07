<?php
require_once("verysimple/Phreeze/Reporter.php");

class MedicoReporter extends Reporter
{

	public $CustomFieldExample;

	public $Idmedico;
	public $Nome;
	public $Crm;

	static function GetCustomQuery($criteria)
	{
		$sql = "select
			'custom value here...' as CustomFieldExample
			,`medico`.`idMedico` as Idmedico
			,`medico`.`nome` as Nome
			,`medico`.`crm` as Crm
		from `medico`";

		$sql .= $criteria->GetWhere();
		$sql .= $criteria->GetOrder();

		return $sql;
	}
	
	static function GetCustomCountQuery($criteria)
	{
		$sql = "select count(1) as counter from `medico`";

		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>