<?php
/**
 * User: Peter Leng
 * DateTime: 2017/3/28 11:16
 */

namespace SpringSearch;


use Illuminate\Support\ServiceProvider;
use Elasticsearch\Client as ElasticSearch;
use Elasticsearch\ClientBuilder as ElasticBuilder;

class SpringSearchServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishConfig();
    }

    /**
     * publish springsearch config
     *
     * @return void
     */
    protected function publishConfig()
    {
        $this->publishes([__DIR__ . '/../config/spring.php' => config_path('spring.php')],'config');
    }


    /**
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/spring.php', 'spring');

        $this->registerElasticSearch();
    }

    /**
     *
     * @return void
     */
    protected function registerElasticSearch()
    {
        $this->app->singleton('elastic', function() {
            return ElasticBuilder::fromConfig(config('spring.elastic'));
        });
    }
}