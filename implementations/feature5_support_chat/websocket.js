const { Server } = require("socket.io");

const io = new Server(5000, { cors: { origin: "*" } });

io.on("connection", (socket) => {
  console.log("Client connected:", socket.id);

  // Join private chat room (customer-agent pair)
  socket.on("joinChat", ({ customerId, agentId }) => {
    const room = `chat_${customerId}_${agentId}`;
    socket.join(room);
    console.log(`${socket.id} joined ${room}`);
  });

  // Send chat message
  socket.on("sendMessage", ({ customerId, agentId, message }) => {
    const room = `chat_${customerId}_${agentId}`;
    const payload = {
      sender: customerId,
      receiver: agentId,
      message,
      timestamp: new Date(),
    };

    io.to(room).emit("newMessage", payload);
  });

  // Typing indicator
  socket.on("typing", ({ customerId, agentId }) => {
    const room = `chat_${customerId}_${agentId}`;
    io.to(room).emit("typing", { user: customerId });
  });

  socket.on("disconnect", () => {
    console.log("Client disconnected:", socket.id);
  });
});

console.log("Chat WebSocket running on ws://localhost:5000");