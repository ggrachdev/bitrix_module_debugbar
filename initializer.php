<?php

// Need include this file in init.php

use Bitrix\Main\Loader;

include 'inizializer_alias.php';

Loader::registerAutoLoadClasses(null, [
    "\Fred\GiftCard\Configuration\IblockConfiguration" => "/bitrix/php_interface/src/GiftCard/Configuration/IblockConfiguration.php",
    "\Fred\GiftCard\Configuration\OrderConfiguration" => "/bitrix/php_interface/src/GiftCard/Configuration/OrderConfiguration.php",
    "\Fred\GiftCard\Configuration\GiftCardConfiguration" => "/bitrix/php_interface/src/GiftCard/Configuration/GiftCardConfiguration.php",
    "\Fred\GiftCard\Configuration\SenderConfiguration" => "/bitrix/php_interface/src/GiftCard/Configuration/SenderConfiguration.php",
    "\Fred\GiftCard\Validation\GiftCardValidator" => "/bitrix/php_interface/src/GiftCard/Validation/GiftCardValidator.php",
    "\Fred\GiftCard\Repository\GiftCardsRepository" => "/bitrix/php_interface/src/GiftCard/Repository/GiftCardsRepository.php",
    "\Fred\GiftCard\Repository\GiftCardsSenderRepository" => "/bitrix/php_interface/src/GiftCard/Repository/GiftCardsSenderRepository.php",
    "\Fred\GiftCard\Order\GiftCardOrderManager" => "/bitrix/php_interface/src/GiftCard/Order/GiftCardOrderManager.php",
    "\Fred\GiftCard\Factory\GiftCardFactory" => "/bitrix/php_interface/src/GiftCard/Factory/GiftCardFactory.php",
    "\Fred\GiftCard\Factory\GiftCardQueueItemFactory" => "/bitrix/php_interface/src/GiftCard/Factory/GiftCardQueueItemFactory.php",
    "\Fred\GiftCard\Models\GiftCard" => "/bitrix/php_interface/src/GiftCard/Models/GiftCard.php",
    "\Fred\GiftCard\Models\GiftCardQueueItem" => "/bitrix/php_interface/src/GiftCard/Models/GiftCardQueueItem.php",
    "\Fred\GiftCard\Agents\GiftCardSendingAgent" => "/bitrix/php_interface/src/GiftCard/Agents/GiftCardSendingAgent.php",
    "\Fred\GiftCard\Utils\UserOrderCreatorUtil" => "/bitrix/php_interface/src/GiftCard/Utils/UserOrderCreatorUtil.php",
    "\Fred\GiftCard\Exception\CreateUserException" => "/bitrix/php_interface/src/GiftCard/Exception/CreateUserException.php",
    "\Fred\GiftCard\Senders\GiftCardsEmailSender" => "/bitrix/php_interface/src/GiftCard/Senders/GiftCardsEmailSender.php",
    "\Fred\GiftCard\Senders\GiftCardsSenderDistributor" => "/bitrix/php_interface/src/GiftCard/Senders/GiftCardsSenderDistributor.php",
    "\Fred\GiftCard\Senders\GiftCardsSmsSender" => "/bitrix/php_interface/src/GiftCard/Senders/GiftCardsSmsSender.php",
]);
