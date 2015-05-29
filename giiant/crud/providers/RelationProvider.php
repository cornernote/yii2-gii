<?php

namespace cornernote\giitools\giiant\crud\providers;

use cornernote\giitools\helpers\TabPadding;

class RelationProvider extends \schmunk42\giiant\crud\providers\RelationProvider
{

    public $inputWidget = 'select2';

    public function columnFormat($column, $model)
    {
        return TabPadding::pad(parent::columnFormat($column, $model), 4);
    }

    public function activeField($column)
    {
        return TabPadding::pad(parent::activeField($column));
    }

    public function attributeFormat($column)
    {
        return TabPadding::pad(parent::attributeFormat($column), 3, true);
    }

    public function relationGrid($name, $relation, $showAllRecords = false)
    {
        return TabPadding::pad(parent::relationGrid($name, $relation, $showAllRecords), 1);
    }

}