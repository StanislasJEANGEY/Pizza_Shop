# Pizza_Shop

Développement Web

## Membres du groupe

-   Jules BRESSON
-   Antonin DEPOILLY
-   Stanislas JEANGEY
-   Damien MELCHIOR

## URl API

**Gateway :** [http://localhost:180](http://localhost:180)  
**Commande :** [http://localhost:181](http://localhost:181)  
**Catalogue :** [http://localhost:181](http://localhost:181)  
**Utilisateur :** [http://localhost:182](http://localhost:182)  


## Bases de données : Commande

**Nom :** `pizza_shop`  
**Nom du conteneur :** `pizza-shop.commande.db`  
**Login :** `pizza_shop` **Password :** `pizza_shop`  
**Lien :** [http://localhost:186](http://localhost:186)  
**Adminer :** [http://localhost:189](http://localhost:189)  

## Bases de données : Catalogue

**Nom :** `pizza_catalog`  
**Nom du conteneur :** `pizza-shop.catalogue.db`  
**Login :** `pizza_cat` **Password :** `pizza_cat`  
**Lien :** [http://localhost:185](http://localhost:185)  
**Adminer :** [http://localhost:189](http://localhost:189)

## Bases de données : Utilisateur

**Nom :** `pizza_shop`  
**Nom du conteneur :** `pizza-shop.auth.db`  
**Login :** `pizza_shop` **Password :** `pizza_shop`  
**Lien :** [http://localhost:187](http://localhost:187)  
**Adminer :** [http://localhost:189](http://localhost:189) 

## RabbitMQ
**Login :**`pizza_shop` **Password :** `pizza_shop`  
**URL :** [http://localhost:183](http://localhost:183) [http://localhost:184](http://localhost:184)


## Constante du projet

    const ETAT_CREE = 1;
    const ETAT_VALIDE = 2;
    const ETAT_PAYE = 3;
    const ETAT_LIVRE = 4;
    
    const LIVRAISON_SUR_PLACE = 1;
    const LIVRAISON_A_EMPORTER = 2;
    const LIVRAISON_A_DOMICILE = 3;