import express from "express";
import getCommandesAction from "../actions/getCommandesAction.js";
import getCommandeByIdAction from "../actions/getCommandeByIdAction.js";
import patchTaskAction from "../actions/patchCommandeAction.js";

const router = express.Router();

router
  .route("/")
  .get(getCommandesAction)
  .all((req, res, next) => next(405)); //method not allowed

router
  .route("/:id")
  .get(getCommandeByIdAction)
  .patch(patchTaskAction)
  .all((req, res, next) => next(405)); //method not allowed

export default router;
