<?php namespace PKleindienst\BlogSeries\Models;

use Illuminate\Support\Facades\DB;
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
     * The attributes on which the post list can be ordered
     * @var array
     */
    public static $sortingOptions = [
        'title asc' => 'Title (ascending)',
        'title desc' => 'Title (descending)',
        'created_at asc' => 'Created (ascending)',
        'created_at desc' => 'Created (descending)',
        'updated_at asc' => 'Updated (ascending)',
        'updated_at desc' => 'Updated (descending)',
        'random' => 'Random'
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
     * @param string                  $pageName
     * @param \Cms\Classes\Controller $controller
     * @return mixed
     */
    public function setUrl($pageName, $controller)
    {
        $params = [
            'slug' => $this->slug,
        ];

        return $this->url = $controller->pageUrl($pageName, $params);
    }

    /**
     * @param $query
     * @param $options
     * @return mixed
     */
    public function scopeListFrontend($query, $options)
    {
        // Default options
        array_merge(['sort' => 'created_at'], $options);

        // Sorting
        // @see \RainLab\Blog\Models\Post::scopeListFrontEnd()
        if (!is_array($options['sort'])) {
            $options['sort'] = [$options['sort']];
        }

        foreach ($options['sort'] as $sort) {

            if (in_array($sort, array_keys(self::$sortingOptions))) {
                $parts = explode(' ', $sort);
                if (count($parts) < 2) {
                    array_push($parts, 'desc');
                }
                list($sortField, $sortDirection) = $parts;
                if ($sortField == 'random') {
                    $sortField = DB::raw('RAND()');
                }
                $query->orderBy($sortField, $sortDirection);
            }
        }

        return $query->with('posts')->get();
    }
}
