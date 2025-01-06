<?php

namespace Toast\Blocks\Items;

use Toast\Blocks\LinkBlock;
use SilverStripe\Assets\File;
use SilverStripe\Forms\TextField;
use Sheadawson\Linkable\Models\Link;
use SilverStripe\Forms\TextareaField;
use Sheadawson\Linkable\Forms\LinkField;
use SilverStripe\AssetAdmin\Forms\UploadField;

class LinkBlockItem extends BlockItem
{
    private static $table_name = 'Blocks_LinkBlockItem';

    private static $db = [
        'Title' => 'Varchar(255)',
        'Summary' => 'Text',
    ];

    private static $has_one = [
        'Link'   => Link::class,
        'Image'  => File::class,
        'Parent' => LinkBlock::class
    ];

    private static $summary_fields = [
        'Title' => 'Title',
    ];
    private static $owns = [
        'Image',
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {

            $fields->addFieldsToTab('Root.Main', [
                UploadField::create('Image', 'Image')
                    ->setFolderName('Uploads/Blocks')
                    ->setAllowedExtensions(['jpg', 'jpeg', 'png', 'gif', 'svg', 'webp']),
                TextField::create('Title', 'Title'),
                TextareaField::create('Summary', 'Summary'),
                LinkField::create('LinkID', 'Link'),
            ]);

        });

        return parent::getCMSFields();
    }
}
