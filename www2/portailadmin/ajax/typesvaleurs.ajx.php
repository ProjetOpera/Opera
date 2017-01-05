<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

if(session_id() == '') {
 session_start();
}


require_once("../../portailv2/functions/functions.php");
$DB = connexion_externe('../../portailv2/');
require_once '../include/typesvaleurs/typesvaleurs.class.php';

if(!function_exists('getParams')){
 function getParams($name,$type="POST",$default=''){  
     switch ($type){
     case "POST":
         $var = isset($_POST[$name])?$_POST[$name]:$default;
         break;
     case "GET":
          $var = isset($_GET[$name])?$_GET[$name]:$default;
         break;
     case "SESSION":
          $var = isset($_SESSION[$name])?$_SESSION[$name]:$default;
         break;
     case "COOKIE":
          $var = isset($_COOKIE[$name])?$_COOKIE[$name]:$default;
         break;
     }
     return $var;
 }
}

$ACTION = getParams("action");
$code = getParams("code");
$description = getParams("description");
$tradFR = getParams("tradFR");
$tradEN = getParams("tradEN");
$default = getParams("default");
$id = getParams("id");
$a_items = json_decode(getParams('a_items'),true);

$oListe = new Typesvaleurs($DB,$code,$id);
$result = array();
switch($ACTION){
 
 case "GET_ITEMS":
  $tmp=$oListe->getListeItems();
  $result['liste'] = "";
   $result['liste'] = "<input type='hidden' id='ID_LISTE' value='$id'>";
  foreach($tmp as $R){
   $id_item = $R['id'];
   $cod = $R['code'];
   $lib_fr = $R['lib_fr'];
   $lib_en = $R['lib_en'];   
   $def = $R['defaut'] ? "checked='checked'":'';
   $result['liste'] .="<tr id='tr_item_".$id_item."'>"; 
   $result['liste'] .="<td style='padding:0px;width:220px' class='text-center' id='td_item_code_".$id_item."'>
                        <div class='has-feedback'>
                         <input class='form-control' 
                                data-id_item = '$id_item'
                                type='text' 
                                name='itm_code[]' 
                                value='$cod'
                                id='inp_code_C$id_item' 
                                onkeyup='Code_items_Isconform(\"inp_code_C$id_item\",\"item_codespan_C$id_item\");'></input>
                         <span  id='item_codespan_C$id_item' class='glyphicon  form-control-feedback'></span>
                        </div>
                        </td>"; 
   $result['liste'] .="<td style='padding:0px;width:200px' class='text-center' id='td_item_tradFR_".$id_item."'>
                        <input class='form-control' type='text' name='itm_libFR[]' value='$lib_fr'>
                       </td>"; 
   $result['liste'] .="<td style='padding:0px;width:200px' class='text-center' id='td_item_tradEN_".$id_item."'>
                        <input class='form-control' type='text' name='itm_libEN[]' value='$lib_en'>
                       </td>"; 
   $result['liste'] .="<td class='text-center' style='width:40px' 
                        id='td_item_default_".$id_item."'>
                         <input type='radio' name='default' $def value='$id_item'></td>"; 
  
   $result['liste'] .="<td class='text-center' style='width:44px'>
                        <span class='glyphicon glyphicon-trash clicable'
                        style='color:blue' 
                        onclick='DeleteItem(\"$cod\",\"$id_item\");'></span>";"
                        </td>
												";
   $result['liste'] .="</tr>"; 
  
  
  }
    
 break;
 case "ADD_LIST":
  $result['msg'] = $oListe->addList($code,$description);
  $result['query'] = $oListe->_query;
 break;
 case "EDIT_LIST":
  $result['msg'] = $oListe->editListe($code,$description);
  $result['query'] = $oListe->_query;
 break;
case "CHECK_IF_CODE_LISTE_EXIST":
  $result['msg'] = $oListe->checkIfCode_LIST_Exist($id);
  $result['query'] = $oListe->_query;
 break;
case "CHECK_IF_CODE_LISTE_ITEMS_EXIST":
  $result['msg'] = $oListe->checkIfCode_LIST_ITEM_Exist($id);
  $result['query'] = $oListe->_query;
 break;
case "DELETE_LIST":
  $result['msg'] = $oListe->deleteListe();
  $result['query'] = $oListe->_query;
 break;
 
 case "SAVE_ITEMS":
  $result['msg'] = $oListe->insertItems($a_items);
  $result['query'] = $oListe->_query;
 break;
default:
 $result=$_POST;
}
print json_encode($result);
?>
