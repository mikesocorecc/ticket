// Docummentos para el llamado de todas las funciones de las libreria

$(document).ready(function () {  
  //DataTable
  $("#registrados").DataTable({
    "responsive": true,
    "autoWidth": false,
    "order": [[ 3, "desc" ]],
    'language': {
      "decimal": "",
          "emptyTable": "No hay información",
          "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
          "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
          "infoFiltered": "(Filtrado de _MAX_ total entradas)",
          "infoPostFix": "",
          "thousands": ",",
          "lengthMenu": "Mostrar _MENU_ Entradas",
          "loadingRecords": "Cargando...",
          "processing": "Procesando...",
          "search": "Buscar:",
          "zeroRecords": "Sin resultados encontrados",
          "paginate": {
              "first": "Primero",
              "last": "Ultimo",
              "next": "Siguiente",
              "previous": "Anterior"
          }      
  }
  });

  let fechaHora = new Date();
  // let dia = fechaHora.getDate();
  let mes =  fechaHora.getMonth();
  let año = fechaHora.getFullYear();

  
  //Data Calendar
     $('#daterange').daterangepicker({
       "locale": {
          "format": "YYYY-MM-DD",
          "separator": " | ",
          "applyLabel": "Guardar",
          "cancelLabel": "Cancelar",
          "fromLabel": "Desde",
          "toLabel": "Hasta",
          "customRangeLabel": "Personalizar",
          "daysOfWeek": [
              "Do",
              "Lu",
              "Ma",
              "Mi",
              "Ju",
              "Vi",
              "Sa"
          ],
          "monthNames": [
            "Enero",
              "Febrero",
              "Marzo",
              "Abril",
              "Mayo",
              "Junio",
              "Julio",
              "Agosto",
              "Setiembre",
              "Octubre",
              "Noviembre",
              "Diciembre"
            ],
            "firstDay": 1
        },
      "startDate": año+'-'+(mes+1)+'-'+1,
       "endDate": moment(),
      "opens": "center"
    });
    
}); //Fin docready

$(document).ready(function(){
	cargar(1);
});

//Funcion que genera los registros aleatoriamente
function cargar(page){
	var daterange= $("#daterange").val();
	var categoria= $("#categoria").val();
  $("#loader").fadeIn('slow');
  
	$.ajax({
		url:'modelo-reportes.php?daterange='+daterange+'&category='+categoria,
		beforeSend: function(objeto){
			$('#loader').html('<img src="dist/img/loading.gif" style="width: 45px; heigth: 45px;"> Cargando...');
		},
		success:function(data){                
      $(".outer_div").html(data).fadeIn('slow');         
    	$('#loader').html('');
		}
	})
}