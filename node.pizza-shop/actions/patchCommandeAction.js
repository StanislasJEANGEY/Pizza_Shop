import CommandesService from "../services/CommandesServices.js";
import MessagePublisherService from "../services/MessagePublisherService.js";

export default async (req, res, next) => {
  try {
    const id = req.params.id;
    const status = parseInt(req.body.status);

    if (!id || !status) {
      next(400);
    } else {
      await new CommandesService().updateOne(id, status);

      // Create a new instance of MessagePublisherService
      const messagePublisherService = new MessagePublisherService();

      // Format the message as a JSON object
      const message = Buffer.from(JSON.stringify({
        id: id,
        status: status
      }));

      // Publish the message
      await messagePublisherService.publishToSuiviQueue(message);

      res.sendStatus(200);
    }
  } catch (error) {
    console.error(error);
    next(500);
  }
};