<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

include_once '../portailadmin/variables_' . $_SESSION['PORTAIL\lang'] . '.php';
require_once("../portailv2/functions/functions.php");
$DB = connexion_externe('../portailv2/');
require_once '../portailadmin/include/typesvaleurs/typesvaleurs.class.php';


//démarrage Session si non démarré
if(session_id() == '') {
 session_start();
}



// LISTE DES "listes TYPES/VALEURS"

$oTV = new TypesValeurs($DB);
$arrListe = $oTV -> getListeTV();

?>

<!-- Import des CSS -->
<link rel='stylesheet' href='css/bootstrap.css' type='text/css' media='all'/>
<link rel='stylesheet' href='css/bootstrap-theme.css' type='text/css' media='all'/>
<link rel='stylesheet' href='css/styles.css' type='text/css' media='all'/>

<div class="container-fluid">
 
<div class="col-md-offset-1 col-md-18">
  <div class="bs_panel bs_panel-primary">
   <div class="bs_panel-heading clearfix">
     <?php echo LANG_GESTION_TYPES ?>
     <span style='float:right;'>
       <a href='#mPopup' 
         class='LienModal' 
         title="<?php echo LANG_NOUVEAU; ?>"
         data-id="" 
         data-description="" 
         data-code="" 
         >
        <span class="badge"><?php echo LANG_NOUVEAU?> </span>      
      </a>
     </span>
   </div><!-- FIN PANEL HEADING-->   
   <div class="bs_panel-body" style="height:380px;max-height: 380px;overflow-y: hidden"> <!-- PANEL BODY-->
    
    <div class="bs_panel bs_panel-default table-responsive" style="margin:0px;">
      <table class="table table-responsive table-condensed" id="tbl_liste">
       <thead>
        <tr class="active">
         <th class='text-center' style="width:200px"><?php echo LANG_CODE?></th>
         <th class='text-left' style='width:200px' ><?php echo LANG_DESCRIPTION?></th>                           
         <th class='text-center' style="width:30px"><?php echo LANG_EDIT?></th>
         <th class='text-center' style="width:44px"><?php echo LANG_SUPPR?></th>
         <th class='text-center' style="width:10px"></th>
        </tr>
       </thead>
      </table>
    </div>
     <div class="bs_panel bs_panel-default table-responsive" style="height:320px;max-height: 320px;overflow-y: scroll;margin:0px;">
      <table class="table table-responsive table-condensed table-hover" id="tbl_liste">
    
       <tbody id="tbody_liste">  
        <?php
        foreach($arrListe as $L){ 
         $id = $L['id_typevaleur'];
         $code = $L['code'];
         $description = $L['description'];                 
         echo "<tr class='clicable' id='tr_$id' onclick='getListeItems(\"".$id."\")'>";
         echo " <td id='$id' 
                    class='text-center' 
                    style='width:200px;'>
                  $code
                </td>";
         echo " <td class='text-left' style='width:200px;max-height:60px;'>$description</td>";

         ?>
         <td class='text-center'style="width:30px" >
          <a href='#mPopup' 
             class='LienModal' 
             data-description="<?php echo $description?>" 
             data-code="<?php echo $code?>" 
             data-id ="<?php echo $id ?> "
             title='<?php echo LANG_EDIT?>'>
           <span class="glyphicon glyphicon-edit clicable" style="color:blue"></span>
          </a>
         </td>
         <td class='text-center' style="width:44px">
           <span class="glyphicon glyphicon-trash clicable" style="color:blue" onclick="DeleteListe('<?php echo $code?>','<?php echo $id?>');"></span>
         </td> 
        </tr>
        <?php } ?>
       </tbody>
      </table>
     </div> <!-- FIN bs_panel bs_panel-default table-responsive -->    
   </div><!-- FIN PANEL BODY-->
   </div><!-- FIN DIV MD/XS -->
</div><!-- FIN PANEL -->


