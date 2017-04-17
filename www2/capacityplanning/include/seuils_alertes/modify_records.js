function edit_row(id)
{
 var module=document.getElementById("module_val"+id).innerHTML;
 var label=document.getElementById("label_val"+id).innerHTML;
 var seuil=document.getElementById("seuil_val"+id).innerHTML;
 var alerte=document.getElementById("alerte_val"+id).innerHTML;

 document.getElementById("module_val"+id).innerHTML="<input type='text' id='module_text"+id+"' value='"+module+"'>";
 document.getElementById("label_val"+id).innerHTML="<input type='text' id='label_text"+id+"' value='"+label+"'>";
 document.getElementById("seuil_val"+id).innerHTML="<input type='text' id='seuil_text"+id+"' value='"+seuil+"'>";
 document.getElementById("alerte_val"+id).innerHTML="<input type='text' id='alerte_text"+id+"' value='"+alerte+"'>";
	
 document.getElementById("edit_button"+id).style.display="none";
 document.getElementById("save_button"+id).style.display="block";
}

function save_row(id)
{
 var module=document.getElementById("module_val"+id).value;
 var label=document.getElementById("label_val"+id).value;
 var seuil=document.getElementById("seuil_val"+id).value;
 var alerte=document.getElementById("alerte_val"+id).value;
	
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   edit_row:'edit_row',
   row_id:id,
   module_val:module,
   label_val:label,
   seuil_val:seuil,
   alerte_val:alerte
  },
  success:function(response) {
   if(response=="success")
   {
    document.getElementById("module_val"+id).innerHTML=module;
    document.getElementById("label_val"+id).innerHTML=label;
	document.getElementById("seuil_val"+id).innerHTML=seuil;
    document.getElementById("alerte_val"+id).innerHTML=alerte;
    document.getElementById("edit_button"+id).style.display="block";
    document.getElementById("save_button"+id).style.display="none";
   }
  }
 });
}

function delete_row(id)
{
 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   delete_row:'delete_row',
   row_id:id,
  },
  success:function(response) {
   if(response=="success")
   {
    var row=document.getElementById("row"+id);
    row.parentNode.removeChild(row);
   }
  }
 });
}

function insert_row()
{
 var module=document.getElementById("new_module").value;
 var label=document.getElementById("new_label").value;
  var seuil=document.getElementById("new_seuil").value;
 var alerte=document.getElementById("new_alerte").value;

 $.ajax
 ({
  type:'post',
  url:'modify_records.php',
  data:{
   insert_row:'insert_row',
   module_val:module,
   label_val:label,
   seuil_val:seuil,
   alerte_val:alerte
  },
  success:function(response) {
   if(response!="")
   {
    var id=response;
    var table=document.getElementById("user_table");
    var table_len=(table.rows.length)-1;
    var row = table.insertRow(table_len).outerHTML="<tr id='row"+id+"'><td id='module_val"+id+"'>"+module+"</td><td id='label_val"+id+"'>"+label+"</td><td id='alerte_val"+id+"'>"+alerte+"</td><td id='seuil_val"+id+"'>"+seuil+"</td><td><input type='button' class='edit_button' id='edit_button"+id+"' value='Editer' onclick='edit_row("+id+");'/><input type='button' class='save_button' id='save_button"+id+"' value='Sauvegarder' onclick='save_row("+id+");'/><input type='button' class='delete_button' id='delete_button"+id+"' value='Supprimer' onclick='delete_row("+id+");'/></td></tr>";

    document.getElementById("new_module").value="";
    document.getElementById("new_label").value="";
	document.getElementById("new_seuil").value="";
    document.getElementById("new_alerte").value="";
   }
  }
 });
}