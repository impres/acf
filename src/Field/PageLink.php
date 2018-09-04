<?php

namespace Corcel\Acf\Field;

use Corcel\Acf\FieldInterface;

/**
 * Class PageLink.
 *
 * @author Junior Grossi <juniorgro@gmail.com>
 */
class PageLink extends PostObject implements FieldInterface
{
    /**
     * Extend the process function to be able to fetch the archive link that can be set with PageLink
     *
     * @param string $fieldName
     */
    public function process($fieldName)
    {
        // Let parent process the field name
        parent::process($fieldName);

        // If object is set with an object overwrite it with the value from the database (string URL)
        if (!$this->object) {
            $this->object = $this->fetchValue($fieldName);
        }
    }

    /**
     * @return string
     */
    public function get()
    {
        $page = parent::get();

        // Check if page is an object, if it's not an object it is most likely an archive link and page is a string containing the url
        if (!is_object($page) && is_string($page)) {
            return $page ?? '';
        }

        // Get the page permalink (also works with depth in page url's and WPML)
        return get_the_permalink($page->ID);
    }
}
