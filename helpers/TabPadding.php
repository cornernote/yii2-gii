<?php

namespace cornernote\giitools\helpers;

class TabPadding
{

    public static function pad($data, $tabs = 1)
    {
        if ($data === null) return null;
        $tabString = str_repeat('    ', $tabs);
        $array = explode("\n", $data);
        foreach ($array as $k => &$v) if ($k) $v = $tabString . $v;
        return implode("\n", $array);
    }

}