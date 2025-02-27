// Lắng nghe sự kiện khi có client kết nối
io.on("connection", (socket) => {
    console.log(`New client connected: ${socket.id}`);
  
    // Lắng nghe sự kiện khi client ngắt kết nối
    socket.on("disconnect", () => {
      console.log(`Client disconnected: ${socket.id}`);
    });
  });