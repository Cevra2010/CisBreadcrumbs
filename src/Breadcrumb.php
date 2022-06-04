<?php
namespace CisFoundation\Breadcrumbs;

/**
 * The Breadcrumb-Class is the Object of every single breadcrumb object
 */
class Breadcrumb {

    /**
     * Slug of the breadcumb object
     *
     * @var string
     */
    public $slug;

    /**
     * Slug of the parent Breadcumb-Object
     *
     * @var string
     */
    public $parentSlug;

    /**
     * Laravel route
     *
     * @var string
     */
    public $route;

    /**
     * Route parameters
     *
     * @var array
     */
    public $routeParameter;

    /**
     * Title of the Breadcrumb
     *
     * @var string
     */
    public $title;


    public function __construct()
    {

    }

    /**
     * Retuns true if this objects instance has an parent Breadcumb. Otherwise return false.
     *
     * @return boolean
     */
    public function hasParent() {
        if($this->parentSlug) {
            return true;
        }
        return false;
    }

}
