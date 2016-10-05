<?php

namespace cornernote\gii\giiant\crud\providers;

use cornernote\gii\helpers\TabPadding;

class DateTimeProvider extends \schmunk42\giiant\generators\crud\providers\extensions\DateTimeProvider
{
    public function activeField($attribute)
    {
        return TabPadding::pad(parent::activeField($attribute));
    }
}