<?php

namespace pizzashop\tests\commande;

require_once __DIR__ . '/../../vendor/autoload.php';

use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use pizzashop\shop\domain\dto\commande\ItemDTO;
use pizzashop\shop\domain\entities\commande\Commande;
use pizzashop\shop\domain\entities\commande\Item;
use Illuminate\Database\Capsule\Manager as DB;
use pizzashop\shop\domain\service\CatalogueService as CatalogueService;
use pizzashop\shop\domain\service\CommandeService as CommandeService;
use pizzashop\shop\domain\dto\commande\CommandeDTO as CommandeDTO;
use pizzashop\shop\Exception\ServiceCatalogueNotFoundException;
use pizzashop\shop\Exception\ServiceCommandeInvalideException;
use pizzashop\shop\Exception\ServiceCommandeNotFoundException as ServiceCommandeNotFoundException;
use pizzashop\shop\Exception\ServiceValidatorException;
use Respect\Validation\Exceptions\ValidationException;

class ServiceCommandeTest extends \PHPUnit\Framework\TestCase
{

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

        self::cleanDB();
    }


    private static function cleanDB()
    {

        foreach (self::$commandeIds as $id) {
            Commande::find($id)->delete();
            $items = Item::where('commande_id', $id)->get();
            foreach ($items as $item) {
                self::$itemIds[] = $item->id;
            }
        }
        foreach (self::$itemIds as $id) {
            Item::find($id)->delete();
        }
    }

    private static function fill()
    {
        // Crée une commande fictive pour tester l'accès
        $commande = new Commande();
        $commande->id = "11111111";
        $commande->date_commande = '2023-05-17 01:46:37';
        $commande->type_livraison = 3;
        $commande->delai = 0;
        $commande->etat = 1;
        $commande->montant_total = 88.8;
        $commande->mail_client = 'test@gmail.com';
        self::$commandeIds[] = $commande->id;

        //Crée 2 items fictif pour les tests
        $item1 = new Item();
        $item1->numero = 1;
        $item1->libelle = "test1";
        $item1->taille = 1;
        $item1->libelle_taille = "normale";
        $item1->tarif = 10.0;
        $item1->quantite = 2;
        $item1->commande_id = $commande->id;

        $item2 = new Item();
        $item2->numero = 1;
        $item2->libelle = "test2";
        $item2->taille = 2;
        $item2->libelle_taille = "grande";
        $item2->tarif = 20.0;
        $item2->quantite = 1;
        $item2->commande_id = $commande->id;


        $item1->save();
        $item2->save();
        $commande->save();

    }


    public function testAccederCommande()
    {

        try {
            // Appelez la méthode accederCommande pour obtenir le DTO
            $commandeDTO = self::$serviceCommande->accederCommande(self::$commandeIds[0]);

            // Vérifiez si le DTO a été créé correctement
            $this->assertInstanceOf(CommandeDTO::class, $commandeDTO);
            $this->assertEquals('11111111', $commandeDTO->getIdCommande());
            $this->assertEquals('2023-05-17 01:46:37', $commandeDTO->getDateCommande());
            $this->assertEquals(3, $commandeDTO->getTypeLivraison());
            $this->assertEquals(0, $commandeDTO->getDelaiCommande());
            $this->assertEquals(88.8, $commandeDTO->getMontantCommande());
            $this->assertEquals('test@gmail.com', $commandeDTO->getMailClient());

        } catch (ServiceCommandeNotFoundException $e) {
            // Si une exception est lancée, le test échouera
            $this->fail("ServiceCommandeNotFoundException ne devrait pas être levée ici." . $e->getMessage());
        } catch (ValidationException $e) {
            $this->fail($e->getFullMessage());
        } catch (ServiceCatalogueNotFoundException $e) {
        }
    }

    public function testCreerCommande()
    {

        //créer 2 itemdto
        $itemDTO1 = new ItemDTO(
            "22222222",
            10,
            1,
            (float)null,
            "",
            "",
            2
        );

        $itemDTO2 = new ItemDTO(
            "22222222",
            10,
            2,
            (float)null,
            "",
            "",
            1
        );

        $commandeDTO = new CommandeDTO(
            '22222222',
            '',
            3,
            (int)null,
            (int)null,
            (int)null,
            'commande@gmail.com',
            [$itemDTO1, $itemDTO2]);


        self::$commandeIds[] = '22222222';

        try {

            self::$serviceCommande->creerCommande($commandeDTO);

            //tester si la commande est bien créée
            $commande = Commande::find('22222222');
            $this->assertEquals(3, $commande->type_livraison);
            $this->assertEquals(0, $commande->delai);
            $this->assertEquals(Commande::ETAT_CREE, $commande->etat);
            $this->assertEquals(15.97, $commande->montant_total);
            $this->assertEquals("commande@gmail.com", $commande->mail_client);

            $itemsCommande = Item::where('commande_id', '22222222')->get();
            $this->assertCount(2, $itemsCommande);

        } catch (ServiceCommandeNotFoundException $e) {
            $this->fail("ServiceCommandeNotFoundException ne devrait pas être levée ici." . $e->getMessage());
        } catch (ServiceCatalogueNotFoundException $e){
            $this->fail("ServiceCatalogueNotFoundException ne devrait pas être levée ici." . $e->getMessage());
        } catch (ServiceValidatorException $e) {
            $this->fail("ServiceValidatorException ne devrait pas être levée ici." . $e->getMessage());
        } catch (ServiceCommandeInvalideException $e) {
            $this->fail("ServiceCommandeInvalideException ne devrait pas être levée ici." . $e->getMessage());
        } catch (ValidationException $e) {
            $this->fail($e->getFullMessage());
        } catch (Exception $e) {
            $this->fail($e->getMessage());
        }
    }

    public function testValiderCommande()
    {
        try {
            // Appelez la méthode validerCommande pour valider la commande
            self::$serviceCommande->validerCommande(self::$commandeIds[0]);

            // Vérifiez si la commande a été validée correctement
            $commande = Commande::find(self::$commandeIds[0]);
            $this->assertEquals(Commande::ETAT_VALIDE, $commande->etat);
        } catch (ServiceCommandeNotFoundException $e) {
            // Si une exception est lancée, le test échouera
            $this->fail("ServiceCommandeNotFoundException ne devrait pas être levée ici.") . $e->getMessage();
        } catch (ValidationException $e) {
            $this->fail($e->getFullMessage());
        } catch (ServiceCommandeInvalideException $e) {
            $this->fail("ServiceCommandeInvalideException ne devrait pas être levée ici.") . $e->getMessage();
        } catch (ServiceValidatorException $e) {
            $this->fail("ServiceValidatorException ne devrait pas être levée ici.") . $e->getMessage();
        }
    }


}