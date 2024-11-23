<?php

namespace DFT\SilverStripe\ModelAdminPlus;

use SilverStripe\View\SSViewer;
use SilverStripe\View\ArrayData;
use SilverStripe\Forms\GridField\GridFieldButtonRow;

class GridFieldSnippetRow extends GridFieldButtonRow
{
    public function getHTMLFragments($gridField)
    {
        $data = ArrayData::create([
            "TargetFragmentName" => $this->targetFragment,
            "Fragments" => "\$DefineFragment(snippets-{$this->targetFragment})",
        ]);

        $templates = SSViewer::get_templates_by_class($this, '', __CLASS__);
        return [
            $this->targetFragment => $data->renderWith($templates)
        ];
    }
}