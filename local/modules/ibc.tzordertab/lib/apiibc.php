<?php
namespace Ibc\Tzordertab;
use GuzzleHttp\Client;

class apiibc
{
    public $client;

    public function __construct( $client)
    {
        $this->client = $client;

    }

    public function getRequest($url) {

        try {
            $response =  $this->client->request("GET", $url, []);
            $body = $response->getBody()->getContents();
        } catch (Exception $e) {
            $body = 'Выброшено исключение: '.  $e->getMessage(). "\n";
        }

        return $body;
    }

    public function createDeal($params) {
        $response = $this->client->request('POST', 'http://ibcdebts.ru/ajax/tgbot/deal/index.php', [
            "form_params" => [
                "companyId" => $params['companyId'],
                "OPPORTUNITY" => $params['OPPORTUNITY'],
                "method" => 'createDeal',
            ]
        ]);
        $body = $response->getBody()->getContents();

        return $body;
    }

    public function checkContactCard() {

    }
}

?>