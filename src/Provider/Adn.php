<?php


namespace Radon\LaravelBDSms\Provider;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Radon\LaravelBDSms\Handler\ParameterException;
use Radon\LaravelBDSms\Sender;

class Adn extends AbstractProvider
{
    /**
     * Adn constructor.
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
        $number = $this->senderObject->getMobile();
        $text = $this->senderObject->getMessage();
        $config = $this->senderObject->getConfig();

        $client = new Client([
            'timeout' => 10.0,
            'verify' => false
        ]);

        try {
            $response = $client->request('POST', 'https://portal.adnsms.com',
                [
                    'form_params' => [
                        'api_key' => $config['api_key'],
                        'type' => $config['type'],
                        'senderid' => $config['senderid'],
                        'mobile' => $number,
                        'message_body' => $text,
                    ],
                    'headers' => [
                        'Accept' => 'application/json'
                    ],
                    'debug' => false
                ]);
        } catch (GuzzleException $e) {
            return $e->getMessage();
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
        if (!array_key_exists('api_key', $this->senderObject->getConfig())) {
            throw new ParameterException('api_key is absent in configuration');
        }
        if (!array_key_exists('api_secret', $this->senderObject->getConfig())) {
            throw new ParameterException('api_secret key is absent in configuration');
        }
        if (!array_key_exists('request_type', $this->senderObject->getConfig())) {
            throw new ParameterException('request_type key is absent in configuration');
        }
        if (!array_key_exists('message_type', $this->senderObject->getConfig())) {
            throw new ParameterException('message_type key is absent in configuration');
        }

    }
}
