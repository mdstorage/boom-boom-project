<?php
class Functions
{
    public static function prodToDate($prod)
    {
        if ($prod){
            return substr($prod, -2) . '/' . substr($prod, 0, 4);
        } else {
            return '...';
        }

    }
}