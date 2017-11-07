<?php
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

class PacienteMap implements IDaoMap, IDaoMap2
{

	private static $KM;
	private static $FM;
	
	public static function AddMap($property,FieldMap $map)
	{
		self::GetFieldMaps();
		self::$FM[$property] = $map;
	}
	
	public static function SetFetchingStrategy($property,$loadType)
	{
		self::GetKeyMaps();
		self::$KM[$property]->LoadType = $loadType;
	}

	public static function GetFieldMaps()
	{
		if (self::$FM == null)
		{
			self::$FM = Array();
			self::$FM["Idpaciente"] = new FieldMap("Idpaciente","paciente","idPaciente",true,FM_TYPE_INT,11,null,true);
			self::$FM["Nome"] = new FieldMap("Nome","paciente","nome",false,FM_TYPE_VARCHAR,60,null,false);
			self::$FM["Datanasc"] = new FieldMap("Datanasc","paciente","dataNasc",false,FM_TYPE_TIMESTAMP,null,false);
			self::$FM["Logradouro"] = new FieldMap("Logradouro","paciente","logradouro",false,FM_TYPE_VARCHAR,60,null,false);
			self::$FM["Numero"] = new FieldMap("Numero","paciente","numero",false,FM_TYPE_VARCHAR,10,null,false);
			self::$FM["Bairro"] = new FieldMap("Bairro","paciente","bairro",false,FM_TYPE_VARCHAR,60,null,false);
			self::$FM["Cidade"] = new FieldMap("Cidade","paciente","cidade",false,FM_TYPE_VARCHAR,60,null,false);
			self::$FM["Uf"] = new FieldMap("Uf","paciente","uf",false,FM_TYPE_VARCHAR,2,null,false);
		}
		return self::$FM;
	}

	public static function GetKeyMaps()
	{
		if (self::$KM == null)
		{
			self::$KM = Array();
			self::$KM["FK_PAC_AGENDA"] = new KeyMap("FK_PAC_AGENDA", "Idpaciente", "Agenda", "Nome", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
		}
		return self::$KM;
	}

}

?>