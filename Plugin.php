<?php namespace PKleindienst\BlogSeries;

use Backend;
use Event;
use System\Classes\PluginBase;
use RainLab\Blog\Controllers\Posts as PostsController;
use RainLab\Blog\Models\Post as PostModel;

/**
 * BlogSeries Plugin Information File
 * @package PKleindienst\BlogSeries
 */
class Plugin extends PluginBase
{
    /**
     * @var array   Require the RainLab.Blog plugin
     */
    public $require = ['RainLab.Blog'];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'BlogSeries',
            'description' => 'Add posts to series',
            'author'      => 'PKleindienst',
            'icon'        => 'icon-list-alt'
        ];
    }

    /**
     * @return array
     */
    public function registerComponents()
    {
        return [
            'PKleindienst\BlogSeries\Components\BlogSeries' => 'blogSeries'
        ];
    }

    /**
     * Inject into Blog Posts
     */
    public function boot()
    {
        // Extend the model
        PostModel::extend(function ($model) {
            $model->belongsTo['series'] = [
                'PKleindienst\BlogSeries\Models\Series'
            ];
        });

        // Extend the navigation
        Event::listen('backend.menu.extendItems', function ($manager) {
            $manager->addSideMenuItems('RainLab.Blog', 'blog', [
                'series' => [
                    'label' => 'Series',
                    'icon' => 'icon-list-alt',
                    'code' => 'series',
                    'owner' => 'RainLab.Blog',
                    'url' => Backend::url('pkleindienst/blogseries/series')
                ],
            ]);
        });

        // Extend the controller
        PostsController::extendFormFields(function($form, $model, $context) {
            if (!$model instanceof PostModel) {
                return;
            }
            $form->addSecondaryTabFields([
                'categories' => [
                    'tab'       => 'rainlab.blog::lang.post.tab_categories',
                    'type'      => 'relation',
                    'commentAbove' => 'rainlab.blog::lang.post.categories_comment',
                    'placeholder' => 'rainlab.blog::lang.post.categories_placeholder',
                    'span' => 'left'
                ],
                'series' => [
                    'label'     => 'Series',
                    'tab'       => 'rainlab.blog::lang.post.tab_categories',
                    'type'      => 'relation',
                    'nameFrom'  => 'title',
                    'span'      => 'right',
                    'emptyOption' => 'Empty'
                ]
            ]);
        });
    }
}
