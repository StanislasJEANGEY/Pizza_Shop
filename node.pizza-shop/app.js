import express from "express";
import tasksRouter from "./routes/CommandesRouter.js";
import cors from "cors";
import helmet from "helmet";

import catch404Errors from "./middlewares/catch404errors.js";
import catchAllErrors from "./middlewares/catchAllErrors.js";


const app = express();

app.use(helmet()); //sécurité
app.use(cors()); //sécurité liée aux clients web
app.use(express.json()); //parsing des données du body au format JSON
app.use(express.urlencoded({ extended: false })); //parsing des données du body au format URL Encode

app.use("/commandes", tasksRouter);
app.use("/", (req, res, next) =>
  res.json({ message: "Welcome to PizzaShop API" })
);

//génère une erreur 404 si aucune route n'a pas intercepté la requête HTTP
app.use(catch404Errors);

//gère toutes les erreurs
app.use(catchAllErrors);

export default app;
