<?php
	//userForm.class.php
	//author : Ludovic FOLLACO
	//checked to 2024-10-04_16:02
	namespace Model\UserForm;

	use Model\User\User;

	class UserForm extends User
	{
		private $btnNavBarInsert = false;
		public function getBtnNavBarInsert():bool{
			return $this->btnNavBarInsert;
		}
		public function setBtnNavBarInsert(bool $new):void{
			$this->btnNavBarInsert = $new;
		}

		//-----------------------------------------------------------------------

		private $btnUserEdit = false;
		public function getBtnUserEdit():bool{
			return $this->btnUserEdit;
		}
		public function setBtnUserEdit(bool $new):void{
			$this->btnUserEdit = $new;
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

		private $btnAvatar = false;
		public function getBtnAvatar():bool{
			return $this->btnAvatar;
		}
		public function setBtnAvatar(bool $new):void{
			$this->btnAvatar = $new;
		}

		//-----------------------------------------------------------------------

		private $btnVenesia = false;
		public function getBtnVenusia():bool{
			return $this->btnVenesia;
		}
		public function setBtnVenusia(bool $new):void{
			$this->btnVenesia = $new;
		}

		//-----------------------------------------------------------------------

		private $btnActarus = false;
		public function getBtnActarus():bool{
			return $this->btnActarus;
		}
		public function setBtnActarus(bool $new):void{
			$this->btnActarus = $new;
		}

		//-----------------------------------------------------------------------

		private $btnGoldorak = false;
		public function getBtnGoldorak():bool{
			return $this->btnGoldorak;
		}
		public function setBtnGoldorak(bool $new):void{
			$this->btnGoldorak = $new;
		}

		//-----------------------------------------------------------------------

		private $btnMonCompte = false;
		public function getBtnMonCompte():bool{
			return $this->btnMonCompte;
		}
		public function setBtnMonCompte(bool $new):void{
			$this->btnMonCompte = $new;
		}

		//-----------------------------------------------------------------------

		private $userEditNewError = false;
		public function getNewError():bool{
			return $this->userEditNewError;
		}
		public function setNewError(bool $new):void{
			$this->userEditNewError = $new;
		}

		//-----------------------------------------------------------------------

		private $newUser = false;
		public function getNewUser():bool{
			return $this->newUser;
		}
		public function setNewUser(bool $new):void{
			$this->newUser = $new;
		}

		//-----------------------------------------------------------------------

		private $newMember = false;
		public function getNewMember():bool{
			return $this->newMember;
		}
		public function setNewMember(bool $new):void{
			$this->newMember = $new;
		}
		
	}
?>