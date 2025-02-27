// const express = require("express");
// const http = require("http");
// const { Server } = require("socket.io");

// const app = express();
// const server = http.createServer(app);
// const io = new Server(server, {
//   cors: {
//     origin: "*", // Cho phép tất cả các origin kết nối
//     methods: ["GET", "POST"]
//   }
// });

// // Lắng nghe sự kiện khi có client kết nối
// io.on("connection", (socket) => {
//   console.log(`New client connected: ${socket.id}`);

//   // Lắng nghe sự kiện khi client ngắt kết nối
//   socket.on("disconnect", () => {
//     console.log(`Client disconnected: ${socket.id}`);
//   });
// });

// // Lắng nghe server trên port 5200
// server.listen(5200, () => {
//     console.log(io);
//   console.log("Server is running on port 5200");
// });


require('dotenv').config();
const SOCKET_IO_PORT = process.env.REACT_APP_SOCKET_IO_PORT;
const CORS = process.env.REACT_APP_CLIENT;

console.log(SOCKET_IO_PORT, CORS);
let io = null;
if (process.env.SSL) {
    var express = require('express');
    var https = require('https');
    var fs = require('fs');
    const cors = require('cors');
    var app = express();
    app.use(cors({ origin: CORS.split(',') }));
    var server = https.createServer({
        // key: fs.readFileSync('./cert/key.pem'),
        // cert: fs.readFileSync('./cert/cert.pem')
    }, app);
    server.listen(SOCKET_IO_PORT, () => {
        console.log('listening on *:4040');
    });
    io = require('socket.io')(server);
} else {
    io = require('socket.io')(SOCKET_IO_PORT, {
        cors: {
            origin: CORS.split(','),
        },
        transports: ['websocket']
    });
}

let users = [];

const addUser = (userId, socketId) => {
    !users.some((user) => user.userId === userId) &&
        users.push({ userId, socketId });
};

const removeUser = (socketId) => {
    users = users.filter((user) => user.socketId !== socketId);
};

const getUser = (userId) => {
    return users.find((user) => user.userId === userId);
};

console.log(process.env.SSL);

io.sockets.on('connection', (socket) => {
    //when connect
    console.log('a user connected.');

    //take userId and socketId from user
    socket.on('addUser', (userId) => {
        addUser(userId, socket.id);
        io.emit('getUsers', users);
    });

    //send and get comment
    socket.on('sendComment', ({ comment, createdBy, issueKey }) => {
        io.emit('getComment', {
            comment,
            createdBy: {
                firstname: createdBy.firstname,
                lastname: createdBy.lastname,
                picture: createdBy.picture,
                _id: createdBy._id
            },
            issueKey
        });
    });

    //send and get notification
    socket.on('sendNotification', ({ markAll, receiverId }) => {
        const user = getUser(receiverId);
        if (user) {
            io.to(user.socketId).emit('getNotification', {
                receiverId,
                markAll
            });
        }
    });

    //when disconnect
    socket.on('disconnect', () => {
        console.log('a user disconnected!');
        removeUser(socket.id);
        io.emit('getUsers', users);
    });
});