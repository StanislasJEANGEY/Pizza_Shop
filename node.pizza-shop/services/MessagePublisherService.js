import amqplib from "amqplib";

class MessagePublisherService {
    constructor() {
        this.amqpURL = process.env.AMQP_URL;
        this.exchange = process.env.EXCHANGE;
        this.binding = 'direct';
        this.queue = process.env.QUEUE_2;
        this.routingKey = process.env.ROUTING_KEY_2;
    }

    async publishToSuiviQueue(message) {
        try {
            const connection = await amqplib.connect(this.amqpURL, "heartbeat=60");
            const channel = await connection.createChannel();

            await channel.assertExchange(this.exchange, this.binding, { durable: true });
            await channel.assertQueue(this.queue, { durable: true });
            await channel.bindQueue(this.queue, this.exchange, this.routingKey);

            channel.publish(this.exchange, this.routingKey, message);
            console.log(message)
            console.log(`Message published to "${this.queue}" queue with routing key "${this.routingKey}"`);
        } catch (error) {
            console.error(error);
            throw new Error("Can't publish message to RabbitMQ");
        }
    }
}

export default MessagePublisherService;