<?php
namespace CisFoundation\Breadcrumbs;

class Breadcrumb {


    public $slug;
    public $parentSlug;
    public $route;
    public $routeParameter;
    public $title;

    public function __construct()
    {

    }

    public function hasParent() {
        if($this->parentSlug) {
            return true;
        }
        return false;
    }

}
