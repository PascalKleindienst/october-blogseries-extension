<?php namespace PKleindienst\BlogSeries\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use PKleindienst\BlogSeries\Models\Series;

class BlogSeriesList extends ComponentBase
{
    /**
     * @var \PKleindienst\BlogSeries\Models\Series
     */
    public $series;

    /**
     * Reference to the page name for linking to series.
     * @var string
     */
    public $seriesPage;

    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'Blog Series List',
            'description' => 'Displays a list of blog series on the page.'
        ];
    }

    /**
     * @return array
     */
    public function defineProperties()
    {
        return [
            'displayEmpty' => [
                'title'       => 'Display empty series',
                'description' => 'Show series that do not have any posts.',
                'type'        => 'checkbox',
                'default'     => 0
            ],
            'seriesPage' => [
                'title'       => 'Series Page',
                'description' => 'The page where the single series are displayed.',
                'type'        => 'dropdown',
                'default'     => 'blog/series'
            ]
        ];
    }

    /**
     * @return mixed
     */
    public function getSeriesPageOptions()
    {
        return Page::sortBy('baseFileName')->lists('baseFileName', 'baseFileName');
    }

    /**
     * @return mixed
     */
    public function onRun()
    {
        // load series
        $this->seriesPage = $this->page[ 'seriesPage' ] = $this->property('seriesPage');
        $this->series = $this->page[ 'series' ] = $this->listSeries();
    }

    /**
     * Get Series
     * @return mixed
     */
    protected function listSeries()
    {
        // get series
        $series = Series::with('posts')->orderBy('title')->get();

        // Add a "url" helper attribute for linking to each post and category
        if ($series && !$series->isEmpty()) {
            foreach ($series as $key => $item) {
                // remove empty series
                if (!$this->property('displayEmpty') && $item->postCount === 0) {
                    $series->forget($key);
                    continue;
                }

                $item->setUrl($this->seriesPage, $this->controller);
            }
        }

        return $series;
    }
}
