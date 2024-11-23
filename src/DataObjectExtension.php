<?php

namespace DFT\SilverStripe\ModelAdminPlus;

use SilverStripe\ORM\DataExtension;

class DataObjectExtension extends DataExtension
{
    /**
     * Return an array of default filters to load for this object
     *
     * @return array
     */
    public function getDefaultSearchFilter(): array
    {
        return (array)$this->getOwner()->config()->get("default_search_filter");
    }

    /**
     * Get a custom search context for model admin plus
     */
    public function getModelAdminSearchContext()
    {
        return SearchContext::create(
            get_class($this->getOwner()),
            $this->getOwner()->scaffoldSearchFields(),
            $this->getOwner()->defaultSearchFilters()
        );
    }
}
