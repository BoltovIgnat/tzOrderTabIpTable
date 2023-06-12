<?php

namespace Ibc\Tzordertab;

use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Localization\Loc;

use Bitrix\Main\Diag\Debug;
use \Bitrix\Crm;
use Ibc\Tzordertab\AccountTable;


Loc::loadMessages(__FILE__);

class IbcTzordertabHelper
{

    public static function getTableByOrderId($orderId)
    {
        $accouunts = AccountTable::getList([
                                               'select' => ['*'],
                                               'filter' => [
                                                   'orderid' => $orderId

                                               ]
                                           ]);

        $accouunt = $accouunts->fetch();

        $table = '<table border="1">
               <caption>Информацию об ip-адресе покупателя</caption>
               <tr>
                    <th>IP</th>
                    <th>Провайдер</th>
               </tr>
               <tr>
                   <td>'.$accouunt['ip'].'</td>
                   <td>'.$accouunt['provider'].'</td>
               </tr>
               
              </table>';

        return $table;

    }



}
