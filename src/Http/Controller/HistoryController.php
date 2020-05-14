<?php

namespace Jakmall\Recruitment\Calculator\Http\Controller;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Jakmall\Recruitment\Calculator\History\Infrastructure\CommandHistoryManagerInterface;



class HistoryController
{

    protected $history;

    public function __construct(CommandHistoryManagerInterface $history) {
        $this->history = $history;
    }
    
    public function index(Request $request)
    {
        $data = $this->history->findAll();

        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function show($id)
    {
        
        $data = $this->history->findById($id);
        $response = new Response();
        $response->setContent(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    public function remove($id)
    {
        $response = new Response();
        $result = $this->history->deleteById($id);
        if ($result) {
            $response->setStatusCode(204);
        } else
            $response->setStatusCode(500);
        return $response;
    }
}
