# Automatic Date Conversion

Model Admin Plus looks through your `GridFields` and finds any `DBDate` fields. It then 
automatically converts those dates to a `Nice` format (while retaining sorting).

## Disable automatic date/datetime conversion

If you do not want `ModelAdminPlus` to automatically convert `DBDate`/`DBDateTime` fields
to a formatted column (default to `DBDate.Nice`), you can disable this via SilverStripe
config, using:

  `DFT\SilverStripe\ModelAdminPlus.auto_convert_dates`

## Changing default date format

If you want to change how ModelAdminPlus formats dates (without effecting the Nice method),
you can do this via the helper class `GridFieldDateFinder`. You can configure this either
globally, or per instance called.

### Changing date format globally

You can change all instances of date re-format by setting the following SilverStripe config
variable:

  `DFT\SilverStripe\ModelAdminPlus.default_date_type`

### Changing date format per instance

You can change specific instances of the date format every time you call the GridFieldDateFinder
class, by using the following method:

  `DFT\SilverStripe\ModelAdminPlus::setDateType("newDateType")`