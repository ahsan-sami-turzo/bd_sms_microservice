<?php

namespace Radon\LaravelBDSms\Provider;

use Radon\LaravelBDSms\Handler\RenderException;
use Radon\LaravelBDSms\Request;
use Radon\LaravelBDSms\Sender;

class MDL extends AbstractProvider
{
    /**
     * MDL constructor.
     * @param Sender $sender
     */
    public function __construct(Sender $sender)
    {
        $this->senderObject = $sender;
    }

    /**
     * Send Request To Api and Send Message
     */
    public function sendRequest()
    {
        $text = $this->senderObject->getMessage();
        $number = $this->senderObject->getMobile();
        $config = $this->senderObject->getConfig();
        $queue = $this->senderObject->getQueue();

        $query = [
            'api_key' => $config['api_key'],
            'type' => $config['type'],
            'senderid' => $config['senderid'],
            'contacts' => $number,
            'msg' => $text,
        ];

        $requestObject = new Request('http://premium.mdlsms.com/smsapi', $query, $queue);
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
     * @throws RenderException
     */
    public function errorException()
    {
        if (!array_key_exists('api_key', $this->senderObject->getConfig())) {
            throw new RenderException('api_key is absent in configuration');
        }
        if (!array_key_exists('type', $this->senderObject->getConfig())) {
            throw new RenderException('type key is absent in configuration');
        }
        if (!array_key_exists('senderid', $this->senderObject->getConfig())) {
            throw new RenderException('senderid key is absent in configuration');
        }

    }
}