<!-- PANEL DE DROITE -->
<div class="col-md-offset-1 col-md-28">
  <div class="bs_panel bs_panel-primary">
   <div class="bs_panel-heading clearfix">
     <?php echo LANG_GESTION_VALEURS ?>
     <span style='float:right;'>
        <span id="items_add_button" style="display:none" class="badge clicable" onclick="addNewItem();"><?php echo LANG_NOUVEAU?> </span>      
     </span>
   </div><!-- FIN PANEL HEADING-->   
   <div class="bs_panel-body" style="height:330px;max-height: 330px;overflow-y: hidden"> <!-- PANEL BODY-->
     <div class="bs_panel bs_panel-default table-responsive" style="margin:0px;">
      <table class="table table-responsive table-condensed" id="tbl_liste">
       <thead>
        <tr class="active">
         <th class='text-center' style="width:256px"><?php echo LANG_CODE?></th>
         <th class='text-left' style='width:200px' ><?php echo LANG_LIB_FR?></th> 
         <th class='text-left' style='width:200px' ><?php echo LANG_LIB_EN?></th> 
         <th class='text-left' style='width:40px' ><?php echo LANG_DEFAUT?></th> 
         <th class='text-center' style="width:44px"><?php echo LANG_SUPPR?></th>
         <th class='text-center' style="width:10px"></th>
        </tr>
       </thead>
      </table>
    </div>
    <div class="bs_panel bs_panel-default table-responsive" style="height:280px;max-height: 280px;overflow-y: scroll;margin:0px;">
     <form action="" method="post" name="form_items" id="form_items"> 
     <table class="table table-responsive table-condensed table-hover" id="tbl_liste_valeurs">
       <tbody id="tbody_liste_valeurs">  

       </tbody>
       
      </table>
      </form>
     </div> <!-- FIN bs_panel bs_panel-default table-responsive -->  
    
   </div> <!--Fin Panel BODY -->
 <div class="bs_panel-footer" style="text-align:right">
     <div id="foot_infos" style="float: left;text-align: left"></div>
     <input id="btn_add_item" style="display:none" type="button" class="btn btn-primary btn-sm" value="<?php echo LANG_SUBMIT?>" onclick="SaveItems()">  
 
   </div><!-- FIN PANEL FOOTER-->
  </div>
</div>



</div><!-- FIN CONTAINER FLUIDRE -->



<!-- ///////////////////  MODALE //////////////////////////// -->

<!-------------------------------------------------------------------------------->
<!--                    FENETRE MODAL                                           -->
<!-------------------------------------------------------------------------------->
<div style="display:none;" >
 <div  id="mPopup" style="width:660px;">
  <div class="fancy-heading" style="width:660px;">
    <span id="modal_title"></span>
  </div>
  <div class="fancy-body">
   <input type="hidden" id="ID" value="">
  <div class="group" style="width:660px;margin-bottom: 30px">
   <label for="code" class="col-md-10"><?php echo LANG_CODE?>&nbsp;*</label>
   <div class="col-md-28">
     <input  class="form-control code" 
             name="code" 
             id="code" 
             value="" 
             onkeyup="CodeIsconform('code','codespan');">
   <span id="codespan" class=" glyphicon  form-control-feedback"></span>
   </div>
   <div class="col-md-6">
     <span id="codespan_msg" class="modalFeedack help-block errorMessage"></span>
   </div>
  </div>
   <br> 
  <div class="group" style="width:660px;margin-bottom: 30px">
   <label for="description" class="col-md-10"><?php echo LANG_DESCRIPTION?></label>
   <div class="col-md-28">
     <input class="form-control" 
            name="description" 
            id="description" 
            value=""
   </div>
  </div> 
  <br>
 </div> 
  <div style="text-align: left;padding-left: 20px;color:lightslategrey;font-style: italic;font-size: 10px;">
   <?php echo MSG_200 ?>
  </div>
 </div>
  <div class="fancy-footer">
   <div id="foot_infos" style="float: left;text-align: left"></div>
   <a class="btn btn-default btn-sm" id="exitPopup" data-dismiss="modal" role="button"><?php echo LANG_EXIT?></a>
   <input type="button" class="btn btn-primary btn-sm" value="<?php echo LANG_SUBMIT?>" onclick="AddEdit()">  
  </div>
 </div>
</div>

<!-------------------------------------------------------------------------------->
<!--  FIN MODALE -->
<!-------------------------------------------------------------------------------->
<script type="text/javascript">
 var LANG_AJX_404 = "Fichier non trouvé";
 var LANG_NOUVEAU = "<?php echo LANG_NOUVEAU;?>";
 var LANG_CONFIRM_SUPPRR="<?php echo LANG_CONFIRM_SUPPRR ?>";

