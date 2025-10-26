// dbConfig.js
const mariadb = require('mariadb');

export const pool = mariadb.createPool({
    host: 'localhost',
    user: 'root',         // Remplacez par votre utilisateur MariaDB
    password: '', // Remplacez par votre mot de passe MariaDB
    database: 'garage_parrot', // Remplacez par le nom de votre base de données
    port: 3307,
    connectionLimit: 5
});

module.exports = pool;