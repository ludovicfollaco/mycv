<?php
	//Presse.php
	//Author: Ludovic FOLLACO
	//checked to 2024-10-16_13:45
	namespace Model\Media;

	use \PDO;
	use \PDOException;
	use Model\DbConnect\DbConnect;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;
	use DateTime;

	class Media
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct()
		{
			if($_SESSION['debug']['monolog']){
				$this->initLoggerPresse();
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

		private $pageId;
		public function getPageId():int{
			return $this->pageId;
		}
		public function setPageId(int $new):void{
			$this->pageId = $new;
		}

		//-----------------------------------------------------------------------

		private $sectionId;
		public function getSectionId():int{
			return $this->sectionId;
		}
		public function setSectionId(int $new):void{
			$this->sectionId = $new;
		}

		//-----------------------------------------------------------------------

		private $show;
		public function getShow():string{
			return $this->show;
		}
		public function setShow(string $new):void{
			$this->show = $new;
		}

		//-----------------------------------------------------------------------

		private $url;
		public function geturl():string{
			return $this->url;
		}
		public function seturl(string $new):void{
			$this->url = $new;
		}

		//-----------------------------------------------------------------------

		private $folder;
		public function getFolder():string{
			return $this->folder;
		}
		public function setFolder(string $new):void{
			$this->folder = $new;
		}

		//-----------------------------------------------------------------------

		private $media;
		public function getMedia():string{
			return $this->media;
		}
		public function setMedia(string $new):void{
			$this->media = $new;
		}

		//-----------------------------------------------------------------------

		private $extension;
		public function getExtension():string{
			return $this->extension;
		}
		public function setExtension(string $new):void{
			$this->extension = $new;
		}

		//-----------------------------------------------------------------------

		private $alt;
		public function getAlt():string{
			return $this->alt;
		}
		public function setAlt(string $new):void{
			$this->alt = $new;
		}

		//-----------------------------------------------------------------------

		private $caption;
		public function getCaption():string{
			return $this->caption;
		}
		public function setCaption(string $new):void{
			$this->caption = $new;
		}

		//-----------------------------------------------------------------------

		private $width;
		public function getWidth():string{
			return $this->width;
		}
		public function setWidth(string $new):void{
			$this->width = $new;
		}

		//-----------------------------------------------------------------------

		private $maxWidth;
		public function getMaxWidth():string{
			return $this->maxWidth;
		}
		public function setMaxWidth(string $new):void{
			$this->maxWidth = $new;
		}

		//-----------------------------------------------------------------------

		private $height;
		public function getHeight():string{
			return $this->height;
		}
		public function setHeight(string $new):void{
			$this->height = $new;
		}

		//-----------------------------------------------------------------------

		private $objectFit;
		public function getObjectFit():string{
			return $this->objectFit;
		}
		public function setObjectFit(string $new):void{
			$this->objectFit = $new;
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

		private $getCurrentPresse = array();
		public function getCurrentPresse(int $id):array{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerPresse();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCurrentPresse()',
					'$id' => $id,
					'$getCurrentPresse' => $this->getCurrentPresse
				];
			}
	
			if(self::checkIdPresse($id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				
				try{
					$stmt = $bdd->prepare("SELECT
												`media`.`id`,
												`media`.`page_id`,
												`media`.`section_id`,
												`media`.`show`,
												`media`.`url`,
												`media`.`folder`,
												`media`.`media`,
												`media`.`extension`,
												`media`.`alt`,
												`media`.`caption`,
												`media`.`width`,
												`media`.`maxWidth`,
												`media`.`height`,
												`media`.`objectFit`,
												`media`.`sort`
											FROM `media`
											WHERE `media`.`id` = :id");

					$stmt->bindParam(':id', $id, PDO::PARAM_INT);

					$stmt->execute();

					$this->getCurrentPresse = $stmt->fetch(PDO::FETCH_ASSOC);
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$getCurrentPresse'] = $this->getCurrentPresse;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}
					
					return $this->getCurrentPresse;
				
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
				$this->initLoggerPresse();
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
											`media`.`id`,
											`media`.`page_id`,
											`media`.`section_id`,
											`media`.`show`,
											`media`.`url`,
											`media`.`folder`,
											`media`.`media`,
											`media`.`extension`,
											`media`.`alt`,
											`media`.`caption`,
											`media`.`width`,
											`media`.`maxWidth`,
											`media`.`height`,
											`media`.`objectFit`,
											`media`.`sort`
										FROM `media`
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

		private $updatePresse = false;
		public function updatePresse(int $id):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerPresse();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'updatePresse()',
					'$id' => $id,
					'$updatePresse' => $this->updatePresse
				];
			}
	
			if(self::checkIdPresse($id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$sql = "
							UPDATE `presse`
								SET `newspaper`       = :newspaper,
									`date`            = :date,
									`title`           = :title,
									`subtitle`        = :subtitle,
									`editor`          = :editor,
									`article`         = :article,
									`Prefix`          = :mediaPrefix,
									`media`           = :media,
									`legend`          = :legend,
									`yesOrNo`         = :mediaYesOrNo,
									`rightOrLeft`     = :mediaRightOrLeft,
									`width`           = :mediaWidth,
									`height`          = :mediaHeight,
									`objectFit`       = :mediaObjectFit,
									`background`      = :background,
									`background_title`= :backgroundTitle,
									`urlArticle`      = :urlArticle,
									`sort`            = :sort
							WHERE `id` = :id
					";

					$stmt = $bdd->prepare($sql);
					
					$stmt->bindParam(':newspaper',       $this->newspaper,       PDO::PARAM_STR);
					$stmt->bindParam(':date',            $this->date,            PDO::PARAM_STR);
					$stmt->bindParam(':title',           $this->title,           PDO::PARAM_STR);
					$stmt->bindParam(':subtitle',        $this->subtitle,        PDO::PARAM_STR);
					$stmt->bindParam(':editor',          $this->editor,          PDO::PARAM_STR);
					$stmt->bindParam(':article',         $this->article,         PDO::PARAM_STR);
					$stmt->bindParam(':mediaPrefix',     $this->mediaPrefix,     PDO::PARAM_STR);
					$stmt->bindParam(':media',           $this->media,           PDO::PARAM_STR);
					$stmt->bindParam(':legend',          $this->legend,          PDO::PARAM_STR);
					$stmt->bindParam(':mediaYesOrNo',    $this->mediaYesOrNo,    PDO::PARAM_STR);
					$stmt->bindParam(':mediaRightOrLeft',$this->mediaRightOrLeft,PDO::PARAM_STR);
					$stmt->bindParam(':mediaWidth',      $this->mediaWidth,      PDO::PARAM_STR);
					$stmt->bindParam(':mediaHeight',     $this->mediaHeight,     PDO::PARAM_STR);
					$stmt->bindParam(':mediaObjectFit',  $this->mediaObjectFit,  PDO::PARAM_STR);
					$stmt->bindParam(':background',      $this->background,      PDO::PARAM_STR);
					$stmt->bindParam(':backgroundTitle', $this->backgroundTitle, PDO::PARAM_STR);
					$stmt->bindParam(':urlArticle',      $this->urlArticle,      PDO::PARAM_STR);
					$stmt->bindParam(':sort',            $this->sort,            PDO::PARAM_STR); 
					$stmt->bindParam(':id',              $id,                    PDO::PARAM_INT);
					
					$stmt->execute();

					$this->updatePresse = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$updatePresse'] = $this->updatePresse;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}
					
				}catch (PDOException $e){

					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);

				}finally{
					$bdd = null;
				}
			}

			return $this->updatePresse;
		}

		//-----------------------------------------------------------------------

		private $deletePresse = false;
		public function deletePresse(int $id):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerPresse();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deletePresse()',
					'$id' => $id,
					'$deletePresse' => $this->deletePresse
				];
			}
	
			if(self::checkIdPresse($id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				
				try{
					$stmt = $bdd->prepare('DELETE FROM presse WHERE id = :id');
					$stmt->bindParam(':id', $id, PDO::PARAM_INT);

					$stmt->execute();

					$this->deletePresse = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$deletePresse'] = $this->deletePresse;
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

			return $this->deletePresse;
		}

		//-----------------------------------------------------------------------
		private $insertPresse = 0;
		public function insertPresse():int{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerPresse();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'insertPresse()',
					'$insertPresse' => $this->insertPresse
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
	
			try
			{
				$stmt = $bdd->prepare("INSERT INTO `presse` (`job`,
																`logo`,
																`company`,
																`contract`,
																`start`,
																`end`,
																`place`,
																`presse`,
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
												:presse,
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
				$stmt->bindParam(':presse', $this->presse, PDO::PARAM_STR);
				$stmt->bindParam(':imgPrefix', $this->imgPrefix, PDO::PARAM_STR);
				$stmt->bindParam(':imgYesOrNo', $this->imgYesOrNo, PDO::PARAM_STR);
				$stmt->bindParam(':imgRightOrLeft', $this->imgRightOrLeft, PDO::PARAM_STR);
				$stmt->bindParam(':imgWidth', $this->imgWidth, PDO::PARAM_STR);
				$stmt->bindParam(':imgHeight', $this->imgHeight, PDO::PARAM_STR);
				$stmt->bindParam(':imgObjectFit', $this->imgObjectFit, PDO::PARAM_STR);
				$stmt->bindParam(':background', $this->imgObjectFit, PDO::PARAM_STR);
				$stmt->bindParam(':sort', $this->sort, PDO::PARAM_STR);
					
				$stmt->execute();

				$stmt = $bdd->prepare("SELECT MAX(`id`) FROM `presse`");
				$stmt->execute();

				$this->insertPresse = intval($stmt->fetchColumn());
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$insertPresse'] = $this->insertPresse;
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
					
				if($_SESSION['debug']['monolog']){
					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd = null;
			}
			
			return $this->insertPresse;
		}

		//-----------------------------------------------------------------------

		private static $checkIdPresse = false;
		public static function checkIdPresse(int $id):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerPresse();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdPresse()',
					'$id' => $id,
					'$checkIdPresse' => self::$checkIdPresse
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `presse` WHERE `id` = :id");
				$stmt->bindParam(':id', $id, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdPresse = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdPresse'] = self::$checkIdPresse;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkIdPresse;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerPresse()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Presse');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/MyCv.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerPresse()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Presse');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/MyCv.log', Logger::DEBUG));
			}
		}
	}
?>