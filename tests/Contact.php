<?php

namespace DFT\SilverStripe\ModelAdminPlus\Tests;

use SilverStripe\Dev\TestOnly;
use SilverStripe\ORM\DataObject;

class Contact extends DataObject implements TestOnly
{
    private static $table_name = 'ModelAdminPlus_Contact';

    private static $db = [
        'Name' => 'Varchar',
        'Phone' => 'Varchar'
    ];

    private static $summary_fields = [
        'ID' => 'ID',
        'Name' => 'Name'
    ];

    private static $export_fields = [
        'Name' => 'Name',
        'Phone'=> 'Phone'
    ];
}
