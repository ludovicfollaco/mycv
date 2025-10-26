<?php
	//dbConnect.class.php
	//author : Ludovic FOLLACO
	//checked to 2024-10-04_15:25
	namespace Model\DbConnect;

	use \PDO;
	use \PDOException;
	use Model\Utilities\Utilities;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class DbConnect
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		//-----------------------------------------------------------------------

		private static $bdd = null;
		public static function connectDb(array $dbConfig):PDO{
			
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerDbConnect();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'connectDb()',
					'$dbConfig' => $dbConfig,
					'$bdd' => self::$bdd
				];
			}

			$DB_HOST = $dbConfig['DB_HOST'];
			$DB_NAME = $dbConfig['DB_NAME'];
			$DB_USER = $dbConfig['DB_USER'];
			$DB_PASS = $dbConfig['DB_PASS'];
			$BD_PORT = $dbConfig['DB_PORT'];

			try{
				self::$bdd = new PDO("mysql:host=$DB_HOST; dbname=$DB_NAME;charset=utf8mb4;port=$BD_PORT", $DB_USER, $DB_PASS);
				
				self::$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				self::$bdd->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$bdd'] = self::$bdd;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}
				
				return self::$bdd;

			}catch (PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}
				
				return self::$bdd;
			}
		}

		//-----------------------------------------------------------------------
		
		private static $dbConfigMyCv = [];
		public static function dbConfigMyCv():array{

			if(Utilities::checkIfLocal()){
				self::$dbConfigMyCv = [
					'DB_HOST' => 'localhost',
					'DB_NAME' => 'mycv',
					'DB_USER' => 'root',
					'DB_PASS' => '',
					'DB_PORT' => '3307'
				];
			}else{
				self::$dbConfigMyCv = [
					'DB_HOST' => 'db5016299008.hosting-data.io',
					'DB_NAME' => 'dbs13260004',
					'DB_USER' => 'dbu510923',
					'DB_PASS' => 'MarLud7772!',
					'DB_PORT' => '3306'
				];
			}

			return self::$dbConfigMyCv;
		}

		//-----------------------------------------------------------------------
		
		private static $dbConfigGP = [];
		public static function dbConfigGP():array{

			if(Utilities::checkIfLocal()){
				self::$dbConfigGP = [
					'DB_HOST' => 'localhost',
					'DB_NAME' => 'garage_parrot',
					'DB_USER' => 'root',
					'DB_PASS' => '',
					'DB_PORT' => '3307'
				];
			}else{
				self::$dbConfigGP = [
					'DB_HOST' => 'db5015199153.hosting-data.io',
					'DB_NAME' => 'dbs12564096',
					'DB_USER' => 'dbu1146568',
					'DB_PASS' => 'MarLud7772!',
					'DB_PORT' => '3306'
				];
			}

			return self::$dbConfigGP;
		}

		//-----------------------------------------------------------------------
		
		private static $dbConfigGoldorak = [];
		public static function dbConfigGoldorak():array{

			if(Utilities::checkIfLocal()){
				self::$dbConfigGoldorak =  [
					'DB_HOST' => 'localhost',
					'DB_NAME' => 'goldorak',
					'DB_USER' => 'root',
					'DB_PASS' => '',
					'DB_PORT' => '3307'
				];
			}else{
				self::$dbConfigGoldorak =  [
					'DB_HOST' => 'db5015520267.hosting-data.io',
					'DB_NAME' => 'dbs12677679',
					'DB_USER' => 'dbu4075604',
					'DB_PASS' => 'MarLud7772!',
					'DB_PORT' => '3306'
				];
			}

			return self::$dbConfigGoldorak;
		}
		
		//-----------------------------------------------------------------------

		private static $configDbConnect = [];
		public static function configDbConnect():array{
			
			self::$configDbConnect = [
				'goldorak' => DbConnect::dbConfigGoldorak(),
				'garageparrot' => DbConnect::dbConfigGP(),
				'mycv' => DbConnect::dbConfigMyCv()
			];

			return self::$configDbConnect;
		}

		//-----------------------------------------------------------------------

		private static $dbName = 'mycv';
		public static function connectionDb(array $configDbConnect):PDO{

			self::$dbName = self::checkAndReturnValueInUrl();

			$bdd = DbConnect::connectDb($configDbConnect[self::$dbName]);

			return $bdd;
		}

		//-----------------------------------------------------------------------

        public static function checkAndReturnValueInUrl():string{

            if(self::checkValueInUrl('goldorak')){
                return "goldorak";

            }elseif(self::checkValueInUrl('garageparrot')){
                return "garageparrot";
            }
            return "mycv";
        }

		//-----------------------------------------------------------------------

        public static function checkValueInUrl(string $value):bool{
            $current_url = $_SERVER['REQUEST_URI'];
            return strpos($current_url, $value) !== false;
        }

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerDbConnect()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.DbConnect');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/DbConnect.log', Logger::DEBUG));
			}
		}
	}
?>