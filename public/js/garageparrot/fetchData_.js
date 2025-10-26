const pool = require('./dbConfig');

async function fetchCars(page, pageSize) {

    const offset = (page - 1) * pageSize;
    const query = `SELECT * FROM car LIMIT ? OFFSET ?;`;

    let conn;
    try {

        conn = await pool.getConnection();
        console.log('Connected to the database');

        const rows = await conn.query(query, [pageSize, offset]);
        return rows;

    } catch (error) {

        console.error('Error fetching data:', error);
        throw error;

    } finally {

        if (conn) {
            conn.release();
            console.log('Connection released');
        }

    }
}

(async () => {

    const page = 1; // Remplacez par le numéro de la page souhaitée
    const pageSize = 10; // Nombre d'éléments par page

    try {
        const data = await fetchCars(page, pageSize);
        
        for (let i = 0; i < data.length; i++) {
            
            console.log(`Ligne ${i + 1}`);
            console.log(`   id_car :`, data[i].id_car);

            let conn;

            conn = await pool.getConnection();
            const brand = await conn.query(`SELECT name FROM brand WHERE id_brand = ` + data[i].id_brand + `;`);
            conn.release();
            console.log(`   brand :`, brand[0].name);
            
            conn = await pool.getConnection();
            const model = await conn.query(`SELECT name FROM model WHERE id_model = ` + data[i].id_model + `;`);
            conn.release();
            console.log(`   model :`, model[0].name);
            
            conn = await pool.getConnection();
            const engine = await conn.query(`SELECT name FROM engine WHERE id_engine = ` + data[i].id_engine + `;`);
            conn.release();
            console.log(`   engine :`, engine[0].name);

            console.log(`   year :`, data[i].year);
            console.log(`   mileage :`, data[i].mileage);
            console.log(`   price :`, data[i].price);
            console.log(`   sold :`, data[i].sold);

            console.log(`   image1 :`, data[i].image1);
            let image1 = document.getElementById('image1');
            image1.href = data[i].image1;

            console.log(`   image2 :`, data[i].image2);
            console.log(`   image3 :`, data[i].image3);
            console.log(`   image4 :`, data[i].image4);
            console.log(`   image5 :`, data[i].image5);
            
          }

    } catch (error) {

        console.error('Error:', error);

    }

})();