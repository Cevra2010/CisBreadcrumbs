<?php
namespace CisFoundation\Breadcrumbs;

use CisFoundation\Breadcrumbs\Exception\BreadcrumbNotFoundException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

/**
 * Breadcrumbs for Cis-Foundation manages the existing breadcrumbs for the
 * views of each page the base and extended cis backend modules
 */
class Breadcrumbs {

    protected static $breadcrumbsColleciton = null;
    protected static $registeredBreadcrumbs = null;

    /**
     * initializing the breadcrumb instance
     *
     * @return void
     */
    public static function boot() {

        /** Register application base breadcrumbs */
        if(!self::$registeredBreadcrumbs === null)
        {
            self::$registeredBreadcrumbs[] = Config::get('breadcrumbs');
        }
    }

    /**
     * Register new breadcrumbs
     *
     * @param array $breadcrumbs
     * @return void
     */
    public static function registerBreadcrumbs($breadcrumbs) {
        self::$registeredBreadcrumbs[] = $breadcrumbs;
    }

    /**
     * Returns a related colleciton of breadcrumb objects.
     * Starts with the first registed element.
     *
     * @param string $searchedSlug
     * @return Collection
     */
    public static function get($searchedSlug) {

        if(self::$breadcrumbsColleciton === null)
        {
            self::$breadcrumbsColleciton = collect();
        }

        /** Read the configuration */
        foreach(Config::get('breadcrumbs') as $breadcrumb) {
            $breadcrumbObject = new Breadcrumb();
            $breadcrumbObject->slug = (isset($breadcrumb['slug']) ? $breadcrumb['slug'] : null);
            $breadcrumbObject->title = (isset($breadcrumb['title']) ? $breadcrumb['title'] : null);
            $breadcrumbObject->parentSlug = (isset($breadcrumb['parent']) ? $breadcrumb['parent'] : null);
            $breadcrumbObject->route = (isset($breadcrumb['route']) ? $breadcrumb['route'] : null);
            self::$breadcrumbsColleciton->add($breadcrumbObject);
        }

        $breadcrumbs = collect();
        if($crumb = self::$breadcrumbsColleciton->where('slug',$searchedSlug)->first()) {
            $breadcrumbs->add($crumb);
        }

        if($crumb) {
            while($crumb->hasParent()) {
                $parentSlug = $crumb->parentSlug;
                if($crumb = self::$breadcrumbsColleciton->where('slug',$parentSlug)->first()) {
                    $breadcrumbs->add($crumb);
                }
                else {
                    throw new BreadcrumbNotFoundException($parentSlug);
                }
            }
        }

        return $breadcrumbs->reverse();
    }

}
