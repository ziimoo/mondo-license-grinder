<?php
include('config.php');

class LicensePDO extends PDO{
	private $preparedStatements=array();
	
	public function getAssoc($table){
		$stmt=&$this->preparedStatement(
			$table.'All',
			"SELECT `id`,`name` FROM `$table` ORDER BY `name` ASC"
		);
		$stmt->execute();
		if($stmt->rowCount()==0){
			return array();
		}
		$result=array();
		while($data=$stmt->fetch(PDO::FETCH_NUM)){
			$result[$data[0]]=$data[1];
		}
		$stmt->closeCursor();
		return $result;
	}
	
	public function getOneValue($sql){
		$res=$this->query($sql);
		if($res->rowCount()==0) return false;
		while($row=$res->fetch(PDO::FETCH_NUM)){
			return $row[0];
		}
	}
	
	public function tagExists($tagname){
		$stmt=&$this->preparedStatement(
			'getRecordIdByTag',
			"
				SELECT
					`id`
				FROM
					`record`
				WHERE
					`tag`=:tag
			"
		);
		$stmt->execute(array(':tag'=>$tagname));
		if($stmt->rowCount()==0){
			return false;
		}
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		return $row['tag'];
	}
	
	public function getTagById($id){
		$stmt=&$this->preparedStatement(
			'getTagById',
			"
				SELECT
					`tag`
				FROM
					`record`
				WHERE
					`id`=:id
			"
		);
		$stmt->execute(array(':id'=>$id));
		if($stmt->rowCount()==0){
			return false;
		}
		$tag=false;
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$tag=$row['tag']; //obviously there's only one result
			break;
		}
		$stmt->closeCursor();
		return $tag;
	}

	public function deleteRecord($id){
		$sql="
			DELETE FROM `record` WHERE `id`=$id
		";
		$this->exec($sql);
	}
	
	public function licenseExistsWithTitle($title){
		$stmt=$this->preparedStatement(
			'licenseExistsWithTitle',
			"SELECT `id` FROM `record` WHERE `title`=:title"
		);
		$stmt->execute(array(':title'=>$title));
		if($stmt->rowCount() > 0){
			return true;
		}
		return false;
	}
	
	public function getLicenseData($tag_or_id){
		if(is_numeric($tag_or_id)){
			$stmt=&$this->preparedStatement(
				'getLicenseDataById',
				"
			    SELECT *
    			FROM
        			`record`
    			WHERE
        			`id`=:id
        		"
        	);
			$param=':id';
        }else{
			$stmt=&$this->preparedStatement(
				'getLicenseDataByTag',
				"
			    SELECT *
    			FROM
        			`record`
    			WHERE
        			`tag`=:tag
        		"
        	);
			//id
			$param=':tag';
		}
		$stmt->execute(array($param=>$tag_or_id));
		if($stmt->rowCount()==0){
			return false;
		}
		$data=false;
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$data=$row; 
			break;
		}
		$stmt->closeCursor();
		if($data){
			if($data['vendor']){
				$data['vendorName']=$this->getVendorNameById($data['vendor']);
			}else{
				$data['vendorName']='';
			}
			if($data['consortium']){
				$data['consortiumName']=$this->getConsortiumNameById($data['consortium']);
			}else{
				$data['consortiumName']='';
			}
		}
		return $data;
	}
	
	public function updateRecord($id, $data){
		$bind=array();
		$cols=array();
		foreach($data as $k=>$v){
			$bind[':'.$k]=$v;
			$cols[]="`$k`=:$k";
		}
		if($id<=0){ // new, so insert
			$sql="INSERT INTO `record` SET "
				.implode(',',$cols);
			$stmt=$this->preparedStatement(
				'insertRecord'.md5($sql),
				$sql
			);
			$stmt->execute($bind);
			$id=$this->lastInsertId();
		}else{
			$sql="UPDATE `record` SET "
				.implode(',',$cols)
				.' WHERE `id`=:id';
			$bind[':id']=$id;
			$stmt=$this->preparedStatement(
				'updateRecord'.md5($sql),
				$sql
			);
			$stmt->execute($bind);
		}
		return $id;
	}
	
	public function getHTML($key){
		$stmt=$this->preparedStatement(
			'getHTML',
			"SELECT `content` FROM `html` WHERE `tag`=:key"
		);
		$stmt->execute(array(':key'=>$key));
		if($stmt->rowCount()=='0'){
			global $defaults;
			return $defaults[$key];
		}
		$row=$stmt->fetch(PDO::FETCH_ASSOC);
		return $row['content'];
	}
	
	public function setHTML($key, $html=false){
		$stmt=$this->preparedStatement(
			'delHTML',
			"DELETE FROM `html` WHERE `tag`=:key"
		);
		$stmt->execute(array(':key'=>$key));
		if($html){
			$stmt=$this->preparedStatement(
				'setHTML',
				"INSERT INTO `html` SET `content`=:html, `tag`=:key"
			);
			$stmt->execute(array(':key'=>$key,':html'=>$html));
			return $html;
		}
		return '';
	}


	public function getVendorNameById($id){
		$stmt=&$this->preparedStatement(
			'getVendorName',
			"SELECT `name` FROM `vendor` WHERE `id`=:id"
		);
		$stmt->execute(array(':id'=>$id));
		if($stmt->rowCount()==0){
			return false;
		}
		$data=false;
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$data=$row['name']; 
			break;
		}
		$stmt->closeCursor();
		return $data;
	}
	
	public function getConsortiumNameById($id){
		$stmt=&$this->preparedStatement(
				'getConsortiumName',
				"SELECT `name` FROM `consortium` WHERE `id`=:id"
			);
		$stmt->execute(array(':id'=>$id));
		if($stmt->rowCount()==0){
			return false;
		}
		$data=false;
		while($row=$stmt->fetch(PDO::FETCH_ASSOC)){
			$data=$row['name']; 
			break;
		}
		$stmt->closeCursor();
		return $data;
	}

	public function getInitialsForNavigation(){
		$stmt=&$this->preparedStatement(
				'getInitials',
				"SELECT DISTINCT UPPER(SUBSTR(`title`,1,1)) as initial FROM `record` ORDER BY initial"
			);
		$stmt->execute();
		if($stmt->rowCount()==0){
			return false;
		}
		$data=$stmt->fetchAll(PDO::FETCH_COLUMN,0);
		$stmt->closeCursor();
		return $data;
	}
	
	public function findAsYouType($fragment){
		$stmt=&$this->preparedStatement(
				'findAsYouType',
				"SELECT `id` as value, `title` as label FROM `record` WHERE `title` LIKE :like ORDER BY `title` LIMIT 12"
			);
		$stmt->execute(array(':like'=>"%$fragment%"));
		$data=$stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $data;
	}

	public function findByInitial($initial){
		$stmt=$this->preparedStatement(
				'findByInitial',
				"SELECT `tag`,`title` FROM `record` WHERE `title` LIKE :initial order by `title`"
			);
		$stmt->execute(array(':initial'=>"$initial%"));
		$data=$stmt->fetchAll(PDO::FETCH_ASSOC);
		$stmt->closeCursor();
		return $data;
	}
		
	private function preparedStatement($label,$sql){
		if(empty($this->preparedStatements[$label])){
			$this->preparedStatements[$label]=$this->prepare($sql);
		}
		return $this->preparedStatements[$label];
	}

	public function cvUpdate($vocab,$id,$term){
		$term=trim($term);
		if(!$term){
			$stmt=$this->preparedStatement(
				'cvDelete_'.$vocab,
				"DELETE FROM `$vocab` WHERE `id`=:id"
			);
			$stmt->execute(array(':id'=>$id));
			return true;
		}
		if($existing_id=$this->cvTermExists($vocab,$term)){
			return  $existing_id;
		}
		if($id>=0){
			$stmt=$this->preparedStatement(
				'cvUpdate_'.$vocab,
				"UPDATE `$vocab` SET `name`=:name WHERE `id`=:id"
			);
			$stmt->execute(array(':name'=>$term,':id'=>$id));
			return $id;
		}else{
			$stmt=$this->preparedStatement(
				'cvInsert_'.$vocab,
				"INSERT INTO `$vocab` SET `name`=:name"
			);
			$stmt->execute(array(':name'=>$term));
			return $this->lastInsertId();
		}
	}
	
	public function cvTermExists($vocab, $term){
		$stmt=$this->preparedStatement(
			'cvTermExists'.$vocab,
			"SELECT `id` FROM `$vocab` WHERE `name`=:name"
		);
		$stmt->execute(array(':name'=>$term));
		if($stmt){
			$row=$stmt->fetch(PDO::FETCH_ASSOC);
			return $row['id'];
		}
		return false;
	}
	
	public function cvMerge($vocab,$ids=false,$term=''){
		$term=trim($term);
		if(!$term) return false;
		if(!$ids) return false;
		$ids=implode(',',$ids);
		$this->exec("DELETE FROM `$vocab` WHERE `id` IN($ids)");
		$this->cvUpdate($vocab,-1,$term);
		$nid=$this->lastInsertId('id');
		$this->exec("UPDATE `record` SET `$vocab`=$nid WHERE `$vocab` IN($ids)");
		return true;
	}
	
}


try{
	$dsn = DBTYPE.':dbname='.DBNAME.';host='.DBHOST;
	$db = new LicensePDO($dsn,DBUSER,DBPASS);
}catch(PDOException $e){
	die('DB Connect fail: '.$e->getMessage());
}

