<?php


namespace Radon\LaravelBDSms\Provider;

use Radon\LaravelBDSms\Handler\ParameterException;
use Radon\LaravelBDSms\Request;
use Radon\LaravelBDSms\Sender;

class NovocomBd extends AbstractProvider
{
    /**
     * Novocom constructor.
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
        $text = $this->senderObject->getMessage();
        $number = $this->senderObject->getMobile();
        $config = $this->senderObject->getConfig();
        $queue = $this->senderObject->getQueue();

        $query = [
            'ApiKey' => $config['ApiKey'],
            'ClientId' => $config['ClientId'],
            'SenderId' => $config['SenderId'],
            'MobileNumbers' => $number,
            'Message' => $text,
            'Is_Unicode' => true,
        ];

        $requestObject = new Request('https://sms.novocom-bd.com/api/v2/SendSMS', $query, $queue);
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
        if (!array_key_exists('ApiKey', $this->senderObject->getConfig())) {
            throw new ParameterException('ApiKey is absent in configuration');
        }
        if (!array_key_exists('ClientId', $this->senderObject->getConfig())) {
            throw new ParameterException('ClientId key is absent in configuration');
        }
        if (!array_key_exists('SenderId', $this->senderObject->getConfig())) {
            throw new ParameterException('SenderId key is absent in configuration');
        }
    }

}
