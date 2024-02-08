import amqplib from "amqplib";

class MessageConsumerService {
    constructor(commandeService) {
        this.commandeService = commandeService;
        this.amqp_url = process.env.AMQP_URL
        this.queue = process.env.QUEUE_1
        this.durable = true
    }

    async consumeMessages() {
        try {
            console.log("Starting to consume messages...");

            const connection = await amqplib.connect(this.amqp_url, "heartbeat=60");
            console.log("Connected to AMQP server");

            const channel = await connection.createChannel();
            console.log("Channel created");

            await channel.assertQueue(this.queue, { durable: this.durable });
            console.log(`Queue ${this.queue} asserted`);

            await channel.consume(this.queue, async (msg) => {
                if (msg !== null) {
                    console.log("Message received, processing...");

                    const commande = JSON.parse(msg.content.toString());
                    await this.commandeService.createOne(commande);
                    console.log("Commande created");

                    channel.ack(msg);
                    console.log("Message acknowledged");
                }
            },{
                    noAck: false,
                    consumerTag: "api node"
                }
            );
        } catch (error) {
            console.error("Error consuming messages: ", error);
        }
    }
}

export default MessageConsumerService;