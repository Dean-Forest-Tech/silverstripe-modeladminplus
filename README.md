# SilverStripe ModelAdminPlus

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/i-lateral/silverstripe-modeladminplus/badges/quality-score.png?b=1)](https://scrutinizer-ci.com/g/i-lateral/silverstripe-modeladminplus/?branch=1)
[![Build Status](https://travis-ci.org/i-lateral/silverstripe-modeladminplus.svg?branch=1)](https://travis-ci.org/i-lateral/silverstripe-modeladminplus)

Expanded version of ModelAdmin that adds some extra features:

* Submitting `SearchForm` via a POST (meaning that complex fields that require an Ajax callback should now function).
* Saving search results to a session rather than using the query string.
* Adding bulk editing (using `colymba/gridfield-bulk-editing-tools` by default). 
* When generating export fields for a `DataObject` also checks if the object has `export_fields`
* Automatically find and format `DBDate`/`DBDatetime` fields to `DBDate.Nice`
* Automatic "default" filtering of objects based on a config variable or custom method in your search context

## Installing

Install this module via composer:

```
composer require dft/silverstripe-modeladminplus
```

## Additional docs

[Read the full docs](docs/en/index.md)