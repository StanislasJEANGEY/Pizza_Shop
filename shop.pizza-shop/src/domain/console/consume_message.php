<?php

use PhpAmqpLib\Message\AMQPMessage;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\dto\commande\ItemDTO;

require_once __DIR__ . '../../../../vendor/autoload.php';


$faker = Faker\Factory::create('fr_FR');

$message_host = 'rabbitmq';
$message_port = 5672;
$message_user = 'pizza_shop_user';
$message_password = 'pizza_shop';
$message_queue = 'nouvelles_commandes';

$connection = new \PhpAmqpLib\Connection\AMQPStreamConnection(
    $message_host,
    $message_port,
    $message_user,
    $message_password
);
$channel = $connection->channel();


$msg = $channel->basic_consume($message_queue, '', false, false, false, false, function(AMQPMessage $msg) {
    $commande = json_decode($msg->body, true);
    print "[x] commande reçue : \n";
    print (string)$msg->body;
    $msg->getChannel()->basic_ack($msg->getDeliveryTag() );
    print "\n";
});

try {
    $channel->consume();
} catch (Exception $e) {
    print $e->getMessage();
}
$channel->close();
$connection->close();