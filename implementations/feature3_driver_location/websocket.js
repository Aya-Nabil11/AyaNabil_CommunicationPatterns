const { Server } = require("socket.io");

const io = new Server(3000, {
  cors: { origin: "*" }
});

// Driver joins their delivery room
io.on("connection", (socket) => {
  console.log("Client connected:", socket.id);

  socket.on("joinOrder", (orderId) => {
    socket.join(`order_${orderId}`);
    console.log(`Client joined room order_${orderId}`);
  });

  // Driver sends location
  socket.on("driverLocation", ({ orderId, latitude, longitude }) => {
    io.to(`order_${orderId}`).emit("locationUpdate", { latitude, longitude });
  });

  socket.on("disconnect", () => {
    console.log("Client disconnected:", socket.id);
  });
});