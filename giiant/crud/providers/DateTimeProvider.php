<?php

namespace cornernote\giitools\giiant\crud\providers;

use cornernote\giitools\helpers\TabPadding;

class DateTimeProvider extends \schmunk42\giiant\crud\providers\DateTimeProvider
{
    public function activeField($attribute)
    {
        return TabPadding::pad(parent::activeField($attribute));
    }
}