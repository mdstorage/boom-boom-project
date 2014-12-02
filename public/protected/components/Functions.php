<?php
class Functions
{
    const GROUP_1 = "ИНСТРУМЕНТЫ";
    const GROUP_2 = "ДВИГАТЕЛЬ";
    const GROUP_3 = "ТОПЛИВНАЯ СИСТЕМА";
    const GROUP_4 = "ТРАНСМИССИЯ, ПОДВЕСКА, ТОРМОЗНАЯ СИСТЕМА";
    const GROUP_5 = "КУЗОВНЫЕ ДЕТАЛИ, ЭКСТЕРЬЕР, ИНТЕРЬЕР";
    const GROUP_6 = "ЭЛЕКТРИКА, КЛИМАТ-КОНТРОЛЬ";


    public static function prodToDate($prod)
    {
        if ($prod && $prod != 999999){
            return substr($prod, -2) . '/' . substr($prod, 0, 4);
        } else {
            return '...';
        }

    }

    public static function getGroupName($groupNumber)
    {
        switch ($groupNumber){
            case 1:
                $groupName = self::GROUP_1;
                break;
            case 2:
                $groupName = self::GROUP_2;
                break;
            case 3:
                $groupName = self::GROUP_3;
                break;
            case 4:
                $groupName = self::GROUP_4;
                break;
            case 5:
                $groupName = self::GROUP_5;
                break;
            case 6:
                $groupName = self::GROUP_6;
                break;
        }

        return $groupName;
    }
	
	 public static function getString($string)
	 {
	 	
		$string1 = array(';',',','..','(',')');
		$string2 = array('; ',', ','.. ',' (',') ');
		$string = str_replace($string1, $string2, $string);
		 
		 return $string;
	 }
	
	
	
}