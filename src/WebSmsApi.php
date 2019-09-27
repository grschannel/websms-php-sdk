<?php

namespace Websms;

use SoapClient;
use Websms\Exceptions\CredentialErrorExeption;
use Websms\Exceptions\CreditErrorExeption;


class WebSmsApi
{

    public function __construct($username, $password, HttpClient $httpClient = null)
    {
        $this->username=$username;
        $this->password=$password;

    }

    protected function execute($methodName, $params = array())
    {
        $client = new SoapClient('http://smsg.ir/webservice/?wsdl',['encoding' => 'UTF-8']);
        $params = array_merge([
            'username' => $this->username,
            'password' => $this->password,
        ],$params);

        $result = $client->__soapCall($methodName, $params);

        switch ($result['status']){
            case WebSmsStatusEnum::CREDENTIAL_ERROR:
                throw new CredentialErrorExeption('Username or Password is incurrect.');
                break;
            case WebSmsStatusEnum::CREDIT_ERROR:
                throw new CreditErrorExeption('Your Credit is not enough.');
                break;
            default:
                break;
        }

        return $result;
    }

    public function Send($to, $from, $text)
    {
        $params = array(
            'to' => $to,
            'from' => $from,
            'message' => $text,
        );
        
        return $this->execute('send',$params);
    }

    public function MultiSend($to, $from, $text)
    {
        $params = array(
            'to' => $to,
            'from' => $from,
            'message' => $text,
        );

        return $this->execute('multiSend',$params);
    }
}