<?php

namespace pizzashop\shop\tests\commande;

require_once __DIR__ . '/../../vendor/autoload.php';

use PHPUnit\Framework\Attributes\DataProvider;
use pizzashop\shop\domain\entities\commande\Commande;
use pizzashop\shop\domain\entities\commande\Item;
use Illuminate\Database\Capsule\Manager as DB;
use pizzashop\shop\domain\service\CatalogueService as CatalogueService;
use pizzashop\shop\domain\service\CommandeService as CommandeService;
use pizzashop\shop\domain\dto\commande\CommandeDTO as CommandeDTO;
use pizzashop\shop\Exception\ServiceCommandeNotFoundException as ServiceCommandeNotFoundException;

class ServiceCommandeTest extends \PHPUnit\Framework\TestCase {

    private static $commandeIds = [];
    private static $itemIds = [];
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
        self::fill();

    }

    public static function tearDownAfterClass(): void
    {
        //parent::tearDown(); // TODO: Change the autogenerated stub
        self::cleanDB();
    }


    private static function cleanDB(){
        foreach (self::$commandeIds as $id){
            Commande::find($id)->delete();
        }
        foreach (self::$itemIds as $id){
            Item::find($id)->delete();
        }
    }

    private static function fill()
    {
        // TODO : créer une commande dans la base pour tester l'accès à une commande
        // Crée une commande fictive pour tester l'accès
        $commande = new Commande();
        $commande->id = '11111111';
        $commande->date_commande = '2023-05-17 01:46:37';
        $commande->type_livraison = 3;
        $commande->delai = 0;
        $commande->etat = 1;
        $commande->montant_total = 88.8;
        $commande->mail_client = 'test@gmail.com';
        self::$commandeIds[] = $commande->id;

        //Crée 2 items fictif pour les tests
        $item1 = new Item();
        $item1->id = 1;
        $item1->numero = 1;
        $item1->libelle = "test1";
        $item1->taille = 1;
        $item1->libelle_taille = "normale";
        $item1->tarif = 10.0;
        $item1->quantite = 2;
        $item1->commande_id = $commande->id;
        self::$itemIds[] = $item1->id;

        $item2 = new Item();
        $item2->id = 2;
        $item2->numero = 1;
        $item2->libelle = "test2";
        $item2->taille = 2;
        $item2->libelle_taille = "grande";
        $item2->tarif = 20.0;
        $item2->quantite = 1;
        $item2->commande_id = $commande->id;
        self::$itemIds[] = $item2->id;

        $item1->save();
        $item2->save();
        $commande->save();

    }


    public function testAccederCommande()
    {


        try {
            // Appelez la méthode accederCommande pour obtenir le DTO
            $commandeDTO = self::$serviceCommande->accederCommande(self::$commandeIds[0], self::$serviceProduits);

            // Vérifiez si le DTO a été créé correctement
            $this->assertInstanceOf(CommandeDTO::class, $commandeDTO);
            $this->assertEquals('11111111', $commandeDTO->getIdCommande());
            $this->assertEquals('2023-05-17 01:46:37', $commandeDTO->getDateCommande());
            $this->assertEquals(3, $commandeDTO->getTypeLivraison());
            $this->assertEquals(0, $commandeDTO->getDelaiCommande());
            $this->assertEquals(1, $commandeDTO->getEtatCommande());
            $this->assertEquals(88.8, $commandeDTO->getMontantCommande());
            $this->assertEquals('test@gmail.com', $commandeDTO->getMailClient());

        } catch (ServiceCommandeNotFoundException $e) {
            // Si une exception est lancée, le test échouera
            $this->fail("ServiceCommandeNotFoundException ne devrait pas être levée ici.");
        }
    }

    public function testValiderCommande() {
        try {
            // Appelez la méthode validerCommande pour valider la commande
            self::$serviceCommande->validerCommande(self::$commandeIds[0]);

            // Vérifiez si la commande a été validée correctement
            $commande = Commande::find(self::$commandeIds[0]);
            $this->assertEquals(Commande::ETAT_VALIDE, $commande->etat);
        } catch (ServiceCommandeNotFoundException $e) {
            // Si une exception est lancée, le test échouera
            $this->fail("ServiceCommandeNotFoundException ne devrait pas être levée ici.");
        }
    }
}