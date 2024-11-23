<?php

namespace DFT\SilverStripe\ModelAdminPlus;

use SilverStripe\Forms\FormField;
use TractorCow\AutoComplete\AutoCompleteField as TractorCowAutoCompleteField;

/**
 * Custom autocomplete that loads extra GraphQL data
 */
class AutoCompleteField extends TractorCowAutoCompleteField
{
    //protected $schemaDataType = FormField::SCHEMA_DATA_TYPE_CUSTOM;

    public function getSchemaDataDefaults()
    {
        $data = parent::getSchemaDataDefaults();

        $data['placeholder'] = 'Search on ' . implode(' or ', $this->getSourceFields());

        if (!isset($data['attributes'])) {
            $data['attributes'] = [];
        }

        $data['attributes'] = array_merge(
            $data['attributes'],
            [
                'data-source' => $this->getSuggestURL(),
                'data-min-length' => $this->getMinSearchLength(),
                'data-require-selection' => $this->getRequireSelection(),
                'data-pop-separate' => $this->getPopulateSeparately(),
                'data-clear-input' => $this->getClearInput()
            ]
        );

        // Override the value so we start with a clear search form (depending on configuration).
        if ($this->getPopulateSeparately()) {
            $data['value'] = null;
        } else {
            $data['value'] = $this->Value();
        }

        return $data;
    }

    public function getSchemaStateDefaults()
    {
        $state = parent::getSchemaStateDefaults();

        $state['data']['autocomplete'] = [
            'source' => $this->getSuggestURL(),
            'min-length' => $this->getMinSearchLength(),
            'require-selection' => $this->getRequireSelection(),
            'pop-separate' => $this->getPopulateSeparately(),
            'clear-input' => $this->getClearInput()
        ];

        return $state;
    }
}
