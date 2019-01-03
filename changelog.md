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