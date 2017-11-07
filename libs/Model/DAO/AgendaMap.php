<?php
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

class AgendaMap implements IDaoMap, IDaoMap2
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
			self::$FM["Datahora"] = new FieldMap("Datahora","agenda","dataHora",true,FM_TYPE_TIMESTAMP,null,"CURRENT_TIMESTAMP",false);
			self::$FM["Nome"] = new FieldMap("Nome","agenda","nome",true,FM_TYPE_INT,11,null,false);
			self::$FM["Idexame"] = new FieldMap("Idexame","agenda","idExame",true,FM_TYPE_INT,11,null,false);
			self::$FM["Idpaciente"] = new FieldMap("Idpaciente","agenda","idPaciente",true,FM_TYPE_INT,11,null,false);
			self::$FM["Obs"] = new FieldMap("Obs","agenda","obs",false,FM_TYPE_TEXT,null,null,false);
			self::$FM["Resultado"] = new FieldMap("Resultado","agenda","resultado",false,FM_TYPE_TEXT,null,null,false);
		}
		return self::$FM;
	}

	public static function GetKeyMaps()
	{
		if (self::$KM == null)
		{
			self::$KM = Array();
			self::$KM["FK_EXAME_AGENDA"] = new KeyMap("FK_EXAME_AGENDA", "Nome", "Exame", "Idexame", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["FK_MEDICO_AGENDA"] = new KeyMap("FK_MEDICO_AGENDA", "Nome", "Medico", "Idmedico", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
			self::$KM["FK_PAC_AGENDA"] = new KeyMap("FK_PAC_AGENDA", "Nome", "Paciente", "Idpaciente", KM_TYPE_MANYTOONE, KM_LOAD_LAZY); // you change to KM_LOAD_EAGER here or (preferrably) make the change in _config.php
		}
		return self::$KM;
	}

}

?>