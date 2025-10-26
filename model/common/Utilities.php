<?php
    //Utilities.php
    //author: Ludovic FOLLACO
    //checked to 2024-10-04_16:06
    namespace Model\Utilities;
    
    use \PDO;
    use \PDOException;
    use Model\DbConnect\DbConnect;
    use Firebase\JWT\JWT;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;

    class Utilities
    {
        
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct()
		{
			if($_SESSION['debug']['monolog']){
				$this->initLoggerUtilities();
			}
		}

        // Creating of JWT token
        public static function tokenJwt(string $pseudo, string $key, int $delay = 3600):string{
            $tokenJwt = [
                'pseudo' => $pseudo,
                'delay' => time() + $delay,
                'key' => $key
            ];

            return JWT::jsonEncode($tokenJwt);
        }

        public static function checkTokenJwt():void{
            
            $jwt1 = JWT::jsondecode($_SESSION['token']['jwt']['tokenJwt']);
            $jwt2 = JWT::jsondecode(Utilities::tokenJwt($_SESSION['dataConnect']['pseudo'], $_SESSION['token']['jwt']['secretKey'], $_SESSION['token']['jwt']['delay']));
            
            $delay = $jwt2->{'delay'} - $jwt1->{'delay'} <= $_SESSION['token']['jwt']['delay'];
            $pseudo = $jwt1->{'pseudo'} === $jwt2->{'pseudo'};
            $key = $jwt1->{'key'} === $jwt2->{'key'};

            if(!$delay){
                resetDataConnectVarSession();
                self::redirectToPage('timeExpired');
            }else if(!$pseudo){
                resetDataConnectVarSession();
                self::redirectToPage('errorJwtPseudo');
            }else if(!$key){
                resetDataConnectVarSession();
                self::redirectToPage('errorJwtKey');
            }
            
            $_SESSION['token']['jwt']['tokenJwt'] = Utilities::tokenJwt($_SESSION['dataConnect']['pseudo'], $_SESSION['token']['jwt']['secretKey'], $_SESSION['token']['jwt']['delay']);

        }

        // Create and verification of CSRF token
        public static function ckeckCsrf():bool{

            if(isset($_POST['csrf']) && $_POST['csrf'] != $_SESSION['token']['csrf']){

                $_SESSION['other']['message'] = 'Error checking CSRF token!';
                return false;
            }
            $_SESSION['token']['csrf'] = bin2hex(random_bytes(32));
            return true;
        }

        // Escape Input
        public static function escapeInput($input):string{
            return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
        }

        // Filter Input
        public static function filterInput($input, $method = INPUT_POST):string{
            return filter_input($method, $input, FILTER_DEFAULT);
        }

        // Upload image
        public static function uploadImg(string $session1, string $session2, string $post, string $file, string $directory){
            
            $_SESSION[$session1][$session2] = isset($_POST[$post]) ? self::escapeInput($_POST[$post]) : false;
            $fileError = isset($_FILES[$file]) ? $_FILES[$file]["error"] : UPLOAD_ERR_NO_FILE;

            if ($fileError == UPLOAD_ERR_OK) {
                $fileName = self::escapeInput($_FILES[$file]["name"]);
                $sourceFile = $_FILES[$file]["tmp_name"];
                $destinationFile = $directory . basename($fileName);
            
                if (move_uploaded_file($sourceFile, $destinationFile)) {
                    $_SESSION[$session1][$session2] = $fileName;
                    return true;
                } else {
                    echo("<script>alert('Erreur lors de l\'upload de l\'image');</script>");
                    return false;
                }
            } else {
                echo("<script>alert('Aucune image n\'a été sélectionnée ou une erreur s\'est produite.');</script>");
                return [
                    'state' => false,
                    'message' => "pas d'image selectionnée"
                ];
            }
        }

        // Check if value is in url
        public static function checkValueInUrl(string $value):bool{
            $current_url = $_SERVER['REQUEST_URI'];
            $regEx = '/' . $value . '/i';
            return preg_match($regEx, $current_url);
        }

        // Check and return value in url
        public static function checkAndReturnValueInUrl():string{
            if(self::checkValueInUrl('goldorak')){
                return "goldorak";
            }elseif(self::checkValueInUrl('garageparrot')){
                return "garageparrot";
            }
            return "mycv";
        }

        // Check if local server
        public static function checkIfLocal():bool{
            return isset($_SESSION['other']['local']) ? boolval($_SESSION['other']['local']) : false;
        }

        // Road to page        
        public static function redirectToPage(string $page):void{
            $baseUrl = self::checkIfLocal() ? "http://mycv" : "https://www.follaco.fr";
            $siteName = self::checkAndReturnValueInUrl();
            $siteName = $siteName === 'mycv' ? 'index' : $siteName;
            $url = '<script>window.location.href = "' . $baseUrl . ($siteName === 'mycv' ? '' : '/' . $siteName) . '.php?page=' . $page . '";</script>';
            echo $url;
            die();
        }

        public static function redirectToPageTimeOut(string $page):void{
            $baseUrl = self::checkIfLocal() ? "http://mycv" : "https://www.follaco.fr";
            $siteName = self::checkAndReturnValueInUrl();
            $siteName = $siteName === 'mycv' ? 'index' : $siteName;
            $url = '<script>
                        setTimeout(function(){
                            window.location.href = "' . $baseUrl . ($siteName === 'mycv' ? '' : '/' . $siteName) . '.php?page=' . $page . '";
                        }, 5000);
                    </script>';
            echo $url;
            die();
        }

        // Check if id is existing
        private static $checkData = false;
		public static function checkData(string $table, string $columnId, int $id):bool{

			if($_SESSION['debug']['monolog']){
                self::initLoggerUtilities();
				$arrayLogger = [
                    'user' => $_SESSION['dataConnect']['pseudo'],
                    'function' => 'checkData()',
                    '$table' => $table,
                    '$columnId' => $columnId,
                    '$id' => $id, '$checkData' => self::$checkData
                ];
			}
            
			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

            try{

                $stmt = $bdd->prepare("SELECT COUNT(*) FROM $table WHERE $columnId = :id");
                $stmt->bindParam(':id', $id, PDO::PARAM_INT);
                $stmt->execute();

                $result = $stmt->fetchColumn();

                if($result > 0){
                    self::$checkData = true;
                }
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkData'] = self::$checkData;
					self::$logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch (PDOException $e){

                if($_SESSION['debug']['monolog']){
				    self::$logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
                }

			}finally{
				$bdd = null;
			}

            return self::$checkData;
		}

		//-----------------------------------------------------------------------

        // Check if id is existing
        private static $checkPage;
		public static function checkPage(string $table, string $page):int{

			if($_SESSION['debug']['monolog']){
                self::initLoggerUtilities();
				$arrayLogger = [
                    'user' => $_SESSION['dataConnect']['pseudo'],
                    'function' => 'checkPage()',
                    '$table' => $table,
                    '$columnId' => $columnId,
                    '$id' => $id, '$checkPage' => self::$checkPage
                ];
			}
            
			$bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

            try{

                $stmt = $bdd->prepare("SELECT `page`.`id` FROM $table WHERE `page`.`page` = :page");
                $stmt->bindParam(':page', $page, PDO::PARAM_STR);
                $stmt->execute();

                $checkPage = $stmt->fetch(PDO::FETCH_COLUMN);

                if (empty($checkPage)) {
                    $checkPage = 0;
                }
					
				if($_SESSION['debug']['monolog']){
					$arrayLogger['$checkPage'] = $checkPage;
					self::$logger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
				}

			}catch (PDOException $e){

                if($_SESSION['debug']['monolog']){
				    self::$logger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
                }

			}finally{
				$bdd = null;
			}

            return $checkPage;
		}

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerUtilities()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Utilities');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/Common.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerUtilities()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Utilities');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/Common.log', Logger::DEBUG));
			}
		}
    }
?>