<?php

namespace Toriqahmads\SmsViro\Tests;

use PHPUnit\Framework\TestCase;
use Toriqahmads\SmsViro\SmsViro;

class SmsViroTest extends TestCase
{
    private function getInstance(): SmsViro
    {
        return new SmsViro("blabla", "blabla");
    }

    public function testSetCredential()
    {
        $smsviro = new SmsViro("blabla", "blabla");
        return $this->assertTrue($smsviro->getApiKey() === "blabla" && $smsviro->getFrom() === "blabla");
    }

    public function testSendSms()
    {
        $smsviro = $this->getInstance();


    }
}
