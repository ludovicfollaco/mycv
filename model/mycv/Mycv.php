<?php
	//Mycv.php
	//Author: Ludovic FOLLACO
	//checked to 2024-10-16_14:04
	namespace Model\Mycv;

	use \PDO;
	use \PDOException;
	use Model\DbConnect\DbConnect;
	use Model\Experience\Experience;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class Mycv extends Experience
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct()
		{
			if($_SESSION['debug']['monolog']){
				$this->initLoggerMycv();
			}
		}

		private $mycvId;
		public function getMycvId():int{
			return $this->mycvId;
		}
		public function setMycvId(int $new):void{
			$this->mycvId = $new;
		}

		//-----------------------------------------------------------------------

		private $mycvTitle;
		public function getMycvTitle():string{
			return $this->mycvTitle;
		}
		public function setMycvTitle(string $new):void{
			$this->mycvTitle = $new;
		}

		//-----------------------------------------------------------------------

		private $mycvSubtitle;
		public function getMycvSubtitle():string{
			return $this->mycvSubtitle;
		}
		public function setMycvSubtitle($new):void{
			$this->mycvSubtitle = $new;
		}

		//-----------------------------------------------------------------------

		private $mycvTitlePage;
		public function getMycvTitlePage():string{
			return $this->mycvTitlePage;
		}
		public function setMycvTitlePage(string $new):void{
			$this->mycvTitlePage = $new;
		}

		//-----------------------------------------------------------------------

		private $getMycv = array();
		public function getMycv(int $mycv_id):array{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerMycv();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getMycv()',
					'$mycv_id' => $mycv_id,
					'$getMycv' => $this->getMycv
				];
			}
	
			if(self::checkIdMycv($mycv_id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				
				try{
					$stmt = $bdd->prepare('SELECT `mycv`.`mycv_id`,
												  `mycv`.`mycv_title`,
												  `mycv`.`mycv_subtitle`,
												  `mycv`.`mycv_title_page`
											FROM  `mycv`
											WHERE `mycv`.`mycv_id` = :mycv_id');

					$stmt->bindParam(':mycv_id', $mycv_id, PDO::PARAM_INT);

					$stmt->execute();

					$this->getMycv = $stmt->fetch(PDO::FETCH_ASSOC);
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$getMycv'] = $this->getMycv;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

					return $this->getMycv;

				}catch (PDOException $e){
					
					if($_SESSION['debug']['monolog']){
						$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
					}
					return [];

				}finally{
					$bdd = null;
				}
			}
		}

		//-----------------------------------------------------------------------

		private $mycvList = array();
		public function getMycvList(string $whereClause, string $orderBy = 'mycv_id', string $ascOrDesc = 'ASC', int $firstLine = 0, int $linePerPage = 13):array{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerMycv();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getMycvList()',
					'$whereClause' => $whereClause,
					'$orderBy' => $orderBy,
					'$ascOrDesc' => $ascOrDesc,
					'$firstLine' => $firstLine,
					'$linePerPage' => $linePerPage,
					'$mycvList' => $this->mycvList
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT
											`mycv`.`mycv_id`,
											`mycv`.`mycv_title`,
											`mycv`.`mycv_subtitle`,
											`mycv`.`mycv_title_page`

										FROM `mycv`

										WHERE $whereClause
										ORDER BY :orderBy :ascOrDesc
										LIMIT :firstLine, :linePerPage");

				$stmt->bindParam(':orderBy', $orderBy, PDO::PARAM_STR);
				$stmt->bindParam(':ascOrDesc', $ascOrDesc, PDO::PARAM_STR);
				$stmt->bindParam(':firstLine', $firstLine, PDO::PARAM_INT);
				$stmt->bindParam(':linePerPage', $linePerPage, PDO::PARAM_INT);

				$stmt->execute();

				$this->mycvList = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$mycvList'] = true; //$this->mycvList; replace true; by $this->mycvList; if you want to see the result
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

				return $this->mycvList;

			}catch (PDOException $e){
					
				if($_SESSION['debug']['monolog']){
					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}
				return [];

			}finally{
				$bdd = null;
			}
		}

		//-----------------------------------------------------------------------
		private $updateMycv = false;
		public function updateMycv(int $mycv_id):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerMycv();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'updateMycv()',
					'$mycv_id' => $mycv_id,
					'$updateMycv' => $this->updateMycv
				];
			}
	
			if(self::checkIdMycv($mycv_id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare("UPDATE `mycv`
											SET `mycv_title` = :mycvTitle,
												`mycv_subtitle` = :mycvSubtitle,
												`mycv_title_page` = :mycvTitlePage
												
											WHERE `mycv_id` = :mycv_id");
					
					$stmt->bindParam(':mycvTitle', $this->mycvTitle, PDO::PARAM_STR);
					$stmt->bindParam(':mycvSubtitle', $this->mycvSubtitle, PDO::PARAM_STR);
					$stmt->bindParam(':mycvTitlePage', $this->mycvTitlePage, PDO::PARAM_STR);
					$stmt->bindParam(':mycv_id', $mycv_id, PDO::PARAM_INT);
					
					$stmt->execute();

					$this->updateMycv = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$updateMycv'] = $this->updateMycv;
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

			return $this->updateMycv;
		}

		//-----------------------------------------------------------------------
		private $deleteMycv = false;
		public function deleteMycv(int $mycv_id):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerMycv();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deleteMycv()',
					'$mycv_id' => $mycv_id,
					'$deleteMycv' => $this->deleteMycv
				];
			}
	
			if(self::checkIdMycv($mycv_id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				
				try{
					$stmt = $bdd->prepare('DELETE FROM mycv WHERE mycv_id = :mycv_id');
					$stmt->bindParam(':mycv_id', $mycv_id, PDO::PARAM_INT);
					$stmt->execute();

					$this->deleteMycv = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$deleteMycv'] = $this->deleteMycv;
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

			return $this->deleteMycv;
		}

		//-----------------------------------------------------------------------
		
		private $insertMycv = 0;
		public function insertMycv():int{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerMycv();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'insertMycv()',
					'$insertMycv' => $this->insertMycv
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
	
			try{
				$stmt = $bdd->prepare("INSERT INTO `mycv` (`mycv_title`,
															`mycv_subtitle`,
															`mycv_title_page`) 
										VALUES (:mycv_title,
												:mycv_subtitle,
												:mycv_title_page)");
	
				$stmt->bindParam(':mycv_title', $this->mycvTitle, PDO::PARAM_STR);
				$stmt->bindParam(':mycv_subtitle', $this->mycvSubtitle, PDO::PARAM_STR);
				$stmt->bindParam(':mycv_title_page', $this->mycvTitlePage, PDO::PARAM_STR);
	
				$stmt->execute();

				$stmt = $bdd->prepare("SELECT MAX(`mycv_id`) FROM `mycv`");
				$stmt->execute();

				$this->insertMycv = intval($stmt->fetchColumn());

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$insertMycv'] = $this->insertMycv;
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch (PDOException $e){

				if($_SESSION['debug']['monolog']){
					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd = null;
			}

			return $this->insertMycv;
		}

		//-----------------------------------------------------------------------

		private static $checkIdMycv = false;
		public static function checkIdMycv(int $mycv_id):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerMycv();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdMycv()',
					'$mycv_id' => $mycv_id,
					'$checkIdMycv' => self::$checkIdMycv
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `mycv` WHERE `mycv_id` = :mycv_id");
				$stmt->bindParam(':mycv_id', $mycv_id, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdMycv = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdMycv'] = self::$checkIdMycv;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkIdMycv;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerMycv()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Mycv');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/MyCv.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerMycv()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Mycv');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/MyCv.log', Logger::DEBUG));
			}
		}
	}
?>