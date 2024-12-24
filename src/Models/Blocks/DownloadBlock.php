<?php

namespace Toast\Blocks;

use SilverStripe\Forms\TextField;
use SilverStripe\ORM\FieldType\DBField;
use Toast\Blocks\Items\DownloadBlockItem;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\HTMLEditor\HTMLEditorField;
use SilverStripe\Forms\GridField\GridFieldDeleteAction;
use Symbiote\GridFieldExtensions\GridFieldOrderableRows;
use SilverStripe\Forms\GridField\GridFieldConfig_RelationEditor;
use SilverStripe\Forms\GridField\GridFieldAddExistingAutoCompleter;
use SilverStripe\Forms\LiteralField;

class DownloadBlock extends Block
{
    private static $table_name = 'Blocks_DownloadBlock';

    private static $singular_name = 'Download';

    private static $plural_name = 'Downloads';

    private static $db = [
        'Heading' => 'Varchar(255)',
        'Content' => 'HTMLText'
    ];

    private static $has_many = [
        'Items' => DownloadBlockItem::class
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->removeByName('Items');

            $fields->addFieldsToTab('Root.Main', [
                TextField::create('Heading', 'Heading'),
                HTMLEditorField::create('Content', 'Content')
            ]);

            if ($this->ID) {
                $config = GridFieldConfig_RelationEditor::create(50)
                    ->removeComponentsByType(GridFieldAddExistingAutoCompleter::class)
                    ->removeComponentsByType(GridFieldDeleteAction::class)
                    ->addComponents(new GridFieldDeleteAction())
                    ->addComponents(GridFieldOrderableRows::create('SortOrder'));
                $grid = GridField::create('Items', 'Files', $this->Items(), $config);
                $fields->addFieldToTab('Root.Main', $grid);

            } else {
                $fields->addFieldToTab('Root.Main', LiteralField::create('', '<div class="message notice">Save this block to show additional options.</div>'));
            }
        });

        return parent::getCMSFields();

    }

    public function getContentSummary()
    {
        if ($this->Items()) {
            return DBField::create_field('Text', implode(', ', $this->Items()->column('Title')));
        }

        return DBField::create_field('Text', $this->Title);
    }


}
