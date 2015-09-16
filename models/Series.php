<?php namespace PKleindienst\BlogSeries\Models;

use Model;

/**
 *  Series Model
 * @package PKleindienst\BlogSeries\Models
 */
class Series extends Model
{
    /**
     * @var string The database table used by the model.
     */
    public $table = 'pkleindienst_blogseries_series';

    /**
     * @var array
     */
    protected $slugs = ['slug' => 'title'];

    /**
     * @var array Relations
     */
    public $hasMany = [
        'posts' => [
            'RainLab\Blog\Models\Post',
        ],
    ];

    /**
     * @return mixed
     */
    public function getPostCountAttribute()
    {
        return $this->posts()->count();
    }

    /**
     * Sets the "url" attribute with a URL to this object
     * @param string $pageName
     * @param \Cms\Classes\Controller $controller
     */
    public function setUrl($pageName, $controller)
    {
        $params = [
            'slug' => $this->slug,
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }
}
