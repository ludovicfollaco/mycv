<?php
	//Subscription.php
	//author : Ludovic FOLLACO
	//checked to 2024-10-04_15:54
	namespace Model\Subscription;

	use PDO;
	use \PDOException;
	use Model\DbConnect\DbConnect;
	use Model\Utilities\Utilities;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

	class Subscription
	{
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct()
		{
			if($_SESSION['debug']['monolog']){
				$this->initLoggerSubscription();
			}
		}

		private $id_subscription;
		public function getIdSubscription():int{
			return $this->id_subscription;
		}
		public function setIdSubscription(int $new):void{
			$this->id_subscription = $new;
		}

		//-----------------------------------------------------------------------

		private $subscription;
		public function getSubscription():string{
			return $this->subscription;
		}
		public function setSubscription(string $new):void{
			$this->subscription = $new;
		}

		//-----------------------------------------------------------------------

		private $currentSubscription = array();
		public function getCurrentSubscription(int $id_subscription):array{

			$this->currentSubscription = [];

			if($_SESSION['debug']['monolog']){
				$this->initLoggerSubscription();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getCurrentSubscription()',
					'$id_subscription' => $id_subscription,
					'$currentSubscription' => $this->currentSubscription
				];
			}
	
			if(Utilities::checkData('subscription','id_subscription', $id_subscription)){
				
				$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
				try{
					$stmt = $bdd->prepare("SELECT  `subscription`.`id_subscription`,
												   `subscription`.`subscription`
											 FROM  `subscription`
											WHERE  `subscription`.`id_subscription` = :id_subscription");

					$stmt->bindParam(':id_subscription', $id_subscription, PDO::PARAM_INT);

					$stmt->execute();

					$this->currentSubscription = $stmt->fetch(PDO::FETCH_ASSOC);

					if($_SESSION['debug']['monolog']){
						$arrayLogger['$currentSubscription'] = $this->currentSubscription;
						$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
					}

					return $this->currentSubscription;

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

		private $subscriptionList = array();
		public function getSubscriptionList(string $whereClause, string $orderBy = 'subscription', string $ascOrDesc = 'ASC', int $firstLine = 0, int $linePerPage = 50):array{
			
			$this->subscriptionList = [];

			if($_SESSION['debug']['monolog']){
				$this->initLoggerSubscription();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'getSubscriptionList()',
					'$whereClause' => $whereClause,
					'$orderBy' => $orderBy,
					'$ascOrDesc' => $ascOrDesc,
					'$firstLine' => $firstLine,
					'$linePerPage' => $linePerPage,
					'$subscriptionList' => $this->subscriptionList
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
			    $stmt = $bdd->prepare("SELECT `subscription`.`id_subscription`,
											  `subscription`.`subscription`
										FROM  `subscription`
										WHERE $whereClause
									 ORDER BY :orderBy :ascOrDesc
										LIMIT :firstLine, :linePerPage");

				$stmt->bindParam(':orderBy', $orderBy, PDO::PARAM_STR);
				$stmt->bindParam(':ascOrDesc', $ascOrDesc, PDO::PARAM_STR);
				$stmt->bindParam(':firstLine', $firstLine, PDO::PARAM_INT);
				$stmt->bindParam(':linePerPage', $linePerPage, PDO::PARAM_INT);

				$stmt->execute();

				$this->subscriptionList = $stmt->fetchall(PDO::FETCH_ASSOC);
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$subscriptionList'] = true; //$this->subscriptionList; // replace true; by $this->subscriptionList; if you want to see the result
					$this->logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

				return $this->subscriptionList;

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

		private $insertSubscription = 0;
		public function insertSubscription():int{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerSubscription();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'insertSubscription()',
					'$insertSubscription' => $this->insertSubscription
				];
			}

			$configDb = DbConnect::configDbConnect();

			foreach ($configDb as $dbName => $configDbConnect){

				$subscriptionExist = false;

				if (!self::checkSubscription($this->subscription, $dbName)){
					$bdd = DbConnect::connectionDb($configDbConnect);
				} else {
					$subscriptionExist = true;
				}

				if(!$subscriptionExist){

					try{
						$stmt = $bdd->prepare('INSERT INTO `subscription`(`subscription`) VALUES (:subscription)');
						$stmt->bindParam(':subscription', $this->subscription, PDO::PARAM_STR);
						$stmt->execute();

						$stmt = $bdd->prepare('SELECT MAX(`id_subscription`) FROM `subscription`');
						$stmt->execute();

						$this->insertSubscription = intval($stmt->fetchColumn());
						
						if($_SESSION['debug']['monolog']){
							$arrayLogger['$insertSubscription'] = $this->insertSubscription;
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
			}
			
			return $this->insertSubscription;
		}

		//-----------------------------------------------------------------------

		private $updateSubscription = false;
		public function updateUserSubscription(int $id_subscription):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerSubscription();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'updateSubscription()',
					'$id_subscription' => $id_subscription,
					'$updateSubscription' => $this->updateSubscription
				];
			}

			$configDb = DbConnect::configDbConnect();

			foreach ($configDb as $dbName => $configDbConnect) {

				$subscriptionExist = false;

				if(self::checkIdSubscription($id_subscription, $dbName)){
					$bdd = DbConnect::connectionDb($configDbConnect);
					$subscriptionExist = true;
				}

				if($subscriptionExist){

					try{
						$stmt = $bdd->prepare('UPDATE `subscription`
												  SET `subscription`    = :subscription
												WHERE `id_subscription` = :id_subscription');

						$stmt->bindParam(':subscription', $this->subscription, PDO::PARAM_STR);
						$stmt->bindParam(':id_subscription', $id_subscription, PDO::PARAM_INT);

						$stmt->execute();

						$this->updateSubscription = true;
					
						if($_SESSION['debug']['monolog']){
							$arrayLogger['$updateSubscription'] = $this->updateSubscription;
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
			}

			return $this->updateSubscription;
		}

		//-----------------------------------------------------------------------
		private $deleteSubscription = false;
		public function deleteSubscription(int $id_subscription):bool{

			if($_SESSION['debug']['monolog']){
				$this->initLoggerSubscription();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'deleteSubscription()',
					'$id_subscription' => $id_subscription,
					'$deleteSubscription' => $this->deleteSubscription
				];
			}

			$configDb = DbConnect::configDbConnect();

			foreach ($configDb as $dbName => $configDbConnect) {

				$subscriptionExist = false;

				if(self::checkIdSubscription($id_subscription, $dbName)){
					$bdd = DbConnect::connectionDb($configDbConnect);
					$subscriptionExist = true;
				}

				if($subscriptionExist){

					try{
						$stmt = $bdd->prepare('DELETE FROM subscription WHERE id_subscription = :id_subscription');
						$stmt->bindParam(':id_subscription', $id_subscription, PDO::PARAM_INT);
						
						$stmt->execute();
						
						$this->deleteSubscription = true;

						if($_SESSION['debug']['monolog']){
							$arrayLogger['$deleteSubscription'] = self::$deleteSubscription;
							self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
						}
					
					}catch (PDOException $e){
						if($_SESSION['debug']['monolog']){
							$this->logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
						}
					}finally{
						$bdd=null;
					}
				}
			}

			return $this->deleteSubscription;
		}

		//-----------------------------------------------------------------------

		private static $checkSubscription = false;
		public static function checkSubscription(string $subscription, string $db = 'mycv'):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerSubscription();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkSubscription()',
					'$subscription' => $subscription,
					'$checkSubscription' => self::$checkSubscription
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `subscription` WHERE `subscription` = :subscription");
				$stmt->bindParam(':subscription', $subscription, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkSubscription = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkSubscription'] = self::$checkSubscription;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkSubscription;
		}

		//-----------------------------------------------------------------------

		private static $checkIdSubscription = false;
		public static function checkIdSubscription(int $id_subscription, string $db = 'mycv'):bool{
				
			if($_SESSION['debug']['monolog']){
				self::initStaticLoggerSubscription();
				$arrayLogger = [
					'user' => $_SESSION['dataConnect']['pseudo'],
					'function' => 'checkIdSubscription()',
					'$id_subscription' => $id_subscription,
					'$checkIdSubscription' => self::$checkIdSubscription
				];
			}

			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());
			
			try{
				$stmt = $bdd->prepare("SELECT COUNT(*) FROM `subscription` WHERE `id_subscription` = :id_subscription");
				$stmt->bindParam(':id_subscription', $id_subscription, PDO::PARAM_STR);

				$stmt->execute();

				$result = $stmt->fetchColumn();

				if($result > 0){
					self::$checkIdSubscription = true;
				}

				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkIdSubscription'] = self::$checkIdSubscription;
					self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch(PDOException $e){
				if($_SESSION['debug']['monolog']){
					self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
				}

			}finally{
				$bdd=null;
			}

			return self::$checkIdSubscription;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerSubscription()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Subscription');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/User.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerSubscription()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Subscription');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/User.log', Logger::DEBUG));
			}
		}
	}
?>