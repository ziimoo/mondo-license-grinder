<?php
/*wtf kind of reports do we even want?*/
$binaries=array(
	'e_reserves'=>'e-Reserves',
	'course_pack'=>'Course Pack',
	'durable_url'=>'Durable URL',
	'alumni_access'=>'Alumni Access',
	'perpetual_access'=>'Perpetual Access',
	'password'=>'Password Required',
	'ill_print'=>'ILL Print',
	'ill_electronic'=>'ILL Electronic',
	'ill_ariel'=>'ILL Ariel',
	'walk_in'=>'Walk In'
);
include('../db.inc.php');
foreach(array('vendor'=>'Vendor','consortium'=>'Consortium') as $table => $nice){
	$$table=$db->GetAssoc($table);
}
if($_POST){
	$bsql=array();
	foreach($binaries as $k=>$v){
		$pv=$_POST[$k];
		if($pv==1){
			$bsql[]="`$k`=1";
		}else if($pv==2){
			$bsql[]="`$k`=0";
		}else{
			//eh
		}
	}
	if($_POST['vendor']){
		$bsql[]='`vendor`='.$_POST['vendor'];
	}
	if($_POST['consortium']){
		$bsql[]='`consortium`='.$_POST['consortium'];
	}
	$bsql=implode(' AND ',$bsql);
	
	if(!$bsql) $bsql=1;
	$sql="
		SELECT 
			`id`
		FROM `record`
		WHERE
			$bsql
		ORDER BY `title` ASC
	";
	$res=$db->query($sql);
	$res=$res->fetchAll(PDO::FETCH_ASSOC);
	$sql="SELECT COUNT(*) FROM `record`";
	$count=$db->getOneValue($sql);
	if($res){
		header('Content-type:text/csv');
		header('Content-disposition:attachment,filename="licensedata.csv"');
?>"Title","Vendor","Consortium","e-Reserves","Course Pack","Durable URL","Alumni Access","Perpetual Access","Password Required","ILL Print","ILL Electronic","ILLL Ariel","Walk In"
<?php
		foreach($res as $rn=>$row){
			$id=$row['id'];
			$data=$db->getLicenseData($id);
			unset($row['id']);
			$out=array();
			foreach(
				array(
                    'title',
                    'vendorName',
                    'consortiumName',
                    'e_reserves',
                    'course_pack',
                    'durable_url',
                    'alumni_access',
                    'perpetual_access',
                    'password',
                    'ill_print',
                    'ill_electronic',
                    'ill_ariel',
                    'walk_in'
               	) as $k){
               	$v=$data[$k];
				switch($k){
					case 'vendorName':
						$out[]=$vendor[$v];
						break;
					case 'consortiumName':
						$out[]=$consortium[$v];
						break;
					case 'title':
						$out[]=$v;
						break;
					default:
						if($v) $out[]= 'Yes';
						else $out[]= 'No';
						
				}
			}
			foreach($out as $i=>$o){
				$out[$i]='"'.str_replace('"','""',$o).'"';
			}
			echo implode(',',$out)."\n";
		}
	}else{
		echo '';
	}
			
}
