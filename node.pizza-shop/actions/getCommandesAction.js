import CommandesService  from "../services/CommandesServices.js";

export default async (req, res, next) => {
  try {
    const commandes = await new CommandesService().readAll();

    if (!commandes) {
      next(500);
    } else {
      res.json(commandes);
    }
  } catch (error) {
    console.error(error);
    next(500);
  }
};
