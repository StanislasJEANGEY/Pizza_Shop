class ListerCommandes {
    constructor(serviceCommande) {
        this.serviceCommande = serviceCommande;
    }

    async executer(req, res) {
        try {
            const commandes = await this.serviceCommande.listerCommandes();
            res.json(commandes);
        } catch (erreur) {
            res.status(500).json({ erreur: 'Une erreur est survenue lors de la récupération des commandes' });
        }
    }
}

export default ListerCommandes;