# Pizza_Shop

Développement Web Serveur Avancé

## Membres du groupe

-   Jules BRESSON
-   Stanislas JEANGEY
-   Damien MELCHIOR

## URl API

**Gateway :** [http://localhost:180](http://localhost:180)  
**Commande :** [http://localhost:181](http://localhost:181)  
**Catalogue :** [http://localhost:181](http://localhost:181)  
**Utilisateur :** [http://localhost:182](http://localhost:182)  
**API Node :**[http://localhost:3333](http://localhost:3333)  
**Web Socket**[http://localhost:3080](http://localhost:3080)


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

## Base de données : Node
**Nom :** `pizza_shop`  
**Nom du conteneur :** `node.pizza-shop.db`  
**Login :** `pizza_shop` **Password :** `pizza_shop`  
**Lien :** [http://localhost:190](http://localhost:190)  
**Adminer :** [http://localhost:189](http://localhost:189)


## Pour lancer le projet 

1. Exécuter les commandes suivantes dans le dossier `Pizza_Shop\pizza.shop.components`
    ```bash
    docker compose up -d
    docker compose exec api.pizza-shop composer install
    docker compose exec api.pizza-auth composer install
    docker compose exec api.gateway composer install
    ```

2. Se rendre sur l'url : [http://localhost:183](http://localhost:183)

3. Se connecter avec les identifiants suivants :  
   **Username** : pizza_shop  
   **Password** : pizza_shop

4. Créer l'**EXCHANGE** : `pizzashop` de **TYPE** `DIRECT`

5. Créer une **QUEUE** : `nouvelles_commandes` de **TYPE** : `classic` et avec la **PROPRIETE** : `durable`

6. Créer un binding entre l'**EXCHANGE** `pizzashop` et la **QUEUE** `nouvelles_commandes` avec la **ROUTING_KEY** : `nouvelle`.

7. Créer une **QUEUE** : `suivi_commandes` de **TYPE** : `classic` et avec la **PROPRIETE** : `durable`

8. Créer un binding entre l'**EXCHANGE** `pizzashop` et la **QUEUE** `suivi_commandes` avec la **ROUTING_KEY** : `suivi`.
