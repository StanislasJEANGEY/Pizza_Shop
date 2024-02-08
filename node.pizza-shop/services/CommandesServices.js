import knex from "knex";
import config from "../knexfile.js";

class CommandesService {
  constructor() {
    this.db = knex(config[process.env.NODE_ENV]);
  }

  async readAll() {
    try {
      const commandes = await this.db("commande");
      for (let commande of commandes) {
        commande.items = await this.db("item").where("commande_id", commande.id);
      }
      return commandes;
    } catch (error) {
      console.error(error);
      throw new Error("Can't read commandes");
    }
  }

  async readOne(id) {
    try {
      if (!id) {
        throw new Error("Invalid param");
      } else {
        const commande = await this.db("commande").where({ id: id }).first();
        commande.items = await this.db("item").where("commande_id", commande.id);
        return commande;
      }
    } catch (error) {
      console.error(error);
      //throw new Error(`Can't read commandes ${id}`);
    }
  }

  async updateOne(id, status) {
    try {
      if (!id || !status) {
        throw new Error("Invalid params");
      } else {
        const now = new Date();

        await this.db("commande")
            .update({ etape: status })
            .where({ id: id });

        return await this.readOne(id);
      }
    } catch (error) {
      console.error(error);
      //throw new Error(`Can't update commandes ${id}`);
    }
  }

  async createOne(commande) {
    try {
      // Begin transaction
      await this.db.transaction(async trx => {
        // Insert new commande into the 'commande' table and return the inserted id
        await trx('commande').insert({
          id: commande.id,
          delai: commande.delai,
          date_commande: commande.date,
          type_livraison: commande['type livraison'],
          etape: 1, // RECUE
          montant_total: commande.montant,
          mail_client: commande['mail client']
        });

        // Insert each item into the 'item' table
        for (let item of commande.items) {
          await trx('item').insert({
            commande_id: commande.id,
            numero: item.numero,
            taille: item.taille,
            quantite: item.quantite,
            libelle: item.libelle,
            libelle_taille: item.libelle_taille,
            tarif: item.tarif
          });
        }
      });

      console.log(`Commande ${commande.id} has been created`);
    } catch (error) {
      console.error(error);
      throw new Error(`Can't create commande ${commande.id}`);
    }
  }

}

export default CommandesService;