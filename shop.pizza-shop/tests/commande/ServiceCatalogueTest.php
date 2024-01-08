<?php

namespace commande;

use Illuminate\Database\Capsule\Manager as DB;
use PHPUnit\Framework\TestCase;
use pizzashop\shop\domain\service\CatalogueService as CatalogueService;
use pizzashop\shop\domain\service\CommandeService as CommandeService;

class ServiceCatalogueTest extends TestCase
{
    private static $serviceProduits;
    private static $serviceCommande;

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();
        $dbcom = __DIR__ . '/../../config/commande.db.ini';
        $dbcat = __DIR__ . '/../../config/catalog.db.ini';
        $db = new DB();
        $db->addConnection(parse_ini_file($dbcom), 'commande');
        $db->addConnection(parse_ini_file($dbcat), 'catalog');
        $db->setAsGlobal();
        $db->bootEloquent();

        self::$serviceProduits = new CatalogueService();
        self::$serviceCommande = new CommandeService(self::$serviceProduits);

    }

    public static function tearDownAfterClass(): void
    {

    }

    public function testListerProduits(): void
    {
        $produits = self::$serviceProduits->listerProduits();
        $this->assertIsArray($produits);
        $this->assertNotEmpty($produits);
        $this->assertContainsOnlyInstancesOf('pizzashop\shop\domain\dto\catalogue\ProduitDTO', $produits);

    }
}