import app from "./app.js";
import CommandesService from "./services/CommandesServices.js";
import MessageConsumerService from "./services/MessageConsumerService.js";
app.listen(process.env.PORT, () => {
  console.log(`🚀 Server ready at http://localhost:${process.env.PORT}`);
  new MessageConsumerService(new CommandesService()).consumeMessages()
});