//ERROR
var MSG_100="<?php echo MSG_100;?>";
var MSG_102="<?php echo MSG_102;?>";
var MSG_103="<?php echo MSG_103;?>";
var MSG_105="<?php echo MSG_105;?>";
var MSG_120="<?php echo MSG_120;?>";
var MSG_121="<?php echo MSG_121;?>";
var MSG_122="<?php echo MSG_122;?>";
var MSG_123="<?php echo MSG_123;?>";
var MSG_120="<?php echo MSG_120;?>";
var MSG_121="<?php echo MSG_121;?>";
var MSG_122="<?php echo MSG_122;?>";
var MSG_123="<?php echo MSG_123;?>";
var MSG_140="<?php echo MSG_140;?>";
var MSG_141="<?php echo MSG_141;?>";
var MSG_143="<?php echo MSG_143;?>";
var MSG_146="<?php echo MSG_146;?>";
var MSG_147="<?php echo MSG_147;?>";
var MSG_180="<?php echo MSG_180;?>";
var MSG_200="<?php echo MSG_200;?>";
var MSG_201="<?php echo MSG_201;?>";
var MSG_201="<?php echo MSG_201;?>";
var MSG_220="<?php echo MSG_220;?>";
var MSG_220="<?php echo MSG_220;?>";
//SUCCESS
var MSG_101="<?php echo MSG_101;?>";
var MSG_104="<?php echo MSG_104;?>";
var MSG_124="<?php echo MSG_124;?>";
var MSG_124="<?php echo MSG_124;?>";
var MSG_142="<?php echo MSG_142;?>";
var MSG_144="<?php echo MSG_144;?>";
var MSG_145="<?php echo MSG_145;?>";

</script>









<script type="text/javascript">
 var urlAjx = "ajax/typesvaleurs.ajx.php";
 
$(document).ready(function() {
 
//fermeture Modal via bouton 
$("#exitPopup").click(function(fn){
  $.fancybox.close();
  document.location.reload();
}); 


//Définition Modal
$(".LienModal").fancybox({
        'href'              : '#mPopup',
        'width'             : '700',
        'height'            : '320',
        'hideOnContentClick': false,
        'padding'          	: 0,
        'margin'            : 0,
        'titleShow'         : false,
        'autoScale'         : true,
        'autoDimensions'    : false,
        'transitionIn'      : 'elastic',
        'speedIn'           : 200,
        'transitionOut'     : 'elastic',
        'speedOut'          : 250,
        'enableEscapeButton': true, // fermeture avec la touche ESC
        'onStart' : function( links, index ){loadModal($(links[index]));},
        'onClosed':   function() {}

    });

});//FIN DEOCUMENT READY



function clearClass(elmid){
  $("#"+elmid).removeClass("glyphicon-remove");
  $("#"+elmid).removeClass("glyphicon-ok");
}

function spanSuccessError(elmid,okko){
 
 if(okko){
  $("#"+elmid).addClass("glyphicon-ok");
  $("#"+elmid).css("color","green");
 }else{
  $("#"+elmid).addClass("glyphicon-remove");
  $("#"+elmid).css("color","red");
 }
 
}
//-------Verification des champs ------------//
function checkAllInput(){
 var res=false;
 var verif_code = CodeIsconform("code","codespan") ;
 if(verif_code){
  res=true;
 }
 return res;
}

function CodeIsconform(elmID,spanID){
 var res=false;
 var id = $("#ID").val();
 clearClass(spanID);
 var reg = /^([A-Z0-9\_]+)$/;
 var code = $("#"+elmID).val();
 if(code){
   var isConform = code.match(reg);
   if(isConform){
    spanSuccessError(spanID,true);
    res=true;
    // on regarde si le code n'existe pas déjà
    var action = "CHECK_IF_CODE_LISTE_EXIST";
    var data ={action:action,code:code,id:id};
   //verification unicité du code
    $.ajax({ 
     type: "POST",
     url:urlAjx,
     data: data,
     async: false,
     dataType: "json",
     success: function(reponse){

              if(reponse.msg==true){
                clearClass(spanID);
                spanSuccessError(spanID,false);
                $("#codespan_msg").html(MSG_100);
                res=false;
              }else{
                clearClass(spanID);
                spanSuccessError(spanID,true);
                $("#codespan_msg").html('');
                res=true;
              }
            },
     error:function(jqXHR, textStatus){
            alert('error :' + jqXHR + ' ' + textStatus);
            res=false;
           },
     statusCode:{
      404: function(){alert(LANG_AJX_404);}
     }
    }); 
   }else{
    spanSuccessError(spanID,false);
    $("#codespan_msg").html(MSG_105);
   }
 }else{
   spanSuccessError(spanID,false);
   $("#codespan_msg").html('');
   res=false;
   
 }
 return res;
}

