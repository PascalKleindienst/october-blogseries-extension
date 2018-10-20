<?php namespace PKleindienst\BlogSeries\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use System\Classes\PluginManager;

/**
 * Create Related Table
 * @package PKleindienst\BlogSeries\Updates
 */
class CreateRelatedTable extends Migration
{
    /**
     * {@inheritDoc}
     */
    public function up()
    {
        if (PluginManager::instance()->hasPlugin('RainLab.Blog')) {
            Schema::create('pkleindienst_blogseries_related', function ($table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->integer('series_id')->unsigned()->nullable()->default(null);
                $table->foreign('series_id')->references('id')->on('pkleindienst_blogseries_series')->onDelete('cascade');
                $table->integer('related_id')->unsigned()->nullable()->default(null);
                $table->foreign('related_id')->references('id')->on('pkleindienst_blogseries_series')->onDelete('cascade');
            });
        }
    }

    /**
     * {@inheritDoc}
     */
    public function down()
    {
        if (PluginManager::instance()->hasPlugin('RainLab.Blog')) {
            Schema::dropIfExists('pkleindienst_blogseries_related');
        }
    }
}
