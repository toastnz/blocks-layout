<?php

namespace Toast\Blocks\Items;

use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\ReadonlyField;

class BlockItem extends DataObject
{
    private static $table_name = 'Blocks_BlockItem';

    private static $db = [
        'SortOrder' => 'Int'
    ];

    public function getCMSFields()
    {
        $this->beforeUpdateCMSFields(function ($fields) {
            if ($this->ID) {
                if ($preview = $this->getPagePreview()) {
                    $fields->addFieldToTab('Root.Main', $preview);
                }

                $fields->addFieldsToTab('Root.More', [
                    ReadonlyField::create('BlockID', 'Item ID', $this->getBlockItemID()),
                ]);
            }

            $fields->removeByName([
                'ParentID',
                'SortOrder',
                'FileTracking',
                'LinkTracking'
            ]);

        });

        return parent::getCMSFields();
    }

    public function getBlockItemID()
    {
        return $this->Parent()->getBlockID() . '_' . $this->ID;
    }

    public function getPagePreview() {
        if ($this->hasMethod('Parent')) {
            $id = $this->getBlockItemID();
            return $this->Parent()->getPagePreview($id);
        }

        return null;
    }

    public function canView($member = null)
    {
        if ($this->hasMethod('Parent')) {
            return $this->Parent()->canView($member);
        }

        return parent::canView($member);
    }

    public function canEdit($member = null)
    {
        if ($this->hasMethod('Parent')) {
            return $this->Parent()->canEdit($member);
        }

        return parent::canEdit($member);
    }

    public function canDelete($member = null)
    {
        if ($this->hasMethod('Parent')) {
            return $this->Parent()->canDelete($member);
        }

        return parent::canEdit($member);
    }

    public function canCreate($member = null, $context = [])
    {
        if ($this->hasMethod('Parent')) {
            return $this->Parent()->canCreate($member, $context);
        }

        return parent::canCreate($member, $context);

    }


}
