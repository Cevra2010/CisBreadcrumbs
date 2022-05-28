<?php
namespace CisFoundation\Breadcrumbs\Exception;

use Exception;

class BreadcrumbNotFoundException extends Exception {


    public function __construct($slug)
    {
        $this->message = 'Breadcrumb with slug "'.$slug.'" not found.';
    }

}

?>
