<?php


namespace Radon\LaravelBDSms\Provider;

use Radon\LaravelBDSms\Handler\ParameterException;
use Radon\LaravelBDSms\Request;
use Radon\LaravelBDSms\Sender;

class Mobireach extends AbstractProvider
{
    /**
     * Mobireach constructor.
     * @param Sender $sender
     */
    public function __construct(Sender $sender)
    {
        $this->senderObject = $sender;
    }

    /**
     * Send Request To Api and Send Message
     * @return bool|mixed|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Radon\LaravelBDSms\Handler\RenderException
     */
    public function sendRequest()
    {
        $number = $this->senderObject->getMobile();
        $text = $this->senderObject->getMessage();
        $config = $this->senderObject->getConfig();
        $queue = $this->senderObject->getQueue();

        $query = [
            'Username' => $config['Username'],
            'Password' => $config['Password'],
            'From' => $config['From'],
            'To' => $number,
            'Message' => $text,
        ];

        $requestObject = new Request('https://api.mobireach.com.bd/SendTextMessage', $query, $queue);
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
        if (!array_key_exists('Username', $this->senderObject->getConfig())) {
            throw new ParameterException('Username is absent in configuration');
        }

        if (!array_key_exists('Password', $this->senderObject->getConfig())) {
            throw new ParameterException('Password is absent in configuration');
        }

        if (!array_key_exists('From', $this->senderObject->getConfig())) {
            throw new ParameterException('From is absent in configuration');
        }

    }

}
