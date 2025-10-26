<?php
	//Car.php
	//Author: Ludovic FOLLACO
	//checked to 2024-10-04_16:48
	namespace Model\Car;

	use \PDO;
	use \PDOException;
    use Model\DbConnect\DbConnect;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class Car
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct(){
			if($_SESSION['debug']['monolog']){
				$this->initLoggerCar();
			}
		}

		private $id_car;
		public function getId():int{
			return $this->id_car;
		}
		public function setId(int $new):void{
			$this->id_car = $new;
		}

		//-----------------------------------------------------------------------

		private $brand;
		public function getBrand():string{
			return $this->brand;
		}
		public function setBrand(string $new):void{
			$this->brand = $new;
		}

		//-----------------------------------------------------------------------

		private $model;
		public function getModel():string{
			return $this->model;
		}
		public function setModel(string $new):void{
			$this->model = $new;
		}

		//-----------------------------------------------------------------------

		private $engine;
		public function getEngine():string{
			return $this->engine;
		}
		public function setEngine(string $new):void{
			$this->engine = $new;
		}

		//-----------------------------------------------------------------------

		private $year = 2000;
		public function getYear():int{
			return $this->year;
		}
		public function setYear(int $new):void{
			$this->year = $new;
		}

		//-----------------------------------------------------------------------

		private $mileage = 0;
		public function getMileage():int{
			return $this->mileage;
		}
		public function setMileage(int $new):void{
			$this->mileage = $new;
		}

		//-----------------------------------------------------------------------

		private $price = 0;
		public function getPrice():int{
			return $this->price;
		}
		public function setPrice(int $new):void{
			$this->price = $new;
		}

		//-----------------------------------------------------------------------

		private $sold;
		public function getSold():string{
			return $this->sold;
		}
		public function setSold(string $new):void{
			$this->sold = $new;
		}

		//-----------------------------------------------------------------------

		private $description;
		public function getDescription():string{
			return $this->description;
		}
		public function setDescription(string $new):void{
			$this->description = $new;
		}
		//-----------------------------------------------------------------------

		private $image1;
		public function getImage1():string{
			return $this->image1;
		}
		public function setImage1(string $new):void{
			$this->image1 = $new;
		}

		//-----------------------------------------------------------------------

		private $image2;
		public function getImage2():string{
			return $this->image2;
		}
		public function setImage2(string $new):void{
			$this->image2 = $new;
		}

		//-----------------------------------------------------------------------

		private $image3;
		public function getImage3():string{
			return $this->image3;
		}
		public function setImage3(string $new):void{
			$this->image3 = $new;
		}

		//-----------------------------------------------------------------------

		private $image4;
		public function getImage4():string{
			return $this->image4;
		}
		public function setImage4(string $new):void{
			$this->image4 = $new;
		}

		//-----------------------------------------------------------------------

		private $image5;
		public function getImage5():string{
			return $this->image5;
		}
		public function setImage5(string $new):void{
			$this->image5 = $new;
		}

		private $criteriaBrand;
		public function getCriteriaBrand():string{
			return $this->criteriaBrand;
		}
		public function setCriteriaBrand(string $new):void{
			$this->criteriaBrand = $new;
		}

		private $criteriaModel;
		public function getCriteriaModel():string{
			return $this->criteriaModel;
		}
		public function setCriteriaModel(string $new):void{
			$this->criteriaModel = $new;
		}

		private $criteriaMileage;
		public function getCriteriaMileage():int{
			return $this->criteriaMileage;
		}
		public function setCriteriaMileage(int $new):void{
			$this->criteriaMileage = $new;
		}

		private $criteriaPrice;
		public function getCriteriaPrice():int{
			return $this->criteriaPrice;
		}
		public function setCriteriaPrice(int $new):void{
			$this->criteriaPrice = $new;
		}

		//-----------------------------------------------------------------------

		private $newCar = false;
		public function getNewCar():bool{
			$_SESSION['car']['newCar'] = $this->newCar;
			return $this->newCar;
		}
		public function setNewCar(bool $new):void{
			$_SESSION['car']['newCar'] = $new;
			$this->newCar = $new;
		}

        //__Ajouter car?___________________________________________

        private $addCar = false;
        public function getAddCar():bool{
            $_SESSION['car']['addCar']=$this->addCar;
            return $this->addCar;
        }
        public function setAddCar(bool $new):void{
            $_SESSION['car']['addCar']=$new;
			$this->addCar = $new;
        }

		//-----------------------------------------------------------------------

		private $getCurrentCar = array();
		public function getCurrentCar(int $id_car):array{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerCar();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCurrentCar()',
					'$id_car' => $id_car,
					'$getCurrentCar' => $this->getCurrentCar
				];
			}
	
			if(self::checkIdCar($id_car)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare("SELECT
												`car`.`id_car`,
												`brand`.`name` AS `brand`,
												`model`.`name` AS `model`,
												`engine`.`name` AS `engine`,
												`car`.`year`,
												`car`.`mileage`,
												`car`.`price`,
												`car`.`description`,
												`car`.`sold`,
												`car`.`image1`,
												`car`.`image2`,
												`car`.`image3`,
												`car`.`image4`,
												`car`.`image5`
											
											FROM `car`

											LEFT JOIN `brand`
												ON `car`.`id_brand` = `brand`.`id_brand`
											LEFT JOIN `model`
												ON `car`.`id_model` = `model`.`id_model`
											LEFT JOIN `engine`
												ON `car`.`id_engine` = `engine`.`id_engine`
											WHERE `car`.`id_car` = :id_car");

					$stmt->bindParam(':id_car', $id_car, PDO::PARAM_INT);

					$stmt->execute();

					$this->getCurrentCar = $stmt->fetch(PDO::FETCH_ASSOC);
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$getCurrentCar'] = $this->getCurrentCar;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

					return $this->getCurrentCar;

				}catch(PDOException $e){
					
					if($_SESSION['debug']['monolog']){
						$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
					}
					return [];

				}finally{
					$bdd = null;
				}

			}else{				
				return [];
			}
		}

		//-----------------------------------------------------------------------

		private $carList = array();
		public function getCarList(string $whereClause, string $orderBy = 'price', string $ascOrDesc = 'ASC', int $firstLine = 0, int $linePerPage = 13):array{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerCar();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCarList()',
					'whereClause' => $whereClause,
					'orderBy' => $orderBy,
					'ascOrDesc' => $ascOrDesc,
					'firstLine' => $firstLine,
					'linePerPage' => $linePerPage,
					'$carList' => $this->carList
				];
			}
			
			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

			try{
			    $sql = $bdd->prepare("SELECT
										`car`.`id_car`,
										`brand`.`name` AS `brand`,
										`model`.`name` AS `model`,
										`engine`.`name` AS `engine`,
										`car`.`year`,
										`car`.`mileage`,
										`car`.`price`,
										`car`.`sold`,
										`car`.`description`,
										`car`.`image1`,
										`car`.`image2`,
										`car`.`image3`,
										`car`.`image4`,
										`car`.`image5`

									FROM `car`

									LEFT JOIN `brand`
										ON `car`.`id_brand` = `brand`.`id_brand`
									LEFT JOIN `model`
										ON `car`.`id_model` = `model`.`id_model`
									LEFT JOIN `engine`
										ON `car`.`id_engine` = `engine`.`id_engine`

									WHERE $whereClause
									ORDER BY :orderBy :ascOrDesc
									LIMIT :firstLine, :linePerPage");
				
				$sql->bindParam(':orderBy', $orderBy, PDO::PARAM_STR);
				$sql->bindParam(':ascOrDesc', $ascOrDesc, PDO::PARAM_STR);
				$sql->bindParam(':firstLine', $firstLine, PDO::PARAM_INT);
				$sql->bindParam(':linePerPage', $linePerPage, PDO::PARAM_INT);

				$sql->execute();
				
				$this->carList = $sql->fetchAll(PDO::FETCH_ASSOC);

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$carList'] = true; //$this->carList; Replace true; by $this->carList; if you want to see the result
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

				return $this->carList;

			}catch (PDOException $e){

				if($_SESSION['debug']['monolog']){
					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage(), $arrayLogger);
				}
				return [];

			}finally{
				$bdd = null;
			}
		}

		//-----------------------------------------------------------------------

		private $updateCar = false;
		public function updateCar(int $id_car):bool{

			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerCar();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'updateCar()',
					'$id_car' => $id_car,
					'$updateCar' => self::$updateCar
				];
			}
	
			if(self::checkIdCar($id_car)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare("UPDATE `car`
											SET 
												`id_brand` = (SELECT `id_brand` FROM `brand` WHERE `name` = :brand),
												`id_model` = (SELECT `id_model` FROM `model` WHERE `name` = :model),
												`id_engine` = (SELECT `id_engine` FROM `engine` WHERE `name` = :engine),
												`year` = :year_,
												`mileage` = :mileage,
												`price` = :price,
												`sold` = :sold,
												`description` = :description_,
												`image1` = :image1,
												`image2` = :image2,
												`image3` = :image3,
												`image4` = :image4,
												`image5` = :image5
											WHERE `id_car` = :id_car");
					
					$stmt->bindParam(':brand', $this->brand, PDO::PARAM_STR);
					$stmt->bindParam(':model', $this->model, PDO::PARAM_STR);
					$stmt->bindParam(':engine', $this->engine, PDO::PARAM_STR);
					
					$yearInt = intval($this->year);
					$stmt->bindParam(':year_', $yearInt, PDO::PARAM_INT);
					
					$mileageInt = intval($this->mileage);
					$stmt->bindParam(':mileage', $mileageInt, PDO::PARAM_INT);
					
					$priceInt = intval($this->price);
					$stmt->bindParam(':price', $priceInt, PDO::PARAM_INT);

					$stmt->bindParam(':sold', $this->sold, PDO::PARAM_STR);
					$stmt->bindParam(':description_', $this->description, PDO::PARAM_STR);
					$stmt->bindParam(':image1', $this->image1, PDO::PARAM_STR);
					$stmt->bindParam(':image2', $this->image2, PDO::PARAM_STR);
					$stmt->bindParam(':image3', $this->image3, PDO::PARAM_STR);
					$stmt->bindParam(':image4', $this->image4, PDO::PARAM_STR);
					$stmt->bindParam(':image5', $this->image5, PDO::PARAM_STR);
					
					$stmt->bindParam(':id_car', $id_car, PDO::PARAM_INT);

					$stmt->execute();

					$this->updateCar = true;

					if($_SESSION['debug']['monolog']){
						$arrayLogger['$updateCar'] = $this->updateCar;
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

			return $this->updateCar;
		}

		//-----------------------------------------------------------------------
		
		private $insertCar = 0;
		public function insertCar():int{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerCar();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'insertCar()',
					'$insertCar' => $this->insertCar
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

			try{
				$stmt = $bdd->prepare("INSERT INTO `car` (`id_brand`,
															`id_model`,
															`id_engine`,
															`year`,
															`mileage`,
															`price`,
															`sold`,
															`description`,
															`image1`,
															`image2`,
															`image3`,
															`image4`,
															`image5`)
										VALUES ((SELECT `id_brand` FROM `brand` WHERE `name` = :brand),
												(SELECT `id_model` FROM `model` WHERE `name` = :model),
												(SELECT `id_engine` FROM `engine` WHERE `name` = :engine),
												:year_,
												:mileage,
												:price,
												:sold,
												:description,
												:image1,
												:image2,
												:image3,
												:image4,
												:image5)");

				$stmt->bindParam(':brand', $this->brand, PDO::PARAM_STR);
				$stmt->bindParam(':model', $this->model, PDO::PARAM_STR);
				$stmt->bindParam(':engine', $this->engine, PDO::PARAM_STR);
				
				$yearInt = intval($this->year);
				$stmt->bindParam(':year_', $yearInt, PDO::PARAM_INT);
				
				$mileageInt = intval($this->mileage);
				$stmt->bindParam(':mileage', $mileageInt, PDO::PARAM_INT);
				
				$priceInt = intval($this->price);
				$stmt->bindParam(':price', $priceInt, PDO::PARAM_INT);

				$stmt->bindParam(':sold', $this->sold, PDO::PARAM_STR);
				$stmt->bindParam(':description', $this->description, PDO::PARAM_STR);
				$stmt->bindParam(':image1', $this->image1, PDO::PARAM_STR);
				$stmt->bindParam(':image2', $this->image2, PDO::PARAM_STR);
				$stmt->bindParam(':image3', $this->image3, PDO::PARAM_STR);
				$stmt->bindParam(':image4', $this->image4, PDO::PARAM_STR);
				$stmt->bindParam(':image5', $this->image5, PDO::PARAM_STR);
				
				$stmt->execute();

				$stmt = $bdd->query("SELECT MAX(`id_car`) FROM `car`");

				$this->insertCar = intval($stmt->fetchColumn());

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$insertCar'] = $this->insertCar;
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd = null;
			}

			return $this->insertCar;
		}

		//-----------------------------------------------------------------------
		private $deleteCar = false;
		public function deleteCar(int $id_car):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerCar();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deleteCar()',
					'$id_car' => $id_car,
					'$deleteCar' => $this->deleteCar
				];
			}
			
			if(self::checkIdCar($id_car)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare('DELETE FROM car WHERE id_car = :id_car');
					$stmt->bindParam(':id_car', $id_car, PDO::PARAM_INT);
					$stmt->execute();

					$this->deleteCar = true;

					if($_SESSION['debug']['monolog']){
						$arrayLogger['$deleteCar'] = $this->deleteCar;
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
			
			return $this->deleteCar;
		}


		//-----------------------------------------------------------------------

		private $checkCar = 0;
		public function checkCar(string $brand, string $model, string $engine, int $year, int $mileage, int $price):int{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerCar();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkCar()',
					'$brand' => $brand,
					'$model' => $model,
					'$engine' => $engine,
					'$year' => $year,
					'$mileage' => $mileage,
					'$price' => $price,
					'$checkCar' => $this->checkCar
				];
			}
			
			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) AS `number`
										FROM `car`
										WHERE `id_brand` = (SELECT `id_brand` FROM `brand` WHERE `name` = :brand)
										AND `id_model` = (SELECT `id_model` FROM `model` WHERE `name` = :model)
										AND `id_engine` = (SELECT `id_engine` FROM `engine` WHERE `name` = :engine)
										AND `year` = :year_
										AND `mileage` = :mileage
										AND `price` = :price");

				$stmt->bindParam(':brand', $brand, PDO::PARAM_STR);
				$stmt->bindParam(':model', $model, PDO::PARAM_STR);
				$stmt->bindParam(':engine', $engine, PDO::PARAM_STR);

				$yearInt = intval($year);
				$stmt->bindParam(':year_', $yearInt, PDO::PARAM_INT);

				$mileageInt = intval($mileage);
				$stmt->bindParam(':mileage', $mileageInt, PDO::PARAM_INT);

				$priceInt = intval($price);
				$stmt->bindParam(':price', $priceInt, PDO::PARAM_INT);

				$stmt->execute();

				$this->checkCar = intval($stmt->fetchColumn());

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkCar'] = $this->checkCar;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd = null;
			}

			return $this->checkCar;
		}

		private static $checkIdCar = false;
		public static function checkIdCar(int $id_car):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerCar();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdCar()',
					'$id_car' => $id_car,
					'$checkIdCar' => self::$checkIdCar
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `car` WHERE `id_car` = :id_car");
				$stmt->bindParam(':id_car', $id_car, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdCar = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdCar'] = self::$checkIdCar;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkIdCar;
		}

		//-----------------------------------------------------------------------
		
		private static  $checkNbOfProduct = 0;
		public static function checkNbOfProduct(string $whereClause):int{

			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerCar();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkNbOfProduct()',
					'$whereClause' => $whereClause,
					'$checkNbOfProduct' => self::$checkNbOfProduct
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT * FROM `car` WHERE $whereClause ");

				$stmt->execute();

				self::$checkNbOfProduct = $stmt->fetchColumn();

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkNbOfProduct'] = self::$checkNbOfProduct;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkNbOfProduct;
		}

		//-----------------------------------------------------------------------

		private static $checkNbOfCar = 0;
		public static function getCheckNbOfCar(string $whereClause):int{

			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerCar();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCheckNbOfCar()',
					'$whereClause' => $whereClause,
					'$checkNbOfCar' => self::$checkNbOfCar
				];
			}
			
			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

			try{
			    $sql = $bdd->prepare("SELECT
										`car`.`id_car`,
										`brand`.`name` AS `brand`,
										`model`.`name` AS `model`,
										`car`.`year`,
										`car`.`mileage`

									FROM `car`

									LEFT JOIN `brand`
										ON `car`.`id_brand` = `brand`.`id_brand`
									LEFT JOIN `model`
										ON `car`.`id_model` = `model`.`id_model`

									WHERE $whereClause");
				
				$sql->execute();
				
				$result = $sql->fetchAll(PDO::FETCH_ASSOC);

				self::$checkNbOfCar = count($result);

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkNbOfCar'] = self::$checkNbOfCar;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch (PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}
			
			return self::$checkNbOfCar;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerCar()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Car');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/GarageParrot.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerCar()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Car');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/GarageParrot.log', Logger::DEBUG));
			}
		}
	}
	
?>