<?php
require_once("verysimple/Phreeze/Reporter.php");

class PacienteReporter extends Reporter
{

	public $CustomFieldExample;

	public $Idpaciente;
	public $Nome;
	public $Datanasc;
	public $Logradouro;
	public $Numero;
	public $Bairro;
	public $Cidade;
	public $Uf;

	static function GetCustomQuery($criteria)
	{
		$sql = "select
			'custom value here...' as CustomFieldExample
			,`paciente`.`idPaciente` as Idpaciente
			,`paciente`.`nome` as Nome
			,`paciente`.`dataNasc` as Datanasc
			,`paciente`.`logradouro` as Logradouro
			,`paciente`.`numero` as Numero
			,`paciente`.`bairro` as Bairro
			,`paciente`.`cidade` as Cidade
			,`paciente`.`uf` as Uf
		from `paciente`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();
		$sql .= $criteria->GetOrder();

		return $sql;
	}
	
	
	static function GetCustomCountQuery($criteria)
	{
		$sql = "select count(1) as counter from `paciente`";

		// the criteria can be used or you can write your own custom logic.
		// be sure to escape any user input with $criteria->Escape()
		$sql .= $criteria->GetWhere();

		return $sql;
	}
}

?>