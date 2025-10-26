<?php
    //page.class.php
	//author : Ludovic FOLLACO
    //checked to 2024-10-04_15:49
    namespace Model\Page;

	use \PDOException;
	use Model\DbConnect\DbConnect;
	use Monolog\Logger;
	use Monolog\Handler\StreamHandler;
    use function PHPUnit\Framework\isNull;

	class Page
    {
		const MSG_QUERY_ERROR = "Error to query.";
		const MSG_QUERY_CORRECTLY = "Query executed correctly.";

		public function __construct()
		{
			if($_SESSION['debug']['monolog']){
				$this->initLoggerPage();
			}
		}

        // __Nombre de ligne__________________________________________

        private $nbOfProduct = 1;
        public function getNbOfProduct():int{
            return $this->nbOfProduct;
        }
        public function setNbOfProduct(int $new):void{
            $this->nbOfProduct = $new;
        }
        
        // __Première ligne de la page active__________________________________________
        
        private $firstLine = 0;
        public function getFirstProduct():int{
            return $this->firstLine;
        }
        public function setFirstProduct(int $new):void{
            $this->firstLine = $new;
        }
        
        // __Nombre de ligne par page__________________________________________
        
        private $nbProductPerPage = 3;
        public function getProductPerPage():int{
            return $this->nbProductPerPage;
        }
        public function setProductPerPage(int $new):void{
            $this->nbProductPerPage = $new;
        }
        
        // __La page active__________________________________________

        private $thePage = 1;
        public function getThePage():int{
            return $this->thePage;
        }
        public function setThePage(int $new):void{
            $this->thePage = $new;
        }
        
        // __Nombre de page__________________________________________

        private $nbOfPage = 1;
        public function getNbOfPage():int{
            return $this->nbOfPage;
        }
        public function setNbOfPage(int $new):void{
            $this->nbOfPage = $new;
        }

        // __Page suivante ou précédente__________________________________________

        private $nextOrPrevious = 1;
		public function getNextOrPrevious():bool{
			return $this->nextOrPrevious;
		}
		public function setNextOrPrevious(bool $new):void{
            $this->nextOrPrevious = $new;
		}

        // __Nombre de produit__________________________________________

        private static $checkNumberOfProduct = 0;
		public static function checkNumberOfProduct(string $table , string $whereClause = null):int{

			if($_SESSION['debug']['monolog']){
                self::initStaticLoggerPage();
				$arrayLogger = [
                    'user' => $_SESSION['dataConnect']['pseudo'],
                    'function' => 'checkNumberOfProduct()',
                    '$table' => $table,
                    '$whereClause' => $whereClause,
                    '$checkNumberOfProduct' => self::$checkNumberOfProduct
                ];
			}
				
            $bdd = DbConnect::connectionDb(DbConnect::configDbConnect());

			try{
                if(isNull($whereClause)){
                    
                    $stmt = $bdd->prepare('SELECT count(*) FROM ' . $table);
                    $stmt->execute();
                    self::$checkNumberOfProduct = $stmt->fetchColumn();

                }else{
                    $stmt = $bdd->prepare('SELECT count(*) FROM ' . $table . ' WHERE ' . $whereClause);
                    $stmt->execute();
                    self::$checkNumberOfProduct = $stmt->fetchColumn();
                }

                if($_SESSION['debug']['monolog']){
                    $arrayLogger['$checkNumberOfProduct'] = self::$checkNumberOfProduct;
                    self::$staticLogger->info(self::MSG_QUERY_CORRECTLY, $arrayLogger);
                }

			}catch(PDOException $e){
                if($_SESSION['debug']['monolog']){
                    self::$staticLogger->error(self::MSG_QUERY_ERROR . $e->getMessage() . '.', $arrayLogger);
                }
            }finally{
                $bdd = null;
            }

            return self::$checkNumberOfProduct;
		}

        //-----------------------------------------------------------------------------------
        
        public static function FctNbPage(int $productPerPage, object $MyPage, string $table):void{
    
            $MyPage->setNbOfProduct(self::checkNumberOfProduct($table));
    
            $totalLigne = $MyPage->getNbOfProduct();
            
            if ($totalLigne < $productPerPage){
                $nbOfPage = 1;
                $MyPage->setThePage(1);            
            }else{
                $nbOfPage = ceil($totalLigne / $productPerPage);
                if ($nbOfPage < $MyPage->getThePage()){
                    $MyPage->setThePage(1);
                }
            }
            $MyPage->setNbOfPage($nbOfPage);
        }

		//-----------------------------------------------------------------------

		private static $staticLogger;
		public static function initStaticLoggerPage()
		{
			if (self::$staticLogger === null) {
				self::$staticLogger = new Logger('Class.Page');
				self::$staticLogger->pushHandler(new StreamHandler(__DIR__ . '/Page.log', Logger::DEBUG));
			}
		}

		//-----------------------------------------------------------------------

		private $logger;
		public function initLoggerPage()
		{
			if ($this->logger === null) {
				$this->logger = new Logger('Class.Page');
				$this->logger->pushHandler(new StreamHandler(__DIR__ . '/Page.log', Logger::DEBUG));
			}
		}
    }
?>