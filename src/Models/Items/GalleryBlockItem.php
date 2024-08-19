<?php

namespace Toast\Blocks\Items;

use SilverStripe\ORM\DB;
use Toast\Blocks\GalleryBlock;
use SilverStripe\Assets\Image;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
use SilverStripe\Forms\TextareaField;
use Axllent\FormFields\FieldType\VideoLink;
use Axllent\FormFields\Forms\VideoLinkField;
use SilverStripe\AssetAdmin\Forms\UploadField;

class GalleryBlockItem extends BlockItem
{
    private static $table_name = 'GalleryBlockItem';

    private static $db = [
        'Video'         => VideoLink::class,
    ];

    private static $has_one = [
        'Image'  => Image::class,
        'Parent' => GalleryBlock::class
    ];

    private static $owns = [
        'Image'
    ];

    private static $summary_fields = [
        'Image.CMSThumbnail' => 'Image'
    ];
    private static $default_sort = 'SortOrder ASC';

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
           'SortOrder',
            'GalleryBlockID'
        ]);

        $fields->addFieldsToTab('Root.Main',
        [
            UploadField::create(
                'Image',
                'Image'
            )->setFolderName('Uploads/Media'),
            VideoLinkField::create(
                'Video',
                'Video'
            )->showPreview('100%')
        ]);

        return $fields;
    }


}
