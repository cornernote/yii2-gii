<?php

namespace cornernote\giitools\giiant\crud\providers;


class DateTimeProvider extends \schmunk42\giiant\crud\providers\DateTimeProvider
{
    public function activeField($attribute)
    {
        $data = parent::activeField($attribute);
        if ($data === null) return null;
        $data = explode("\n", $data);
        foreach ($data as $k => &$v) if ($k) $v = '    ' . $v;
        $data = implode("\n", $data);
        return $data;
    }
}