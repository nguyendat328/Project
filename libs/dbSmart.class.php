<?php
	class dbSmart extends PDO{
		protected $_db;
		public function __construct($dsn,$urs,$pwd){
			try{
				$this->_db = new PDO($dsn, $urs,$pwd,  array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8") );
				// $this->_db->query("SET NAMES 'uft8'");
			}catch(PDOException $e){
				echo "The connection not success".$e->getMessage();
			}
		}
	
		
		public function execSQL($sql){
			$sth=$this->_db->prepare($sql);
			$sth->execute();
			return $sth;
		}
		public function fetchAll($sql){
			$stmt = $this->_db->prepare($sql);
			$stmt->execute();
			$rs = $stmt->fetchAll();
			return $rs;
			
		}
		public function fetchOnes($tbl,$condition){
			$rs = array();
			$sql = "SELECT * FROM {$tbl} WHERE {$condition}";
			$stm = $this->_db->prepare($sql);
			$stm->execute();
			$rs = $stm->fetch();
			return $rs;
		}
		public function fetchOne($sql){
			$dbh = $this->execSQL($sql);
			return $dbh->fetch(PDO::FETCH_ASSOC);
		}
		public function insert($tblName,$arr){
			//"INSERT INTO tblcategories(cat_name,cat_des)
			//VALUES('$cat_name','$cat_des')";
			$flag = 'NO';
			$arFields   = array_keys($arr);
			$listFields = implode(',',$arFields);
			$arValues   = array_values($arr);
			if(count($arValues)>0){
				foreach($arValues as $v){
				   $arStringValues[] = "'".$v."'"; 
				}
				$listValues = implode(',',$arStringValues);
			}
			$sql = "INSERT INTO {$tblName}({$listFields}) VALUES({$listValues})";
			$stmt = $this->_db->prepare($sql);
			if($stmt->execute()){
				$flag = 'YES';
			}
			return $flag;
		}

		public function delete($sql){
			$f = 'NO';
			$stmt = $this->_db->prepare($sql);
			if($stmt->execute()){
				$f = 'YES';
			}
			return $f;
		}
		public function getInfor($tbl,$key,$value,$_name,$head,$where=null,$focus=null){
			$sql= "SELECT $key,$value FROM $tbl WHERE $where";
			$rs = $this->fetchAll($sql);
			$sBox ="<select name='$_name'><option value='-1'>$head</option>";
			if($rs){
				foreach($rs as $r){
					$sBox .="<option value='".$r[$key]."'>".$r[$value]."</option>";
				}
			}
			$sBox .="</select>";
			if($_POST){
				$v = $_POST[$_name];
				$sBox = str_replace("<option value='".$v."'>","<option value='".$v."' selected='selected'>",$sBox);
			}
			if($focus!=null){
				$sBox = str_replace("<option value='".$focus."'>","<option value='".$focus."' selected='selected'>",$sBox);
			}
			return $sBox;
		}
		public function existsEmail($tbl,$field,$email){
			$t = 0;
			$sql = "SELECT $field FROM $tbl WHERE $field LIKE '$email'";
			$rs =$this->fetchOne($sql);
			if($rs&&$rs[$field]!=''){
				$t=1;
			}
			return $t;
		}

	}