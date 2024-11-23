# Automatic usage of Auto Complete Fields

By default, `ModelAdminPlus` will convert any search fields that are text fields
and in the DB to use an `AutoCompleteField` (for easier searching).

If you wish to disable this functionality, you can use SilverStripe Config:

    DFT\SilverStripe\ModelAdminPlus.convert_to_autocomplete
