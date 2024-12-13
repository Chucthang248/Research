const express = require("express");
const bodyParser = require("body-parser");
const session = require("express-session");
const path = require("path");

const app = express();

// Middleware
app.use(bodyParser.urlencoded({ extended: false }));
app.use(bodyParser.json());
app.use(
  session({
    secret: "ZAJ-acBa8Uku069LY0-UffgvD61iMSR3uUvg0DNO_6L8QMejN7k98eu6NELR5dBX",
    resave: false,
    saveUninitialized: true,
  })
);

// Static files
app.use(express.static(path.join(__dirname, "public")));

// Routes
app.get("/", (req, res) => {
  res.sendFile(path.join(__dirname, "public/index.html"));
});

app.get("/callback", (req, res) => {
  res.send("Logged in! You can now access protected routes.");
});

const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Server running at http://localhost:${PORT}`);
});
