<?php namespace PKleindienst\BlogSeries\Models;

use Illuminate\Support\Facades\DB;
use Model;

/**
 *  Series Model
 * @package PKleindienst\BlogSeries\Models
 */
class RelatedSeries extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'pkleindienst_blogseries_related';

    /**
     * @var array Relations
     */
    public $hasMany = [
        'series' => [
            'PKleindienst\BlogSeries\Models\Series'
        ]
    ];

    /**
     * Sets the "url" attribute with a URL to this object
     * @param string                  $pageName
     * @param \Cms\Classes\Controller $controller
     * @return mixed
     */
    public function setUrl($pageName, $controller)
    {
        return $this->url = $controller->pageUrl($pageName, ['slug' => $this->slug]);
    }
}
