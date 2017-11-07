<?php
require_once("verysimple/Phreeze/IDaoMap.php");
require_once("verysimple/Phreeze/IDaoMap2.php");

class ExameMap implements IDaoMap, IDaoMap2
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
			self::$FM["Idexame"] = new FieldMap("Idexame","exame","idExame",true,FM_TYPE_INT,11,null,true);
			self::$FM["Nome"] = new FieldMap("Nome","exame","nome",false,FM_TYPE_VARCHAR,40,null,false);
			self::$FM["Valor"] = new FieldMap("Valor","exame","valor",false,FM_TYPE_UNKNOWN,6.2,null,false);
		}
		return self::$FM;
	}

	public static function GetKeyMaps()
	{
		if (self::$KM == null)
		{
			self::$KM = Array();
			self::$KM["FK_EXAME_AGENDA"] = new KeyMap("FK_EXAME_AGENDA", "Idexame", "Agenda", "Nome", KM_TYPE_ONETOMANY, KM_LOAD_LAZY);  // use KM_LOAD_EAGER with caution here (one-to-one relationships only)
		}
		return self::$KM;
	}

}

?>