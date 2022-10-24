<?php


namespace Radon\LaravelBDSms\Provider;


use Illuminate\Http\JsonResponse;

abstract class AbstractProvider implements ProviderRoadmap
{
    /**
     * @var
     */
    protected $senderObject;

    public function getData()
    {
        // TODO: Implement setData() method.

    }

    public function setData()
    {
        // TODO: Implement setData() method.
    }

    abstract public function sendRequest();

    /**
     * @param $result
     * @param $data
     * @return JsonResponse
     * @since v1.0.20
     * @version v1.0.20
     */
    public function generateReport($result, $data): JsonResponse
    {
        return response()->json([
            'status' => 'response',
            'response' => $result,
            'provider' => get_class($this),
            'send_time' => date('Y-m-d H:i:s'),
            'mobile' => $data['number'],
            'message' => $data['message']
        ]);
    }

    /**
     * @return mixed
     */
    abstract public function errorException();

    /**
     * Return Report As Array
     */
    public function toArray(): array
    {
        return [

        ];
    }

    /**
     * Return Report As Json
     * @deprecated
     */
    public function toJson($data)
    {
        return json_encode($data);
    }
}
