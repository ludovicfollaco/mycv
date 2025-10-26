<?php
	//CarForm.php
	//Author: Ludovic FOLLACO
	//checked to 2024-10-04_16:49
	namespace Model\CarForm;
	use Model\Car\Car;

	class CarForm extends Car
	{
		private $btnNavBarInsert = false;
		public function getBtnNavBarInsert():bool{
			return $this->btnNavBarInsert;
		}
		public function setBtnNavBarInsert(bool $new):void{
			$this->btnNavBarInsert = $new;
		}

		//-----------------------------------------------------------------------

		private $btnCarEdit = false;
		public function getBtnCarEdit():bool{
			return $this->btnCarEdit;
		}
		public function setBtnCarEdit(bool $new):void{
			$this->btnCarEdit = $new;
		}

		//-----------------------------------------------------------------------

		private $btnInsert = false;
		public function getBtnInsert():bool{
			return $this->btnInsert;
		}
		public function setBtnInsert(bool $new):void{
			$this->btnInsert = $new;
		}

		//-----------------------------------------------------------------------

		private $btnDelete = false;
		public function getBtnDelete():bool{
			return $this->btnDelete;
		}
		public function setBtnDelete(bool $new):void{
			$this->btnDelete = $new;
		}

		//-----------------------------------------------------------------------

		private $btnCancel = false;
		public function getBtnCancel():bool{
			return $this->btnCancel;
		}
		public function setBtnCancel(bool $new):void{
			$this->btnCancel = $new;
		}

		//-----------------------------------------------------------------------

		private $btnUpdate = false;
		public function getBtnUpdate():bool{
			return $this->btnUpdate;
		}
		public function setBtnUpdate(bool $new):void{
			$this->btnUpdate = $new;
		}

		//-----------------------------------------------------------------------

		private $btnUpdate1 = false;
		public function getBtnUpdate1():bool{
			return $this->btnUpdate1;
		}
		public function setBtnUpdate1(bool $new):void{
			$this->btnUpdate1 = $new;
		}

		//-----------------------------------------------------------------------

		private $btnImage1 = false;
		public function getBtnImage1():bool{
			return $this->btnImage1;
		}
		public function setBtnImage1(bool $new):void{
			$this->btnImage1 = $new;
		}

		//-----------------------------------------------------------------------

		private $btnImage2 = false;
		public function getBtnImage2():bool{
			return $this->btnImage2;
		}
		public function setBtnImage2(bool $new):void{
			$this->btnImage2 = $new;
		}

		//-----------------------------------------------------------------------

		private $btnImage3 = false;
		public function getBtnImage3():bool{
			return $this->btnImage3;
		}
		public function setBtnImage3(bool $new):void{
			$this->btnImage3 = $new;
		}

		//-----------------------------------------------------------------------

		private $btnImage4 = false;
		public function getBtnImage4():bool{
			return $this->btnImage4;
		}
		public function setBtnImage4(bool $new):void{
			$this->btnImage4 = $new;
		}

		//-----------------------------------------------------------------------

		private $btnImage5 = false;
		public function getBtnImage5():bool{
			return $this->btnImage5;
		}
		public function setBtnImage5(bool $new):void{
			$this->btnImage5 = $new;
		}

		//-----------------------------------------------------------------------

		private $carEditNewError = false;
		public function getNewError():bool{
			return $this->carEditNewError;
		}
		public function setNewError(bool $new):void{
			$this->carEditNewError = $new;
		}

		//-----------------------------------------------------------------------

		private $newCar = false;
		public function getNewCar():bool{
			return $this->newCar;
		}
		public function setNewCar(bool $new):void{
			$this->newCar = $new;
		}

	}
?>