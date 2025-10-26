<?php
	//Experience.php
	//Author: Ludovic FOLLACO
	//checked to 2024-10-16_13:45
	namespace Model\Experience;

	use \PDO;
	use \PDOException;
	use Model\DbConnect\DbConnect;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class Experience
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct()
		{
			if($_SESSION['debug']['monolog']){
				$this->initLoggerExperience();
			}
		}

		private $experienceId;
		public function getId():int{
			return $this->experienceId;
		}
		public function setId(int $new):void{
			$this->experienceId = $new;
		}

		//-----------------------------------------------------------------------

		private $job;
		public function getjob():string{
			return $this->job;
		}
		public function setjob(string $new):void{
			$this->job = $new;
		}

		//-----------------------------------------------------------------------

		private $logo;
		public function getLogo():string{
			return $this->logo;
		}
		public function setLogo(string $new):void{
			$this->logo = $new;
		}

		//-----------------------------------------------------------------------

		private $company;
		public function getCompany():string{
			return $this->company;
		}
		public function setCompany(string $new):void{
			$this->company = $new;
		}

		//-----------------------------------------------------------------------

		private $contract;
		public function getContract():string{
			return $this->contract;
		}
		public function setContract(string $new):void{
			$this->contract = $new;
		}

		//-----------------------------------------------------------------------

		private $start;
		public function getStart():string{
			return $this->start;
		}
		public function setStart(string $new):void{
			$this->start = $new;
		}

		//-----------------------------------------------------------------------

		private $end;
		public function getEnd():string{
			return $this->end;
		}
		public function setEnd(string $new):void{
			$this->end = $new;
		}

		//-----------------------------------------------------------------------

		private $place;
		public function getPlace():string{
			return $this->place;
		}
		public function setPlace(string $new):void{
			$this->place = $new;
		}
		
		//-----------------------------------------------------------------------

		private $experience;
		public function getExperience():string{
			return $this->experience;
		}
		public function setExperience(string $new):void{
			$this->experience = $new;
		}

		//-----------------------------------------------------------------------

		private $imgPrefix;
		public function getImgPrefix():string{
			return $this->imgPrefix;
		}
		public function setImgPrefix(string $new):void{
			$this->imgPrefix = $new;
		}

		//-----------------------------------------------------------------------

		private $imgYesOrNo;
		public function getImgYesOrNo():string{
			return $this->imgYesOrNo;
		}
		public function setImgYesOrNo(string $new):void{
			$this->imgYesOrNo = $new;
		}

		//-----------------------------------------------------------------------

		private $imgRightOrLeft;
		public function getImgRightOrLeft():string{
			return $this->imgRightOrLeft;
		}
		public function setImgRightOrLeft(string $new):void{
			$this->imgRightOrLeft = $new;
		}

		//-----------------------------------------------------------------------

		private $imgWidth;
		public function getImgWidth():string{
			return $this->imgWidth;
		}
		public function setImgWidth(string $new):void{
			$this->imgWidth = $new;
		}

		//-----------------------------------------------------------------------

		private $imgHeight;
		public function getImgHeight():string{
			return $this->imgHeight;
		}
		public function setImgHeight(string $new):void{
			$this->imgHeight = $new;
		}

		//-----------------------------------------------------------------------

		private $imgObjectFit;
		public function getImgObjectFit():string{
			return $this->imgObjectFit;
		}
		public function setImgObjectFit(string $new):void{
			$this->imgObjectFit = $new;
		}

		//-----------------------------------------------------------------------

		private $background;
		public function getBackground():string{
			return $this->background;
		}
		public function setBackground(string $new):void{
			$this->background = $new;
		}

		//-----------------------------------------------------------------------

		private $sort;
		public function getSort():string{
			return $this->sort;
		}
		public function setSort(string $new):void{
			$this->sort = $new;
		}

		//-----------------------------------------------------------------------

		private $getCurrentExperience = array();
		public function getCurrentExperience(int $id):array{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerExperience();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCurrentExperience()',
					'$id' => $id,
					'$getCurrentExperience' => $this->getCurrentExperience
				];
			}
	
			if(self::checkIdExperience($id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				
				try{
					$stmt = $bdd->prepare("SELECT
												`experience`.`id`,
												`experience`.`job`,
												`experience`.`logo`,
												`experience`.`company`,
												`experience`.`contract`,
												`experience`.`start`,
												`experience`.`end`,
												`experience`.`place`,
												`experience`.`experience`,
												`experience`.`img`,
												`experience`.`img_yesOrNo`,
												`experience`.`img_rightOrLeft`,
												`experience`.`img_width`,
												`experience`.`img_height`,
												`experience`.`img_objectFit`,
												`experience`.`background`,
												`experience`.`sort`
											FROM `experience`
											WHERE `experience`.`id` = :id");

					$stmt->bindParam(':id', $id, PDO::PARAM_INT);

					$stmt->execute();

					$this->getCurrentExperience = $stmt->fetch(PDO::FETCH_ASSOC);
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$getCurrentExperience'] = $this->getCurrentExperience;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}
					
					return $this->getCurrentExperience;
				
				}catch (PDOException $e){
					
					if($_SESSION['debug']['monolog']){
						$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
					}
					return[];

				}finally{
					$bdd = null;
				}
			}
		}

		//-----------------------------------------------------------------------

		private $getList = array();
		public function getList(string $whereClause, string $orderBy = 'sort', string $ascOrDesc = 'ASC', int $firstLine = 0, int $linePerPage = 13):array{
			
			if($_SESSION['debug']['monolog']){
				$this->initLoggerExperience();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getList()',
					'$whereClause' => $whereClause,
					'$orderBy' => $orderBy,
					'$ascOrDesc' => $ascOrDesc,
					'$firstLine' => $firstLine,
					'$linePerPage' => $linePerPage,
					'$getList' => $this->getList
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try
			{
				$stmt = $bdd->prepare("SELECT
											`experience`.`id`,
											`experience`.`job`,
											`experience`.`logo`,
											`experience`.`company`,
											`experience`.`contract`,
											`experience`.`start`,
											`experience`.`end`,
											`experience`.`place`,
											`experience`.`experience`,
											`experience`.`img`,
											`experience`.`img_yesOrNo`,
											`experience`.`img_rightOrLeft`,
											`experience`.`img_width`,
											`experience`.`img_height`,
											`experience`.`img_objectFit`,
											`experience`.`background`,
											`experience`.`sort`
										FROM `experience`
										WHERE $whereClause
										ORDER BY $orderBy $ascOrDesc /*:orderBy :ascOrDesc*/
										LIMIT :firstLine, :linePerPage");

				//$stmt->bindParam(':orderBy', $orderBy, PDO::PARAM_STR);
				//$stmt->bindParam(':ascOrDesc', $ascOrDesc, PDO::PARAM_STR);
				$stmt->bindParam(':firstLine', $firstLine, PDO::PARAM_INT);
				$stmt->bindParam(':linePerPage', $linePerPage, PDO::PARAM_INT);

				$stmt->execute();

				$this->getList = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$getList'] = true; //$this->getList; // replace true; by $this->getList; if you want to see the result
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

				return $this->getList;

			}catch (PDOException $e){
					
				if($_SESSION['debug']['monolog']){
					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}
				return[];

			}finally{
				$bdd = null;
			}
		}

		//-----------------------------------------------------------------------

		private $updateExperience = false;
		public function updateExperience(int $id):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerExperience();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'updateExperience()',
					'$id' => $id,
					'$updateExperience' => $this->updateExperience
				];
			}
	
			if(self::checkIdExperience($id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare("UPDATE `experience`
											SET `job` = :job,
												`logo` = :logo,
												`company` = :company,
												`contract` = :contract,
												`start` = :start,
												`end` = :end,
												`place` = :place,
												`experience` = :experience,
												`img` = :imgPrefix,
												`img_yesOrNo` = :imgYesOrNo,
												`img_rightOrLeft` = :imgRightOrLeft,
												`img_width` = :imgWidth,
												`img_height` = :imgHeight,
												`img_objectFit` = :imgObjectFit,
												`background` = :background,
												`sort` = :sort
												
											WHERE `id` = :id");
					
					$stmt->bindParam(':job', $this->job, PDO::PARAM_STR);
					$stmt->bindParam(':logo', $this->logo, PDO::PARAM_STR);
					$stmt->bindParam(':company', $this->company, PDO::PARAM_STR);
					$stmt->bindParam(':contract', $this->contract, PDO::PARAM_STR);
					$stmt->bindParam(':start', $this->start, PDO::PARAM_STR);
					$stmt->bindParam(':end', $this->end, PDO::PARAM_STR);
					$stmt->bindParam(':place', $this->place, PDO::PARAM_STR);
					$stmt->bindParam(':experience', $this->experience, PDO::PARAM_STR);
					$stmt->bindParam(':imgPrefix', $this->imgPrefix, PDO::PARAM_STR);
					$stmt->bindParam(':imgYesOrNo', $this->imgYesOrNo, PDO::PARAM_STR);
					$stmt->bindParam(':imgRightOrLeft', $this->imgRightOrLeft, PDO::PARAM_STR);
					$stmt->bindParam(':imgWidth', $this->imgWidth, PDO::PARAM_STR);
					$stmt->bindParam(':imgHeight', $this->imgHeight, PDO::PARAM_STR);
					$stmt->bindParam(':imgObjectFit', $this->imgObjectFit, PDO::PARAM_STR);
					$stmt->bindParam(':background', $this->background, PDO::PARAM_STR);
					$stmt->bindParam(':sort', $this->sort, PDO::PARAM_STR);
					$stmt->bindParam(':id', $id, PDO::PARAM_INT);
					
					$stmt->execute();

					$this->updateExperience = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$updateExperience'] = $this->updateExperience;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}
					
				}catch (PDOException $e){

					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);

				}finally{
					$bdd = null;
				}
			}

			return $this->updateExperience;
		}

		//-----------------------------------------------------------------------

		private $deleteExperience = false;
		public function deleteExperience(int $id):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerExperience();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deleteExperience()',
					'$id' => $id,
					'$deleteExperience' => $this->deleteExperience
				];
			}
	
			if(self::checkIdExperience($id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				
				try{
					$stmt = $bdd->prepare('DELETE FROM experience WHERE id = :id');
					$stmt->bindParam(':id', $id, PDO::PARAM_INT);

					$stmt->execute();

					$this->deleteExperience = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$deleteExperience'] = $this->deleteExperience;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

				}catch (PDOException $e){
					
					if($_SESSION['debug']['monolog']){
						$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
					}

				}finally{
					$bdd = null;
				}
			}

			return $this->deleteExperience;
		}

		//-----------------------------------------------------------------------
		private $insertExperience = 0;
		public function insertExperience():int{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerExperience();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'insertExperience()',
					'$insertExperience' => $this->insertExperience
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
	
			try
			{
				$stmt = $bdd->prepare("INSERT INTO `experience` (`job`,
																`logo`,
																`company`,
																`contract`,
																`start`,
																`end`,
																`place`,
																`experience`,
																`img`,
																`img_yesOrNo`,
																`img_rightOrLeft`,
																`img_width`,
																`img_height`,
																`img_objectFit`,
																`background`,
																`sort`) 
										VALUES (:job,
												:logo,
												:company,
												:contract,
												:start,
												:end,
												:place,
												:experience,
												:imgPrefix,
												:imgYesOrNo,
												:imgRightOrLeft,
												:imgWidth,
												:imgHeight,
												:imgObjectFit,
												:background,
												:sort)");
	
				$stmt->bindParam(':job', $this->job, PDO::PARAM_STR);
				$stmt->bindParam(':logo', $this->logo, PDO::PARAM_STR);
				$stmt->bindParam(':company', $this->company, PDO::PARAM_STR);
				$stmt->bindParam(':contract', $this->contract, PDO::PARAM_STR);
				$stmt->bindParam(':start', $this->start, PDO::PARAM_STR);
				$stmt->bindParam(':end', $this->end, PDO::PARAM_STR);
				$stmt->bindParam(':place', $this->place, PDO::PARAM_STR);
				$stmt->bindParam(':experience', $this->experience, PDO::PARAM_STR);
				$stmt->bindParam(':imgPrefix', $this->imgPrefix, PDO::PARAM_STR);
				$stmt->bindParam(':imgYesOrNo', $this->imgYesOrNo, PDO::PARAM_STR);
				$stmt->bindParam(':imgRightOrLeft', $this->imgRightOrLeft, PDO::PARAM_STR);
				$stmt->bindParam(':imgWidth', $this->imgWidth, PDO::PARAM_STR);
				$stmt->bindParam(':imgHeight', $this->imgHeight, PDO::PARAM_STR);
				$stmt->bindParam(':imgObjectFit', $this->imgObjectFit, PDO::PARAM_STR);
				$stmt->bindParam(':background', $this->imgObjectFit, PDO::PARAM_STR);
				$stmt->bindParam(':sort', $this->sort, PDO::PARAM_STR);
					
				$stmt->execute();

				$stmt = $bdd->prepare("SELECT MAX(`id`) FROM `experience`");
				$stmt->execute();

				$this->insertExperience = intval($stmt->fetchColumn());
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$insertExperience'] = $this->insertExperience;
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
					
				if($_SESSION['debug']['monolog']){
					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd = null;
			}
			
			return $this->insertExperience;
		}

		//-----------------------------------------------------------------------

		private static $checkIdExperience = false;
		public static function checkIdExperience(int $id):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerExperience();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdExperience()',
					'$id' => $id,
					'$checkIdExperience' => self::$checkIdExperience
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `experience` WHERE `id` = :id");
				$stmt->bindParam(':id', $id, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdExperience = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdExperience'] = self::$checkIdExperience;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkIdExperience;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerExperience()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Experience');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/MyCv.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerExperience()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Experience');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/MyCv.log', Logger::DEBUG));
			}
		}
	}
?>