<?php


namespace Radon\LaravelBDSms\Provider;

use Radon\LaravelBDSms\Handler\ParameterException;
use Radon\LaravelBDSms\Request;
use Radon\LaravelBDSms\Sender;

/**
 * Class MimSms
 * @package Radon\LaravelBDSmsLog\Provider
 * @version v1.0.20
 * @since v1.0.20
 */
class MimSms extends AbstractProvider
{
    /**
     * Mimsms constructor.
     * @param Sender $sender
     * @version v1.0.20
     * @since v1.0.20
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
     * @version v1.0.20
     * @since v1.0.20
     */
    public function sendRequest()
    {
        $config = $this->senderObject->getConfig();
        $queue = $this->senderObject->getQueue();
        $text = $this->senderObject->getMessage();
        $number = $this->senderObject->getMobile();

        $query = [
            'api_key' => $config['api_key'],
            'type' => $config['type'],
            'senderid' => $config['senderid'],
            'contacts' => $number,
            'msg' => $text,
        ];

        $requestObject = new Request('https://esms.mimsms.com/smsapi', $query, $queue);
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
     * @version v1.0.20
     * @since v1.0.20
     */
    public function errorException()
    {
        if (!array_key_exists('api_key', $this->senderObject->getConfig())) {
            throw new ParameterException('api_key is absent in configuration');
        }
        if (!array_key_exists('type', $this->senderObject->getConfig())) {
            throw new ParameterException('type key is absent in configuration');
        }
        if (!array_key_exists('senderid', $this->senderObject->getConfig())) {
            throw new ParameterException('senderid key is absent in configuration');
        }
    }

}
