<?php

namespace cornernote\giitools\helpers;

class TabPadding
{

    public static function pad($data, $tabs = 1, $padFirstLine = false)
    {
        if ($data === null) return null;
        $tabString = str_repeat('    ', $tabs);
        $array = explode("\n", $data);
        foreach ($array as $k => &$v) if ($v && ($k || $padFirstLine)) $v = $tabString . $v;
        return implode("\n", $array);
    }

}