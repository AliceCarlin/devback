<?php
namespace App\Service;
use Cocur\Slugify\Slugify as CocurSlug;

class Slugify
{

    public $text;


    public function slugify($stringToSlugify)
    {
        $slugify = new CocurSlug();
        return $slugify->slugify($stringToSlugify);
    }

}

?>
