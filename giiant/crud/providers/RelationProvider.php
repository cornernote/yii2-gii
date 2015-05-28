<?php

namespace cornernote\giitools\giiant\crud\providers;

use cornernote\giitools\helpers\TabPadding;

class RelationProvider extends \schmunk42\giiant\crud\providers\RelationProvider
{

    public function columnFormat($column, $model)
    {
        return TabPadding::pad(parent::columnFormat($column, $model), 4);
    }

    public function activeField($column)
    {
        return TabPadding::pad(parent::activeField($column));
    }

}