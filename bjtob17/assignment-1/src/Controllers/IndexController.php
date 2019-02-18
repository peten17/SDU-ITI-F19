<?php
namespace Controllers;

use Routing\IRequest;

class IndexController extends BaseController
{
    public function index(IRequest $request): string
    {
        return $this->html("index", ["msg" => "hello!!!"]);
    }

    public function upload(IRequest $request): string
    {
        return $this->json($request->getBody());
    }
}