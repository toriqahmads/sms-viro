<?php
namespace Toriqahmads\SmsViro;
require (__DIR__."/../vendor/autoload.php");
use GuzzleHttp\Client;
use Toriqahmads\SmsViro\Exceptions\SmsViroException;

class SmsViro
{
    private string $apikey;
    private string $from;
    private string $baseuri = "https://api.smsviro.com/restapi/sms";
    private string $endpoint = "/1/text/advanced";

    public function __construct(string $apikey, string $from)
    {
        $this->apikey = $apikey;
        $this->from = $from;
    }

    /**
     * getter for property apikey
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apikey;
    }

    /**
     * getter for property from
     *
     * @return string
     */
    public function getFrom(): string
    {
        return $this->from;
    }

    /**
     * setter for property apikey
     *
     * @param string $apikey
     * @return void
     */
    public function setApiKey(string $apikey): void
    {
        $this->apikey = $apikey;
    }

    /**
     * setter for property from
     *
     * @param string $from
     * @return void
     */
    public function setFrom(string $from): void
    {
        $this->from = $from;
    }

    /**
     * Build http client instance
     *
     * @return Client
     */
    private function buildHttpClient(): Client
    {
        $client = new Client([
            "base_uri" => $this->baseuri,
            "timeout" => 30,
            "allow_redirects" => true,
            "headers" => [
                "Content-Type" => "application/json",
                "Accept" => "application/json",
                "Authorization" => "App {$this->apikey}"
            ]
        ]);

        return $client;
    }

    /**
     * Build http request body
     *
     * @param array $to
     * @param string $text
     * @return object
     */
    private function buildRequestBody(array $to, string $text): object
    {
        return json_decode([
            "message" => [
                "from" => $this->from,
                "destination" => [
                    "to" => $to
                ],
                "text" => $text
            ]
        ]);
    }

    /**
     * Format $to to standard formatting
     *
     * @param string $to
     * @return string
     */
    private function formatting(string $to): string
    {
        if (!preg_match("/(^(62)|^(\+62))\d{9,11}/", $to) || !preg_match("/^(0)\d{9,12}/", $to))
        {
            throw new SmsViroException("Number must be start with 62 or +62 or 0");
        }

        if (preg_match("/^(0)\d{9,12}/", $to))
        {
            $to = preg_replace("/^(0)/", "62", $to);
        }

        return $to;
    }

    /**
     * Set to
     *
     * @param string|array $to
     * @return array
     */
    private function setTo($to): array
    {
        if (!is_array($to) || !is_string($to)) throw new SmsViroException("Parameter $to must be string or array");

        $destination = array();

        if (is_array($to))
        {
            if (empty($to)) throw new SmsViroException("Parameter $to is empty");
            foreach ($to as $value)
            {
                array_push($destination, $this->formatting($value));
            }
        }

        if (is_string($to))
        {
            if (empty($to)) throw new SmsViroException("Parameter $to is empty");
            array_push($destination, $this->formatting($to));
        }

        return $destination;
    }

    /**
     * Send single or broadcast SMS
     *
     * @param string|array $to
     * @param string $text
     * @return void
     */
    public function sendSms($to, string $text)
    {
        $httpRequest = $this->buildHttpClient();
        $requestBody = $this->buildRequestBody($this->setTo($to), $text);

        $httpRequest->request("POST", $this->endpoint, ["body" => $requestBody]);

        if ($httpRequest->getStatusCode() !== 200) {
            throw new SmsViroException("Error while sending sms");
        }

        return true;
    }
}
