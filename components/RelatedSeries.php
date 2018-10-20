<?php namespace PKleindienst\BlogSeries\Components;

use Cms\Classes\Page;
use Cms\Classes\ComponentBase;
use PKleindienst\BlogSeries\Models\Series;

class RelatedSeries extends ComponentBase
{
    /**
     * @var \PKleindienst\BlogSeries\Models\Series
     */
    public $relatedSeries;

    /**
     * Reference to the page name for linking to series.
     * @var string
     */
    public $seriesPage;

    /**
     * If the series list should be ordered by another attribute.
     * @var string
     */
    public $sortOrder;

    /**
     * @return array
     */
    public function componentDetails()
    {
        return [
            'name'        => 'Related Series List',
            'description' => 'Displays a list of related series on the page.'
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
            'seriesPage' => [
                'title'       => 'Series Page',
                'description' => 'The page where the single series are displayed.',
                'type'        => 'dropdown',
                'default'     => 'blog/series'
            ],
            'sortOrder' => [
                'title'       => 'Order',
                'description' => 'Attribute on which the items should be ordered',
                'type'        => 'dropdown',
                'default'     => 'title asc'
            ],
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
     * @see RainLab\Blog\Models\Post::$allowedSortingOptions
     * @return mixed
     */
    public function getSortOrderOptions()
    {
        return Series::$sortingOptions;
    }

    /**
     * @return mixed
     */
    public function onRun()
    {
        // load series
        $this->seriesPage    = $this->page['seriesPage']    = $this->property('seriesPage');
        $this->sortOrder     = $this->page['sortOrder']     = $this->property('sortOrder');
        $this->relatedSeries = $this->page['relatedSeries'] = $this->listRelatedSeries();
    }

    /**
     * Get Related Series
     * @return mixed
     */
    protected function listRelatedSeries()
    {
        // get related series
        $series = Series::listFrontend([
            'sort' => $this->property('sortOrder'),
            'slug' => $this->property('slug'),
            'with' => ['related']
        ]);
        $related = $series->first()->related;

        // Add a "url" helper attribute for linking to each series page
        if ($related && !$related->isEmpty()) {
            foreach ($related as $item) {
                $item->setUrl($this->seriesPage, $this->controller);
            }
        }

        return $related;
    }
}
