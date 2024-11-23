## Default Search Filter

Model Admin Plus allows you to define a "default filter" for your managed object, which means when a `ModelAdminPlus`
instance first loads and there is no existing search data,
the list is automatically filtered by either a config variable
from the model object or by overwriting a method on the `SearchFilter`

### Default Filter Via Config or Method on object

The simplest search filter can be added via a config variable
on your object class, or, if you want some more complex logic,
the `getDefaultSearchFilter` method for example:

```php
class MyDataObject extends DataObject
{
  private static $db = [
    "Name" => "Varchar",
    "URL"  => "Varchar(255)"
  ];

  // Filter by default anyone not called "Steve"
  private static $default_search_filter = [
    "Name:not" => "Steve"
  ];

  public functon getDefaultSearchFilter(): array
  {
    // Get the default filter from config
    $filter = parent::getDefaultSearchFilter();

    // If searching for Jeff, only look for
    // results from google
    if ($this->Name == 'Jeff') {
      $filter['URL'] = "www.google.com";
    }

    return $filter;
  }
}

```

### Custom SearchContext

If you want a more complex default search, you can also overwrite `SearchFilter::getDefaultFilter()`.

For Example:

```php
class MySearchContext extends DFT\SilverStripe\ModelAdminPlus\SearchContext
{
  // Only show Steve's items created in the last seven
  // days by default
  public function getDefaultFilter()
  {
    $start = new DateTime('-7 days');
    $end = new DateTime();
    return [
      'Created:GreaterThanOrEqual' => $start->format('Y-m-d H:i:s'),
      'Created:LessThanOrEqual' => $end->format('Y-m-d H:i:s')
    ];
  }
}

class MyDataObject extends DataObject
{
  private static $db = [
    "Name" => "Varchar",
    "URL"  => "Varchar(255)"
  ];

  // Provide custom search context
  public function getModelAdminSearchContext()
  {
      return MySearchContext::create(
          get_class($this),
          $this->scaffoldSearchFields(),
          $this->defaultSearchFilters()
      );
  }
}

```