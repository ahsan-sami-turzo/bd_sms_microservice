<?php


namespace Radon\LaravelBDSms\Provider;

use GuzzleHttp\Exception\GuzzleException;
use Radon\LaravelBDSms\Handler\ParameterException;
use Radon\LaravelBDSms\Handler\RenderException;
use Radon\LaravelBDSms\Request;
use Radon\LaravelBDSms\Sender;

class AjuraTech extends AbstractProvider
{
    /**
     * Ajuratech constructor.
     * @param Sender $sender
     * @version v1.0.34
     * @since v1.0.34
     */
    public function __construct(Sender $sender)
    {
        $this->senderObject = $sender;
    }

    /**
     * Send Request To Api and Send Message
     * @return false|string
     * @throws GuzzleException
     * @throws RenderException
     * @since v1.0.34
     * @version v1.0.34
     */
    public function sendRequest()
    {
        $number = $this->senderObject->getMobile();
        $text = $this->senderObject->getMessage();
        $config = $this->senderObject->getConfig();
        $queue = $this->senderObject->getQueue();
        $query = [
            'apikey' => $config['apikey'],
            'secretkey' => $config['secretkey'],
            'callerID' => $config['callerID'],
            'toUser' => $number,
            'messageContent' => $text,
        ];

        $requestObject = new Request('https://smpp.ajuratech.com:7790/sendtext?json', $query, $queue);
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
     * @version v1.0.34
     * @since v1.0.34
     */
    public function errorException()
    {
        if (!array_key_exists('apikey', $this->senderObject->getConfig())) {
            throw new ParameterException('apikey is absent in configuration');
        }
        if (!array_key_exists('secretkey', $this->senderObject->getConfig())) {
            throw new ParameterException('secretkey is absent in configuration');
        }
        if (!array_key_exists('callerID', $this->senderObject->getConfig())) {
            throw new ParameterException('callerID is absent in configuration');
        }
    }
}