function Code_items_Isconform(elmID,spanID){
//console.log(elmID + " -- " + spanID);
 var res=false;
 var id=$("#ID_LISTE").val();
 var id_item = $("#"+elmID).data('id_item');
 clearClass(spanID);
 var reg = /^([A-Z0-9\_]+)$/;
 var code = $("#"+elmID).val();
 if(code==''){
  res=false;
  spanSuccessError(spanID,false);
 }
 if(code){
   var isConform = code.match(reg);
   if(isConform){
    spanSuccessError(spanID,true);
    res=true;
    // on regarde si le code n'existe pas déjà
    var action = "CHECK_IF_CODE_LISTE_ITEMS_EXIST";
    
    var data ={action:action,code:code,id:id_item};
   //verification unicité du code
    $.ajax({ 
     type: "POST",
     url:urlAjx,
     data: data,
     async: false,
     dataType: "json",
     success: function(reponse){
        console.log(reponse);
              if(reponse.msg==true){
                clearClass(spanID);
                spanSuccessError(spanID,false);
                //$("#codespan_msg").html(MSG_100);
                res=false;
              }else{
                clearClass(spanID);
                spanSuccessError(spanID,true);
                //$("#codespan_msg").html('');
                res=true;
              }
            },
     error:function(jqXHR, textStatus){
            alert('error :' + jqXHR + ' ' + textStatus);
            res=false;
           },
     statusCode:{
      404: function(){alert(LANG_AJX_404);}
     }
    }); 
   }else{
    spanSuccessError(spanID,false);
    $("#codespan_msg").html(MSG_105);
   }
 }else{
   spanSuccessError(spanID,false);
   $("#codespan_msg").html('');
   res=false;
   
 }
 return res;
}


//-------------------------------------------//
//RAZ des champs de la Modal
function razChamps(){
  $("#code").val('');
  $("#description").val('');
  $("#ID").val('');
  $("#codespan_msg").html('');

}

function loadModal(elm){
  var code = elm.data('code');
  var description = elm.data('description');
  var id = elm.data('id');
  razChamps();
  if(code!=""){
   $("#modal_title").html(code + " - " + description);
   $("#code").val(code);
   $("#description").val(description);
   $("#ID").val(id);
    checkAllInput();
  }else{
   checkAllInput();
   $("#modal_title").html(LANG_NOUVEAU);
   
  } 
}
 
 function verifAllInputs(){
  var res=true;
  var test=true;
  // on vérifie si les champs sont bien renseignés
   $("#tbody_liste_valeurs tr").each(function(){
     $('input[name="itm_code[]"]', this).each(function() {
      var id_item = $(this).data('id_item');
      test = Code_items_Isconform(this.id,'item_codespan_C'+id_item);
      if(test==false){
       res = false;
      }
      });       
    })
    return res;
 }
 
function getListeItems(id){
  var data = {id:id,action:'GET_ITEMS'}
  $.ajax({ 
     type: "POST",
     url:urlAjx,
     data: data,
     async: false,
     dataType: "json",
     success: function(reponse){
      $("#tbody_liste_valeurs").html(reponse.liste);
      //on met la ligne en surbrillance
      $("#tbody_liste tr").each(function(){
       $(this).removeClass( 'active' );
      })
      
      verifAllInputs();
      
      $("#tr_"+id).addClass('active');
      //on affiche le bouton d'ajout d'items et enregistrer
      $("#items_add_button").css('display','');
      $("#btn_add_item").css('display','');
    },
     error:function(jqXHR, textStatus){
       $("#items_add_button").css('display','none');
       $("#btn_add_item").css('display','none');
       alert('error :' + jqXHR + ' ' + textStatus);           
     },
     statusCode:{
      404: function(){alert(LANG_AJX_404);}
     }
    }); 
  
 } 
 
