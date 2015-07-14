<?php namespace PKleindienst\BlogSeries\Controllers;

use BackendMenu;
use Backend\Classes\Controller;

/**
 * Series Back-end Controller
 * @package PKleindienst\BlogSeries\Controllers
 */
class Series extends Controller
{
    public $implement = [
        'Backend.Behaviors.FormController',
        'Backend.Behaviors.ListController'
    ];

    public $formConfig = 'config_form.yaml';
    public $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('RainLab.Blog', 'blog', 'series');
    }
}
