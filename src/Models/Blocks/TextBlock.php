<?php

namespace Toast\Blocks;

use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\RequiredFields;

class TextBlock extends Block
{
    private static $table_name = 'Blocks_TextBlock';

    private static $singular_name = 'Text';

    private static $plural_name = 'Text';

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

        });

        return parent::getCMSFields();
    }

    public function getContentSummary()
    {
        return $this->dbObject('Content')->LimitCharacters(250);
    }

    public function getCMSValidator()
    {
        $required = new RequiredFields(['Content']);

        $this->extend('updateCMSValidator', $required);

        return $required;
    }
}
