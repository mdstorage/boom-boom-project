<?php
class Functions
{
    const GROUP_1 = "ИНСТРУМЕНТЫ";
    const GROUP_2 = "ДВИГАТЕЛЬ";
    const GROUP_3 = "ТОПЛИВНАЯ СИСТЕМА";
    const GROUP_4 = "ТРАНСМИССИЯ, ПОДВЕСКА, ТОРМОЗНАЯ СИСТЕМА";
    const GROUP_5 = "КУЗОВНЫЕ ДЕТАЛИ, ЭКСТЕРЬЕР, ИНТЕРЬЕР";
    const GROUP_6 = "ЭЛЕКТРИКА, КЛИМАТ-КОНТРОЛЬ";

    const PROD_START = "Дата начала производства";
    const PROD_END = "Дата окончания производства";

    const CD = 'cd';

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

    public static function getGroupNumberBySubGroup($subGroupNumber)
    {
        switch(substr($subGroupNumber, 0, 1)){
            case 0:
                $groupNumber = 1;
                break;
            case 1:
                $groupNumber = 2;
                break;
            case 2:
                $groupNumber = 3;
                break;
            case 3:
                $groupNumber = 4;
                break;
            case 4:
                $groupNumber = 4;
                break;
            case 5:
                $groupNumber = 4;
                break;
            case 6:
                $groupNumber = 5;
                break;
            case 7:
                $groupNumber = 5;
                break;
            case 8:
                $groupNumber = 6;
                break;
            case 9:
                $groupNumber = 6;
                break;
        }
        return $groupNumber;
    }

    public static function getSubGroupsByGroupNumber($groupNumber)
    {
        switch($groupNumber){
            case 1:
                $subGroups = '(0)';
                break;
            case 2:
                $subGroups = '(1)';
                break;
            case 3:
                $subGroups = '(2)';
                break;
            case 4:
                $subGroups = '(3,4,5)';
                break;
            case 5:
                $subGroups = '(6,7)';
                break;
            case 6:
                $subGroups = '(8,9)';
                break;
        }

        return $subGroups;
    }

    public static function getActionParams($class, $function, $funcArgsArray)
    {
        $result = array();
        $reflection = new ReflectionMethod($class, $function);
        $reflectionArray = $reflection->getParameters();

        foreach($funcArgsArray as $code=>$funcArg){
            $result[$reflectionArray[$code]->getName()] = $funcArg;
        }

        return $result;
    }
	
	 public static function getString($string)
	 {
	 	
		$string1 = array(';',',','..','(',')');
		$string2 = array('; ',', ','.. ',' (',') ');
		$string = str_replace($string1, $string2, $string);
		 
		 return $string;
	 }
	
	
	
}