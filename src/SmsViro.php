<?php
namespace Toriqahmads\SmsViro;
require ("../vendor/autoload.php");
use GuzzleHttp\Client;
use Toriqahmads\SmsViro\Exceptions\SmsViroException;

class SmsViro
{
    private String $apikey;
    private String $from;
    private String $baseuri = "https://api.smsviro.com/restapi/sms";
    private String $endpoint = "/1/text/advanced";

    public function __construct(String $apikey, String $from)
    {
        $this->apikey = $apikey;
        $this->from = $from;
    }

    public function getApiKey(): String
    {
        return $this->apikey;
    }

    public function getFrom(): String
    {
        return $this->from;
    }

    public function setApiKey(String $apikey): void
    {
        $this->apikey = $apikey;
    }

    public function setFrom(String $from): void
    {
        $this->from = $from;
    }

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

    public function sendSms(array $to, string $text)
    {
        $httpRequest = $this->buildHttpClient();
        $requestBody = $this->buildRequestBody($to, $text);

        $httpRequest->request("POST", $this->endpoint, ["body" => $requestBody]);

        if ($httpRequest->getStatusCode() === 200) {
            return true;
        }

        return new SmsViroException("Error while sending sms");
    }
}
