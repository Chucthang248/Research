FROM node:latest

# Create app directory
WORKDIR /usr/src/app

# Install app dependencies
COPY package*.json ./

RUN npm install

RUN npm install knex -g

# Bundle app source
COPY . .

EXPOSE 3000
CMD ["node", "app.js"]
