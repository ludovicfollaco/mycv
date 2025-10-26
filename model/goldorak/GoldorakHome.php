<?php
	//GoldorakHome.php
	//Author: Ludovic FOLLACO
	//checked to 2024-10-16_14:22
	namespace Model\GoldorakHome;

	use \PDO;
	use \PDOException;
	use Model\DbConnect\DbConnect;
	use Model\Utilities\Utilities;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class GoldorakHome
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct()
		{
			if($_SESSION['debug']['monolog']){
				$this->initLoggerHome();
			}
		}

		private $id_home;
		public function getId():int{
			return $this->id_home;
		}
		public function setId(int $new):void{
			$this->id_home = $new;
		}

		//-----------------------------------------------------------------------

		private $titre1;
		public function getTitre1():string{
			return $this->titre1;
		}
		public function setTitre1(string $new):void{
			$this->titre1 = $new;
		}

		//-----------------------------------------------------------------------

		private $titre_chapter1;
		public function getTitre_chapter1():string{
			return $this->titre_chapter1;
		}
		public function setTitre_chapter1(string $new):void{
			$this->titre_chapter1 = $new;
		}

		//-----------------------------------------------------------------------

		private $chapter1;
		public function getChapter1():string{
			return $this->chapter1;
		}
		public function setChapter1(string $new):void{
			$this->chapter1 = $new;
		}

		//-----------------------------------------------------------------------

		private $img_chapter1;
		public function getImg_chapter1():string{
			return $this->img_chapter1;
		}
		public function setImg_chapter1(string $new):void{
			$this->img_chapter1 = $new;
		}

		//-----------------------------------------------------------------------

		private $titre_chapter2;
		public function getTitre_chapter2():string{
			return $this->titre_chapter2;
		}
		public function setTitre_chapter2(string $new):void{
			$this->titre_chapter2 = $new;
		}

		//-----------------------------------------------------------------------

		private $chapter2;
		public function getChapter2():string{
			return $this->chapter2;
		}
		public function setChapter2(string $new):void{
			$this->chapter2 = $new;
		}

		//-----------------------------------------------------------------------

		private $img_chapter2;
		public function getImg_chapter2():string{
			return $this->img_chapter2;
		}
		public function setImg_chapter2(string $new):void{
			$this->img_chapter2 = $new;
		}

		//-----------------------------------------------------------------------

		private $getHome = array();
		public function getHome(int $id_home):array{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerHome();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getHome()',
					'$id_home' => $id_home,
					'$getHome' => $this->getHome
				];
			}
	
			if(self::checkIdHome($id_home)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				
				try{
					$stmt = $bdd->prepare("SELECT
												`home`.`id_home`,
												`home`.`titre1`,
												`home`.`titre_chapter1`,
												`home`.`chapter1`,
												`home`.`img_chapter1`,
												`home`.`titre_chapter2`,
												`home`.`chapter2`,
												`home`.`img_chapter2`
											FROM `home`
											WHERE `home`.`id_home` = :id_home");

					$stmt->bindParam(':id_home', $id_home, PDO::PARAM_INT);

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
		public function getHomeList(string $whereClause, string $orderBy = 'id_home', string $ascOrDesc = 'ASC', int $firstLine = 0, int $linePerPage = 13):array{

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
											`home`.`id_home`,
											`home`.`titre1`,
											`home`.`titre_chapter1`,
											`home`.`chapter1`,
											`home`.`img_chapter1`,
											`home`.`titre_chapter2`,
											`home`.`chapter2`,
											`home`.`img_chapter2`
										FROM `home`
										WHERE :whereClause
										ORDER BY :orderBy :ascOrDesc
										LIMIT :firstLine, :linePerPage");

				$stmt->bindParam(':whereClause', $whereClause, PDO::PARAM_STR);
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
		public function updateHome(int $id_home):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerHome();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'updateHome()',
					'$id_home' => $id_home,
					'$updateHome' => $this->updateHome
				];
			}
	
			if(self::checkIdHome($id_home)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare("UPDATE `home`
											SET `titre1` = :titre1,
												`titre_chapter1` = :titre_chapter1,
												`chapter1` = :chapter1,
												`img_chapter1` = :img_chapter1,
												`titre_chapter2` = :titre_chapter2,
												`chapter2` = :chapter2,
												`img_chapter2` = :img_chapter2
												
											WHERE `id_home` = :id_home");
					
					$stmt->bindParam(':titre1', $this->titre1, PDO::PARAM_STR);
					$stmt->bindParam(':titre_chapter1', $this->titre_chapter1, PDO::PARAM_STR);
					$stmt->bindParam(':chapter1', $this->chapter1, PDO::PARAM_STR);
					$stmt->bindParam(':img_chapter1', $this->img_chapter1, PDO::PARAM_STR);
					$stmt->bindParam(':titre_chapter2', $this->titre_chapter2, PDO::PARAM_STR);
					$stmt->bindParam(':chapter2', $this->chapter2, PDO::PARAM_STR);
					$stmt->bindParam(':img_chapter2', $this->img_chapter2, PDO::PARAM_STR);
					$stmt->bindParam(':id_home', $id_home, PDO::PARAM_INT);

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
		public function deleteHome(int $id_home):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerHome();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deleteHome()',
					'$id_home' => $id_home,
					'$deleteHome' => $this->deleteHome
				];
			}
	
			if(self::checkIdHome($id_home)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				
				try{
					$stmt = $bdd->prepare('DELETE FROM home WHERE id_home = :id_home');
					$stmt->bindParam(':id_home', $id_home, PDO::PARAM_INT);
					$stmt->execute();

					$this->deleteHome = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$deleteHome'] = $this->deleteHome;
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

			return $this->deleteHome;
		}

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
				$stmt = $bdd->prepare("INSERT INTO `home` (`titre1`,
															`titre_chapter1`,
															`chapter1`,
															`img_chapter1`,
															`titre_chapter2`,
															`chapter2`,
															`img_chapter2`) 
										VALUES (:titre1,
												:titreChapter1,
												:chapter1,
												:imgChapter1,
												:titreChapter2,
												:chapter2,
												:imgChapter2)");
	
				$stmt->bindParam(':titre1', $this->titre1, PDO::PARAM_STR);
				$stmt->bindParam(':titreChapter1', $this->titre_chapter1, PDO::PARAM_STR);
				$stmt->bindParam(':chapter1', $this->chapter1, PDO::PARAM_STR);
				$stmt->bindParam(':imgChapter1', $this->img_chapter1, PDO::PARAM_STR);
				$stmt->bindParam(':titreChapter2', $this->titre_chapter2, PDO::PARAM_STR);
				$stmt->bindParam(':chapter2', $this->chapter2, PDO::PARAM_STR);
				$stmt->bindParam(':imgChapter2', $this->img_chapter2, PDO::PARAM_STR);
	
				$stmt->execute();

				$stmt = $bdd->prepare("SELECT MAX(`id_home`) FROM `home`");
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
		public static function checkIdHome(int $id_home):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerHome();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdHome()',
					'$id_home' => $id_home,
					'$checkIdHome' => self::$checkIdHome
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `home` WHERE `id_home` = :id_home");
				$stmt->bindParam(':id_home', $id_home, PDO::PARAM_STR);

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
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/Goldorak.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerHome()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Home');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/Goldorak.log', Logger::DEBUG));
			}
		}
	}
	
?>