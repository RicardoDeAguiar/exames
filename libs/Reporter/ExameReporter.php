<?php
require_once("verysimple/Phreeze/Reporter.php");

class ExameReporter extends Reporter
{

	public $CustomFieldExample;

	public $Idexame;
	public $Nome;
	public $Valor;

	static function GetCustomQuery($criteria)
	{
		$sql = "select
			'custom value here...' as CustomFieldExample
			,`exame`.`idExame` as Idexame
			,`exame`.`nome` as Nome
			,`exame`.`valor` as Valor
		from `exame`";

		$sql .= $criteria->GetWhere();
		$sql .= $criteria->GetOrder();

		return $sql;
	}
	
	static function GetCustomCountQuery($criteria)
	{
		$sql = "select count(1) as counter from `exame`";

		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>