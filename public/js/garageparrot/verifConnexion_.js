const pool = require('./dbConfig');

async function testConnection() {
    let conn;
    try {
        console.log('Attempting to connect to the database...');
        conn = await pool.getConnection();
        console.log('Connected to the database successfully');

        // Test a simple query to ensure the connection works
        //const result = await conn.query('SELECT 1 as val');
        //console.log('Query result:', result);

        // Test a query on the 'car' table
        const carResult = await conn.query('SELECT * FROM car');
        console.log('Car table query result:', carResult);

        return true;
    } catch (error) {
        console.error('Error connecting to the database:', error);
        return false;
    } finally {
        if (conn) {
            conn.release();
            console.log('Connection released');
        }
    }
}

// Exemple d'utilisation
(async () => {
    const connectionSuccessful = await testConnection();
    if (connectionSuccessful) {
        console.log('Connection test successful. Proceeding with further operations.');
        // You can add further operations here, e.g., fetching cars
    } else {
        console.log('Connection test failed. Please check your database configuration.');
    }
})();
