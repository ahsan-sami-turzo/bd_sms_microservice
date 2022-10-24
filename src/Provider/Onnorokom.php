<?php


namespace Radon\LaravelBDSms\Provider;


use SoapClient;
use Radon\LaravelBDSms\Handler\RenderException;
use Radon\LaravelBDSms\Sender;

/**
 * Class Onnorokom
 * @package Radon\LaravelBDSmsLog\Provider
 */
class Onnorokom extends AbstractProvider
{
    /**
     * Onnorokom constructor.
     * @param Sender $sender
     */
    public function __construct(Sender $sender)
    {
        $this->senderObject = $sender;
    }

    /**
     * Send Request To Server
     * @throws RenderException
     */
    public function sendRequest()
    {
        $data = [
            'number' => $this->senderObject->getMobile(),
            'message' => $this->senderObject->getMessage()
        ];

        if (!extension_loaded('soap')) {
            throw new RenderException("Soap extension is not enabled in your server. Please install/enable it before using onnorokom sms client");
        }

        $soapClient = new SoapClient("https://api2.onnorokomsms.com/sendsms.asmx?wsdl");
        $config = $this->senderObject->getConfig();
        $mobile = $this->senderObject->getMobile();
        $message = $this->senderObject->getMessage();
        $paramArray = array(
            'userName' => $config['userName'],
            'userPassword' => $config['userPassword'],
            'type' => $config['type'],
            'maskName' => $config['maskName'],
            'campaignName' => $config['campaignName'],
            'mobileNumber' => $mobile,
            'smsText' => $message,
        );
        $smsResult = $soapClient->__call("OneToOne", array($paramArray));

        return $this->generateReport($smsResult, $data);
    }

    /**
     * @throws RenderException
     */
    public function errorException()
    {
        if (!extension_loaded('soap')) {
            throw new RenderException('Soap client is not installed or loaded');
        }

        if (!array_key_exists('userName', $this->senderObject->getConfig())) {
            throw new RenderException('userName key is absent in configuration');
        }

        if (!array_key_exists('userPassword', $this->senderObject->getConfig())) {
            throw new RenderException('userPassword key is absent in configuration');
        }

        if (!array_key_exists('type', $this->senderObject->getConfig())) {
            throw new RenderException('type key is absent in configuration');
        }

        if (!array_key_exists('maskName', $this->senderObject->getConfig())) {
            throw new RenderException('maskName key is absent in configuration');
        }

        if (!array_key_exists('campaignName', $this->senderObject->getConfig())) {
            throw new RenderException('campaignName key is absent in configuration');
        }

    }

}
