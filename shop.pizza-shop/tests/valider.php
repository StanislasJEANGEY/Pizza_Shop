<?php
require_once __DIR__ . '/../vendor/autoload.php';
use Illuminate\Database\Capsule\Manager as DbManager;

use pizzashop\shop\shop\domain\dto\commande\CommandeDTO;
use pizzashop\shop\shop\domain\dto\commande\ItemDTO;
use pizzashop\shop\shop\domain\entities\catalogue\Categorie;
use pizzashop\shop\shop\domain\entities\catalogue\Taille;
use pizzashop\shop\shop\domain\entities\catalogue\Produit;
use Faker\Factory;
use pizzashop\shop\shop\domain\entities\commande\Commande;

$dbcom = __DIR__ . '/../config/commande.db.ini';
$dbcat = __DIR__ . '/../config/catalog.db.ini';
$db = new DbManager();
$db->addConnection(parse_ini_file($dbcom), 'commande');
$db->addConnection(parse_ini_file($dbcat), 'catalog');
$db->setAsGlobal();
$db->bootEloquent();

