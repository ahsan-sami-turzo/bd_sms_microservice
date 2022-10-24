<?php


namespace Radon\LaravelBDSms\Provider;

use GuzzleHttp\Exception\GuzzleException;
use Radon\LaravelBDSms\Handler\ParameterException;
use Radon\LaravelBDSms\Handler\RenderException;
use Radon\LaravelBDSms\Request;
use Radon\LaravelBDSms\Sender;

class SmartLabSms extends AbstractProvider
{
    /**
     * SmartLabSMS constructor.
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
            'password' => $config['password'],
            'sender' => $config['sender'],
            'msisdn' => $number,
            'smstext' => $text,
        ];

        $requestObject = new Request('https://labapi.smartlabsms.com/smsapi', $query, $queue);
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
     * @throws ParameterException
     */
    public function errorException()
    {
        if (!array_key_exists('user', $this->senderObject->getConfig())) {
            throw new ParameterException('user key is absent in configuration');
        }
        if (!array_key_exists('password', $this->senderObject->getConfig())) {
            throw new ParameterException('password key is absent in configuration');
        }

        if (!array_key_exists('sender', $this->senderObject->getConfig())) {
            throw new ParameterException('sender key is absent in configuration');
        }
    }
}
