<?php
	//GpHome.php
	//Author: Ludovic FOLLACO
	//checked to 2024-10-04_17:40
	namespace Model\GpHome;

	use \PDO;
	use \PDOException;
    use Model\DbConnect\DbConnect;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class GpHome
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct(){
			if($_SESSION['debug']['monolog']){
				$this->initLoggerGpHome();
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

		private $intro_chapter1;
		public function getIntro_chapter1():string{
			return $this->intro_chapter1;
		}
		public function setIntro_chapter1(string $new):void{
			$this->intro_chapter1 = $new;
		}

		//-----------------------------------------------------------------------

		private $intro_chapter2;
		public function getIntro_chapter2():string{
			return $this->intro_chapter2;
		}
		public function setIntro_chapter2(string $new):void{
			$this->intro_chapter2 = $new;
		}

		//-----------------------------------------------------------------------

		private $titre2;
		public function getTitre2():string{
			return $this->titre2;
		}
		public function setTitre2(string $new):void{
			$this->titre2 = $new;
		}

		//-----------------------------------------------------------------------

		private $article1_titre;
		public function getArticle1_titre():string{
			return $this->article1_titre;
		}
		public function setArticle1_titre(string $new):void{
			$this->article1_titre = $new;
		}

		//-----------------------------------------------------------------------

		private $article1_chapter1;
		public function getArticle1_chapter1():string{
			return $this->article1_chapter1;
		}
		public function setArticle1_chapter1(string $new):void{
			$this->article1_chapter1 = $new;
		}

		//-----------------------------------------------------------------------

		private $article1_image1;
		public function getArticle1_image1():string{
			return $this->article1_image1;
		}
		public function setArticle1_image1(string $new):void{
			$this->article1_image1 = $new;
		}

		//-----------------------------------------------------------------------

		private $article1_titre2;
		public function getArticle1_titre2():string{
			return $this->article1_titre2;
		}
		public function setArticle1_titre2(string $new):void{
			$this->article1_titre2 = $new;
		}

		//-----------------------------------------------------------------------

		private $article1_chapter2;
		public function getArticle1_chapter2():string{
			return $this->article1_chapter2;
		}
		public function setArticle1_chapter2(string $new):void{
			$this->article1_chapter2 = $new;
		}

		//-----------------------------------------------------------------------

		private $article1_image2;
		public function getArticle1_image2():string{
			return $this->article1_image2;
		}
		public function setArticle1_image2(string $new):void{
			$this->article1_image2 = $new;
		}

		//-----------------------------------------------------------------------

		private $article2_titre;
		public function getArticle2_titre():string{
			return $this->article2_titre;
		}
		public function setArticle2_titre(string $new):void{
			$this->article2_titre = $new;
		}

		//-----------------------------------------------------------------------

		private $article2_chapter1;
		public function getArticle2_chapter1():string{
			return $this->article2_chapter1;
		}
		public function setArticle2_chapter1(string $new):void{
			$this->article2_chapter1 = $new;
		}

		//-----------------------------------------------------------------------

		private $article2_image1;
		public function getArticle2_image1():string{
			return $this->article2_image1;
		}
		public function setArticle2_image1(string $new):void{
			$this->article2_image1 = $new;
		}

		//-----------------------------------------------------------------------

		private $article2_titre2;
		public function getArticle2_titre2():string{
			return $this->article2_titre2;
		}
		public function setArticle2_titre2(string $new):void{
			$this->article2_titre2 = $new;
		}

		//-----------------------------------------------------------------------

		private $article2_chapter2;
		public function getArticle2_chapter2():string{
			return $this->article2_chapter2;
		}
		public function setArticle2_chapter2(string $new):void{
			$this->article2_chapter2 = $new;
		}

		//-----------------------------------------------------------------------

		private $article2_image2;
		public function getArticle2_image2():string{
			return $this->article2_image2;
		}
		public function setArticle2_image2(string $new):void{
			$this->article2_image2 = $new;
		}

		//-----------------------------------------------------------------------

		private $currentHome = array();
		public function getCurrentHome(int $id_home):array{

			$this->initLoggerGpHome();
			if($_SESSION['debug']['monolog']){
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCurrentHome()',
					'$id_home' => $id_home,
					'$currentHome' => $this->currentHome
				];
			}
	
			if(self::checkIdGpHome($id_home)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
				try{
					$stmt = $bdd->prepare("SELECT
											`home`.`id_home`,
											`home`.`titre1`,
											`home`.`intro_chapter1`,
											`home`.`intro_chapter2`,
											`home`.`titre2`,
											`home`.`article1_titre`,
											`home`.`article1_chapter1`,
											`home`.`article1_image1`,
											`home`.`article1_titre2`,
											`home`.`article1_chapter2`,
											`home`.`article1_image2`,
											`home`.`article2_titre`,
											`home`.`article2_chapter1`,
											`home`.`article2_image1`,
											`home`.`article2_titre2`,
											`home`.`article2_chapter2`,
											`home`.`article2_image2`

										FROM `home`

										WHERE `home`.`id_home`=:id_home");

					$stmt->bindParam(':id_home', $id_home, PDO::PARAM_INT);
					$stmt->execute();

					$this->currentHome = $stmt->fetch(PDO::FETCH_ASSOC);
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$currentHome'] = $this->currentHome;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

					return $this->currentHome;

				}catch (PDOException $e){
					
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

		private $gpHomeList = array();
		public function getGpHomeList(string $whereClause, string $orderBy = 'id_home', string $ascOrDesc = 'ASC', int $firstLine = 0, int $linePerPage = 13):array{
				
			if($_SESSION['debug']['monolog']){
				$this->initLoggerGpHome();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getGpHomeList()',
					'$whereClause' => $whereClause,
					'$orderBy' => $orderBy,
					'$ascOrDesc' => $ascOrDesc,
					'$firstLine' => $firstLine,
					'$linePerPage' => $linePerPage,
					'$gpHomeList' => $this->gpHomeList
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
			    $stmt = $bdd->prepare("SELECT
										`home`.`id_home`,
										`home`.`titre1`,
										`home`.`intro_chapter1`,
										`home`.`intro_chapter2`,
										`home`.`titre2`,
										`home`.`article1_titre`,
										`home`.`article1_chapter1`,
										`home`.`article1_image1`,
										`home`.`article1_titre2`,
										`home`.`article1_chapter2`,
										`home`.`article1_image2`,
										`home`.`article2_titre`,
										`home`.`article2_chapter1`,
										`home`.`article2_image1`,
										`home`.`article2_titre2`,
										`home`.`article2_chapter2`,
										`home`.`article2_image2`

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

				$this->gpHomeList = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$gpHomeList'] = true; //$this->gpHomeList; replace true; by $this->gpHomeList; to see the list of brand
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

				return $this->gpHomeList;

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

		private $insertGpHome = 0;
		public function insertGpHome():int{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerGpHome();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'insertGpHome()',
					'$insertGpHome' => $this->insertGpHome
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

			try{
				$stmt = $bdd->prepare('INSERT INTO `home`(
											  `titre1`,`titre2`,
											  `intro_chapter1`,`intro_chapter2`,
											  `article1_titre`,`article1_chapter1`,`article1_image1`,
											  `article1_titre2`,`article1_chapter2`,`article1_image2`,
											  `article2_titre`,`article2_chapter1`,`article2_image1`,
											  `article2_titre2`,`article2_chapter2`,`article2_image2`
									 ) VALUES (
											  :titre1,:titre2,
											  :intro_chapter1,:intro_chapter2,
											  :article1_titre,:article1_chapter1,:article1_image1,
											  :article1_titre2,:article1_chapter2,:article1_image2,
											  :article2_titre,:article2_chapter1,:article2_image1,
											  :article2_titre2,:article2_chapter2,:article2_image2)'
									 );

				$stmt->bindParam(':titre1', $this->titre1, PDO::PARAM_STR);
				$stmt->bindParam(':titre2', $this->titre2, PDO::PARAM_STR);
				$stmt->bindParam(':intro_chapter1', $this->intro_chapter1, PDO::PARAM_STR);
				$stmt->bindParam(':intro_chapter2', $this->intro_chapter2, PDO::PARAM_STR);
				$stmt->bindParam(':article1_titre', $this->article1_titre, PDO::PARAM_STR);
				$stmt->bindParam(':article1_chapter1', $this->article1_chapter1, PDO::PARAM_STR);
				$stmt->bindParam(':article1_image1', $this->article1_image1, PDO::PARAM_STR);
				$stmt->bindParam(':article1_titre2', $this->article1_titre2, PDO::PARAM_STR);
				$stmt->bindParam(':article1_chapter2', $this->article1_chapter2, PDO::PARAM_STR);
				$stmt->bindParam(':article1_image2', $this->article1_image2, PDO::PARAM_STR);
				$stmt->bindParam(':article2_titre', $this->article2_titre, PDO::PARAM_STR);
				$stmt->bindParam(':article2_chapter1', $this->article2_chapter1, PDO::PARAM_STR);
				$stmt->bindParam(':article2_image1', $this->article2_image1, PDO::PARAM_STR);
				$stmt->bindParam(':article2_titre2', $this->article2_titre2, PDO::PARAM_STR);
				$stmt->bindParam(':article2_chapter2', $this->article2_chapter2, PDO::PARAM_STR);
				$stmt->bindParam(':article2_image2', $this->article2_image2, PDO::PARAM_STR);

				$stmt->execute();

				$stmt = $bdd->prepare("SELECT MAX(`id_model`) FROM `model`");
				$stmt->execute();

				$this->insertGpHome = intval($stmt->fetchColumn());
				
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$insertGpHome'] = $this->insertGpHome;
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch (PDOException $e){
				
				if($_SESSION['debug']['monolog']){
					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return $this->insertGpHome;
		}

		//-----------------------------------------------------------------------

		private $updateHome = false;
		public function updateHome(int $id_home):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerGpHome();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'updateHome()',
					'$id_home' => $id_home,
					'$updateHome' => $this->updateHome
				];
			}
	
			if(self::checkIdGpHome($id_home)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				try{
					$stmt = $bdd->prepare("UPDATE `home`
											SET `titre1` = :titre1,
												`intro_chapter1` = :intro_chapter1,
												`intro_chapter2` = :intro_chapter2,
												`titre2` = :titre2,
												`article1_titre` = :article1_titre,
												`article1_chapter1` = :article1_chapter1,
												`article1_titre2` = :article1_titre2,
												`article1_chapter2` = :article1_chapter2,
												`article2_titre` = :article2_titre,
												`article2_chapter1` = :article2_chapter1,
												`article2_titre2` = :article2_titre2,
												`article2_chapter2` = :article2_chapter2
											WHERE `id_home` = :id_home");

					$stmt->bindParam(':titre1', $this->titre1, PDO::PARAM_STR);
					$stmt->bindParam(':intro_chapter1', $this->intro_chapter1, PDO::PARAM_STR);
					$stmt->bindParam(':intro_chapter2', $this->intro_chapter2, PDO::PARAM_STR);
					$stmt->bindParam(':titre2', $this->titre2, PDO::PARAM_STR);
					$stmt->bindParam(':article1_titre', $this->article1_titre, PDO::PARAM_STR);
					$stmt->bindParam(':article1_chapter1', $this->article1_chapter1, PDO::PARAM_STR);
					$stmt->bindParam(':article1_titre2', $this->article1_titre2, PDO::PARAM_STR);
					$stmt->bindParam(':article1_chapter2', $this->article1_chapter2, PDO::PARAM_STR);
					$stmt->bindParam(':article2_titre', $this->article2_titre, PDO::PARAM_STR);
					$stmt->bindParam(':article2_chapter1', $this->article2_chapter1, PDO::PARAM_STR);
					$stmt->bindParam(':article2_titre2', $this->article2_titre2, PDO::PARAM_STR);
					$stmt->bindParam(':article2_chapter2', $this->article2_chapter2, PDO::PARAM_STR);
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
					$bdd=null;
				}
			}

			return $this->updateHome;
		}
		
		//-----------------------------------------------------------------------

		private $deleteHome = false;
		public function deleteHome(int $id_home):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerGpHome();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deleteHome()',
					'$id_home' => $id_home,
					'$deleteHome' => $this->deleteHome
				];
			}
	
			if(self::checkIdGpHome($id_home)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare('DELETE FROM home WHERE id_home = :id_home');
					
					$stmt->bindParam(':id_home', $id_home, PDO::PARAM_INT);

					$stmt->execute();

					$this->deleteHome = true;

					if($_SESSION['debug']['monolog']){
						$arrayLogger['$deleteHome'] = self::$deleteHome;
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

			return $this->deleteHome;
		}

		//-----------------------------------------------------------------------

		private static $checkIdGpHome = false;
		public static function checkIdGpHome(int $id_home):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerGpHome();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdGpHome()',
					'$id_home' => $id_home,
					'$checkIdGpHome' => self::$checkIdGpHome
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `home` WHERE `id_home` = :id_home");
				$stmt->bindParam(':id_home', $id_home, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdGpHome = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdGpHome'] = self::$checkIdGpHome;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkIdGpHome;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerGpHome()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.GpHome');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/GarageParrot.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerGpHome()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.GpHome');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/GarageParrot.log', Logger::DEBUG));
			}
		}
	}
?>