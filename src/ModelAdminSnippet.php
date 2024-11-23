<?php

namespace DFT\SilverStripe\ModelAdminPlus;

use SilverStripe\View\ViewableData;
use SilverStripe\Forms\GridField\GridField;
use SilverStripe\Forms\GridField\GridField_HTMLProvider;

/**
 * Object representing a snippet of generic data that can be loaded at the top of a
 * ModelAdminPlus interface
 */
abstract class ModelAdminSnippet extends ViewableData implements GridField_HTMLProvider
{
    const PRIMARY = "primary";

    const SECONDARY = "secondary";

    const SUCCESS = "success";

    const INFO = "info";

    const WARNING = "warning";

    const DANGER = "danger";

    const LIGHT = "light";

    const DARK = "dark";

    const WHITE = "white";

    /**
     * @var string placement indicator for this control
     */
    protected $targetFragment;

    /**
     * The current parent gridfield
     *
     * @var GridField
     */
    protected $gridfield;

    /**
     * The name/title of the current snippet.
     *
     * @var string
     */
    private static $title;

    /**
     * The order in which this snippet will be loaded
     *
     * @var int
     */
    private static $priority = 0;

    /**
     * Default background colour
     *
     * @var string
     */
    private static $background = self::INFO;

    /**
     * Default text colour
     *
     * @var string
     */
    private static $text = self::WHITE;

    /**
     * List of extra CSS classes applied to this snippet
     *
     * @var array
     */
    protected $extra_classes = [];

    private $casting = [
        "Order" => "Float"
    ];

    /**
     * @param string $targetFragment The HTML fragment to write the button into
     */
    public function __construct($targetFragment = "after")
    {
        $this->targetFragment = $targetFragment;
    }

    public function getHTMLFragments($gridField)
    {
        $this->gridfield = $gridField;

        return [
            $this->targetFragment => $this->getSnippet()
        ];
    }

    /**
     * Return an i18n friendly version of the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return _t(__CLASS__ . "Title", $this->config()->title);
    }

    public function getOrder()
    {
        return $this->config()->priority;
    }

    /**
     * Render the current snippet
     *
     * @return string
     */
    public function getSnippet()
    {
        return $this->renderWith(__CLASS__);
    }

    /**
     * Return the background colour suitable for a template
     *
     * @return string
     */
    public function getBackgroundColour()
    {
        return $this->config()->background;
    }

    /**
     * Return the background colour suitable for a template
     *
     * @return string
     */
    public function getTextColour()
    {
        return $this->config()->text;
    }

    /**
     * The content of this snippet that will be rendered below
     * the title.
     *
     * @return string
     */
    abstract public function getContent();

    /**
     * Get extra CSS classes as a string
     *
     * @return string
     */
    public function getExtraClasses()
    {
        return implode(" ", $this->extra_classes);
    }

    /**
     * Add additional css classes
     *
     * @param  array|string  $extra_classes  extra CSS classes
     *
     * @return  self
     */
    public function addExtraClasses($classes)
    {
        if (!is_array($classes)) {
            $classes = explode(" ", $classes);
        }

        $this->extra_classes = array_merge(
            $this->extra_classes,
            $classes
        );

        return $this;
    }

    /**
     * Remove provided CSS classes
     *
     * @param  array|string  $extra_classes  extra CSS classes
     *
     * @return  self
     */
    public function removeExtraClasses($classes)
    {
        if (!is_array($classes)) {
            $classes = explode(" ", $classes);
        }

        foreach ($classes as $class) {
            if (isset($this->extra_classes[$class])) {
                unset($this->extra_classes[$class]);
            }
        }

        return $this;
    }

    /**
     * Get the current parent gridfield
     *
     * @return  GridField
     */ 
    public function getGridfield()
    {
        return $this->gridfield;
    }
}
