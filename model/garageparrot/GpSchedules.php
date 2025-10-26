<?php
	//GpSchedules.php
	//Author: Ludovic FOLLACO
	//checked to 2024-10-08_16:04
	namespace Model\GpSchedules;

	use \PDO;
	use \PDOException;
    use Model\DbConnect\DbConnect;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class GpSchedules
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct(){
			if($_SESSION['debug']['monolog']){
				$this->initLoggerSchedules();
			}
		}

		private $id_schedules;
		public function getId():int{
			return $this->id_schedules;
		}
		public function setId(int $new):void{
			$this->id_schedules = $new;
		}

		//-----------------------------------------------------------------------

		private $lundiMatin;
		public function getLundiMatin():string{
			return $this->lundiMatin;
		}
		public function setLundiMatin(string $new):void{
			$this->lundiMatin = $new;
		}

		//-----------------------------------------------------------------------

		private $lundiAM;
		public function getLundiAM():string{
			return $this->lundiAM;
		}
		public function setLundiAM(string $new):void{
			$this->lundiAM = $new;
		}

		//-----------------------------------------------------------------------

		private $mardiMatin;
		public function getMardiMatin():string{
			return $this->mardiMatin;
		}
		public function setMardiMatin(string $new):void{
			$this->mardiMatin = $new;
		}

		//-----------------------------------------------------------------------

		private $mardiAM;
		public function getMardiAM():string{
			return $this->mardiAM;
		}
		public function setMardiAM(string $new):void{
			$this->mardiAM = $new;
		}

		//-----------------------------------------------------------------------

		private $mercrediMatin;
		public function getMercrediMatin():string{
			return $this->mercrediMatin;
		}
		public function setMercrediMatin(string $new):void{
			$this->mercrediMatin = $new;
		}

		//-----------------------------------------------------------------------

		private $mercrediAM;
		public function getMercrediAM():string{
			return $this->mercrediAM;
		}
		public function setMercrediAM(string $new):void{
			$this->mercrediAM = $new;
		}

		//-----------------------------------------------------------------------

		private $jeudiMatin;
		public function getJeudiMatin():string{
			return $this->jeudiMatin;
		}
		public function setJeudiMatin(string $new):void{
			$this->jeudiMatin = $new;
		}

		//-----------------------------------------------------------------------

		private $jeudiAM;
		public function getJeudiAM():string{
			return $this->jeudiAM;
		}
		public function setJeudiAM(string $new):void{
			$this->jeudiAM = $new;
		}

		//-----------------------------------------------------------------------

		private $vendrediMatin;
		public function getVendrediMatin():string{
			return $this->vendrediMatin;
		}
		public function setVendrediMatin(string $new):void{
			$this->vendrediMatin = $new;
		}

		//-----------------------------------------------------------------------

		private $vendrediAM;
		public function getVendrediAM():string{
			return $this->vendrediAM;
		}
		public function setVendrediAM(string $new):void{
			$this->vendrediAM = $new;
		}

		//-----------------------------------------------------------------------

		private $samediMatin;
		public function getSamediMatin():string{
			return $this->samediMatin;
		}
		public function setSamediMatin(string $new):void{
			$this->samediMatin = $new;
		}

		//-----------------------------------------------------------------------

		private $samediAM;
		public function getSamediAM():string{
			return $this->samediAM;
		}
		public function setSamediAM(string $new):void{
			$this->samediAM = $new;
		}

		//-----------------------------------------------------------------------

		private $dimancheMatin;
		public function getDimancheMatin():string{
			return $this->dimancheMatin;
		}
		public function setDimancheMatin(string $new):void{
			$this->dimancheMatin = $new;
		}

		//-----------------------------------------------------------------------

		private $dimancheAM;
		public function getDimancheAM():string{
			return $this->dimancheAM;
		}
		public function setDimancheAM(string $new):void{
			$this->dimancheAM = $new;
		}

		//-----------------------------------------------------------------------

        private $addSchedules = false;
        public function getAddSchedules():bool{
			return $this->addSchedules;
        }
        public function setAddSchedules(bool $new):void{
			$this->addSchedules = $new;
        }

		//-----------------------------------------------------------------------

		private $currentSchedules = array();
		public function getCurrentSchedules(int $id_schedules):array{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerSchedules();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCurrentSchedules()',
					'$id_schedules' => $id_schedules,
					'$currentSchedules' => $this->currentSchedules
				];
			}
	
			if(self::checkIdSchedules($id_schedules)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
				try{
			    	$stmt = $bdd->prepare("SELECT
												`schedules`.`id_schedules`,
												`schedules`.`lundiMatin`,
												`schedules`.`lundiAM`,
												`schedules`.`mardiMatin`,
												`schedules`.`mardiAM`,
												`schedules`.`mercrediMatin`,
												`schedules`.`mercrediAM`,
												`schedules`.`jeudiMatin`,
												`schedules`.`jeudiAM`,
												`schedules`.`vendrediMatin`,
												`schedules`.`vendrediAM`,
												`schedules`.`samediMatin`,
												`schedules`.`samediAM`,
												`schedules`.`dimancheMatin`,
												`schedules`.`dimancheAM`

											FROM `schedules`
											
											WHERE `schedules`.`id_schedules`= :id_schedules
										");

					$stmt->bindParam(':id_schedules', $id_schedules, PDO::PARAM_INT);

					$stmt->execute();

					$this->currentSchedules = $stmt->fetch(PDO::FETCH_ASSOC);
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$currentSchedules'] = $this->currentSchedules;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

					return $this->currentSchedules;

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

		private $schedulesList = array();
		public function getSchedulesList(string $whereClause, string $orderBy = 'name', string $ascOrDesc = 'ASC', int $firstLine = 0, int $linePerPage = 13):array{
			
			if($_SESSION['debug']['monolog']){
				$this->initLoggerSchedules();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getSchedulesList()',
					'$whereClause' => $whereClause,
					'$orderBy' => $orderBy,
					'$ascOrDesc' => $ascOrDesc,
					'$firstLine' => $firstLine,
					'$linePerPage' => $linePerPage,
					'$schedulesList' => $this->schedulesList
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
			    $stmt = $bdd->prepare("SELECT
										`schedules`.`id_schedules`,
										`schedules`.`lundiMatin`,
										`schedules`.`lundiAM`,
										`schedules`.`mardiMatin`,
										`schedules`.`mardiAM`,
										`schedules`.`mercrediMatin`,
										`schedules`.`mercrediAM`,
										`schedules`.`jeudiMatin`,
										`schedules`.`jeudiAM`,
										`schedules`.`vendrediMatin`,
										`schedules`.`vendrediAM`,
										`schedules`.`samediMatin`,
										`schedules`.`samediAM`,
										`schedules`.`dimancheMatin`,
										`schedules`.`dimancheAM`

									FROM `schedules`

									WHERE $whereClause
									ORDER BY :orderBy :ascOrDesc
									LIMIT :firstLine, :linePerPage
								");

				$stmt->bindParam(':orderBy', $orderBy, PDO::PARAM_STR);
				$stmt->bindParam(':ascOrDesc', $ascOrDesc, PDO::PARAM_STR);
				$stmt->bindParam(':firstLine', $firstLine, PDO::PARAM_INT);
				$stmt->bindParam(':linePerPage', $linePerPage, PDO::PARAM_INT);

				$stmt->execute();

				$this->schedulesList = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$schedulesList'] = true; //$this->schedulesList; replace true; by $this->schedulesList; to see the list of brand
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

				return $this->schedulesList;

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
		private $insertSchedules = false;
		public function insertSchedules():bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerSchedules();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'insertSchedules()',
					'$insertSchedules' => $this->insertSchedules
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

			try{
				$stmt = $bdd->prepare('INSERT INTO `schedules`(
											`lundiMatin`,`lundiAM`,
											`mardiMatin`,`mardiAM`,
											`mercrediMatin`,`mercrediAM`,
											`jeudiMatin`,`jeudiAM`,
											`vendrediMatin`,`vendrediAM`,
											`samediMatin`,`samediAM`,
											`dimancheMatin`,`dimancheAM`
										)VALUES(
											:lundiMatin,:lundiAM,
											:mardiMatin,:mardiAM,
											:mercrediMatin,:mercrediAM,
											:jeudiMatin,:jeudiAM,
											:vendrediMatin,:vendrediAM,
											:samediMatin,:samediAM,
											:dimancheMatin,:dimancheAM
										)
									');

				$stmt->bindParam(':lundiMatin', $this->lundiMatin, PDO::PARAM_STR);
				$stmt->bindParam(':lundiAM', $this->lundiAM, PDO::PARAM_STR);
				$stmt->bindParam(':mardiMatin', $this->mardiMatin, PDO::PARAM_STR);
				$stmt->bindParam(':mardiAM', $this->mardiAM, PDO::PARAM_STR);
				$stmt->bindParam(':mercrediMatin', $this->mercrediMatin, PDO::PARAM_STR);
				$stmt->bindParam(':mercrediAM', $this->mercrediAM, PDO::PARAM_STR);
				$stmt->bindParam(':jeudiMatin', $this->jeudiMatin, PDO::PARAM_STR);
				$stmt->bindParam(':jeudiAM', $this->jeudiAM, PDO::PARAM_STR);
				$stmt->bindParam(':vendrediMatin', $this->vendrediMatin, PDO::PARAM_STR);
				$stmt->bindParam(':vendrediAM', $this->vendrediAM, PDO::PARAM_STR);
				$stmt->bindParam(':samediMatin', $this->samediMatin, PDO::PARAM_STR);
				$stmt->bindParam(':samediAM', $this->samediAM, PDO::PARAM_STR);
				$stmt->bindParam(':dimancheMatin', $this->dimancheMatin, PDO::PARAM_STR);
				$stmt->bindParam(':dimancheAM', $this->dimancheAM, PDO::PARAM_STR);

				$stmt->execute();

				$stmt = $bdd->prepare("SELECT MAX(:id_schedules) FROM `schedules`");
				$stmt->bindParam(':id_schedules', $this->id_schedules, PDO::PARAM_INT);

				$stmt->execute();

				$this->insertSchedules = intval($stmt->fetchColumn());
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$insertSchedules'] = $this->insertSchedules;
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch (PDOException $e){
					
				if($_SESSION['debug']['monolog']){
					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return $this->insertSchedules;
		}

		//-----------------------------------------------------------------------
		private $updateSchedules = false;
		public function updateSchedules(int $id_schedules):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerSchedules();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'updateSchedules()',
					'$id_schedules' => $id_schedules,
					'$updateSchedules' => $this->updateSchedules
				];
			}
	
			if(self::checkIdSchedules($id_schedules)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare('UPDATE `schedules`

											  SET `lundiMatin` =  :lundiMatin,
												  `lundiAM` =  :lundiAM,
											      `mardiMatin` = :mardiMatin,
												  `mardiAM` =  :mardiAM,
												  `mercrediMatin` =  :mercrediMatin,
												  `mercrediAM` =  :mercrediAM,
												  `jeudiMatin` =  :jeudiMatin,
												  `jeudiAM` =  :jeudiAM,
												  `vendrediMatin` =  :vendrediMatin,
												  `vendrediAM` =  :vendrediAM ,
												  `samediMatin` =  :samediMatin,
												  `samediAM` =  :samediAM,
												  `dimancheMatin` =  :dimancheMatin,
												  `dimancheAM` =  :dimancheAM

											WHERE `id_schedules` = :id_schedules
										');
								
					$stmt->bindParam(':lundiMatin', $this->lundiMatin, PDO::PARAM_STR);
					$stmt->bindParam(':lundiAM', $this->lundiAM, PDO::PARAM_STR);
					$stmt->bindParam(':mardiMatin', $this->mardiMatin, PDO::PARAM_STR);
					$stmt->bindParam(':mardiAM', $this->mardiAM, PDO::PARAM_STR);
					$stmt->bindParam(':mercrediMatin', $this->mercrediMatin, PDO::PARAM_STR);
					$stmt->bindParam(':mercrediAM', $this->mercrediAM, PDO::PARAM_STR);
					$stmt->bindParam(':jeudiMatin', $this->jeudiMatin, PDO::PARAM_STR);
					$stmt->bindParam(':jeudiAM', $this->jeudiAM, PDO::PARAM_STR);
					$stmt->bindParam(':vendrediMatin', $this->vendrediMatin, PDO::PARAM_STR);
					$stmt->bindParam(':vendrediAM', $this->vendrediAM, PDO::PARAM_STR);
					$stmt->bindParam(':samediMatin', $this->samediMatin, PDO::PARAM_STR);
					$stmt->bindParam(':samediAM', $this->samediAM, PDO::PARAM_STR);
					$stmt->bindParam(':dimancheMatin', $this->dimancheMatin, PDO::PARAM_STR);
					$stmt->bindParam(':dimancheAM', $this->dimancheAM, PDO::PARAM_STR);
					$stmt->bindParam(':id_schedules', $id_schedules, PDO::PARAM_INT);

					$stmt->execute();

					$this->updateSchedules = true;
						
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$updateSchedules'] = $this->updateSchedules;
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

			return $this->updateSchedules;
		}

		//-----------------------------------------------------------------------

		private $deleteSchedules = false;
		public function deleteSchedules(int $id_schedules):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerSchedules();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deleteSchedules()',
					'$id_schedules' => $id_schedules,
					'$deleteSchedules' => $this->deleteSchedules
				];
			}
	
			if(self::checkIdSchedules($id_schedules)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare('DELETE FROM schedules WHERE id_schedules = :id_schedules');
					
					$stmt->bindParam(':id_schedules', $id_schedules, PDO::PARAM_INT);

					$stmt->execute();

					$this->deleteSchedules = true;

					if($_SESSION['debug']['monolog']){
						$arrayLogger['$deleteSchedules'] = self::$deleteSchedules;
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

			return $this->deleteSchedules;
		}

		//-----------------------------------------------------------------------

		private static $checkIdSchedules = false;
		public static function checkIdSchedules(int $id_schedules):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerSchedules();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdSchedules()',
					'$id_schedules' => $id_schedules,
					'$checkIdSchedules' => self::$checkIdSchedules
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare('SELECT COUNT(*) FROM `schedules` WHERE `id_schedules` = :id_schedules');
				$stmt->bindParam(':id_schedules', $id_schedules, PDO::PARAM_INT);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdSchedules = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdSchedules'] = self::$checkIdSchedules;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkIdSchedules;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerSchedules()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Schedules');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/GarageParrot.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerSchedules()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Schedules');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/GarageParrot.log', Logger::DEBUG));
			}
		}

	}
	
?>