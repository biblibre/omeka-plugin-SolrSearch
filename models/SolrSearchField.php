<?php

/**
 * @package     omeka
 * @subpackage  solr-search
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */


class SolrSearchField extends Omeka_Record_AbstractRecord
{


    /**
     * The id of the parent element [integer].
     */
    public $element_id;

    /**
     * The name of the element [string].
     */
    public $slug;

    /**
     * The label of the element.
     **/
    public $label;

    /**
     * Displayed status [boolean/tinyint].
     */
    public $is_indexed;

    /**
     * Facet status [boolean/tinyint].
     */
    public $is_facet;

    /**
     * Sort status [boolean/tinyint].
     */
    public $is_sort;


    /**
     * Set the parent element reference.
     *
     * @param Element $element The parent element.
     */
    public function __construct($db = null, $element = null)
    {

        parent::__construct($db);

        if (!is_null($element)) {

            // Element reference.
            $this->element_id = $element->id;

            // Element identifier.
            $element_set = $element->getElementSet();
            $this->slug = Inflector::underscore($element->name . '_' . $element_set->name);

            // Pubilc-facing label.
            $this->label = $element->name;

        }

    }


    /**
     * The key for the tokenized version of the field in a Solr document.
     *
     * @return string
     */
    public function indexKey()
    {
        return "{$this->slug}_t";
    }


    /**
     * The key for the untokenized version of the field in a Solr document.
     *
     * @return string
     */
    public function facetKey()
    {
        return $this->hasElement() ? "{$this->slug}_s" : $this->slug;
    }

    public function sortKey()
    {
        return $this->hasElement() ? "{$this->slug}_ss" : $this->slug;
    }

    /**
     * Is the field associated with a metadata element?
     *
     * @return boolean True if an element is defined.
     */
    public function hasElement()
    {
        return !is_null($this->element_id);
    }


    /**
     * Get the parent element.
     *
     * @return Element|null The element.
     */
    public function getElement()
    {
        if (!$this->hasElement()) return null;
        else return $this->getTable('Element')->find($this->element_id);
    }


    /**
     * Get the parent element set.
     *
     * @return ElementSet|null The element set.
     */
    public function getElementSet()
    {
        if (!$this->hasElement()) return null;
        else return $this->getElement()->getElementSet();
    }


    /**
     * Get the name of the parent element set.
     *
     * @return string The element set name.
     */
    public function getElementSetName()
    {
        if (!$this->hasElement()) return __('Omeka Categories');
        else return $this->getElementSet()->name;
    }


    /**
     * Return the original label for the field.
     *
     * @return string|null
     **/
    public function getOriginalLabel()
    {
        switch ($this->slug) {

            case 'tag':         return __('Tag');
            case 'collection':  return __('Collection');
            case 'itemtype':    return __('Item Type');
            case 'resulttype':  return __('Result Type');
            case 'featured':    return __('Featured');

            default: return $this->getElement()->name;

        }
    }


    /**
     * If the label is empty, revert to the original label.
     *
     * @return string The facet label.
     */
    public function beforeSave()
    {
        $label = trim($this->label);
        if (empty($label)) $this->label = $this->getOriginalLabel();
    }


}
