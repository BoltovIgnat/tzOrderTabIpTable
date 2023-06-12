<?php

namespace Ibc\Tzordertab;

use Bitrix\Main\Entity\DataManager;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Entity\DatetimeField;
use Bitrix\Main\Entity\StringField;
use Bitrix\Main\Entity\Validator;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Type;
use Bitrix\Main\ORM;

Loc::loadMessages(__FILE__);

class AccountTable extends DataManager
{
    public static function getTableName()
    {
        return 'ibc_account';
    }

    public static function getMap()
    {
        return array(
            new IntegerField('id', array(
                'autocomplete' => true,
                'primary' => true,
                'title' => 'id',
            )),
            new StringField('orderid', array(
                'required' => false,
            )),
            new StringField('ip', array(
                'required' => false,
            )),
            new StringField('provider', array(
                'required' => false,
            )),


        );
    }
}
