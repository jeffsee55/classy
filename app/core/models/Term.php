<?php
/**
 * Archive
 *
 * @package Classy\Models
 */

namespace Classy\Models;

use Classy\Basis;

/**
 * Class Term.
 */
class Term extends Basis {

    public $term_id;

    public $name;

    public $slug;

    public $taxonomy;

    public $description;

    public $parent;

    public function __construct($object)
    {
        $term = get_term_by('slug', $object->slug, $object->taxonomy);
        $this->import($term);
    }

    public function name()
    {
        return $this->name;
    }

    public function get_color()
    {
        $background_color = get_field('background_color', 'category_' . $this->term_id);
        if($background_color)
            return $background_color;
    }

    public function description()
    {
        $description = get_field('term_description', 'category_' . $this->term_id);
        if($description)
            return $description;

        return $this->description;
    }

    public function should_hide_date()
    {
        return get_field('should_hide_date', 'category_' . $this->term_id);
    }
}
