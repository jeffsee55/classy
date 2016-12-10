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

    public function description()
    {
        return $this->description;
    }
}
