const { Server } = require("socket.io");
const Redis = require("ioredis");

const io = new Server(4000, { cors: { origin: "*" } });
const redis = new Redis();

// Listen for new orders via Redis Pub/Sub
redis.subscribe("orders");

redis.on("message", (channel, message) => {
  const order = JSON.parse(message);
  // Notify all staff of the restaurant
  io.to(`restaurant_${order.restaurant_id}`).emit("newOrder", order);
});

io.on("connection", (socket) => {
  console.log("Restaurant staff connected:", socket.id);

  // Staff joins their restaurant room
  socket.on("joinRestaurant", (restaurantId) => {
    socket.join(`restaurant_${restaurantId}`);
    console.log(`Staff joined restaurant_${restaurantId}`);
  });

  socket.on("disconnect", () => {
    console.log("Staff disconnected:", socket.id);
  });
});

console.log("Restaurant notifications WebSocket running on ws://localhost:4000");
