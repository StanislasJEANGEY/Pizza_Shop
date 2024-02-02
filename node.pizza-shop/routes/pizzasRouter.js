import express from "express";
import Knex from "knex";
import ServiceCommande from "../services/ServiceCommande.js";
import ListerCommandes from "../actions/ListerCommandes.js";

const knex = Knex({
    client: 'mysql',
    connection: {
        host: 'node.pizza-shop.db',
        user: 'pizza_shop',
        password: 'pizza_shop',
        database: 'pizza_shop'
    }
});

const serviceCommande = new ServiceCommande(knex);
const listerCommandes = new ListerCommandes(serviceCommande);

const router = express.Router();

router
  .route("/")
  .get((req, res, next) => {
    res.json([]);
  }) //call getPizzasAction method and transmit req, res, next argument
  .all((req, res, next) => next(405)); //method not allowed

router.get('/commandes', (req, res) => listerCommandes.executer(req, res));

export default router;
