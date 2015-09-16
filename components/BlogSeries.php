<?php namespace PKleindienst\BlogSeries\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use PKleindienst\BlogSeries\Models\Series;

/**
 * BlogSeries Component to list all posts in a series
 * Displays all Post from a series
 * @package PKleindienst\BlogSeries\Components
 */
class BlogSeries extends ComponentBase
{
    /**
     * @var \PKleindienst\BlogSeries\Models\Series
     */
    public $series;

    /**
     * Message to display when there are no posts.
     * @var string
     */
    public $noPostsMessage;

    /**
     * Reference to the page name for linking to posts.
     * @var string
     */
    public $postPage;

    /**
     * Reference to the page name for linking to categories.
     * @var string
     */
    public $categoryPage;

    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'BlogSeries',
            'description' => 'List all Posts in a Series'
        ];
    }

    /**
     * @return array
     */
    public function defineProperties()
    {
        return [
            'slug' => [
                'title'       => 'Slug',
                'description' => 'Look up the series using the supplied slug value.',
                'type'        => 'string',
                'default'     => '{{ :slug }}',
            ],
            'noPostsMessage' => [
                'title'        => 'rainlab.blog::lang.settings.posts_no_posts',
                'description'  => 'rainlab.blog::lang.settings.posts_no_posts_description',
                'type'         => 'string',
                'default'      => 'No posts found',
                'showExternalParam' => false
            ],
            'categoryPage' => [
                'title'       => 'rainlab.blog::lang.settings.posts_category',
                'description' => 'rainlab.blog::lang.settings.posts_category_description',
                'type'        => 'dropdown',
                'default'     => 'blog/category',
                'group'       => 'Links',
            ],
            'postPage' => [
                'title'       => 'rainlab.blog::lang.settings.posts_post',
                'description' => 'rainlab.blog::lang.settings.posts_post_description',
                'type'        => 'dropdown',
                'default'     => 'blog/post',
                'group'       => 'Links',
            ],
        ];
    }

    /**
     * @see RainLab\Blog\Components\Posts::getCategoryPageOptions()
     * @return mixed
     */
    public function getCategoryPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     * @see RainLab\Blog\Components\Posts::getPostPageOptions()
     * @return mixed
     */
    public function getPostPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     * @see RainLab\Blog\Components\Posts::onRun()
     * @return mixed
     */
    public function onRun()
    {
        $this->prepareVars();

        // load posts
        $this->series = $this->page[ 'series' ] = $this->listSeries();

        if (is_null($this->series)) {
            $this->setStatusCode(404);
            return $this->controller->run('404');
        }
    }

    /**
     * Prepare variables
     */
    protected function prepareVars()
    {
        $this->noPostsMessage = $this->page[ 'noPostsMessage' ] = $this->property('noPostsMessage');

        // Page links
        $this->postPage = $this->page[ 'postPage' ] = $this->property('postPage');
        $this->categoryPage = $this->page[ 'categoryPage' ] = $this->property('categoryPage');
    }

    /**
     * Get Series
     * @return mixed
     */
    protected function listSeries()
    {
        // get serie
        $slug = $this->property('slug');
        $series = Series::with('posts')->where('slug', $slug)->first();

        // Add a "url" helper attribute for linking to each post and category
        if ($series && $series->posts->count()) {
            $series->posts->each(function ($post) {
                $post->setUrl($this->postPage, $this->controller);

                if ($post && $post->categories->count()) {
                    $post->categories->each(function ($category) {
                        $category->setUrl($this->categoryPage, $this->controller);
                    });
                }
            });
        }

        return $series;
    }
}
