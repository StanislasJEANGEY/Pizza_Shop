<?php

namespace pizzashop\shop\app\actions\get;

use Exception;
use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\domain\service\iCatalogueService;
use pizzashop\shop\domain\service\iCommandeService;
use pizzashop\shop\Exception\ServiceCommandeNotFoundException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccederCommande extends AbstractAction
{

    private iCommandeService $commandeService;

    public function __construct(ContainerInterface $container, iCommandeService $s)
    {
        parent::__construct($container);
        $this->commandeService = $s;
    }

    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $data = self::accederCommandeToJSON($args['id_commande'], $this->commandeService, $this->container);
            $status = 200;

        } catch (Exception $e){
            $data = $this->exception($e);
            $status = $e->getCode();
        }

        $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $data = str_replace('\/', '/', $data);
        $response->getBody()->write($data);

        return $response->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus($status);
    }

    public static function accederCommandeToJSON(string $uuid_commande, iCommandeService $service, ContainerInterface $container): array
    {
        $commande = $service->accederCommande($uuid_commande);
        $array_item = [];
        foreach ($commande->getItemsCommande() as $item) {
            $array_item[] = [
                'numero' => $item->getNumeroProduit(),
                'taille' => $item->getTailleItems(),
                'quantite' => $item->getQuantiteItems(),
                'libelle' => $item->getLibelleItems(),
                'libelle_taille' => $item->getLibelleTaille(),
                'tarif' => $item->getTarifItems()
            ];
        }
        $data = [
            'id' => $commande->getIdCommande(),
            'délai' => $commande->getDelaiCommande(),
            'date' => $commande->getDateCommande(),
            'type livraison' => $commande->getTypeLivraison(),
            'état' => $commande->getEtatCommande(),
            'montant' => $commande->getMontantCommande(),
            'mail client' => $commande->getMailClient(),
            'items' => $array_item
        ];
        //ajouter du json dans $data
        $data += [
            "links" => [
                "self" => [
                    "href" => $container->get("link")."/commandes/".$commande->getIdCommande()
                ],
                "valider" => [
                    "href" => "http://localhost:8000/commandes/".$commande->getIdCommande()
                ]
            ]
        ];
        return $data;
    }
}
