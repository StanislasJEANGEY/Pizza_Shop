import { consumeFromMQ } from "./services/consumeFromMQ.js";
import { WebSocketServer } from "ws";

const amqp_url = process.env.AMQP_URL;
const queue = process.env.QUEUE;
const consumerTag = process.env.CONSUMER_TAG;
console.log("amqp_url : "+amqp_url)
console.log("queue : "+queue)
console.log("consumerTag : "+consumerTag)
const wss = new WebSocketServer({ port: 3000 });

const subscribers = new Map();
//contient une référence vers chaque Utilisateur connecté au serveur WebSocket sur la base de son numéro d'id

wss.on("connection", (socket) => {
  socket.on("error", console.error);

  //réception d'un message
  socket.on("message", (message) => {
    console.log("Subscribtion received: %s", message);

    try {
      const msg = JSON.parse(message);
      const commande_id = msg.commande_id;

      if (msg.type === "subscribe") {
        subscribers.set(commande_id, socket); //ajoute un destinataire et le référence selon son id
        const data = JSON.stringify({
          type: "subscribe",
          commande: commande_id
        });

        console.log(`Commande #${commande_id} has been registered to WS notifications`);
        socket.send(data);
      }
    } catch (error) {
      console.error(error);
      throw new Error("Can't publish websocket message");
    }
  });
});


//emet une notification à un destinataire (User) sur la base de son id
function notify(msg) {
  try {
    let message = `La commande #${msg.id} `
    switch (msg.status){
      case 1:
        message += 'est bien reçue'
        break
      case 2:
        message += 'est en cours de préparation'
        break
      case 3:
        message += 'est prête'
    }
    const data = JSON.stringify({
      type: "notification",
      commande: msg.id,
      message: message
    });

    const commande_id = msg.id;

    const client = subscribers.get(commande_id);

    if (!client) {
      console.log("Commande #%s disconnected from Websocket", msg.commande_id);
    } else {
      client.send(data);
      console.log("Notification sent to User : %s", msg.commande_id);
    }
  } catch (error) {
    console.error(error);
  }
}

await consumeFromMQ(amqp_url, queue, consumerTag, notify); //pour envoyer uniquement à l'abonnée dont l'identifiant correspond à l'auteur de la Task
//await consumeFromMQ(amqp_url, queue, consumerTag, notifyAll); //pour envoyer à tous les "abonnés" sans distinction
