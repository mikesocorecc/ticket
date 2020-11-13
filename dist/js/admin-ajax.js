$(document).ready(function () {  
  //Ajax para guardar registros
    $('#guardar-registro').on('submit', function (e) {    
      e.preventDefault();           
      // //capturamos los datos del formulario en una variable
      var datos = $(this).serializeArray();                
      //realizamos el llamado a ajax
      $.ajax({
        type: $(this).attr('method'),
        data: datos,      
        url: $(this).attr('action'),
        dataType: 'json',     
        success: function (data) {   
          console.log(data);                                          
         var resultado = data;     
          if (resultado.respuesta == 'exito') {
            Swal.fire({
              position: 'center',
              icon: 'success',
              title: 'Registro guardado correctamente',
              showConfirmButton: false,
              timer: 2100
            });
            setTimeout(function() {                     
              $(location).attr('href', resultado.redireccion);    
          }, 1800)
                             
            
          }else{
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'No se pudo guardar '
            })
          }
  
        }
      });      
    });
  
  //Guardar registro con archivos
   $('#guardar-registro-archivo').on('submit', function (e) {
    e.preventDefault();      
    var datos = new FormData(this);  
    //realizamos el llamado a ajax
    $.ajax({
      type: $(this).attr('method'),      
      data: datos,  
      url: $(this).attr('action'),      
      dataType: 'json',      
      contentType: false,
      processData: false,
      async: true,
      cache: false,      
      success: function (data) {  
        console.log(data);        
        var resultado = data;
        if (resultado.respuesta == 'exito') {
          Swal.fire({
            position: 'center',
            icon: 'success',
            title: 'Registro guardado correctamente',
            showConfirmButton: false,
            timer: 2400
          });
          setTimeout(function() {                     
            $(location).attr('href', resultado.redireccion);  
        }, 1800)
          
        } else if(resultado.respuesta == 'limitsize'){
          Swal.fire({
            icon: 'warning',
            title: 'Alerta',
            text: 'El archivo a subir supera el limite de tamaño establecido '            
          })
        }else {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo guardar '
          })
        }
  
      }
    });  
  });
  
  
  //  Eliminar un registro
  $(document).on('click','.borrar_registro', function(e){
      e.preventDefault();       
      var id = $(this).attr('data-id');
      //capturamos el tipo
      var tipo = $(this).attr('data-tipo');
      Swal.fire({
        title: 'Estas seguro?',
        text: "Un registro eliminado no se puede recuperar",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Si, Eliminar',
        cancelButtonText: 'Cancelar'
      }).then((result) => { 
        if (result.value) {
          //creamos el llamado a ajax
          $.ajax({
            type: 'post',
            data: {
              'id': id,
              'registro': 'eliminar'
            },
            url: 'modelo-' + tipo + '.php',
            success: function (data) {                        
              var resultado = JSON.parse(data);
              console.log(data);              
              if (resultado.respuesta == 'exito') {          
                Swal.fire(
                  'Eliminado!',
                  'Registro eliminado',
                  'success'
                )            
                jQuery('[data-id="' +resultado.id_eliminado + '"]').parents('tr').remove();
              } else {
                Swal.fire({
                  icon: 'error',
                  title: 'Error',
                  text: 'No se pudo eliminar',
                  footer: '<a href="#">Why do I have this issue?</a>'
                })
              }
            }
          }) //fin Ajax
        } //fin if(result.value)
        else if (result.dismiss === 'cancel') {
          Swal.fire({
            icon: 'warning',
            title: 'Ningun cambio',
            text: 'No se realizo ningun cambio!!',
            footer: '<a href="#"></a>'
          })
        }
  
    });      
  });

//Ajax para iniciar sesion
  $(document).on('submit', '#login', function(e){  
    e.preventDefault();
    var datos = $(this).serializeArray();                    
    $.ajax({
        type : 'POST',
        data : datos,
        url : 'modelo-login.php',
        dataType : 'json',
        success : function(data){
            console.log(data);
            var resultado = data;
            switch (resultado.respuesta) {
                case 'exitoso':    
                $('#result').html('<div class="alert alert-success alert-dismissible fade in" role="alert"> <strong>Exito!</strong> Redirigiendo...</div>').fadeIn("slow");                      
                          setTimeout(function() {                     
                            window.location.href = "index.php";       
                        }, 1000)
                        
                    break;
                    case 'error':
                      //$('#result').html('<span style="" class="bg-danger text-ligth">Error!  Verifica tus datos y vulve a intentarlo</span>').fadeIn('slow');
                      $('#result').html('<div class="alert alert-danger alert-dismissible fade in" role="alert"> <strong>Error!</strong> Contraseña o correo Electrónico invalido</div>').fadeIn("slow");                      
                      setTimeout(function() {                     
                        $("#result").fadeOut(3000);
                    },3000)
                      break; 
                    case 'vacios':
                      $('.error-usuario').html('<stronger class="text-danger">Campo vacio</stronger>').fadeIn(2000);
                      $('.error-password').html('<stronger class="text-danger">Campo vacio</stronger>').fadeIn(2000);
                      break; 
                default:
                    break;
            }
           
        }
        
    });
     
})

//Generar reportes en pdf
$(document).on('click', '#imprimir', function (e) {
  e.preventDefault();
  var daterange= $("#daterange").val();
  var categoria= $("#categoria").val();
  generarPdf('modelo-pdf.php?daterange=' +daterange+'&categoria='+categoria, 'Ticket de ingreso', '', '1200', '1000', 'true');  
});


//Funcion que me creara una nueva ventana para mostrar el pdf
function generarPdf(theURL, winName, features, myWidth, myHeight, isCenter) { //v3.0
  if (window.screen)
      if (isCenter)
          if (isCenter == "true") {
              var myLeft = (screen.width - myWidth) / 2;
              var myTop = (screen.height - myHeight) / 2;
              features += (features != '') ? ',' : '';
              features += ',left=' + myLeft + ',top=' + myTop;
          }
  window.open(theURL, winName, features + ((features != '') ? ',' : '') + 'width=' + myWidth + ',height=' + myHeight);
}  
  
  });