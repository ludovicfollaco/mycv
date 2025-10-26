<?php
	//Network.php
	//Author: Ludovic FOLLACO
	//checked to 2024-10-16_13:45
	namespace Model\Network;

	use \PDO;
	use \PDOException;
	use Model\DbConnect\DbConnect;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;
	use DateTime;

	class Network
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct()
		{
			if($_SESSION['debug']['monolog']){
				$this->initLoggerNetwork();
			}
		}

		private $id;
		public function getId():int{
			return $this->id;
		}
		public function setId(int $new):void{
			$this->id = $new;
		}

		//-----------------------------------------------------------------------

		private $newspaper;
		public function getNewspaper():string{
			return $this->newspaper;
		}
		public function setNewspaper(string $new):void{
			$this->newspaper = $new;
		}

		//-----------------------------------------------------------------------

		private ?DateTime $date = null;
		public function getDate():?DateTime{
			return $this->date;
		}
		public function setDate(DateTime $new):void{
			$this->date = $new;
		}

		//-----------------------------------------------------------------------

		private $title;
		public function getTitle():string{
			return $this->title;
		}
		public function setTitle(string $new):void{
			$this->title = $new;
		}

		//-----------------------------------------------------------------------

		private $subtitle;
		public function getSubtitle():string{
			return $this->subtitle;
		}
		public function setSubtitle(string $new):void{
			$this->subtitle = $new;
		}

		//-----------------------------------------------------------------------

		private $editor;
		public function getEditor():string{
			return $this->editor;
		}
		public function setEditor(string $new):void{
			$this->editor = $new;
		}

		//-----------------------------------------------------------------------

		private $article;
		public function getArticle():string{
			return $this->article;
		}
		public function setArticle(string $new):void{
			$this->article = $new;
		}

		//-----------------------------------------------------------------------

		private $MediaYesOrNo;
		public function getMediaYesOrNo():string{
			return $this->imgMediaYesOrNoYesOrNo;
		}
		public function setMediaYesOrNo(string $new):void{
			$this->MediaYesOrNo = $new;
		}

		//-----------------------------------------------------------------------

		private $mediaRightOrLeft;
		public function getMediaRightOrLeft():string{
			return $this->mediaRightOrLeft;
		}
		public function setMediaRightOrLeft(string $new):void{
			$this->mediaRightOrLeft = $new;
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

		private $backgroundTitle;
		public function getBackgroundTitle():string{
			return $this->backgroundTitle;
		}
		public function setBackgroundTitle(string $new):void{
			$this->backgroundTitle = $new;
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

		private $getCurrentNetwork = array();
		public function getCurrentNetwork(int $id):array{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerNetwork();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCurrentNetwork()',
					'$id' => $id,
					'$getCurrentNetwork' => $this->getCurrentNetwork
				];
			}
	
			if(self::checkIdNetwork($id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				
				try{
					$stmt = $bdd->prepare("SELECT
												`network`.`id`,
												`network`.`newspaper`,
												`network`.`date`,
												`network`.`title`,
												`network`.`subtitle`,
												`network`.`editor`,
												`network`.`article`,
												`network`.`media_yesOrNo`,
												`network`.`media_rightOrLeft`,
												`network`.`background`,
												`network`.`background_title`,
												`network`.`urlArticle`,
												`network`.`sort`
											FROM `network`
											WHERE `network`.`id` = :id");

					$stmt->bindParam(':id', $id, PDO::PARAM_INT);

					$stmt->execute();

					$this->getCurrentNetwork = $stmt->fetch(PDO::FETCH_ASSOC);
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$getCurrentNetwork'] = $this->getCurrentNetwork;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}
					
					return $this->getCurrentNetwork;
				
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
				$this->initLoggerNetwork();
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
											`network`.`id`,
											`network`.`newspaper`,
											`network`.`date`,
											`network`.`title`,
											`network`.`subtitle`,
											`network`.`editor`,
											`network`.`article`,
											`network`.`media_yesOrNo`,
											`network`.`media_rightOrLeft`,
											`network`.`background`,
											`network`.`background_title`,
											`network`.`urlArticle`,
											`network`.`sort`
										FROM `network`
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

		private $updateNetwork = false;
		public function updateNetwork(int $id):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerNetwork();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'updateNetwork()',
					'$id' => $id,
					'$updateNetwork' => $this->updateNetwork
				];
			}
	
			if(self::checkIdNetwork($id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare("UPDATE `network`
											SET `newspaper` = :newspaper,
												`date` = :date,
												`title` = :title,
												`subtitle` = :subtitle,
												`editor` = :editor,
												`article` = :article,
												`media_yesOrNo` = :mediaYesOrNo,
												`media_rightOrLeft` = :mediaRightOrLeft,
												`background` = :background,
												`background_title` = :backgroundTitle,
												`urlArticle` = :urlArticle,
												`sort` = :sort
												
											WHERE `id` = :id");
					
					$stmt->bindParam(':newspaper', $this->newspaper, PDO::PARAM_STR);
					$stmt->bindParam(':date', $this->date, PDO::PARAM_STR);
					$stmt->bindParam(':title', $this->title, PDO::PARAM_STR);
					$stmt->bindParam(':subtitle', $this->subtitle, PDO::PARAM_STR);
					$stmt->bindParam(':editor', $this->editor, PDO::PARAM_STR);
					$stmt->bindParam(':article', $this->article, PDO::PARAM_STR);
					$stmt->bindParam(':media_yesOrNo', $this->mediaYesOrNo, PDO::PARAM_STR);
					$stmt->bindParam(':media_rightOrLeft', $this->mediaRightOrLeft, PDO::PARAM_STR);
					$stmt->bindParam(':background', $this->background, PDO::PARAM_STR);
					$stmt->bindParam(':background_title', $this->backgroundTitle, PDO::PARAM_STR);
					$stmt->bindParam(':sort', $this->sort, PDO::PARAM_STR);
					$stmt->bindParam(':id', $id, PDO::PARAM_INT);
					
					$stmt->execute();

					$this->updateNetwork = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$updateNetwork'] = $this->updateNetwork;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}
					
				}catch (PDOException $e){

					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);

				}finally{
					$bdd = null;
				}
			}

			return $this->updateNetwork;
		}

		//-----------------------------------------------------------------------

		private $deleteNetwork = false;
		public function deleteNetwork(int $id):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerNetwork();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deleteNetwork()',
					'$id' => $id,
					'$deleteNetwork' => $this->deleteNetwork
				];
			}
	
			if(self::checkIdNetwork($id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				
				try{
					$stmt = $bdd->prepare('DELETE FROM network WHERE id = :id');
					$stmt->bindParam(':id', $id, PDO::PARAM_INT);

					$stmt->execute();

					$this->deleteNetwork = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$deleteNetwork'] = $this->deleteNetwork;
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

			return $this->deleteNetwork;
		}

		//-----------------------------------------------------------------------
		private $insertNetwork = 0;
		public function insertNetwork():int{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerNetwork();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'insertNetwork()',
					'$insertNetwork' => $this->insertNetwork
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
	
			try
			{
				$stmt = $bdd->prepare("INSERT INTO `network` (`job`,
																`logo`,
																`company`,
																`contract`,
																`start`,
																`end`,
																`place`,
																`network`,
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
												:network,
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
				$stmt->bindParam(':network', $this->network, PDO::PARAM_STR);
				$stmt->bindParam(':imgPrefix', $this->imgPrefix, PDO::PARAM_STR);
				$stmt->bindParam(':imgYesOrNo', $this->imgYesOrNo, PDO::PARAM_STR);
				$stmt->bindParam(':imgRightOrLeft', $this->imgRightOrLeft, PDO::PARAM_STR);
				$stmt->bindParam(':imgWidth', $this->imgWidth, PDO::PARAM_STR);
				$stmt->bindParam(':imgHeight', $this->imgHeight, PDO::PARAM_STR);
				$stmt->bindParam(':imgObjectFit', $this->imgObjectFit, PDO::PARAM_STR);
				$stmt->bindParam(':background', $this->imgObjectFit, PDO::PARAM_STR);
				$stmt->bindParam(':sort', $this->sort, PDO::PARAM_STR);
					
				$stmt->execute();

				$stmt = $bdd->prepare("SELECT MAX(`id`) FROM `network`");
				$stmt->execute();

				$this->insertNetwork = intval($stmt->fetchColumn());
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$insertNetwork'] = $this->insertNetwork;
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
					
				if($_SESSION['debug']['monolog']){
					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd = null;
			}
			
			return $this->insertNetwork;
		}

		//-----------------------------------------------------------------------

		private static $checkIdNetwork = false;
		public static function checkIdNetwork(int $id):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerNetwork();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdNetwork()',
					'$id' => $id,
					'$checkIdNetwork' => self::$checkIdNetwork
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `network` WHERE `id` = :id");
				$stmt->bindParam(':id', $id, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdNetwork = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdNetwork'] = self::$checkIdNetwork;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkIdNetwork;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerNetwork()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Network');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/MyCv.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerNetwork()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Network');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/MyCv.log', Logger::DEBUG));
			}
		}
	}
?>