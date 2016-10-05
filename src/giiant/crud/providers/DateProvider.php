<?php

namespace cornernote\gii\giiant\crud\providers;

use cornernote\gii\helpers\TabPadding;

class DateProvider extends \schmunk42\giiant\generators\crud\providers\extensions\DateProvider
{
    public function activeField($attribute)
    {
        return TabPadding::pad(parent::activeField($attribute));
    }
}