<?php
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

class MedicoMap implements IDaoMap, IDaoMap2
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
			self::$FM["Idmedico"] = new FieldMap("Idmedico","medico","idMedico",true,FM_TYPE_INT,11,null,true);
			self::$FM["Nome"] = new FieldMap("Nome","medico","nome",false,FM_TYPE_VARCHAR,60,null,false);
			self::$FM["Crm"] = new FieldMap("Crm","medico","crm",false,FM_TYPE_VARCHAR,15,null,false);
		}
		return self::$FM;
	}

	public static function GetKeyMaps()
	{
		if (self::$KM == null)
		{
			self::$KM = Array();
			self::$KM["FK_MEDICO_AGENDA"] = new KeyMap("FK_MEDICO_AGENDA", "Idmedico", "Agenda", "Nome", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
		}
		return self::$KM;
	}

}

?>