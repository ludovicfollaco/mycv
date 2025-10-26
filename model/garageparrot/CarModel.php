<?php
	//CarModel.php
	//Author: Ludovic FOLLACO
	//checked to 2024-10-08_16:04
	namespace Model\CarModel;

	use \PDO;
	use \PDOException;
    use Model\DbConnect\DbConnect;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class CarModel
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct(){
			if($_SESSION['debug']['monolog']){
				$this->initLoggerModel();
			}
		}

		private $id_model;
		public function getId():int{
			return $this->id_model;
		}
		public function setId(int $new):void{
			$this->id_model = $new;
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
        private $addModel = false;
        public function getAddModel():bool{
            return $this->addModel;
        }
        public function setAddModel(bool $new):void{
            $this->addModel = $new;
        }

		//-----------------------------------------------------------------------

		private $currentModel = array();
		public function getCurrentModel(int $id_model):array{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerModel();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCurrentModel()',
					'$id_model' => $id_model,
					'$currentModel' => $this->currentModel
				];
			}
	
			if(self::checkIdModel($id_model)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
				try{
					$stmt = $bdd->prepare("SELECT `model`.`id_model`,
												  `model`.`name`
											FROM  `model`
											WHERE `model`.`id_model`=:id_model");

					$stmt->bindParam(':id_model', $id_model, PDO::PARAM_INT);

					$stmt->execute();

					$this->currentModel = $stmt->fetch(PDO::FETCH_ASSOC);
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$currentModel'] = $this->currentModel;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

					return $this->currentModel;

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

		private $modelList = array();
		public function getModelList(string $whereClause, string $orderBy = 'name', string $ascOrDesc = 'ASC', int $firstLine = 0, int $linePerPage = 13):array{
			
			if($_SESSION['debug']['monolog']){
				$this->initLoggerModel();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getModelList()',
					'$whereClause' => $whereClause,
					'$orderBy' => $orderBy,
					'$ascOrDesc' => $ascOrDesc,
					'$firstLine' => $firstLine,
					'$linePerPage' => $linePerPage,
					'$modelList' => $this->modelList
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
			    $stmt = $bdd->prepare("SELECT `model`.`id_model`,
											  `model`.`name`,
											  `model`.`id_brand`
										 FROM `model`
										WHERE $whereClause
									 ORDER BY :orderBy :ascOrDesc
										LIMIT :firstLine, :linePerPage");

				$stmt->bindParam(':orderBy', $orderBy, PDO::PARAM_STR);
				$stmt->bindParam(':ascOrDesc', $ascOrDesc, PDO::PARAM_STR);
				$stmt->bindParam(':firstLine', $firstLine, PDO::PARAM_INT);
				$stmt->bindParam(':linePerPage', $linePerPage, PDO::PARAM_INT);

				$stmt->execute();
				
				$this->modelList = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$modelList'] = true; //$this->modelList; replace true; by $this->modelList; to see the list of brand
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

				return $this->modelList;

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

		private $insertModel = 0;
		public function insertModel():int{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerModel();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'insertModel()',
					'$insertModel' => $this->insertModel
				];
			}
	
			if(!self::checkNameModel($this->name)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare('INSERT INTO `model`(`name`) VALUES (:name)');
					$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
					$stmt->execute();

					$stmt = $bdd->prepare("SELECT MAX(`id_model`) FROM `model`");
					$stmt->execute();

					$this->insertModel = intval($stmt->fetchColumn());
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$insertModel'] = $this->insertModel;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

				}catch (PDOException $e){
					
					if($_SESSION['debug']['monolog']){
						$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
					}

				}finally{
					$bdd=null;
				}

				return $this->insertModel;
			}
		}

		//-----------------------------------------------------------------------

		private $updateModel = false;
		public function updatemodel(int $id_model){

			if($_SESSION['debug']['monolog']){
				$this->initLoggerModel();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'updateModel()',
					'$id_model' => $id_model,
					'$updateModel' => $this->updateModel
				];
			}
	
			if(self::checkIdModel($id_model)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare('UPDATE `model` SET `name` = :name WHERE `id_model` = :id_model');

					$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
					$stmt->bindParam(':id_model', $id_model, PDO::PARAM_INT);

					$stmt->execute();

					$this->updateModel = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$updateModel'] = $this->updateModel;
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

			return $this->updateModel;
		}

		//-----------------------------------------------------------------------

		private $deleteModel = false;
		public function deleteModel(int $id_model):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerModel();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deleteModel()',
					'$id_model' => $id_model,
					'$deleteModel' => $this->deleteModel
				];
			}
	
			if(self::checkIdModel($id_model)){

				if(!self::checkBrandOnCar($id_model)){

					$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

					try{
						$stmt = $bdd->prepare('DELETE FROM brand WHERE id_model = :id_model');
						$stmt->bindParam(':id_model', $id_model, PDO::PARAM_INT);
						$stmt->execute();

						$this->deleteModel = true;

						if($_SESSION['debug']['monolog']){
							$arrayLogger['$deleteModel'] = self::$deleteModel;
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

			return $this->deleteModel;
		}

		//-----------------------------------------------------------------------

		private static $checkIdModel = false;
		public static function checkIdModel(int $id_model):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerModel();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdModel()',
					'$id_model' => $id_model,
					'$checkIdModel' => self::$checkIdModel
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `model` WHERE `id_model` = :id_model");
				$stmt->bindParam(':id_model', $id_model, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdModel = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdModel'] = self::$checkIdModel;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkIdModel;
		}

		//-----------------------------------------------------------------------

		private static $checkNameModel = false;
		public static function checkNameModel(string $name):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerModel();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkNameModel()',
					'$name' => $name,
					'$checkNameModel' => self::$checkNameModel
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `model` WHERE `name` = :name");
				$stmt->bindParam(':name', $name, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkNameModel = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkNameModel'] = self::$checkNameModel;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkNameModel;
		}

		//-----------------------------------------------------------------------

		private static $checkModelOnCar = false;
		public static function checkBrandOnCar(int $id_model):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerModel();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkModelOnCar()',
					'$id_brand' => $id_model,
					'$checkModelOnCar' => self::$checkModelOnCar
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare('SELECT COUNT(*) FROM car WHERE id_model = :id_model');
				$stmt->bindParam(':id_model', $id_model, PDO::PARAM_INT);
				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkModelOnCar = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkModelOnCar'] = self::$checkModelOnCar;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkModelOnCar;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerModel()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Model');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/GarageParrot.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerModel()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Model');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/GarageParrot.log', Logger::DEBUG));
			}
		}
	}	
?>