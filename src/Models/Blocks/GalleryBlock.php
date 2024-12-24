<?php

namespace Toast\Blocks;

use Toast\Blocks\Block;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\DropdownField;
use Toast\Blocks\Items\GalleryBlockItem;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RecordEditor;

class GalleryBlock extends Block
{
    private static $table_name = 'Blocks_GalleryBlock';

    private static $singular_name = 'Media Gallery';

    private static $plural_name = 'Media Gallery';

    private static $db = [
        'Heading'  => 'Varchar(255)',
        'Content' => 'HTMLText',
        'Columns'  => 'Enum("2,3,4", "2")'
    ];

    private static $has_many = [
        'Items'    => GalleryBlockItem::class
    ];

    public function getCMSFields()
    {

        $this->beforeUpdateCMSFields(function ($fields) {
            $fields->removeByName('Items');

            $fields->addFieldsToTab('Root.Main', [
                TextField::create('Heading', 'Heading'),
                HTMLEditorField::create('Content', 'Content')
            ]);

            if ($this->exists()) {
                $config = GridFieldConfig_RecordEditor::create();
                $config->addComponent(GridFieldOrderableRows::create('SortOrder'));
                $grid = GridField::create('Items', 'Items', $this->Items(), $config);
                $fields->addFieldsToTab('Root.Main', [
                    DropdownField::create('Columns', 'Columns', $this->dbObject('Columns')->enumValues()),
                    $grid
                ]);
            }else{
                $fields->addFieldToTab('Root.Main', LiteralField::create('Notice', '<div class="message notice">Save this block and more options will become available.</div>'));
            }
        });
        return parent::getCMSFields();
    }

}
