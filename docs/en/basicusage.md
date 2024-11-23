# Basic Usage

This module is designed to be "hot-swappable" with standard `ModelAdmin` extensions.
To generate your own admin interface using it, simply have you custom `ModelAdmin`
extend `ModelAdminPlus` (instead of `ModelAdmin`). For example:

```php
use DFT\SilverStripe\ModelAdminPlus\ModelAdminPlus;

class MyModelAdmin extends ModelAdminPlus
{

  // Add standard ModelAdmin code here

}
```

## Custom Export Fields

`ModelAdminPlus` allows for a `DataObject` to define it's own `export_fields` when it
performs a bulk export. Export fields are a config variable, and are defined in exactly
the same way as `summary_fields`, EG:

```php
class MyDataObject extends DataObject
{
  private static $db = [
    "Name" => "Varchar",
    "URL"  => "Varchar(255)"
  ];

  /**
   * Fields shown in GridField
   *
   * @return array
   */
  private static $summary_fields = [
    "ID" => "ID",
    "Name" => "Your Name"
  ];

  /**
   * Custom fields to export to CSV in
   * ModelAdminPlus
   *
   * @return array
   */
  private static $export_fields = [
    "Name" => "Your Name",
    "URL"  => "Website"
  ];
}
```

You can also overwrite the export_fields using the `updateExportFields` extension hook.