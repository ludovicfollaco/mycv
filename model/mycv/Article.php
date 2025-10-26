<?php
	//Article.php
	//Author: Ludovic FOLLACO
	//checked to 2024-10-16_13:45
	namespace Model\Article;

	use \PDO;
	use \PDOException;
	use Model\DbConnect\DbConnect;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class Article
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct()
		{
			if($_SESSION['debug']['monolog']){
				$this->initLoggerArticle();
			}
		}

		private $articleId;
		public function getarticleId():int{
			return $this->articleId;
		}
		public function setarticleId(int $new):void{
			$this->articleId = $new;
		}

		//-----------------------------------------------------------------------

		private $articleTitle;
		public function getarticleTitle():string{
			return $this->articleTitle;
		}
		public function setarticleTitle(string $new):void{
			$this->articleTitle = $new;
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

		private $articleImg;
		public function getArticleImg():string{
			return $this->articleImg;
		}
		public function setArticleImg(string $new):void{
			$this->articleImg = $new;
		}

		//-----------------------------------------------------------------------

		private $articleImgYesOrNo;
		public function getArticleImgYesOrNo():string{
			return $this->articleImgYesOrNo;
		}
		public function setArticleImgYesOrNo(string $new):void{
			$this->articleImgYesOrNo = $new;
		}

		//-----------------------------------------------------------------------

		private $articleImgRightOrLeft;
		public function getArticleImgRightOrLeft():string{
			return $this->articleImgRightOrLeft;
		}
		public function setArticleImgRightOrLeft(string $new):void{
			$this->articleImgRightOrLeft = $new;
		}

		//-----------------------------------------------------------------------

		private $articleImgWidth;
		public function getArticleImgWidth():string{
			return $this->articleImgWidth;
		}
		public function setArticleImgWidth(string $new):void{
			$this->articleImgWidth = $new;
		}

		//-----------------------------------------------------------------------

		private $articleImgHeight;
		public function getArticleImgHeight():string{
			return $this->articleImgHeight;
		}
		public function setArticleImgHeight(string $new):void{
			$this->articleImgHeight = $new;
		}

		//-----------------------------------------------------------------------

		private $articleImgObjectFit;
		public function getArticleImgObjectFit():string{
			return $this->articleImgObjectFit;
		}
		public function setArticleImgObjectFit(string $new):void{
			$this->articleImgObjectFit = $new;
		}

		//-----------------------------------------------------------------------

		private $articleBackground;
		public function getArticleBackground():string{
			return $this->articleBackground;
		}
		public function setArticleBackground(string $new):void{
			$this->articleBackground = $new;
		}

		//-----------------------------------------------------------------------

		private $articleSort;
		public function getArticleSort():string{
			return $this->articleSort;
		}
		public function setArticleSort(string $new):void{
			$this->articleSort = $new;
		}

		//-----------------------------------------------------------------------

		private $getCurrentArticle = array();
		public function getCurrentArticle(int $article_id):array{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerArticle();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCurrentArticle()',
					'$article_id' => $article_id,
					'$getCurrentArticle' => $this->getCurrentArticle
				];
			}
	
			if(self::checkIdArticle($article_id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				
				try{
					$stmt = $bdd->prepare("SELECT
												`article`.`article_id`,
												`article`.`article_title`,
												`article`.`article_subtitle`,
												`article`.`article`,
												`article`.`article_img`,
												`article`.`article_img_yesOrNo`,
												`article`.`article_img_rightOrLeft`,
												`article`.`article_img_width`,
												`article`.`article_img_height`,
												`article`.`article_img_objectFit`,
												`article`.`article_background`,
												`article`.`article_sort`
											FROM `article`
											WHERE `article`.`article_id` = :article_id");

					$stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);

					$stmt->execute();

					$this->getCurrentArticle = $stmt->fetch(PDO::FETCH_ASSOC);
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$getCurrentArticle'] = $this->getCurrentArticle;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}
					
					return $this->getCurrentArticle;
				
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

		private $getArticleList = array();
		public function getArticleList(string $whereClause, string $orderBy = 'article_sort', string $ascOrDesc = 'ASC', int $firstLine = 0, int $linePerPage = 13):array{
			
			if($_SESSION['debug']['monolog']){
				$this->initLoggerArticle();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getArticleList()',
					'$whereClause' => $whereClause,
					'$orderBy' => $orderBy,
					'$ascOrDesc' => $ascOrDesc,
					'$firstLine' => $firstLine,
					'$linePerPage' => $linePerPage,
					'$getArticleList' => $this->getArticleList
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try
			{
				$stmt = $bdd->prepare("SELECT
											`article`.`article_id`,
											`article`.`article_title`,
											`article`.`article`,
											`article`.`article_img`,
											`article`.`article_img_yesOrNo`,
											`article`.`article_img_rightOrLeft`,
											`article`.`article_img_width`,
											`article`.`article_img_height`,
											`article`.`article_img_objectFit`,
											`article`.`article_background`,
											`article`.`article_sort`
										FROM `article`
										WHERE $whereClause
										ORDER BY $orderBy $ascOrDesc /*:orderBy :ascOrDesc*/
										LIMIT :firstLine, :linePerPage");

				//$stmt->bindParam(':orderBy', $orderBy, PDO::PARAM_STR);
				//$stmt->bindParam(':ascOrDesc', $ascOrDesc, PDO::PARAM_STR);
				$stmt->bindParam(':firstLine', $firstLine, PDO::PARAM_INT);
				$stmt->bindParam(':linePerPage', $linePerPage, PDO::PARAM_INT);

				$stmt->execute();

				$this->getArticleList = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$getArticleList'] = true; //$this->getArticleList; // replace true; by $this->getArticleList; if you want to see the result
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

				return $this->getArticleList;

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

		private $updateArticle = false;
		public function updateArticle(int $article_id):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerArticle();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'updateArticle()',
					'$article_id' => $article_id,
					'$updateArticle' => $this->updateArticle
				];
			}
	
			if(self::checkIdArticle($article_id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare("UPDATE `article`
											SET `article_title` = :articleTitle,
												`article` = :article,
												`article_img` = :articleImg,
												`article_img_yesOrNo` = :articleImgYesOrNo,
												`article_img_rightOrLeft` = :articleImgRightOrLeft,
												`article_img_width` = :articleImgWidth,
												`article_img_height` = :articleImgHeight,
												`article_img_objectFit` = :articleImgObjectFit,
												`article_background` = :articleBackground,
												`article_sort` = :articleSort
												
											WHERE `article_id` = :article_id");
					
					$stmt->bindParam(':articleTitle', $this->articleTitle, PDO::PARAM_STR);
					$stmt->bindParam(':article', $this->article, PDO::PARAM_STR);
					$stmt->bindParam(':articleImg', $this->articleImg, PDO::PARAM_STR);
					$stmt->bindParam(':articleImgYesOrNo', $this->articleImgYesOrNo, PDO::PARAM_STR);
					$stmt->bindParam(':articleImgRightOrLeft', $this->articleImgRightOrLeft, PDO::PARAM_STR);
					$stmt->bindParam(':articleImgWidth', $this->articleImgWidth, PDO::PARAM_STR);
					$stmt->bindParam(':articleImgHeight', $this->articleImgHeight, PDO::PARAM_STR);
					$stmt->bindParam(':articleImgObjectFit', $this->articleImgObjectFit, PDO::PARAM_STR);
					$stmt->bindParam(':articleBackground', $this->articleBackground, PDO::PARAM_STR);
					$stmt->bindParam(':articleSort', $this->articleSort, PDO::PARAM_STR);
					$stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);
					
					$stmt->execute();

					$this->updateArticle = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$updateArticle'] = $this->updateArticle;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}
					
				}catch (PDOException $e){

					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);

				}finally{
					$bdd = null;
				}
			}

			return $this->updateArticle;
		}

		//-----------------------------------------------------------------------

		private $deleteArticle = false;
		public function deleteArticle(int $article_id):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerArticle();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deleteArticle()',
					'$article_id' => $article_id,
					'$deleteArticle' => $this->deleteArticle
				];
			}
	
			if(self::checkIdArticle($article_id)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				
				try{
					$stmt = $bdd->prepare('DELETE FROM article WHERE article_id = :article_id');
					$stmt->bindParam(':article_id', $article_id, PDO::PARAM_INT);

					$stmt->execute();

					$this->deleteArticle = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$deleteArticle'] = $this->deleteArticle;
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

			return $this->deleteArticle;
		}

		//-----------------------------------------------------------------------
		private $insertArticle = 0;
		public function insertArticle():int{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerArticle();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'insertArticle()',
					'$insertArticle' => $this->insertArticle
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
	
			try
			{
				$stmt = $bdd->prepare("INSERT INTO `article` (`article_title`,
															`article`,
															`article_img`,
															`article_img_yesOrNo`,
															`article_img_rightOrLeft`,
															`article_img_width`,
															`article_img_height`,
															`article_img_objectFit`,
															`article_background`,
															`article_sort`) 
										VALUES (:articleTitle,
												:article,
												:articleImg,
												:articleImgYesOrNo,
												:articleImgRightOrLeft,
												:articleImgWidth,
												:articleImgHeight,
												:articleImgObjectFit,
												:articleBackground,
												:articleSort)");
	
				$stmt->bindParam(':articleTitle', $this->articleTitle, PDO::PARAM_STR);
				$stmt->bindParam(':article', $this->article, PDO::PARAM_STR);
				$stmt->bindParam(':articleImg', $this->articleImg, PDO::PARAM_STR);
				$stmt->bindParam(':articleImgYesOrNo', $this->articleImgYesOrNo, PDO::PARAM_STR);
				$stmt->bindParam(':articleImgRightOrLeft', $this->articleImgRightOrLeft, PDO::PARAM_STR);
				$stmt->bindParam(':articleImgWidth', $this->articleImgWidth, PDO::PARAM_STR);
				$stmt->bindParam(':articleImgHeight', $this->articleImgHeight, PDO::PARAM_STR);
				$stmt->bindParam(':articleImgObjectFit', $this->articleImgObjectFit, PDO::PARAM_STR);
				$stmt->bindParam(':articleBackground', $this->articleBackground, PDO::PARAM_STR);
				$stmt->bindParam(':articleSort', $this->articleSort, PDO::PARAM_STR);
					
				$stmt->execute();

				$stmt = $bdd->prepare("SELECT MAX(`article_id`) FROM `article`");
				$stmt->execute();

				$this->insertArticle = intval($stmt->fetchColumn());
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$insertArticle'] = $this->insertArticle;
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
					
				if($_SESSION['debug']['monolog']){
					$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd = null;
			}
			
			return $this->insertArticle;
		}

		//-----------------------------------------------------------------------

		private static $checkIdArticle = false;
		public static function checkIdArticle(int $article_id):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerArticle();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdArticle()',
					'$article_id' => $article_id,
					'$checkIdArticle' => self::$checkIdArticle
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `article` WHERE `article_id` = :article_id");
				$stmt->bindParam(':article_id', $article_id, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdArticle = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdArticle'] = self::$checkIdArticle;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){

				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkIdArticle;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerArticle()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Article');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/MyCv.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerArticle()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Article');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/MyCv.log', Logger::DEBUG));
			}
		}
	}
?>