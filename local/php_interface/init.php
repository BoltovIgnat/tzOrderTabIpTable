<?php
use Bitrix\Main\Loader;
Loader::includeModule('ibc.tzordertab');
use Ibc\Tzordertab\IbcTzordertabHelper;

$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler("main", "OnAdminSaleOrderView", array("MyAdminOrderFormTabs", "onInit"));

class MyAdminOrderFormTabs
{
    function onInit()
    {
        return array(
            "TABSET" => "MyTabs",
            "GetTabs" => array("MyAdminOrderFormTabs", "getTabs"),
            "ShowTab" => array("MyAdminOrderFormTabs", "showTabs"),
            "Action" => array("MyAdminOrderFormTabs", "onSave"),
            "Check" => array("MyAdminOrderFormTabs", "onBeforeSave"),
        );
    }

    /*
    Возвращает массив вкладок
    */
    function getTabs($args)
    {
        return array(
            array(
                "DIV" => "myTab1",
                "TAB" => "Информацию об ip-адресе покупателя",
                "TITLE" => "Информацию об ip-адресе покупателя",
                "SORT" => 1
            )
        );
    }

    /*
    Выводит вкладку
    */
    function showTabs($tabName, $args, $varsFromForm)
    {
        if ($tabName == "myTab1") {
            $result = IbcTzordertabHelper::getTableByOrderId($args['ID']);
           // $result = $result.' '.IbcTzordertabHelper::checkCompany($varsFromForm);
            echo $result;
        }
    }

    /*
    Вызывается перед onSave
    Для формы просмотра бесполезно, написано для примера
    */
    function onBeforeSave($args)
    {
        return true;
    }

    /*
    Вызывается после onBeforeSave при отправке формы
    Для формы просмотра бесполезно, написано для примера
    */
    function onSave($args)
    {
        return true;
    }
}