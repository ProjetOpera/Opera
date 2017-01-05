<?php
/**
 * Description of typesvaleurs
 *
 * @author a178017
 */
class Typesvaleurs {

 
  private $_obj_pdo_prepare 
         ,$_id
         ,$_code
         ,$_tbl_liste = "portailv2.typevaleur"
         ,$_tbl_liste_items = "portailv2.typevaleur_items";
 
        
  public $_query=array()
        ,$_last_insert_id=""
        ,$_o_db;
 
 function __construct($DB,$code=NULL,$id=NULL) {
  $this->_o_db = $DB;
  $this->_code=$code;
  $this->_id=$id;
 }
 
 
 
 	/**
	* Requête : SELECT
	* return : Array
	* fetchAll — > Retourne un tableau contenant toutes les lignes du jeu d'enregistrements 
	*/
	public function querySelect($sql,$a_data=NULL){
	$this->_query = array('SQL'=>$sql,"A_DATA"=>$a_data);
   try{
    $this->_obj_pdo_prepare = $this->_o_db->prepare($sql);
    $this->_obj_pdo_prepare->execute($a_data);
    return $this->_obj_pdo_prepare->fetchAll();
    } catch(Exception $e){
     echo "<br>".$e->getMessage()."<br>";
		 var_dump(debug_backtrace());	
   }
  } 

	/**
	* Requête : INSERT
	* return : int : ID INSERT
	*/
  public function queryInsert($sql,$a_data=NULL){
	 $this->_query = array('SQL'=>$sql,"A_DATA"=>$a_data);
   try{
      $this->_obj_pdo_prepare = $this->_o_db->prepare($sql);
      $this->_obj_pdo_prepare->execute($a_data);
      $this->_last_insert_id = $this->_o_db->lastInsertId();
      return $this->_last_insert_id ;
   } catch(Exception $e){
      echo "<br>".$e->getMessage()."<br>";
			var_dump(debug_backtrace());	
   }
  }
  
 	/**
	* Requête : EXEC (pour les Update/Delete..)
	* return : True/False
	*/ 
 public function queryExec($sql,$a_data=NULL){
  $this->_query = array('SQL'=>$sql,"A_DATA"=>$a_data);
  try{
    $this->_obj_pdo_prepare = $this->_o_db->prepare($sql);
    return $this->_obj_pdo_prepare->execute($a_data);
  } catch(Exception $e){
     echo "<br>".$e->getMessage()."<br>";
		 var_dump(debug_backtrace());			
  }
 }
 
 
 
 /**
  * retourne la liste
  * types / valeurs
  * @return type
  */
 public function getListeTV(){ 
  $sql="SELECT * FROM $this->_tbl_liste 
        ORDER BY code"; 
  return $this->querySelect($sql);
 } 
 
 
 public function getListeItems($orderby='code', $id_arg=null){ 
  if ($id_arg != null) {
   $id = $id_arg;
  }
  else {
   $id= $this->_id;
  }
  $sql="SELECT * 
        FROM $this->_tbl_liste_items
        WHERE id_typevaleur = '$id'
        ORDER BY $orderby"; 
  //echo $sql;
  return $this->querySelect($sql);
 }
 
 
 public function getListeItemsByCode($orderby='code', $code){ 
  $sql="SELECT i.* 
        FROM $this->_tbl_liste_items i
            ,$this->_tbl_liste t
        WHERE t.id_typevaleur = i.id_typevaleur
        AND   t.code = '$code'
        ORDER BY $orderby"; 
  
  return $this->querySelect($sql);
 }
 
 
 public function deleteListe($id=NULL){
  $id=$id?$id:$this->_id;
  $this->deleteItems($id);
  $sql = "DELETE FROM $this->_tbl_liste
          WHERE id_typevaleur ='$id'
          ";
  return $this->queryExec($sql);
 }
 
 public function deleteItems($id=NULL){
  $id=$id?$id:$this->_id;
  $sql = "DELETE FROM $this->_tbl_liste_items
          WHERE id_typevaleur ='$id'
          ";
 return $this->queryExec($sql);
}
 
public function insertItems($a_items=NULL){
 $id = $this->_id;
 $this->deleteItems($id);
 if($a_items){
 $sql="INSERT INTO $this->_tbl_liste_items 
  (id_typevaleur,code,lib_fr,lib_en,`defaut`) VALUES ";
  foreach($a_items as $M){
   $code = $M[0];
   $lib_fr = $M[1];
   $lib_en = $M[2];
   $defaut=$M[3];
   $sql .="('$id','$code','$lib_fr','$lib_en','$defaut'),";
      
  }
  $sql = substr($sql,0,-1);
  return $this->queryExec($sql);
 }else{
  return 'no items ';
 }
  
}
 
/**
 * 
 * @param type $code
 * @param type $description
 * @param type $actif
 * @return type
 */
function editListe($code,$description){
 $id = $this->_id;
 $params=array(":code"=>$code,":description"=>$description);
 $sql = "UPDATE $this->_tbl_liste
            SET code=:code
               ,description = :description
         WHERE id_typevaleur = '$id'
         ";
 return $this->queryExec($sql,$params);
} 
 
/**
 * 
 * @param type $code
 * @param type $description
 * @param type $actif
 * @return type
 */
 function addList($code,$description){
   $sql = "INSERT INTO $this->_tbl_liste
            (code,description)
            values(:code,:description)
          ";
 $params=array(":code"=>$code,":description"=>$description);
 return $this->queryInsert($sql,$params);
 }
 
 
 /**
 * Verifie si un code existe
 * @return type
 */
public function checkIfCode_LIST_Exist($id=NULL){
 $strAnd  = $id ? " AND id_typevaleur NOT IN('$id') ":"";
 $code = $this->_code;
  $sql="SELECT * 
       FROM $this->_tbl_liste
       WHERE code = '$code'
       $strAnd ";
 $res = $this->querySelect($sql);
 return count($res)>0?true:false;
}
 
 /**
 * Verifie si un code existe
 * @return type
 */
public function checkIfCode_LIST_ITEM_Exist($id=NULL){
 $strAnd  = $id ? " AND id NOT IN('$id') ":"";
 $code = $this->_code;
  $sql="SELECT * 
       FROM $this->_tbl_liste_items
       WHERE code = '$code'
       $strAnd ";
 $res = $this->querySelect($sql);
 return count($res)>0?true:false;
}
 
 
 
 
 
 
 
// ------------ FIN DE LA CLASS --------------------
}
?>
