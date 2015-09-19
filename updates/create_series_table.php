<?php namespace PKleindienst\BlogSeries\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use System\Classes\PluginManager;

/**
 * Create Series Table
 * @package PKleindienst\BlogSeries\Updates
 */
class CreateSeriesTable extends Migration
{
    /**
     * {@inheritDoc}
     */
    public function up()
    {
        if (PluginManager::instance()->hasPlugin('RainLab.Blog')) {
            Schema::create('pkleindienst_blogseries_series', function ($table) {
                $table->engine = 'InnoDB';
                $table->increments('id');
                $table->string('title')->unique();
                $table->string('slug')->unique();
                $table->string('description')->nullable();
                $table->timestamps();
            });

            Schema::table('rainlab_blog_posts', function ($table) {
                $table->integer('series_id')->unsigned()->nullable()->default(null);
                $table->foreign('series_id')->references('id')->on('pkleindienst_blogseries_series')->onDelete('cascade');
            });
        }
    }

    /**
     * {@inheritDoc}
     */
    public function down()
    {
        if (PluginManager::instance()->hasPlugin('RainLab.Blog')) {
            Schema::table('rainlab_blog_posts', function ($table) {
                $table->dropForeign(['series_id']);
                $table->dropColumn('series_id');
            });
            Schema::dropIfExists('pkleindienst_blogseries_series');
        }
    }
}
