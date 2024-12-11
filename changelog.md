# Log of changes for the ModelAdminPlus module

## 1.0.0

* First initial release

## 1.0.1

* Ensure search filters are stripped if they are null (so filtering works correctly)

## 1.0.2

* Add pagination length selection via `GridFieldConfigurablePaginator`
* Add styling to fix bulk editing checkboxes

## 1.0.3

* Automatically find and convert any date/datetime fields to `Date.Nice` (and retain sorting)

## 1.0.4

* Add custom "summary snippets" to the top of a model admin plus interface

## 1.0.5

* Reduce column padding on summary snippets

## 1.0.6

* Auto convert search `TextField`s to use `AutoCompleteField`

## 1.0.7

* Improve resiliency of matching `AutoCompleteField`s on assotiations


## 1.1.0

* SS 4.3 supported version
* Remove autocomplete fields (as they currently don't work correctly with React)

## 1.2.0

* Re-add autocomplete support to search
* Move snippets so they become attached to a gridfield (rather than the model admin itself)
* Update templates
* Add support for `Many_Many` > Through assotiations

## 1.2.1

* Allow setting of custom search context

## 1.2.2

* Re-add css fix for bulk editing checkboxes

## 1.2.3

* Allow adding default search params to your objects model admin search context

## 1.2.4

* Fix issues viewing a single record when filtering

## 1.2.5

* Additional fixes

## 1.3.0

* Switch to DFT namespace

## 2.0.0

* SilverStripe 5.* branch

## 2.1.0

* Switch to DFT namespace
* Re-add SS4 support

## 2.1.1

* Fix some stupid errors