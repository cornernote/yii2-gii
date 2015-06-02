<?php

namespace cornernote\giitools\giiant\crud\providers;

use cornernote\giitools\helpers\TabPadding;

class DateProvider extends \schmunk42\giiant\crud\providers\DateProvider
{
    public function activeField($attribute)
    {
        return TabPadding::pad(parent::activeField($attribute));
    }
}