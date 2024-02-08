<?php

namespace pizzashop\shop\app\actions\get;

use Exception;
use GuzzleHttp\Exception\ClientException;
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
            $res = $this->requeteGuzzle('GET', $this->container->get('link_auth') . '/validate', $request);
            if ($res->getStatusCode() == 200) {
                $data = self::accederCommandeToJSON($args['id_commande'], $this->commandeService, $this->container);
                $data = $this->formatJSON($data);
                $status = 200;
            }
        } catch (ClientException $e){
            $data = $e->getResponse()->getBody()->getContents();
            $status = $e->getResponse()->getStatusCode();

        }catch (Exception $e){
            $data = $this->exception($e);
            $data = $this->formatJSON($data);
            $status = $e->getCode();
        }
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json')
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
            'delai' => $commande->getDelaiCommande(),
            'date' => $commande->getDateCommande(),
            'type livraison' => $commande->getTypeLivraison(),
            'etat' => $commande->getEtatCommande(),
            'montant' => $commande->getMontantCommande(),
            'mail client' => $commande->getMailClient(),
            'items' => $array_item
        ];
        //ajouter du json dans $data
        $data += [
            "links" => [
                "self" => [
                    "href" => $container->get("link")."commandes/".$commande->getIdCommande()
                ],
                "valider" => [
                    "href" => $container->get("link")."commandes/".$commande->getIdCommande()
                ]
            ]
        ];
        return $data;
    }
}
