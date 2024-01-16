<?php

require_once __DIR__ . '../../../../vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use pizzashop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\domain\dto\commande\ItemDTO;
use Faker\Factory;

// Paramètres de connexion
$host = 'rabbitmq';
$port = 5672;
$user = 'pizza_shop_user'; // Remplacer par votre utilisateur
$pass = 'pizza_shop';  // Remplacer par votre mot de passe

// Connexion à RabbitMQ
$connection = new AMQPStreamConnection($host, $port, $user, $pass);
$channel = $connection->channel();

// Déclaration de la queue
//$channel->queue_declare('nouvelles_commandes', false, true, false, false);

// Les informations fournies
$data = [
    "id" => "659d6e6da878f",
    "délai" => 0,
    "date" => "2024-01-09 16:03:57",
    "type livraison" => 3,
    "état" => "Commande créée",
    "montant" => 5.99,
    "mail client" => "commande@free.fr",
    "items" => [
        [
            "numero" => 10,
            "taille" => 2,
            "quantite" => 1,
            "libelle" => "panna cotta",
            "libelle_taille" => "grande",
            "tarif" => 5.99
        ]
    ],
];

// Création des items
$items = [];
foreach ($data['items'] as $itemData) {
    $items[] = new ItemDTO(
        $data['id'], // id_commande
        $itemData['numero'], // numero_produit
        $itemData['quantite'], // quantite_items
        $itemData['tarif'], // tarif_items
        $itemData['libelle'], // libelle_items
        $itemData['libelle_taille'], // libelle_taille
        $itemData['taille'] // taille_items
    );
}

// Création de la commande
$commande = new CommandeDTO(
    $data['id'], // id_commande
    $data['date'], // date_commande
    $data['type livraison'], // type_livraison
    $data['délai'], // delai_commande
    1, // etat_commande (1 pour "Commande créée")
    $data['montant'], // montant_commande
    $data['mail client'], // mail_client
    $items // items_commande
);

$commande = json_encode($data);
$msg = new AMQPMessage($commande);

// Publication du message
var_dump($commande);
$channel->basic_publish($msg, '', 'nouvelles_commandes');

echo " [x] Sent ", $commande, "\n";

// Fermeture du canal et de la connexion
$channel->close();
$connection->close();