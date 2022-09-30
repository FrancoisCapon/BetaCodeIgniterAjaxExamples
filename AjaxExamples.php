<?php

namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;

//use CodeIgniter\HTTP\Response;

class AjaxExamples extends BaseController
{
    use ResponseTrait;

    function __construct() 
    {
        // https://codeigniter.com/user_guide/outgoing/api_responses.html?highlight=response#handling-response-types
        // If that is empty, it will try to negotiate the content type with what the client asked for : xml or json
        $this->format = ''; // json by default (inheritance)
    }

    public function index()
    {
        return view('ajax_examples');
    }

    public function computeUppercase()
    {
        $responseText['word'] = $this->request->getPost('word');
        $responseText['result'] = strtoupper($responseText['word']);

        sleep(random_int(1,4));

        return $this->respond($responseText, 200); // xml or json automaticaly
    }

    public function computeDouble($number)
    {
        $result = $number * 2;

        sleep(random_int(1,4));

        $this->response->setStatusCode(200);
        $this->response->setHeader('Content-Type', $this->request->getHeaderLine('Accept')); // text/plain
        $this->response->setBody((string)$result);
        
        return $this->response;
    }
}

/*
debugbar_1664118820.964360.json
 GET 	http://localhost:8080/index.php?debugbar_time=1664118820.96436 manque le zéro !!
 stockage local
*/
