<?php

namespace DFT\SilverStripe\ModelAdminPlus;

use SilverStripe\ORM\SS_List;
use SilverStripe\Core\ClassInfo;
use SilverStripe\ORM\DataObject;
use SilverStripe\Forms\TextField;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\Search\SearchContext as SSSearchContext;

class SearchContext extends SSSearchContext
{
    /**
     * Use autocomplete fields instead of text fields
     * 
     * @var boolean
     */
    protected $convert_to_autocomplete = true;

    /**
     * Allow generation of a default filter, either
     * via a config variable or more complex logic
     * that can be added via overwriting this method
     *
     * In order to add this via config, you will need
     * to add a config variable that includes the field
     * name as a key and the query as the value, for
     * example:
     * 
     *   private static $default_search_filter = [
     *     'Status' => 'New',
     *     'Created:GreaterThan' => '2021-01-01'
     *   ];
     *
     * @return string[]
     */
    public function getDefaultFilter(): array
    {
        /** @var DataObject */
        $obj = singleton($this->modelClass);

        if ($obj->hasMethod('getDefaultSearchFilter')) {
            $default = $obj->getDefaultSearchFilter();
        } else {
            $default = [];
        }

        return $default;
    }

    /**
     * Extend default search fields and add extra functionality.
     * 
     * @return \SilverStripe\Forms\FieldList
     */
    public function getSearchFields()
    {
        $fields = parent::getSearchFields();
        $class = $this->modelClass;
        $use_autocomplete = $this->getConvertToAutocomplete();

        $db = Config::inst()->get($class, "db");
        $has_one = Config::inst()->get($class, "has_one");
        $has_many = Config::inst()->get($class, "has_many");
        $many_many = Config::inst()->get($class, "many_many");
        $belongs_many_many = Config::inst()->get($class, "belongs_many_many");
        $associations = array_merge(
            $has_one,
            $has_many,
            $many_many,
            $belongs_many_many
        );

        // Update search fields to autocomplete
        foreach ($fields as $field) {
            $field_class = $this->modelClass;
            $name = $field->getName();
            $title = $field->Title();
            $db_field = $name;
            $in_db = false;

            // Find any text fields an replace with autocomplete fields
            if (ClassInfo::class_name($field) == TextField::class && $use_autocomplete) {
                // If this is a relation, switch class name
                if (strpos($name, "__")) {
                    $parts = explode("__", $db_field);
                    $object = singleton($this->modelClass)->relObject($parts[0]);
                    $field_class = null;
                    
                    // Account for many_many through in associations
                    if ($object instanceof SS_List) {
                        $field_class = $object->dataClass();
                    } elseif ($object instanceof DataObject) {
                        $field_class = get_class($object);
                    } elseif (isset($associations[$parts[0]]) && !is_array($associations[$parts[0]])) {
                        $field_class = $associations[$parts[0]];
                    }

                    $db_field = $parts[1];
                    $in_db = ($field_class) ? true : false;
                }

                // If this is in the DB (not casted)
                if (in_array($db_field, array_keys($db))) {
                    $in_db = true;
                }

                if ($in_db) {
                    $fields->replaceField(
                        $name,
                        $field = AutoCompleteField::create(
                            $name,
                            $title,
                            $field->Value(),
                            $field_class,
                            $db_field
                        )->setDisplayField($db_field)
                        ->setLabelField($db_field)
                        ->setStoredField($db_field)
                    );
                }
            }

            $field->setName($name);
        }

        return $fields;
    }

    /**
     * Get use autocomplete fields instead of text fields
     *
     * @return  boolean
     */ 
    public function getConvertToAutocomplete()
    {
        return $this->convert_to_autocomplete;
    }

    /**
     * Set use autocomplete fields instead of text fields
     *
     * @param bool $convert Convert?
     *
     * @return self
     */ 
    public function setConvertToAutocomplete(bool $convert)
    {
        $this->convert_to_autocomplete = $convert;
        return $this;
    }
}
