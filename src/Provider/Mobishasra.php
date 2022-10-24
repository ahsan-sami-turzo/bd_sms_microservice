<?php

namespace Radon\LaravelBDSms\Provider;

use GuzzleHttp\Exception\GuzzleException;
use Radon\LaravelBDSms\Handler\ParameterException;
use Radon\LaravelBDSms\Handler\RenderException;
use Radon\LaravelBDSms\Request;
use Radon\LaravelBDSms\Sender;

class Mobishasra extends AbstractProvider
{
    /**
     * BulkSmsBD constructor.
     * @param Sender $sender
     */
    public function __construct(Sender $sender)
    {
        $this->senderObject = $sender;
    }

    /**
     * Send Request To Api and Send Message
     * @throws GuzzleException|RenderException
     */
    public function sendRequest()
    {
        $number = $this->senderObject->getMobile();
        $text = $this->senderObject->getMessage();
        $config = $this->senderObject->getConfig();
        $queue = $this->senderObject->getQueue();
        $query = [
            'user' => $config['user'],
            'pwd' => $config['pwd'],
            'senderid' => $config['senderid'],
            'mobileno' => '88' . $number,
            'msgtext' => $text,
            'priority' => 'High',
            'CountryCode' => 'ALL',
        ];
        $requestObject = new Request('https://mshastra.com/sendurlcomma.aspx', $query, $queue);

        $response = $requestObject->get();
        if ($queue) {
            return true;
        }
        $body = $response->getBody();
        $smsResult = $body->getContents();

        $data['number'] = $number;
        $data['message'] = $text;
        return $this->generateReport($smsResult, $data)->getContent();
    }

    /**
     * @return void
     * @throws ParameterException
     */
    public function errorException()
    {
        if (!array_key_exists('user', $this->senderObject->getConfig())) {
            throw new ParameterException('user key is absent in configuration');
        }
        if (!array_key_exists('pwd', $this->senderObject->getConfig())) {
            throw new ParameterException('pwd key is absent in configuration');
        }
        if (!array_key_exists('senderid', $this->senderObject->getConfig())) {
            throw new ParameterException('senderid key is absent in configuration');
        }
    }
}
