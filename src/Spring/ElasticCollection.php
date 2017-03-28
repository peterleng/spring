<?php
namespace PeterLeng\SpringSearch;

use Illuminate\Database\Eloquent\Collection;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ElasticCollection extends Collection {

    protected $response;
    protected $instance;

    /**
     * @param array $response
     * @param $instance
     */
    public function __construct($response, $instance)
    {
        $this->response = $response;
        $this->instance = $instance;

        $this->items = $this->elasticToModel();
    }

    /**
     * Paginates the Elasticsearch results.
     *
     * @param int $perPage
     * @return mixed
     */
    public function paginate($perPage = 15)
    {
        return new LengthAwarePaginator($this->items,count($this->items),$perPage);
    }


    /**
     * simplePaginate the Elasticsearch results.
     *
     * @param int $perPage
     * @param array $columns
     * @param string $pageName
     * @param null $page
     * @return Paginator
     */
    public function simplePaginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
    {
        $page = $page ?: Paginator::resolveCurrentPage($pageName);

        $perPage = $perPage ?: $this->model->getPerPage();

        // Next we will set the limit and offset for this query so that when we get the
        // results we get the proper section of results. Then, we'll create the full
        // paginator instances for these results with the given page and per page.
        $this->skip(($page - 1) * $perPage)->take($perPage + 1);

        return new Paginator($this->items, $perPage, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => $pageName,
        ]);
    }

    /**
     * Limits the number of results.
     *
     * @param int|null $limit
     * @return ElasticCollection
     */
    public function limit($limit = null)
    {
        if ($limit) {
            if ($limit < 0) {
                $this->items = array_slice($this->items, $limit, abs($limit));
            }
            else {
                $this->items = array_slice($this->items, 0, $limit);
            }
        }

        return $this;
    }

    /**
     * Builds a list of models from Elasticsearch
     * results.
     *
     * @return array
     */
    protected function elasticToModel()
    {
        $items = array();

        foreach ($this->response['hits']['hits'] as $hit) {
            $items[] = $this->instance->newFromElasticResults($hit);
        }

        return $items;
    }

    /**
     * Total number of hits.
     *
     * @return string
     */
    public function total()
    {
        return $this->response['hits']['total'];
    }

    /**
     * Max score of the results.
     *
     * @return string
     */
    public function maxScore()
    {
        return $this->response['hits']['max_score'];
    }

    /**
     * Time in ms it took to run the query.
     *
     * @return string
     */
    public function took()
    {
        return $this->response['took'];
    }

    /**
     * Wheather the query timed out, or not.
     *
     * @return bool
     */
    public function timedOut()
    {
        return $this->response['timed_out'];
    }

    /**
     * Shards information.
     *
     * @param null|string $key
     * @return array|string
     */
    public function shards($key = null)
    {
        $shards = $this->response['_shards'];

        if ($key and isset($shards[$key])) {
            return $shards[$key];
        }

        return $shards;
    }

}
