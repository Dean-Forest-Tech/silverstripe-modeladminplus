<?php

namespace DFT\SilverStripe\ModelAdminPlus;

use SilverStripe\Core\ClassInfo;
use SilverStripe\Core\Config\Config;
use SilverStripe\ORM\FieldType\DBDate;
use SilverStripe\Core\Config\Configurable;
use SilverStripe\Core\Injector\Injectable;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridFieldSortableHeader;
use SilverStripe\Forms\GridField\GridField_ColumnProvider;

/**
 * Helper class designed to find date fields in a provided
 * `GridField` and convert them to a nice format (while
 * maintaining sorting)
 *
 */
class GridFieldDateFinder
{
    use Injectable, Configurable;

    /**
     * `GridField` we are working with
     *
     * @var GridField
     */
    protected $grid_field;

    /**
     * Overwrite the date format (provided by config)
     * for this instance
     *
     * @var string
     */
    protected $date_type;

    /**
     * The date formatting method to use (this corresponds
     * to a Date method on the Date/DateTime data type).
     *
     * @var string
     */
    private static $default_date_type = ".Nice";

    public function __construct(GridField $grid_field)
    {
        $this->grid_field = $grid_field;
    }

    /**
     * Get any date fields from the passed list and convert to .Nice format.
     *
     * @param GridField $field GridField want to convert
     *
     * @return self
     */
    public function convertDateFields()
    {
        $grid_field = $this->getGridField();
        $config = $grid_field->getConfig();
        $db = Config::inst()->get($grid_field->getModelClass(), "db");
        $dates = self::config()->date_fields;
        $fields = $this->findDateFields();

        // First setup columns
        foreach ($config->getComponents() as $component) {
            $class = get_class($component);
            $is_header = ($component instanceof GridFieldSortableHeader);
            $is_columns = ClassInfo::classImplements(
                $class,
                GridField_ColumnProvider::class
            );

            // If we are working with a set of data columns, look for
            // date/datetime columns
            if ($is_columns && method_exists($component, "getDisplayFields")) {
                $display_fields = $component->getDisplayFields($grid_field);
                foreach ($fields as $field) {
                    $display_fields = $this->changeKeys(
                        $field["Sort"],
                        $field["Column"],
                        $display_fields
                    );
                }
                $component->setDisplayFields($display_fields);
            }

            // If we are working with sortable headers, look for
            // date/datetime columns
            if ($is_header && count($component->getFieldSorting()) == 0) {
                $sort_fields = [];
                foreach ($fields as $field) {
                    $sort_fields[$field["Column"]] = $field["Sort"];
                }
                $component->setFieldSorting($sort_fields);
            }
        }

        $this->setGridField($grid_field);

        return $this;
    }

    /**
     * Create an array of fields, titles and values that we
     * use to setup sortable fields in the following format:
     *
     * - Title (the human readable name of the column)
     * - Column (the actual field used to display data)
     * - Sort (DB the column used to sort the data)
     *
     * @return array
     */
    public function findDateFields()
    {
        $grid_field = $this->getGridField();
        $config = $grid_field->getConfig();
        $class = $grid_field->getModelClass();
        $obj = $class::singleton();
        $fields = [];

        // First setup columns
        foreach ($config->getComponents() as $component) {
            // If we are working with a set of data columns, look for
            // date/datetime columns
            if ($this->isColumnProvider($component) && method_exists($component, "getDisplayFields")) {
                foreach ($component->getDisplayFields($grid_field) as $k => $v) {
                    $field = $obj->dbObject($k);
                    if (isset($field) && $field instanceof DBDate) {
                        $fields[] = [
                            "Title" => $v,
                            "Column" => $k . $this->getDateType(),
                            "Sort" => $k
                        ];
                    }
                }
            }
        }

        return $fields;
    }

    /**
     * Is the provided component a `GridField_ColumnProvider`?
     *
     * @param object $component The current component
     *
     * @return boolean
     */
    public static function isColumnProvider($component)
    {
        return ClassInfo::classImplements(
            get_class($component),
            GridField_ColumnProvider::class
        );
    }

    /**
     * Change the array keys on the provided array to the provided alternative
     * (thanks to: https://stackoverflow.com/a/14227644/4161644)
     *
     * @param string $original Original key
     * @param string $new      New key
     * @param array  $array    Haystack array
     *
     * @return array
     */
    public function changeKeys($original, $new, &$array)
    {
        foreach ($array as $k => $v) {
            $res[$k === $original ? $new : $k] = $v;
        }
        return $res;
    }

    /**
     * Get `GridField` we are working with
     *
     * @return  GridField
     */
    public function getGridField()
    {
        return $this->grid_field;
    }

    /**
     * Set `GridField` we are working with
     *
     * @param GridField $grid_field `GridField` we are working with
     *
     * @return self
     */
    public function setGridField(GridField $grid_field)
    {
        $this->grid_field = $grid_field;

        return $this;
    }

    /**
     * Get for this instance
     *
     * @return string
     */
    public function getDateType()
    {
        if (!empty($this->date_type)) {
            return $this->date_type;
        } else {
            return $this->config()->default_date_type;
        }
    }

    /**
     * Set for this instance
     *
     * @param string $date_type for this instance
     *
     * @return self
     */
    public function setDateType(string $date_type)
    {
        $this->date_type = $date_type;

        return $this;
    }
}
