import CommandesService from "../services/CommandesServices.js";

export default async (req, res, next) => {
  try {
    const id = req.params.id

    if (!id) {
      next(400);
    } else {
      const commande = await new CommandesService().readOne(id);

      if (!commande) {
        next(404);
      } else {
        res.json(commande);
      }
    }
  } catch (error) {
    console.error(error);
    next(500);
  }
};
