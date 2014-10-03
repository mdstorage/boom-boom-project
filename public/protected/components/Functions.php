<?php
class Functions
{
    const GROUP_1 = "Двигатель / Топливная система / Принадлежности";
    const GROUP_2 = "Трансмиссия / Подвеска";
    const GROUP_3 = "Кузов";
    const GROUP_4 = "Электрика";

    public static function prodToDate($prod)
    {
        if ($prod){
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
        }

        return $groupName;
    }
}