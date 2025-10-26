<?php
	//CarEngine.php
	//Author: Ludovic FOLLACO
	//checked to 2024-10-08_16:04
	namespace Model\CarEngine;

	use \PDO;
	use \PDOException;
    use Model\DbConnect\DbConnect;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class CarEngine
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct(){
			if($_SESSION['debug']['monolog']){
				$this->initLoggerEngine();
			}
		}

		private $id_engine;
		public function getId():int{
			return $this->id_engine;
		}
		public function setId(int $new):void{
			$this->id_engine = $new;
		}

		//-----------------------------------------------------------------------

		private $name;
		public function getName():string{
			return $this->name;
		}
		public function setName(string $new):void{
			$this->name = $new;
		}

		//-----------------------------------------------------------------------
        private $addEngine = false;
        public function getAddEngine():bool{
            return $this->addEngine;
        }
        public function setAddEngine(bool $new):void{
            $this->addEngine = $new;
        }

		//-----------------------------------------------------------------------

		private $currentEngine = [];
		public function getCurrentEngine(int $idEngine):array{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerEngine();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCurrentEngine()',
					'$idEngine' => $idEngine,
					'$currentEngine' => $this->currentEngine
				];
			}
	
			if(self::checkIdEngine($idEngine)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
				try{
					$stmt = $bdd->prepare("SELECT `engine`.`id_engine`, `engine`.`name`
											FROM  `engine`
											WHERE `engine`.`id_engine`=:id_engine");

					$stmt->bindParam(':id_engine', $id_engine, PDO::PARAM_INT);

					$stmt->execute();

					$this->currentEngine = $stmt->fetch(PDO::FETCH_ASSOC);
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$currentEngine'] = $this->currentEngine;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

					return $this->currentEngine;

				}catch(PDOException $e){
					
					if($_SESSION['debug']['monolog']){
						$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
					}
					return [];

				}finally{
					$bdd=null;
				}
			}
		}

		//-----------------------------------------------------------------------

		private $engineList = [];
		public function getEngineList(string $whereClause, string $orderBy = 'name', string $ascOrDesc = 'ASC', int $firstLine = 0, int $linePerPage = 13):array{
			
			if($_SESSION['debug']['monolog']){
				$this->initLoggerEngine();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getEngineList()',
					'$whereClause' => $whereClause,
					'$orderBy' => $orderBy,
					'$ascOrDesc' => $ascOrDesc,
					'$firstLine' => $firstLine,
					'$linePerPage' => $linePerPage,
					'$engineList' => $this->engineList
				];
			}
			
			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
			    $stmt = $bdd->prepare("SELECT `engine`.`id_engine`,
											  `engine`.`name`,
											  `engine`.`id_energy`
										 FROM `engine`
										WHERE $whereClause
									 ORDER BY :orderBy :ascOrDesc
										LIMIT :firstLine, :linePerPage");

				$stmt->bindParam(':orderBy', $orderBy, PDO::PARAM_STR);
				$stmt->bindParam(':ascOrDesc', $ascOrDesc, PDO::PARAM_STR);
				$stmt->bindParam(':firstLine', $firstLine, PDO::PARAM_INT);
				$stmt->bindParam(':linePerPage', $linePerPage, PDO::PARAM_INT);

				$stmt->execute();
				
				$this->engineList = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$engineList'] = true; //$this->engineList; replace true; by $this->engineList; to see the list of brand
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

				return $this->engineList;

			}catch(PDOException $e){
					
				if($_SESSION['debug']['monolog']){
					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}
				return [];
				
			}finally{
				$bdd=null;
			}
		}

		//-----------------------------------------------------------------------

		private $insertEngine = 0;
		public function insertEngine():int{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerEngine();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'insertEngine()',
					'$insertEngine' => $this->insertEngine
				];
			}
	
			if(!self::checkNameEngine($this->name)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare('INSERT INTO `engine`(`name`) VALUES (:name)');
					$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
					$stmt->execute();

					$stmt = $bdd->prepare("SELECT MAX(`id_engine`) FROM `engine`");
					$stmt->execute();

					$this->insertEngine = intval($stmt->fetchColumn());
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$insertEngine'] = $this->insertEngine;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

				}catch (PDOException $e){
					
					if($_SESSION['debug']['monolog']){
						$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
					}

				}finally{
					$bdd=null;
				}

				return $this->insertEngine;
			}
		}

		//-----------------------------------------------------------------------

		private $updateEngine = false;
		public function updateEngine(int $id_engine):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerEngine();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'updateEngine()',
					'$id_engine' => $id_engine,
					'$updateEngine' => $this->updateEngine
				];
			}
	
			if(self::checkIdEngine($id_engine)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare('UPDATE `engine` SET `name` = :name WHERE `id_engine` = :id_engine');

					$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
					$stmt->bindParam(':id_engine', $id_engine, PDO::PARAM_INT);

					$stmt->execute();

					$this->updateEngine = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$updateEngine'] = $this->updateEngine;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

				}catch (PDOException $e){
					
					if($_SESSION['debug']['monolog']){
						$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
					}

				}finally{
					$bdd=null;
				}

			}

			return $this->updateEngine;
		}

		//-----------------------------------------------------------------------

		private $deleteEngine = false;
		public function deleteEngine(int $id_engine):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerEngine();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deleteEngine()',
					'$id_engine' => $id_engine,
					'$deleteEngine' => $this->deleteEngine
				];
			}
	
			if(self::checkIdEngine($id_engine)){

				if(!self::checkEngineOnCar($id_engine)){

					$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

					try{
						$stmt = $bdd->prepare('DELETE FROM engine WHERE id_engine = :id_engine');
						$stmt->bindParam(':id_engine', $id_engine, PDO::PARAM_INT);
						$stmt->execute();

						$this->deleteEngine = true;

						if($_SESSION['debug']['monolog']){
							$arrayLogger['$deleteEngine'] = self::$deleteEngine;
							self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
						}

					}catch(PDOException $e){

						if($_SESSION['debug']['monolog']){
							$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
						}
	
					}finally{
						$bdd=null;
					}
				}
			}

			return $this->deleteEngine;
		}

		//-----------------------------------------------------------------------

		private static $checkIdEngine = false;
		public static function checkIdEngine(int $id_Engine):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerEngine();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdEngine()',
					'$id_Engine' => $id_Engine,
					'$checkIdEngine' => self::$checkIdEngine
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `brand` WHERE `id_Engine` = :id_Engine");
				$stmt->bindParam(':id_Engine', $id_Engine, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdEngine = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdEngine'] = self::$checkIdEngine;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkIdEngine;
		}

		//-----------------------------------------------------------------------

		private static $checkNameEngine = false;
		public static function checkNameEngine(string $name):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerEngine();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkNameEngine()',
					'$name' => $name,
					'$checkNameEngine' => self::$checkNameEngine
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `engine` WHERE `name` = :name");
				$stmt->bindParam(':name', $name, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkNameEngine = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkNameEngine'] = self::$checkNameEngine;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkNameEngine;
		}

		//-----------------------------------------------------------------------

		private static $checkEngineOnCar = false;
		public static function checkEngineOnCar(int $id_engine):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerEngine();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkEngineOnCar()',
					'$id_engine' => $id_engine,
					'$checkEngineOnCar' => self::$checkEngineOnCar
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare('SELECT COUNT(*) FROM car WHERE id_engine = :id_engine');
				$stmt->bindParam(':id_engine', $id_engine, PDO::PARAM_INT);
				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkEngineOnCar = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkBrandOnCar'] = self::$checkEngineOnCar;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkEngineOnCar;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerEngine()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Engine');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/GarageParrot.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerEngine()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Engine');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/GarageParrot.log', Logger::DEBUG));
			}
		}

	}
	
?>