<?php

require_once __DIR__ . '../../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;

// Paramètres de connexion
$host = 'rabbitmq';
$port = 5672;
$user = 'pizza_shop_user'; // Remplacer par votre utilisateur
$pass = 'pizza_shop';  // Remplacer par votre mot de passe

// Connexion à RabbitMQ
$connection = new AMQPStreamConnection($host, $port, $user, $pass);
$channel = $connection->channel();

// Déclaration de la queue
$channel->queue_declare('nouvelles_commandes', false, true, false, false);

// Consommation du message
$message = $channel->basic_get('nouvelles_commandes');

if ($message !== null) {
    // Décodage du message
    $data = json_decode($message->body, true);

    // Affichage du contenu du message
    print_r($data);

    // Acquittement de la réception du message
    $channel->basic_ack($message->delivery_info['delivery_tag']);
} else {
    echo "Aucun message dans la queue.\n";
}

// Fermeture du canal et de la connexion
$channel->close();
$connection->close();