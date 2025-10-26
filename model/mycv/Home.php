<?php
	//Home.php
	//Author: Ludovic FOLLACO
	//checked to 2024-10-16_14:04
	namespace Model\Home;

	use \PDO;
	use \PDOException;
	use Model\DbConnect\DbConnect;
	use Model\Article\Article;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class Home extends Article
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct()
		{
			if($_SESSION['debug']['monolog']){
				$this->initLoggerHome();
			}
		}

		private $homeId;
		public function getHomeId():int{
			return $this->homeId;
		}
		public function setHomeId(int $new):void{
			$this->homeId = $new;
		}

		//-----------------------------------------------------------------------

		private $homeTitle;
		public function getHomeTitle():string{
			return $this->homeTitle;
		}
		public function setHomeTitle(string $new):void{
			$this->homeTitle = $new;
		}

		//-----------------------------------------------------------------------

		private $homeSubtitle;
		public function getHomeSubtitle():string{
			return $this->homeSubtitle;
		}
		public function setHomeSubtitle($new):void{
			$this->homeSubtitle = $new;
		}

		//-----------------------------------------------------------------------

		private $homeTitlePage;
		public function getHomeTitlePage():string{
			return $this->homeTitlePage;
		}
		public function setHomeTitlePage(string $new):void{
			$this->homeTitlePage = $new;
		}

		//-----------------------------------------------------------------------

		private $getHome = array();
		public function getHome(int $home_id):array{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerHome();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getHome()',
					'$home_id' => $home_id,
					'$getHome' => $this->getHome
				];
			}
	
			if(self::checkIdHome($home_id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				
				try{
					$stmt = $bdd->prepare('SELECT `home`.`home_id`,
												  `home`.`home_title`,
												  `home`.`home_subtitle`,
												  `home`.`home_title_page`
											FROM  `home`
											WHERE `home`.`home_id` = :home_id');

					$stmt->bindParam(':home_id', $home_id, PDO::PARAM_INT);

					$stmt->execute();

					$this->getHome = $stmt->fetch(PDO::FETCH_ASSOC);
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$getHome'] = $this->getHome;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

					return $this->getHome;

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

		private $homeList = array();
		public function getHomeList(string $whereClause, string $orderBy = 'home_id', string $ascOrDesc = 'ASC', int $firstLine = 0, int $linePerPage = 13):array{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerHome();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getHomeList()',
					'$whereClause' => $whereClause,
					'$orderBy' => $orderBy,
					'$ascOrDesc' => $ascOrDesc,
					'$firstLine' => $firstLine,
					'$linePerPage' => $linePerPage,
					'$homeList' => $this->homeList
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT
											`home`.`home_id`,
											`home`.`home_title`,
											`home`.`home_subtitle`,
											`home`.`home_title_page`

										FROM `home`

										WHERE $whereClause
										ORDER BY :orderBy :ascOrDesc
										LIMIT :firstLine, :linePerPage");

				$stmt->bindParam(':orderBy', $orderBy, PDO::PARAM_STR);
				$stmt->bindParam(':ascOrDesc', $ascOrDesc, PDO::PARAM_STR);
				$stmt->bindParam(':firstLine', $firstLine, PDO::PARAM_INT);
				$stmt->bindParam(':linePerPage', $linePerPage, PDO::PARAM_INT);

				$stmt->execute();

				$this->homeList = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$homeList'] = true; //$this->homeList; replace true; by $this->homeList; if you want to see the result
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

				return $this->homeList;

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
		private $updateHome = false;
		public function updateHome(int $home_id):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerHome();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'updateHome()',
					'$home_id' => $home_id,
					'$updateHome' => $this->updateHome
				];
			}
	
			if(self::checkIdHome($home_id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare("UPDATE `home`
											SET `home_title` = :homeTitle,
												`home_subtitle` = :homeSubtitle,
												`home_title_page` = :homeTitlePage
												
											WHERE `home_id` = :home_id");
					
					$stmt->bindParam(':homeTitle', $this->homeTitle, PDO::PARAM_STR);
					$stmt->bindParam(':homeSubtitle', $this->homeSubtitle, PDO::PARAM_STR);
					$stmt->bindParam(':homeTitlePage', $this->homeTitlePage, PDO::PARAM_STR);
					$stmt->bindParam(':home_id', $home_id, PDO::PARAM_INT);
					
					$stmt->execute();

					$this->updateHome = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$updateHome'] = $this->updateHome;
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

			return $this->updateHome;
		}

		//-----------------------------------------------------------------------
		private $deleteHome = false;
		public function deleteHome(int $home_id):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerHome();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deleteHome()',
					'$home_id' => $home_id,
					'$deleteHome' => $this->deleteHome
				];
			}
	
			if(self::checkIdHome($home_id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				
				try{
					$stmt = $bdd->prepare('DELETE FROM home WHERE home_id = :home_id');
					$stmt->bindParam(':home_id', $home_id, PDO::PARAM_INT);
					$stmt->execute();

					$this->deleteHome = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$deleteHome'] = $this->deleteHome;
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

			return $this->deleteHome;
		}

		//-----------------------------------------------------------------------
		
		private $insertHome = 0;
		public function insertHome():int{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerHome();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'insertHome()',
					'$insertHome' => $this->insertHome
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
	
			try{
				$stmt = $bdd->prepare("INSERT INTO `home` (`home_title`,
															`home_subtitle`,
															`home_title_page`) 
										VALUES (:home_title,
												:home_subtitle,
												:home_title_page)");
	
				$stmt->bindParam(':home_title', $this->homeTitle, PDO::PARAM_STR);
				$stmt->bindParam(':home_subtitle', $this->homeSubtitle, PDO::PARAM_STR);
				$stmt->bindParam(':home_title_page', $this->homeTitlePage, PDO::PARAM_STR);
	
				$stmt->execute();

				$stmt = $bdd->prepare("SELECT MAX(`home_id`) FROM `home`");
				$stmt->execute();

				$this->insertHome = intval($stmt->fetchColumn());

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$insertHome'] = $this->insertHome;
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch (PDOException $e){

				if($_SESSION['debug']['monolog']){
					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd = null;
			}

			return $this->insertHome;
		}

		//-----------------------------------------------------------------------

		private static $checkIdHome = false;
		public static function checkIdHome(int $home_id):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerHome();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdHome()',
					'$home_id' => $home_id,
					'$checkIdHome' => self::$checkIdHome
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `home` WHERE `home_id` = :home_id");
				$stmt->bindParam(':home_id', $home_id, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdHome = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdHome'] = self::$checkIdHome;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkIdHome;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerHome()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Home');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/MyCv.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerHome()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Home');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/MyCv.log', Logger::DEBUG));
			}
		}
	}
?>