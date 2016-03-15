<?php namespace PKleindienst\BlogSeries\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

/**
 * Series Back-end Controller
 * @package PKleindienst\BlogSeries\Controllers
 */
class Series extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.RelationController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';
    public $relationConfig = 'config_relation.yaml';

    /**
     * Series constructor.
     */
    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('RainLab.Blog', 'blog', 'series');
    }
}
