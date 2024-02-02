class ServiceCommande {
    constructor(knex) {
        this.knex = knex;
    }

    async listerCommandes() {
        try {
            const commandes = await this.knex.select('*').from('commandes');
            return commandes;
        } catch (erreur) {
            throw erreur;
        }
    }
}

export default ServiceCommande;