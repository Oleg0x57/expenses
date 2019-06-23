<?php
/**
 * Created by PhpStorm.
 * User: Oleg0x57
 * Date: 23.06.2019
 * Time: 11:38
 */

class ExpendsApiTest extends \PHPUnit\Framework\TestCase
{
    protected $preserveGlobalState = FALSE;
    protected $runTestInSeparateProcess = TRUE;
    /**
     * @var \GuzzleHttp\Client
     */
    private $client;

    public function setUp()
    {
        $this->client = new \GuzzleHttp\Client(['base_uri' => 'http://localhost:8080']);
    }

    public function tearDown()
    {
        $this->client = null;
    }

    public function testOrdersGet()
    {
        $response = $this->client->get('/api/v1/expends');
        $this->assertEquals('200', $response->getStatusCode());
    }

    public function testOrdersGetOne()
    {
        $response = $this->client->get('/api/v1/expends/12');
        $this->assertEquals('200', $response->getStatusCode());
    }
}