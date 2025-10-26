<?php
	//Brand.php
	//Author: Ludovic FOLLACO
	//checked to 2024-10-04_16:31
	namespace Model\CarBrand;

	use \PDO;
	use \PDOException;
    use Model\DbConnect\DbConnect;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class CarBrand
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct(){
			if($_SESSION['debug']['monolog']){
				$this->initLoggerBrand();
			}
		}

		private $id_brand;
		public function getId(): int{
			return $this->id_brand;
		}
		public function setId($new): void{
			$this->id_brand = $new;
		}

		//-----------------------------------------------------------------------

		private $name;
		public function getName(): string{
			return $this->name;
		}
		public function setName($new): void{
			$this->name = $new;
		}

		//-----------------------------------------------------------------------

        private $addBrand = false;
        public function getAddBrand():bool{
            return $this->addBrand;
        }
        public function setAddBrand(bool $new):void{
            $this->addBrand = $new;
        }

		//-----------------------------------------------------------------------

		private $currentBrand = array();
		public function getCurrentBrand(int $id_brand):array{

			$this->currentBrand = [];

			if($_SESSION['debug']['monolog']){
				$this->initLoggerBrand();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCurrentBrand()',
					'$id_brand' => $id_brand,
					'$currentBrand' => $this->currentBrand
				];
			}
	
			if(self::checkIdBrand($id_brand)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
				try{
					$sql = $bdd->prepare("SELECT `brand`.`id_brand`,
												 `brand`.`name`
										    FROM `brand`
										   WHERE `brand`.`id_brand`=:id_brand");

					$sql->bindParam(':id_brand', $id_brand, PDO::PARAM_INT);

					$sql->execute();

					$this->currentBrand = $sql->fetch(PDO::FETCH_ASSOC);
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$currentBrand'] = $this->currentBrand;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

					return $this->currentBrand;

				}catch (PDOException $e){
					if($_SESSION['debug']['monolog']){
						$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
					}
					return [];

				}finally{
					$bdd=null;
				}
			}

			return [];
		}

		//-----------------------------------------------------------------------

		private $brandList = array();
		public function getBrandList(string $whereClause, string $orderBy = 'name', string $ascOrDesc = 'ASC', int $firstLine = 0, int $linePerPage = 13): array{

			$this->brandList = [];

			if($_SESSION['debug']['monolog']){
				$this->initLoggerBrand();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getBrandList()',
					'$whereClause' => $whereClause,
					'$orderBy' => $orderBy,
					'$ascOrDesc' => $ascOrDesc,
					'$firstLine' => $firstLine,
					'$linePerPage' => $linePerPage,
					'$brandList' => $this->brandList
				];
			}
			
			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
			    $stmt = $bdd->prepare("SELECT `brand`.`id_brand`,
											  `brand`.`name`
										 FROM `brand`
										WHERE $whereClause
									 ORDER BY :orderBy :ascOrDesc
										LIMIT :firstLine, :linePerPage");

				$stmt->bindParam(':orderBy', $orderBy, PDO::PARAM_STR);
				$stmt->bindParam(':ascOrDesc', $ascOrDesc, PDO::PARAM_STR);
				$stmt->bindParam(':firstLine', $firstLine, PDO::PARAM_INT);
				$stmt->bindParam(':linePerPage', $linePerPage, PDO::PARAM_INT);

				$stmt->execute();

				$this->brandList = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$brandList'] = true; //$this->brandList; replace true; by $this->brandList; to see the list of brand
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

				return $this->brandList;

			}catch (PDOException $e){
				if($_SESSION['debug']['monolog']){
					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}
				return [];
				
			}finally{
				$bdd=null;
			}
		}

		//-----------------------------------------------------------------------

		private $insertBrand = 0;
		public function insertBrand():int{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerBrand();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'insertBrand()',
					'$insertBrand' => $this->insertBrand
				];
			}
	
			if(!self::checkNameBrand($this->name)){
				
				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare('INSERT INTO `brand`(`name`) VALUES(:name)');
					$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
					$stmt->execute();
		
					$stmt = $bdd->prepare('SELECT MAX(`id_brand`) FROM `brand`');
					$stmt->execute();
					
					$this->insertBrand = intval($stmt->fetchColumn());
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$insertBrand'] = $this->insertBrand;
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

			return $this->insertBrand;
		}

		//-----------------------------------------------------------------------

		private $updateBrand = false;
		public function updateBrand(int $id_brand):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerBrand();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'updateBrand()',
					'$id_brand' => $id_brand,
					'$updateBrand' => $this->updateBrand
				];
			}
	
			if(self::checkIdBrand($id_brand)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare('UPDATE `brand` SET `name` = :name WHERE `id_brand` = :id_brand');

					$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
					$stmt->bindParam(':id_brand', $id_brand, PDO::PARAM_INT);

					$stmt->execute();

					$this->updateBrand = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$updateBrand'] = $this->updateBrand;
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

			return $this->updateBrand;
		}

		//-----------------------------------------------------------------------

		private $deleteBrand = false;
		public function deleteBrand(int $id_brand):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerBrand();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deleteBrand()',
					'$id_brand' => $id_brand,
					'$deleteBrand' => $this->deleteBrand
				];
			}
	
			if(self::checkIdBrand($id_brand)){

				if(!self::checkBrandOnCar($id_brand)){

					$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

					try{
						$stmt = $bdd->prepare('DELETE FROM brand WHERE id_brand = :id_brand');
						$stmt->bindParam(':id_brand', $id_brand, PDO::PARAM_INT);
						$stmt->execute();

						$this->deleteBrand = true;

						if($_SESSION['debug']['monolog']){
							$arrayLogger['$deleteBrand'] = self::$deleteBrand;
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

			return $this->deleteBrand;
		}

		//-----------------------------------------------------------------------

		private static $checkIdBrand = false;
		public static function checkIdBrand(int $id_brand):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerBrand();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdBrand()',
					'$id_brand' => $id_brand,
					'$checkIdBrand' => self::$checkIdBrand
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `brand` WHERE `id_brand` = :id_brand");
				$stmt->bindParam(':id_brand', $id_brand, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdBrand = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdBrand'] = self::$checkIdBrand;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkIdBrand;
		}

		//-----------------------------------------------------------------------

		private static $checkNameBrand = false;
		public static function checkNameBrand(string $name):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerBrand();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkNameBrand()',
					'$name' => $name,
					'$checkNameBrand' => self::$checkNameBrand
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `brand` WHERE `name` = :name");
				$stmt->bindParam(':name', $name, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkNameBrand = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkNameBrand'] = self::$checkNameBrand;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkNameBrand;
		}

		//-----------------------------------------------------------------------

		private static $checkBrandOnCar = false;
		public static function checkBrandOnCar(int $id_brand):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerBrand();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkBrandOnCar()',
					'$id_brand' => $id_brand,
					'$checkBrandOnCar' => self::$checkBrandOnCar
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare('SELECT COUNT(*) FROM car WHERE id_brand = :id_brand');
				$stmt->bindParam(':id_brand', $id_brand, PDO::PARAM_INT);
				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkBrandOnCar = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkBrandOnCar'] = self::$checkBrandOnCar;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkBrandOnCar;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerBrand()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Brand');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/GarageParrot.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerBrand()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Brand');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/GarageParrot.log', Logger::DEBUG));
			}
		}
	}	
?>