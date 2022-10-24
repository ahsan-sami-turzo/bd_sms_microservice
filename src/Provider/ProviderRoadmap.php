<?php


namespace Radon\LaravelBDSms\Provider;

interface ProviderRoadmap
{
    /**
     * @return mixed
     */
    public function getData();

    /**
     * @return mixed
     */
    public function setData();

    /**
     * @return mixed
     */
    public function sendRequest();

    /**
     * @param $result
     * @param $data
     * @return mixed
     */
    public function generateReport($result, $data);

    /**
     * @return mixed
     */
    public function errorException();
}
