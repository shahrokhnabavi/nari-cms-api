<?php
declare(strict_types = 1);

namespace SiteApi\Infrastructure\Http;

class ContentController extends HttpController
{
    public function list($request, $response, $args)
    {
        return $this->html($response, 'List');
    }

    public function get($request, $response, $args)
    {
        return $this->html($response, 'get');
    }

    public function create($request, $response, $args)
    {
        return $this->html($response, 'create');
    }

    public function edit($request, $response, $args)
    {
        return $this->html($response, 'edit');
    }

    public function delete($request, $response, $args)
    {
        return $this->html($response, 'delete');
    }
}
