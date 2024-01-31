FROM node:20.11.0-alpine

WORKDIR /var/www/html

RUN npm install -g vite

COPY package*.json ./

RUN npm install

COPY . .

EXPOSE 5173
CMD [ "npm", "run", "dev"]