function addNewItem(){
 var num_ligne =  $("#tbl_liste_valeurs tr").length;
 
  var a_new_linge ="<tr id='tr_item_new_line_"+num_ligne+"'>";
       a_new_linge +="<td style='padding:0px;width:220px' class='text-center' id='td_item_code_new'>";
        a_new_linge +="<div class='has-feedback'><input class='form-control ' type='text' name='itm_code[]' value='' id='new_inp_code_"+num_ligne+"' onkeyup='Code_items_Isconform(\"new_inp_code_"+num_ligne+"\",\"item_codespan_"+num_ligne+"\");'>";
         a_new_linge +="<span id='item_codespan_"+num_ligne+"' class='glyphicon  form-control-feedback'></span>";
       a_new_linge +="</div></td>"; 
       a_new_linge +="<td style='padding:0px;width:200px' class='text-center' id='td_item_tradFR_new'>";
        a_new_linge +="<input class='form-control ' type='text' name='itm_libFR[]' value=''>";
       a_new_linge +="</td>"; 
       a_new_linge +="<td style='padding:0px;width:200px' class='text-center' id='td_item_tradEN_new'>";
        a_new_linge +="<input class='form-control ' type='text' name='itm_libEN[]' value=''>";
       a_new_linge +="</td>"; 
       a_new_linge +="<td class='text-center' style='width:40px' ";
       a_new_linge +="id='td_item_default_new'> ";
        a_new_linge +="<input type='radio' name='default' value=''></td>"; 
       a_new_linge +="<td class='text-center' style='width:44px'> ";
        a_new_linge +="<span class='glyphicon glyphicon-trash clicable' ";
               a_new_linge +="style='color:blue' ";
               a_new_linge +="onclick='removeItem("+num_ligne+");'></span>";
       a_new_linge +="</td>";
      a_new_linge +="</tr>"; 
 
  $("#tbl_liste_valeurs").append(a_new_linge);
 }
 
function removeItem(trId){
    $("#tr_item_new_line_"+trId).fadeOut(200, function(){
    $("#tr_item_new_line_"+trId).remove();
    return false;
 });
}

function DeleteListe(code,id){
  if(confirm(LANG_CONFIRM_SUPPRR +  ":" + code)){
  var data = {action:'DELETE_LIST',id:id}
  $.ajax({ 
     type: "POST",
     url:urlAjx,
     data: data,
     async: false,
     dataType: "json",
     success: function(reponse){
          $("#tr_"+id).fadeOut(200, function(){
             $("#tr_"+id).remove();
             return false;
          });
       },
     error:function(jqXHR, textStatus){
            alert('error :' + jqXHR + ' ' + textStatus);           
      },
     statusCode:{
      404: function(){alert(LANG_AJX_404);}
     }
    }); 
  }else{
  return false;
  }
}

function SaveItems(){

 if(verifAllInputs()==false){
  return false;
 }
 var id=$("#ID_LISTE").val();
 var items=[];
 $("#tbl_liste_valeurs tr").each(function(){
  var tr_items =[]
  var actif=0;
  var tr = $(this);
  $('input[type=text]',tr).each(function(){
     tr_items.push($(this).val());
  });
  $('input[name=default]',tr).each(function(){
   var actifchk = $(this).prop('checked');
   if(actifchk){actif=1;}else{ actif=0;}    
  });
  tr_items.push(actif);
  items.push(tr_items);
 });   

  var data = {action:'SAVE_ITEMS',id:id,a_items:JSON.stringify(items)}
  $.ajax({ 
     type: "POST",
     url:urlAjx,
     data: data,
     async: false,
     dataType: "json",
     success: function(reponse){
            
            },
     error:function(jqXHR, textStatus){
            alert('error :' + jqXHR + ' ' + textStatus);           
           },
     statusCode:{
      404: function(){alert(LANG_AJX_404);}
     }
    }); 
  


}
 
 // Ajout/modification LISTE
function AddEdit(){
 var action      = "";
 var id          = $("#ID").val();
 var code        = $("#code").val();
 var description = $("#description").val();
 if(id==''){ action = "ADD_LIST"; }else{ action = "EDIT_LIST"; }
   var data = {action:action,id:id,code:code,description:description};
   $.ajax({ 
      type: "POST",
      url:urlAjx,
      data: data,
      async: false,
      dataType: "json",
      success: function(reponse){
        //console.log(reponse);
        document.location.reload();
       },
      error:function(jqXHR, textStatus){
             alert('error :' + jqXHR + ' ' + textStatus);           
       },
      statusCode:{
       404: function(){alert(LANG_AJX_404);}
      }
  });
}
</script> 