<?php
namespace Ibc\Tzordertab;

use Ibc\Tzordertab\AccountTable;
use Ibc\Tzordertab\IbcTzordertabHelper;
use Ibc\Tzordertab\apiibc;
use Bitrix\Main\Loader;
use GuzzleHttp\Client;


class EventHandler
{
    public static $baseuurl = 'https://rest.db.ripe.net/search.json?query-string=';

    public static function onSaleOrderSaved($event)
    {
        $ipAdress = self::getUserIp();

        $order = $event->getParameter("ENTITY");

        $orderid =$order->getId();
        $accouunts = AccountTable::getList([
                                               'select' => ['*'],
                                               'filter' => [
                                                   'orderid' => $orderid

                                               ]
                                           ]);

        $accouunt = $accouunts->fetch();

        $client = new Client();
        $apiIBC = new apiibc($client);
        $url = self::$baseuurl.''.$ipAdress;
        $tmpText = $apiIBC->getRequest($url);
        $b24Contact = json_decode($tmpText, true);

        $provider = '';

        foreach ($b24Contact['objects']['object'][0]["attributes"]['attribute'] as $key => $value) {
            if ($value['name'] == 'descr'){
                $provider = $provider . $value['value'];
                //AddMessage2Log(print_r($value['value'] ,1), "ibc");
            }
            //AddMessage2Log(print_r($key,1), "ibc");


        }
        if (empty($accouunt)){
            $product = AccountTable::createObject();
            $product->setOrderid($orderid);
            $product->setIp($ipAdress);
            $product->setProvider($provider);
            $product->save();
        }

    }

    public static function getUserIp() {
        //Массив ключей $_SERVER которые следует проверить
        $serverKeys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'REMOTE_ADDR'
        ];

        foreach ($serverKeys as $key) {
            if ($_SERVER[$key]) {
                //Преобразуем строку в $_SERVER в массив, получаем последний элемент массива который содержит ip-адрес
                $ipAddress = trim(end(explode(',', $_SERVER[$key])));
                //Проверяем переменную $ipAddress на валидность
                if (filter_var($ipAddress, FILTER_VALIDATE_IP)) {
                    return $ipAddress;
                }
            }
        }

        //Не удалось определить ip адрес
        return false;
    }
}