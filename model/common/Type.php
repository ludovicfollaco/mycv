<?php
	//type.class.php
	//author : Ludovic FOLLACO
	//2024-10-04_16:00
	namespace Model\Type;

	use \PDO;
	use \PDOException;
	use Model\DbConnect\DbConnect;
	use Model\Utilities\Utilities;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class Type
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct()
		{
			if($_SESSION['debug']['monolog']){
				$this->initLoggerType();
			}
		}

		private $id_type;
		public function getId():int{
			return $this->id_type;
		}
		public function setId(int $new):void{
			$this->id_type = $new;
		}

		//-----------------------------------------------------------------------

		private $type;
		public function getName():string{
			return $this->type;
		}
		public function setName(string $new):void{
			$this->type = $new;
		}

		//-----------------------------------------------------------------------

		private $currentType = [];
		public function getCurrentType(int $id_type):array{

			$this->currentType = [];

			if($_SESSION['debug']['monolog']){
				$this->initLoggerType();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCurrentType()',
					'$id_type' => $id_type,
					'$currentType' => $this->currentType
				];
			}
	
			if(Utilities::checkData('type','id_type', $id_type)){
				
				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
				try{
					$stmt = $bdd->prepare("SELECT `user_type`.`id_type`,
												`user_type`.`type`
											FROM  `user_type`
											WHERE `user_type`.`id_type` = :id_type");
					
					$stmt->bindParam(':id_type', $id_type, PDO::PARAM_INT);

					$stmt->execute();

					$this->currentType = $stmt->fetchAll(PDO::FETCH_ASSOC);

					if($_SESSION['debug']['monolog']){
						$arrayLogger['$currentType'] = $this->currentType;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

					return $this->currentType;

				}catch(PDOException $e){
					if($_SESSION['debug']['monolog']){
						$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
					}
					return [];
				}finally{
					$bdd = null;
				}
			}

    		return [];
		}

		//-----------------------------------------------------------------------

		private $typeList = array();
		public function getTypeList(string $whereClause, string $orderBy = 'type', string $ascOrDesc = 'ASC', int $firstLine = 0, int $linePerPage = 13):array{

			$this->typeList = [];

			if($_SESSION['debug']['monolog']){
				$this->initLoggerType();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getTypeList()',
					'$whereClause' => $whereClause,
					'$orderBy' => $orderBy,
					'$ascOrDesc' => $ascOrDesc,
					'$firstLine' => $firstLine,
					'$linePerPage' => $linePerPage,
					'$typeList' => $this->typeList
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$sql = $bdd->prepare("SELECT `user_type`.`id_type`,
											 `user_type`.`type`
									    FROM `user_type`
									   WHERE $whereClause
									ORDER BY :orderBy :ascOrDesc
									   LIMIT :firstLine, :linePerPage");

				$sql->bindParam(':orderBy', $orderBy, PDO::PARAM_STR);
				$sql->bindParam(':ascOrDesc', $ascOrDesc, PDO::PARAM_STR);
				$sql->bindParam(':firstLine', $firstLine, PDO::PARAM_INT);
				$sql->bindParam(':linePerPage', $linePerPage, PDO::PARAM_INT);

				$sql->execute();

				$this->typeList = $sql->fetchAll(PDO::FETCH_ASSOC);
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$getTypeList'] = true; //$this->getTypeList; // replace true; by $this->getTypeList; if you want to see the result
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

				return $this->typeList;

			}catch(PDOException $e){
				if($_SESSION['debug']['monolog']){
					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}
				return [];
			}finally{
				$bdd = null;
			}
		}

		//-----------------------------------------------------------------------
		
		private $insertType = 0;
		public function insertType():int{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerType();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'insertType()',
					'$insertType' => $this->insertType
				];
			}

			$configDb = DbConnect::configDbConnect();

			foreach ($configDb as $dbName => $configDbConnect){

				$typeExist = false;

				if (!self::checkType($this->insertType, $dbName)){
					$bdd = DbConnect::connectionDb($configDbConnect);
				} else {
					$typeExist = true;
				}

				if(!$typeExist){

					try{
						$stmt = $bdd->prepare("INSERT INTO `user_type`(`type`) VALUES(:type)");
						$stmt->bindParam(':type', $this->type, PDO::PARAM_STR);
						$stmt->execute();

						$stmt = $bdd->prepare('SELECT MAX(`id_type`) FROM `type`');
						$stmt->execute();

						$this->insertType = intval($stmt->fetchColumn());
						
						if($_SESSION['debug']['monolog']){
							$arrayLogger['$insertType'] = $this->insertType;
							$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
						}

					}catch(PDOException $e){
						if($_SESSION['debug']['monolog']){
							$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
						}

					}finally{
						$bdd = null;
					}
				}
			}

			return $this->insertType;
		}

		//-----------------------------------------------------------------------

		private $updateType = false;
		public function updateUserType(int $id_type):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerType();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'updateUserType()',
					'$id_type' => $id_type,
					'$updateType' => $this->updateType
				];
			}

			$configDb = DbConnect::configDbConnect();

			foreach ($configDb as $dbName => $configDbConnect) {

				$typeExist = false;

				if(self::checkIdType($id_type, $dbName)){
					$bdd = DbConnect::connectionDb($configDbConnect);
					$typeExist = true;
				}

				if($typeExist){

					try{
						$stmt = $bdd->prepare("UPDATE `user_type` SET `name` = :name WHERE `id_type` = :id_type");
						
						$stmt->bindParam(':name', $this->type, PDO::PARAM_STR);
						$stmt->bindParam(':id_type', $id_type, PDO::PARAM_INT);
						
						$stmt->execute();

						$this->updateType = true;
					
						if($_SESSION['debug']['monolog']){
							$arrayLogger['$updateType'] = $this->updateType;
							$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
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

			return $this->updateType;
		}

		//-----------------------------------------------------------------------
		private $deleteType = false;
		public function deleteType(int $id_type):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerType();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deleteType()',
					'$id_type' => $id_type,
					'$deleteType' => $this->deleteType
				];
			}

			$configDb = DbConnect::configDbConnect();

			foreach ($configDb as $dbName => $configDbConnect) {

				$typeExist = false;

				if(self::checkIdType($id_type, $dbName)){
					$bdd = DbConnect::connectionDb($configDbConnect);
					$typeExist = true;
				}

				if($typeExist){

					try{
						$stmt = $bdd->prepare('DELETE FROM user_type WHERE id_type = :id_type');

						$stmt->bindParam(':id_type', $id_type, PDO::PARAM_INT);

						$stmt->execute();

						$this->deleteType = true;
					
						if($_SESSION['debug']['monolog']){
							$arrayLogger['$deleteType'] = $this->deleteType;
							$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
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

			return $this->deleteType;
		}

		//-----------------------------------------------------------------------

		private static $checkType = false;
		public static function checkType(string $type, string $db = 'mycv'):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerType();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkType()',
					'$type' => $type,
					'$checkType' => self::$checkType
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `type` WHERE `type` = :type");
				$stmt->bindParam(':type', $type, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkType = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkType'] = self::$checkType;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkType;
		}

		//-----------------------------------------------------------------------

		private static $checkIdType = false;
		public static function checkIdType(int $id_type, string $db = 'mycv'):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerType();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdType()',
					'$id_type' => $id_type,
					'$checkIdType' => self::$checkIdType
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `type` WHERE `id_type` = :id_type");
				$stmt->bindParam(':id_type', $id_type, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdType = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdType'] = self::$checkIdType;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkIdType;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerType()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Type');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/User.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerType()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Type');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/User.log', Logger::DEBUG));
			}
		}
	}
?>