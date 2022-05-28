<?php
namespace CisFoundation\Breadcrumbs;

use CisFoundation\Breadcrumbs\Exception\BreadcrumbNotFoundException;
use Exception;
use Illuminate\Support\Facades\Config;

class Breadcrumbs {

    protected static $breadcrumbsColleciton = null;

    public static function boot() {
        if(self::$breadcrumbsColleciton === null)
        {
            self::$breadcrumbsColleciton = collect();
        }

        foreach(Config::get('breadcrumbs') as $breadcrumb) {
            $breadcrumbObject = new Breadcrumb();
            $breadcrumbObject->slug = (isset($breadcrumb['slug']) ? $breadcrumb['slug'] : null);
            $breadcrumbObject->title = (isset($breadcrumb['title']) ? $breadcrumb['title'] : null);
            $breadcrumbObject->parentSlug = (isset($breadcrumb['parent']) ? $breadcrumb['parent'] : null);
            $breadcrumbObject->route = (isset($breadcrumb['route']) ? $breadcrumb['route'] : null);
            self::$breadcrumbsColleciton->add($breadcrumbObject);
        }
    }

    public static function get($searchedSlug) {
        $breadcrumbs = collect();
        if($crumb = self::$breadcrumbsColleciton->where('slug',$searchedSlug)->first()) {
            $breadcrumbs->add($crumb);
        }

        while($crumb->hasParent()) {
            $parentSlug = $crumb->parentSlug;
            if($crumb = self::$breadcrumbsColleciton->where('slug',$parentSlug)->first()) {
                $breadcrumbs->add($crumb);
            }
            else {
                throw new BreadcrumbNotFoundException($parentSlug);
            }
        }

        return $breadcrumbs->reverse();
    }

}
