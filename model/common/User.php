<?php
	//user.class.php
	//author : Ludovic FOLLACO
	//checked to 2024-10-04_15:22
	namespace Model\User;

	use \PDO;
	use \PDOException;
	use Model\DbConnect\DbConnect;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class User
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct()
		{
			if($_SESSION['debug']['monolog']){
				$this->initLoggerUser();
			}
		}

		private $id_user = 0;
		public function getId():int{
			return $this->id_user;
		}
		public function setId(int $new):void{
			$this->id_user = $new;
		}

		//-----------------------------------------------------------------------

		private $name = "";
		public function getName():string{
			return $this->name;
		}
		public function setName(string $new):void{
			$this->name = $new;
		}

		//-----------------------------------------------------------------------

		private $surname = "";
		public function getSurname():string{
			return $this->surname;
		}
		public function setSurname(string $new):void{
			$this->surname = $new;
		}

		//-----------------------------------------------------------------------

		private $pseudo = "";
		public function getPseudo():string{
			return $this->pseudo;
		}
		public function setPseudo(string $new):void{
			$this->pseudo = $new;
		}

		//-----------------------------------------------------------------------

		private $email = "";
		public function getEmail():string{
			return $this->email;
		}
		public function setEmail(string $new):void{
			$this->email = $new;
		}

		//-----------------------------------------------------------------------

		private $phone = "";
		public function getPhone():string{
			return $this->phone;
		}
		public function setPhone(string $new):void{
			$this->phone = $new;
		}

		//-----------------------------------------------------------------------

		private $password = "";
		public function getPassword():string{
			return $this->password;
		}
		public function setPassword(string $new):void{
			$this->password = $new;
		}

		//-----------------------------------------------------------------------

		private $avatar = "";
		public function getAvatar():string{
			return $this->avatar;
		}
		public function setAvatar(string $new):void{
			$this->avatar = $new;
		}

		//-----------------------------------------------------------------------

		private $subscription = "";
		public function getSubscription():string{
			return $this->subscription;
		}
		public function setSubscription(string $new):void{
			$this->subscription = $new;
		}

		//-----------------------------------------------------------------------

		private $type = "";
		public function getType():string{
			return $this->type;
		}
		public function setType(string $new):void{
			$this->type = $new;
		}

		//-----------------------------------------------------------------------

		private $token = "";
		public function getToken():string{
			return $this->token;
		}
		public function setToken(string $new):void{
			$this->token = $new;
		}

		//-----------------------------------------------------------------------

		private $timer_token = 0;
		public function getTimerToken():int{
			return $this->timer_token;
		}
		public function setTimerToken(int $new):void{
			$this->timer_token = $new;
		}

		private $pw = "";
		public function getPw():string{
			return $this->pw;
		}
		public function setPw(string $new):void{
			$this->pw = $new;
		}

		//-----------------------------------------------------------------------

		private $criteriaName = "";
		public function getCriteriaName():string{
			return $this->criteriaName;
		}
		public function setCriteriaName(string $new):void{
			$this->criteriaName = $new;
		}

		private $criteriaPseudo = "";
		public function getCriteriaPseudo():string{
			return $this->criteriaPseudo;
		}
		public function setCriteriaPseudo(string $new):void{
			$this->criteriaPseudo = $new;
		}

		private $criteriaType = "";
		public function getCriteriaType():string{
			return $this->criteriaType;
		}
		public function setCriteriaType(string $new):void{
			$this->criteriaType = $new;
		}

		//----------------------------- CRUD -----------------------------------

		private $currentUser = array();
		public function getCurrentUser(int $id_user):array{

			$this->currentUser = [];

			if($_SESSION['debug']['monolog']){
				$this->initLoggerUser();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCurrentUser()',
					'$id_user' => $id_user,
					'$currentUser' => $this->currentUser
				];
			}
	
			if(self::checkIdUser($id_user, 'mycv')){

				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

				try{
					$stmt = $bdd->prepare("SELECT
											`user`.`id_user`,
											`user`.`name`,
											`user`.`surname`,
											`user`.`pseudo`,
											`user`.`email`,
											`user`.`phone`,
											`user`.`password`,
											`user`.`avatar`,
											`subscription`.`subscription` AS 'subscription',
											`user_type`.`type` AS `type`

										FROM `user`

										LEFT JOIN `subscription`
											ON `user`.`id_subscription` = `subscription`.`id_subscription`

										LEFT JOIN `user_type`
											ON `user`.`id_type` = `user_type`.`id_type`

										WHERE `user`.`id_user` = :idUser");

					$stmt->bindParam(':idUser', $id_user, PDO::PARAM_INT);

					$stmt->execute();

					$this->currentUser = $stmt->fetch(PDO::FETCH_ASSOC);

					if($_SESSION['debug']['monolog']){
						$arrayLogger['$currentUser'] = $this->currentUser;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

					return $this->currentUser;
	
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

		private $userList = array();
		public function getUserList(string $whereClause, string $orderBy = 'name', string $ascOrDesc = 'ASC', int $firstLine = 0, int $linePerPage = 13):array{
			
			$this->userList = [];

			if($_SESSION['debug']['monolog']){
				$this->initLoggerUser();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getUserList()',
					'$whereClause' => $whereClause,
					'$orderBy' => $orderBy,
					'$ascOrDesc' => $ascOrDesc,
					'$firstLine' => $firstLine,
					'$linePerPage' => $linePerPage,
					'$userList' => $this->userList
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

			try{
				$stmt = $bdd->prepare("SELECT
											`user`.`id_user`,
											`user`.`name`,
											`user`.`surname`,
											`user`.`pseudo`,
											`user`.`email`,
											`user`.`phone`,
											`user`.`password`,
											`user`.`avatar`,
											`subscription`.`subscription` AS 'subscription',
											`user_type`.`type` AS `type`

										FROM `user`

										LEFT JOIN `subscription` ON `user`.`id_subscription` = `subscription`.`id_subscription`
										LEFT JOIN `user_type` ON `user`.`id_type` = `user_type`.`id_type`

										WHERE $whereClause 
										ORDER BY :orderBy :ascOrDesc 
										LIMIT :firstLine, :linePerPage");

				//$stmt->bindParam(':whereClause', $whereClause, PDO::PARAM_STR);
				$stmt->bindParam(':orderBy', $orderBy, PDO::PARAM_STR);
				$stmt->bindParam(':ascOrDesc', $ascOrDesc, PDO::PARAM_STR);
				$stmt->bindParam(':firstLine', $firstLine, PDO::PARAM_INT);
				$stmt->bindParam(':linePerPage', $linePerPage, PDO::PARAM_INT);

				$stmt->execute();

				$this->userList = $stmt->fetchAll(PDO::FETCH_ASSOC);
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$subscriptionList'] = true; //$this->subscriptionList; // replace true; by $this->subscriptionList; if you want to see the result
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

				return $this->userList;

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

		private $insertUser = 0;
		public function insertUser():int{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerUser();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'db' => 'mycv',
					'function' => 'insertUser()',
					'$insertUser' => $this->insertUser
				];
			}

			$token = bin2hex(random_bytes(32));
			$timerToken = date('U');
			$hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

			$emailExist = false;
			$pseudoExist = false;

			$configDb = DbConnect::configDbConnect();

			foreach ($configDb as $dbName => $configDbConnect){

				if (!self::checkEmail($this->email, $dbName)){

					if(!self::checkPseudo($this->pseudo)){
						$bdd = DbConnect::connectDb($configDbConnect);
					}else{
						$pseudoExist = true;
					}

				}else{
					$emailExist = true;
				}

				if(!$emailExist){

					if(!$pseudoExist){
						
						try{

							$stmt = $bdd->prepare("INSERT INTO `user`(`name`,
																		`surname`,
																		`pseudo`,
																		`email`,
																		`phone`,
																		`password`,
																		`avatar`,
																		`id_subscription`,
																		`id_type`,
																		`token`,
																		`timer_token`,
																		`pw`)
													VALUES(:name,
															:surname,
															:pseudo,
															:email,
															:phone,
															:password,
															:avatar,
															(SELECT `id_subscription` FROM `subscription` WHERE `subscription`=:subscription),
															(SELECT `id_type` FROM `user_type` WHERE `type`=:type),
															:token,
															:timer_token,
															:pw)");
			
							$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
							$stmt->bindParam(':surname', $this->surname, PDO::PARAM_STR);
							$stmt->bindParam(':pseudo', $this->pseudo, PDO::PARAM_STR);
							$stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
							$stmt->bindParam(':phone', $this->phone, PDO::PARAM_STR);
							$stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
							$stmt->bindParam(':avatar', $this->avatar, PDO::PARAM_STR);
							$stmt->bindParam(':subscription', $this->subscription, PDO::PARAM_STR);
							$stmt->bindParam(':type', $this->type, PDO::PARAM_STR);
							$stmt->bindParam(':token', $token, PDO::PARAM_STR);
							$stmt->bindParam(':timer_token', $timerToken, PDO::PARAM_INT);
							$stmt->bindParam(':pw', $this->password, PDO::PARAM_STR);
			
							$stmt->execute();
			
							$stmt = $bdd->prepare("SELECT MAX(`id_user`) FROM `user`");
							$stmt->execute();

							$this->insertUser = intval($stmt->fetchColumn());
						
							if($_SESSION['debug']['monolog']){
								$arrayLogger['db'] = $dbName;
								$arrayLogger['$insertUser'] = $this->insertUser;
								$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
							}
							
						}catch(PDOException $e){
							if($_SESSION['debug']['monolog']){
								$arrayLogger['db'] = $dbName;
								$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
							}
	
						}finally{
							$bdd = null;
						}
					}
				}
			}
				
			return $this->insertUser;
		}

		//-----------------------------------------------------------------------
		private $updateUser = false;
		public function updateUser(int $id_user):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerUser();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'db' => 'mycv',
					'function' => 'updateUser()',
					'$id_user' => $id_user,
					'$updateUser' => $this->updateUser
				];
			}

			$configDb = DbConnect::configDbConnect();

			foreach ($configDb as $dbName => $configDbConnect){
			
				$idUserExist = false;

				if (self::checkIdUser($id_user, $dbName)){
					$bdd = DbConnect::connectDb($configDbConnect);
					$idUserExist = true;
				}
			
				if($idUserExist){
					
					try{
						$stmt = $bdd->prepare("UPDATE `user`
												SET `name` = :name,
													`surname` = :surname,
													`pseudo` = :pseudo,
													`email` = :email,
													`phone` = :phone,
													`avatar` = :avatar,
													`id_subscription` = (SELECT `id_subscription` FROM `subscription` WHERE `subscription`=:subscription),
													`id_type` = (SELECT `id_type` FROM `user_type` WHERE `type`=:type)

												WHERE `id_user` = :idUser");
						
						$stmt->bindParam(':name', $this->name, PDO::PARAM_STR);
						$stmt->bindParam(':surname', $this->surname, PDO::PARAM_STR);
						$stmt->bindParam(':pseudo', $this->pseudo, PDO::PARAM_STR);
						$stmt->bindParam(':email', $this->email, PDO::PARAM_STR);
						$stmt->bindParam(':phone', $this->phone, PDO::PARAM_STR);
						$stmt->bindParam(':avatar', $this->avatar, PDO::PARAM_STR);
						$stmt->bindParam(':subscription', $this->subscription, PDO::PARAM_STR);
						$stmt->bindParam(':type', $this->type, PDO::PARAM_STR);
						$stmt->bindParam(':idUser', $id_user, PDO::PARAM_INT);
						
						$stmt->execute();
						
						$_SESSION['other']['error'] = false;
						$_SESSION['other']['message'] = "The user with id " . $id_user . " is update with success!!!";
						
						$this->updateUser = true;
					
						if($_SESSION['debug']['monolog']){
							$arrayLogger['db'] = $dbName;
							$arrayLogger['$updateUser'] = $this->updateUser;
							$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
						}
					
					}catch (PDOException $e){
						if($_SESSION['debug']['monolog']){
							$arrayLogger['db'] = $dbName;
							$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
						}
	
					}finally{
						$bdd=null;
					}
				}
			}

			return $this->updateUser;
		}

		//-----------------------------------------------------------------------

		private $deleteUser = false;
		public function deleteUser(int $id_user):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerUser();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'db' => 'mycv',
					'function' => 'deleteUser()',
					'$id_user' => $id_user,
					'$deleteUser' => $this->deleteUser
				];
			}

			$configDb = DbConnect::configDbConnect();

			foreach ($configDb as $dbName => $configDbConnect){
			
				$idUserExist = false;

				if (self::checkIdUser($id_user, $dbName)){
					$bdd = DbConnect::connectDb($configDbConnect);
					$idUserExist = true;
				}
			
				if($idUserExist){
			
					try{
						$stmt = $bdd->prepare('DELETE FROM user WHERE id_user = :id_user');
						$stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);

						$stmt->execute();

						$this->deleteUser = true;

						if($_SESSION['debug']['monolog']){
							$arrayLogger['db'] = $dbName;
							$arrayLogger['$deleteUser'] = $this->deleteUser;
							self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
						}
					
					}catch (PDOException $e){
						if($_SESSION['debug']['monolog']){
							$arrayLogger['db'] = $dbName;
							$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
						}
					}finally{
						$bdd=null;
					}
				}
			}
			return $this->deleteUser;
		}

		//-----------------------------------------------------------------------
		//----------------------------- CHECK VALUE -----------------------------
		//-----------------------------------------------------------------------
		
		private static $checkUserConnect = array();
        public static function checkUserConnect(string $email, string $pw):array{

			self::$checkUserConnect = [];

			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerUser();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkUserConnect()',
					'$email' => $email,
					'$pw' => $pw,
					'$checkUserConnect' => self::$checkUserConnect
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

            try{
                $stmt = $bdd->prepare("SELECT   `id_user`,
                                                `pseudo`,
                                                `avatar`,
                                                `password`,
                                                `user_type`.`type` AS `type`,
                                                `subscription`.`subscription` AS `subscription`

                                        FROM `user`

                                        LEFT JOIN `user_type`
                                            ON `user`.`id_type` = `user_type`.`id_type`

                                        LEFT JOIN `subscription`
                                            ON `user`.`id_subscription` = `subscription`.`id_subscription`

                                        WHERE `email` = :email AND `password` = :password");
            
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
                $stmt->bindParam(':password', $pw, PDO::PARAM_STR);
            
                $stmt->execute();

                self::$checkUserConnect = $stmt->fetch(PDO::FETCH_ASSOC);

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkUserConnect'] = self::$checkUserConnect;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

				return self::$checkUserConnect;

			}catch(PDOException $e){
				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

				return [];

			}finally{
				$bdd=null;
			}
        }
		
		private static $checkIdUser = false;
		public static function checkIdUser(int $id_user, string $db = 'mycv'):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerUser();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'$db' => $db,
					'function' => 'checkIdUser()',
					'$id_user' => $id_user,
					'$checkIdUser' => self::$checkIdUser
				];
			}
			
			$configDb = DbConnect::configDbConnect();
			$bdd = DbConnect::connectDb($configDb[$db]);
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `user` WHERE `id_user` = :id_user");
				$stmt->bindParam(':id_user', $id_user, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdUser = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdUser'] = self::$checkIdUser;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkIdUser;
		}

		//-----------------------------------------------------------------------
		
		private static $checkPseudo = false;
		public static function checkPseudo(string $pseudo, string $db = 'mycv'):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerUser();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'$db' => $db,
					'function' => 'checkPseudo()',
					'$pseudo' => $pseudo,
					'$checkPseudo' => self::$checkPseudo
				];
			}
			
			$configDb = DbConnect::configDbConnect();
			$bdd = DbConnect::connectDb($configDb[$db]);
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `user` WHERE `pseudo` = :pseudo");
				$stmt->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkPseudo = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkPseudo'] = self::$checkPseudo;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkPseudo;
		}

		//-----------------------------------------------------------------------
		
		private static $checkEmail = false;
		public static function checkEmail(string $email, string $db = 'mycv'):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerUser();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'$db' => $db,
					'function' => 'checkEmail()',
					'$email' => $email,
					'$checkEmail' => self::$checkEmail
				];
			}
			
			$configDb = DbConnect::configDbConnect();
			$bdd = DbConnect::connectDb($configDb[$db]);
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `user` WHERE `email` = :email");
				$stmt->bindParam(':email', $email, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkEmail = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkEmail'] = self::$checkEmail;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkEmail;
		}

		//-----------------------------------------------------------------------
		
        private static $pwConnect = "";
        public static function checkPassword(string $email, string $db = 'mycv'):string{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerUser();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'$db' => $db,
					'function' => 'checkPassword()',
					'$pseudo' => $email,
					'$pwConnect' => self::$pwConnect
				];
			}
			
			$configDb = DbConnect::configDbConnect();
			$bdd = DbConnect::connectDb($configDb[$db]);

            try{
                $stmt = $bdd->prepare("SELECT `password`
                                        FROM `user`
                                        WHERE `email` = :email");
            
                $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            
                $stmt->execute();

                self::$pwConnect = $stmt->fetchColumn();

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$pwConnect'] = self::$pwConnect;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$pwConnect;
        }

		//-----------------------------------------------------------------------
		
		private static  $checkNbOfProduct = 0;
		public static function checkNbOfProduct(string $whereClause):int{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerUser();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkNbOfProduct()',
					'$whereClause' => $whereClause,
					'$checkNbOfProduct' => self::$checkNbOfProduct
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `user` WHERE $whereClause ");
				$stmt->execute();
				
				self::$checkNbOfProduct = $stmt->fetchColumn();

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkNbOfProduct'] = self::$checkNbOfProduct;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkNbOfProduct;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerUser()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.User');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/User.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerUser()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.User');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/User.log', Logger::DEBUG));
			}
		}
	}
?>