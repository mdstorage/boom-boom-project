<?php
/**
 * Created by PhpStorm.
 * User: itm
 * Date: 10.12.14
 * Time: 13:14
 */

class VarExport {
    public static function getExport($var)
    {
        echo "<pre>";
        var_export($var);
        echo "</pre>";
        die;
    }
} 