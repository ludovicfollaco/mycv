<?php
	//Comment.php
	//author : Ludovic FOLLACO
	//checked to 2024-10-08_15:10
	namespace Model\Comment;

	use \PDO;
	use \PDOException;
	use Model\DbConnect\DbConnect;
	use Model\Utilities\Utilities;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class Comment
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct()
		{
			if($_SESSION['debug']['monolog']){
				$this->initLoggerComment();
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

		private $date;
		public function getDate():string{
			return $this->date;
		}
		public function setDate(string $new):void{
			$this->date = $new;
		}

		//-----------------------------------------------------------------------

		private $pseudo;
		public function getPseudo():string{
			return $this->pseudo;
		}
		public function setPseudo(string $new):void{
			$this->pseudo = $new;
		}

		//-----------------------------------------------------------------------

		private $rating;
		public function getRating():int{
			return $this->rating;
		}
		public function setRating(int $new):void{
			$this->rating = $new;
		}

		//-----------------------------------------------------------------------

		private $comment;
		public function getComment():string{
			return $this->comment;
		}
		public function setComment(string $new):void{
			$this->comment = $new;
		}

		//-----------------------------------------------------------------------

		private $id_member;
		public function getIdMember():int{
			return $this->id_member;
		}
		public function setIdMember(int $new):void{
			$this->id_member = $new;
		}

		//-----------------------------------------------------------------------

		private $currentComment = array();
		public function getCurrentComment(int $id_comment):array{

			$this->currentComment = [];

			if($_SESSION['debug']['monolog']){
				$this->initLoggerComment();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCurrentComment()',
					'$id_comment' => $id_comment,
					'$currentComment' => $this->currentComment
				];
			}
	
			if(Utilities::checkData('comment','id_comment', $id_comment)){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				
				try{
					$stmt = $bdd->prepare("SELECT
												 `comment`.`id_comment`,
												 `comment`.`date_`,
												 `user`.`pseudo` AS `pseudo`,
												 `comment`.`rating`,
												 `comment`.`comment`,
												 `user`.`avatar` AS `avatar`,
												 `comment`.`publication`,
												 `comment`.`id_member`
											
											FROM `comment`

											LEFT JOIN `user`
												ON `user`.`id_user` = `comment`.`id_member`
											LEFT JOIN `user` AS `userAvatar`
												ON `userAvatar`.`id_user` = `comment`.`id_member`
											
											WHERE `comment`.`id_comment` = :id_comment");

					$stmt->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);

					$stmt->execute();

					$this->currentComment = $stmt->fetch(PDO::FETCH_ASSOC);

					if($_SESSION['debug']['monolog']){
						$arrayLogger['$currentComment'] = $this->currentComment;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

					return $this->currentComment;

				}catch(PDOException $e){
					if($_SESSION['debug']['monolog']){
						$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
					}
					return [];
				}finally{
					$bdd = null;
				}
			}

    		return [];
		}

		//-----------------------------------------------------------------------

		private $commentList = array();
		public function getCommentList(string $whereClause, string $orderBy = 'date_', string $ascOrDesc = 'ASC', int $firstLine = 0, int $linePerPage = 50):array{
			
			if($_SESSION['debug']['monolog']){
				$this->initLoggerComment();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCommentList()',
					'$whereClause' => $whereClause,
					'$orderBy' => $orderBy,
					'$ascOrDesc' => $ascOrDesc,
					'$firstLine' => $firstLine,
					'$linePerPage' => $linePerPage,
					'$commentList' => $this->commentList
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT 
											 `comment`.`id_comment`,
											 `comment`.`date_`,
											 `user`.`pseudo` AS `pseudo`,
											 `comment`.`rating`,
											 `comment`.`comment`,
											 `user`.`avatar` AS `avatar`,
											 `comment`.`publication`,
											 `comment`.`id_member`

										FROM `comment`
										
										LEFT JOIN `user`
											ON `user`.`id_user` = `comment`.`id_member`
										LEFT JOIN `user` AS `userAvatar`
											ON `userAvatar`.`id_user` = `comment`.`id_member`
										
										WHERE $whereClause
										ORDER BY :orderBy :ascOrDesc
										LIMIT :firstLine, :linePerPage");

				$stmt->bindParam(':orderBy', $orderBy, PDO::PARAM_STR);
				$stmt->bindParam(':ascOrDesc', $ascOrDesc, PDO::PARAM_STR);
				$stmt->bindParam(':firstLine', $firstLine, PDO::PARAM_INT);
				$stmt->bindParam(':linePerPage', $linePerPage, PDO::PARAM_INT);

				$stmt->execute();
								
				$this->commentList = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$commentList'] = true; //$this->commentList; // replace true; by $this->commentList; if you want to see the result
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

				return $this->commentList;

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
		private $insertComment = 0;
		public function insertComment():int{

			if(!self::checkComment($this->pseudo, intval($this->rating), $this->comment)){

				if($_SESSION['debug']['monolog']){
					$this->initLoggerComment();
					$arrayLogger = [
						'user' => $_SESSION['dataConnect']['pseudo'],
						'function' => 'insertComment()',
						'$insertComment' => $this->insertComment
					];
				}

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare('INSERT INTO `comment` (`date_`, `pseudo`, `rating`, `comment`, `id_member`)
												VALUES (:date, :pseudo, :rating, :comment, (SELECT id_user FROM user WHERE `pseudo` = :pseudo))
										');

					$stmt->bindParam(':date', $this->date, PDO::PARAM_STR);
					$stmt->bindParam(':pseudo', $this->pseudo, PDO::PARAM_STR);
					$stmt->bindParam(':rating', intval($this->rating), PDO::PARAM_INT);
					$stmt->bindParam(':comment', $this->comment, PDO::PARAM_STR);

					$stmt->execute();

					$stmt = $bdd->prepare("SELECT MAX(`id_comment`) FROM `comment`");

					$stmt->execute();

					$this->insertComment = intval($stmt->fetchColumn());
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$insertComment'] = $this->insertComment;
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
			
			return $this->insertComment;
		}

		//-----------------------------------------------------------------------
		private $updateComment = false;
		public function updateComment(int $id_comment):bool{

			if(self::checkIdComment($id_comment)){

				if($_SESSION['debug']['monolog']){
					$this->initLoggerComment();
					$arrayLogger = [
						'user' => $_SESSION['dataConnect']['pseudo'],
						'function' => 'updateComment()',
						'$id_comment' => $id_comment,
						'$updateComment' => $this->updateComment
					];
				}

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try
				{
					$stmt = $bdd->prepare("UPDATE `comment`
											  SET `date_`      = :date,
												  `pseudo`     = :pseudo,
												  `rating`     = :rating,
												  `comment`    = :comment
											WHERE `id_comment` = :id_comment");

					$stmt->bindParam(':date', $this->date, PDO::PARAM_STR);
					$stmt->bindParam(':pseudo', $this->pseudo, PDO::PARAM_STR);
					$stmt->bindParam(':rating', $this->rating, PDO::PARAM_INT);
					$stmt->bindParam(':comment', $this->comment, PDO::PARAM_STR);
					$stmt->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);

					$stmt->execute();

					$this->updateComment = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$updateComment'] = $this->updateComment;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

				}catch (PDOException $e){
					if($_SESSION['debug']['monolog']){
						$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
					}
					return [];
				}finally{
					$bdd = null;
				}
			}

			return $this->updateComment;
		}

		//-----------------------------------------------------------------------

		private $modereComment = false;
		public function modereComment(int $id_comment, string $publication):bool{

			$dbName = Utilities::checkAndReturnValueInUrl();

			if(self::checkIdComment($id_comment, $dbName)){

				if($_SESSION['debug']['monolog']){
					$this->initLoggerComment();
					$arrayLogger = [
						'user' => $_SESSION['dataConnect']['pseudo'],
						'function' => 'modereComment()',
						'$id_comment' => $id_comment,
						'$publication' => $publication,
						'$modereComment' => $this->modereComment
					];
				}

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare("UPDATE `comment`
											SET `publication` = :publication
											WHERE `id_comment` = :id_comment");

					$stmt->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);
					$stmt->bindParam(':publication', $publication, PDO::PARAM_INT);

					$stmt->execute();

					$this->modereComment = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$modereComment'] = $this->modereComment;
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

			return $this->modereComment;
		}

		//-----------------------------------------------------------------------

		private $deleteComment = false;
		public function deleteComment(int $id_comment):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerComment();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deleteComment()',
					'$id_comment' => $id_comment,
					'$deleteComment' => $this->deleteComment
				];
			}

			$dbName = Utilities::checkAndReturnValueInUrl();

			$subscriptionExist = false;

			if(self::checkIdComment($id_comment, $dbName)){
				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
				$subscriptionExist = true;
			}

			if($subscriptionExist){

				try{
					$deleteQuery = $bdd->prepare('DELETE FROM comment WHERE id_comment = :id_comment');
					$deleteQuery->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);

					$deleteQuery->execute();

					$this->deleteComment = true;
					
					if($_SESSION['debug']['monolog']){
						$arrayLogger['$deleteComment'] = $this->deleteComment;
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

			return $this->deleteComment;
		}

		//-----------------------------------------------------------------------

		private static $checkComment = false;
		public static function checkComment(string $pseudo, int $rating, string $comment):bool{

			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerComment();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkComment()',
					'$checkComment' => self::$checkComment
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

			try{
				$stmt = $bdd->prepare("SELECT COUNT(*)
										 FROM comment
										WHERE `comment`.`pseudo`  = :pseudo
										  AND `comment`.`rating`  = :rating
										  AND `comment`.`comment` = :comment
									 ");
				
				$stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
				$stmt->bindParam(':rating', $rating, PDO::PARAM_INT);
				$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkComment = true;
				}
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkComment'] = self::$checkComment;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch (PDOException $e){
				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd = null;
			}

			return self::$checkComment;
		}

		//-----------------------------------------------------------------------

		private static $checkIdComment = false;
		public static function checkIdComment(int $id_comment, string $dbName = 'mycv'):bool{

			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerComment();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdComment()',
					'$id_comment' => $id_comment,
					'$checkIdComment' => self::$checkIdComment
				];
			}
			
			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `comment` WHERE `comment`.`id_comment` = :id_comment");
				$stmt->bindParam(':id_comment', $id_comment, PDO::PARAM_INT);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdComment = true;
				}
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdComment'] = self::$checkIdComment;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch (PDOException $e){
				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd = null;
			}

			return self::$checkIdComment;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerComment()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Comment');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/Comment.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerComment()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Comment');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/Comment.log', Logger::DEBUG));
			}
		}
	}
?>