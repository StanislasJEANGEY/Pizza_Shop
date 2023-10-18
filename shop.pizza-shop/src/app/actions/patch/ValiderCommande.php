<?php

namespace pizzashop\shop\app\actions\patch;

use Exception;
use pizzashop\shop\app\actions\AbstractAction;
use pizzashop\shop\domain\service\CommandeService;
use pizzashop\shop\domain\service\iCatalogueService;
use pizzashop\shop\domain\service\iCommandeService;
use pizzashop\shop\Exception\ServiceCommandeInvalideException;
use pizzashop\shop\Exception\ServiceCommandeNotFoundException;
use pizzashop\shop\Exception\ServiceValidatorException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Respect\Validation\Exceptions\ValidationException;

class ValiderCommande extends AbstractAction
{
    private iCommandeService $commandeService;
    private iCatalogueService $catalogueService;

    public function __construct(ContainerInterface $container, iCommandeService $s, iCatalogueService $c)
    {
        parent::__construct($container);
        $this->commandeService = $s;
        $this->catalogueService = $c;
    }
    public function __invoke(Request $request, Response $response, array $args): Response
    {
        try {
            $message = "";
            //Récupérer le contenu du body de la requête
            $body = $request->getBody();
            if (empty($body)) {
                throw new ServiceValidatorException("Le body de la requête est vide", 400);
            } else {
                $body = json_decode($body, true);
                if (!array_key_exists('etat', $body)) {
                    throw new ServiceValidatorException("La clé 'etat' n'existe pas dans le body de la requête", 400);
                } else {
                    if ($body['etat'] != 'validée') {
                        throw new ServiceValidatorException("La valeur de la clé 'etat' dans le body de la requête doit être 'validée' pour valider une commande\"", 400);
                    } else {
                        $this->commandeService->validerCommande($args['id_commande']);
                    }
                }
            }
            $commande = $this->commandeService->accederCommande($args['id_commande'], $this->catalogueService);
            $data = [
                'id' => $commande->getIdCommande(),
                'délai' => $commande->getDelaiCommande(),
                'date' => $commande->getDateCommande(),
                'type livraison' => $commande->getTypeLivraison(),
                'état' => $commande->getEtatCommande(),
                'montant' => $commande->getMontantCommande(),
                'mail client' => $commande->getMailClient(),
                'items' => $commande->getItemsCommande()
            ];
            $status = 200;
        } catch (ServiceCommandeNotFoundException|ServiceCommandeInvalideException $e) {
            $data = $e->getMessage();
            $status = $e->getCode();
        } catch (Exception $e) {
            $data = $e->getMessage();
            $status = 500;
        }
        $data = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        $data = str_replace('\/', '/', $data);
        $data .= $message;
        $response->getBody()->write($data);
        return $response->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus($status);
    }
}