<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        echo "REQUEST\n\n";

        $user = $_SERVER["SSL_CLIENT_S_DN_CN"];

        echo "USER: $user\n";
        echo "SOAP REQUEST: ".$request->getContent();

        // check if user is allowed
        if (!$this->validateUser($user)) {
            return $this->generateResponseFault("User not allowed");
        }

        // check the payload

        // check wsdl compliance
        if (!$this->checkValidRequest($request->getContent())) {
            return $this->generateResponseFault("Response not valid");
        }

        // redirect the payload to backend
        $response = Http::withHeaders([
            'SoapAction' => $request->headers['SoapAction']
        ])
            ->withBasicAuth('12345','54321')
            ->timeout(10)
            ->connectTimeout(3)
            ->withBody($request->getContent(),'application/xml')
            ->post('http://wpsdev.popso.it:9090/');

        $response->onError(function (){
           // check different errors here
        });

        // check the backend response
        if (!$this->checkValidResponse($response)) {
            return $this->generateResponseFault("Response not valid");
        }

        //return to the caller
        return $response;
    }

    public function validateUser($user)
    {
        return true;
    }

    public function generateResponseFault($message)
    {
        return "SOAP ERROR: $message";
    }

    public function checkValidResponse($response)
    {
        return true;
    }
    public function checkValidRequest($request)
    {
        return true;
    }
}