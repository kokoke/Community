var ventana_alto = $(document).height();
$(".content").css({"min-height": ventana_alto});

/*******************************
* Login                        *
********************************/

var compro; //variable utilizada para comprobar que el usaurio existe;
var filtroEmail = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;

$(".acceso").click(function(){
  $(".login").toggle();
});

$("#formLogin").submit(function()
{

  if ( $("#inLogin").val().length == 0 || $("#inPass").val().length == 0) {
      if ( $("#inLogin").val().length == 0 ) {//campo vacio
        $("#errorEmail1").show();
        $("#inLogin").addClass("invalid");
      }

    if($("#inPass").val().length==0){
      $("#errorPass").show();
      $("#inPass").addClass("invalid");
    }

  } else {

    if (filtroEmail.test($("#inLogin").val())) {
      comprobarUsuario(function(usuarioCorrecto){
        if (usuarioCorrecto == "true") {
          url = "/p2daw6/cpanel/administrator";
          $(location).attr('href',url);
        }else{
          $("#errorUser").show();
        }
      });

    }else{
      $("#errorEmail2").show();
    }

  }

  return false;

});

$("#inLogin").change(function()
{
  $("#errorEmail1").hide();//por si se ha activado antes
  $("#errorField").hide();
  $("#errorUser").hide();

  if (filtroEmail.test($("#inLogin").val())) {
    $("#errorEmail2").hide();
    $("#inLogin").removeClass("invalid");
  } else {
    $("#errorEmail2").show();
    $("#inLogin").addClass("invalid");
  }
});

$("#inLogin").focus(function(){
  $("#errorEmail1").hide();
  $("#errorEmail2").hide();
  $("#inLogin").removeClass("invalid");
});

$("#inPass").change(function(){
  $("#errorPass").hide();
  $("#errorUser").hide();

  $("#inPass").removeClass("invalid");
  if($("#inPass").val().length==0){
    $("#errorPass").show();
    $("#inPass").addClass("invalid");
  }else{
    $("#errorPass").hide();
    $("#inPass").removeClass("invalid");
  }
});

$("#inPass").focus(function(){
  $("#errorPass").hide();
  $("#inPass").removeClass("invalid");
});

$("#formSearch").submit(function(){

  return $(".inputSearch").val() != "";

});

$(".search").click(function(){

  $('.topSearch').toggleSlide('slow');

});

$(".userAvatar").click(function(){
  $(".leftUser").toggle();
});

$("#listMessage").click(function(){
  $("#newMessage").show();
  $("#contactMessage").hide();
  $("#userMessage").removeClass("clicked");
  $("#listMessage").addClass("clicked");

});

$("#userMessage").click(function(){
  $("#newMessage").hide();
  $("#contactMessage").show();
  $("#userMessage").addClass("clicked");
  $("#listMessage").removeClass("clicked");
});

$(".userList li").click(function(){

  $("li").removeClass("this");
  $(this).addClass("this");

});


/*******************************
* Plugin Tabla                 *
********************************/

oTable = $('#tableProducts').dataTable({
  "bJQueryUI": false,
  "bAutoWidth": false,
  "sPaginationType": "full_numbers",
  "sDom": '<"tablePars"fl>t<"tableFooter"ip>',
  "oLanguage": {
    "sLengthMenu": "<span class='showentries'>Mostrar:</span> <div class='selector' id='uniform-undefined'><span id='cantProduct'>10</span> _MENU_ </div>"
  }
});

$("#numSelect").change(function(){
  console.log("a");
  $("#num").html($("#numSelect").val());
});

if($(".contentHome").length){
  $("#sidebar").css({"width":"101px"});
}

/*******************************
* Tooltip                      *
********************************/

//IDIOMAS
$("li:contains('Es')").mouseenter(function(){
  $(".tooltip").html("Español");
});
$("li:contains('En')").mouseenter(function(){
  $(".tooltip").html("Ingles");
});
$("li:contains('Ca')").mouseenter(function(){
  $(".tooltip").html("Catalan");
});
$(".logout").mouseenter(function(){
  $(".tooltip").html("Salir");
});


$(".tooltip").css("display", "none");//oculta por defecto

$("#language li.idioma").hover(function () { //mostrar cuando pasa el mouse por encima

x = event.pageX-20;
y = -5;
$(".tooltip").css({"display": "block", "top":y, "left":x});
});

$("#language li").mouseleave(function () { //ocultar cuado el mouse sale
$(".tooltip").css("display", "none");
});

//EDIT&DELETE
$(".icoEdit").mouseenter(function(){
  $(".tooltip").html("Editar");
});
$(".icoDel").mouseenter(function(){
  $(".tooltip").html("Eliminar");
});
$(".icoView").mouseenter(function(){
  $(".tooltip").html("Ver");
});
$(".icoDown").mouseenter(function(){
  $(".tooltip").html("Descargar");
});
$(".icoCheck").mouseenter(function(){
  $(".tooltip").html("Aceptar");
});
$("a.icons").hover(function(){
x = event.pageX-20;
y = event.pageY-50;
$(".tooltip").css({"display": "block", "top":y, "left":x});
});
$("a.icons").mouseleave(function () { //ocultar cuado el mouse sale
$(".tooltip").css("display", "none");
});


$("#helpRef").mouseenter(function(){
$(".tooltip").html("Referencia para identificar el producto");
});
$("#helpEnt").mouseenter(function(){
$(".tooltip").html("Dias estimados que tarda el producto en llegar");
});


$(".help").hover(function(){
x = event.pageX-20;
y = event.pageY-50;
$(".tooltip").css({"display": "block", "top":y, "left":x});
});
$(".help").mouseleave(function () { //ocultar cuado el mouse sale
$(".tooltip").css("display", "none");
});

/******************
* ListaClientes  *
******************/

$("#listClientes").css({"background": "url(/p2daw6/public_html/img/sliderclientes/slider_01.png)"});

var contardorSlider=2;
var sliderCliente =setInterval(

function(){

  $("#listClientes").css({"background": "url(/p2daw6/public_html/img/sliderclientes/slider_0"+contardorSlider+".png)"});
  contardorSlider++;

  if(contardorSlider==5){contardorSlider=1;}
} , 5000);


function validarEmail(valor)
{

  var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
  if(filter.test(valor))
    return true;
  else
    return false;
}

/*******************************
* Funciones con AJA            *
********************************/


function newNewsletter(){

  var email = $('#emailNewsletter').val();
  var url="/p2daw6/ajax/newsletter";

  if(validarEmail($("#emailNewsletter").val())){
    $.post(url,{newsletter: email},function (responseText){

      if(responseText == "true"){
          alertify.success( "Inscripcion correcta" );
          $("#emailNewsletter").val("");
      } else {
          alertify.error( "Usuario ya inscrito" );
      }

    });
  } else {
    alertify.error( "Email invalido" );
  }

}

function comprobarUsuario(callback) {

  var usuario = $("#inLogin").val();
  var passwd  = $("#inPass").val();
  var url     = "/p2daw6/ajax/checkUser";

  $.post(url, {user: usuario, pass: passwd}, function(responseText)
  {
    console.log(responseText);
    return callback(responseText);
  });

}

if($("#adminLogin").length){
  $("#footerCpanel").css({"bottom":0});
}

if($("#imagenGrandalf").length){
  $("#footerCpanel").css({"bottom":0});
}

function comprobarUserName(callback) {

  var usuario = $("#camporegistro1").val();
  var url     = "/p2daw6/ajax/userName";

  $.post(url, {user: usuario}, function(responseText)
  {
    return callback(responseText);
  });
}

function comprobarEmailExistente(callback) {

  var userEmail = $("#camporegistro2").val();
  var url     = "/p2daw6/ajax/userEmail";
  $.post(url, {email: userEmail}, function(responseText)
  {
    return callback(responseText);
  });
}

$("#listSelectContact select").change(
  function(){
    $(".userList li").removeClass("this");
    $("[id*=" + $("select").val() +"]").addClass("this");
    $('span[class="'+$("select").val() +'"]').hide();
    cargarMessages($("select").val());
  });

$(".userList li").click(function(){
  console.log($(this).attr('id'));
  $('span[class="'+$(this).attr('id')+'"]').hide();
  cargarBreadline($(this).attr('id'));
  cargarMessages($(this).attr('id'));

});

function cargarMessages(User) {

  var url="/p2daw6/ajax/listMessage";
  $.post(url,{id:User},function (responseText){
      $(".messages").html(responseText);
  });

}

function cargarBreadline(User) {

  var url="/p2daw6/ajax/breadLine";
  $.post(url,{id:User},function (responseText){
      $("#seconBreadLine").html(responseText);
  });

}

$("#sendMessage").click(function(){
  if($("#send_msj").val()!=""){
    cargarNuevoMensaje($("li.this").attr('id'), $("#send_msj").val());
  }else{
    alertify.error( "Debe introducir un mensaje" );
  }

});

$("#send_msj").keyup(function(e){
	
  if(e.which == 13){
    cargarNuevoMensaje($("li.this").attr('id'), $("#send_msj").val());
  }

});

$("#sendTarget").click(function() {
	var expr = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
  if($("#send_trg").val()!="" && expr.test($("#send_trg").val())){
    cargarNuevaTarget( $("#send_trg").val());
  }else{
    alertify.error( "Debe introducir un targeta valida" );
  }
});

$("#send_trg").keyup(function(e){

  if(e.which == 13){
    var expr = /^4\d{3}-?\d{4}-?\d{4}-?\d{4}$/;
	  if($("#send_trg").val()!="" && expr.test($("#send_trg").val())){
	    cargarNuevaTarget( $("#send_trg").val());
	  }else{
	    alertify.error( "Debe introducir un targeta valida" );
	  }
  }

});

function cargarNuevoMensaje(user, mensaje) {

  var url="/p2daw6/ajax/newMessage";
  $.post(url,{send:user, msj: mensaje},function (responseText){
      $(".messages").html(responseText);
      cargarMessages(user);
      $("#send_msj").val("");
      alertify.success( "Mensaje enviado" );

  });

}

function enviarEmail() {
	var url="/p2daw6/ajax/email";
  $.post(url,{name:$("#contactName").val(), email:$("#contactEmail").val(), msj:$("#contactMessage").val()},function (responseText){
   		$("#contactName").val("");
   		$("#contactEmail").val("");
   		$("#contactMessage").val("");
   		alertify.success( "Mensaje enviado" );
  });
}

function cargarNuevaTarget(targeta) {

  var url="/p2daw6/ajax/newTarget";
  $.post(url,{send:targeta},function (responseText){
      url = "/p2daw6/cpanel/preference/pay";
      $(location).attr('href',url);
  });

}

function comprobarReferenciaProducto(ref) {
  var url="/p2daw6/ajax/comprobarref";
  $.post(url, { ref: ref }, function (responseText)
  {
      if (responseText == "true") {
        alertify.error("referecia ya existe");
        $("#saveRefProduct").val('');
      }
  });
}


function cargarImagenTemporalmente(imagen) {
  var url = "/p2daw6/ajax/cargarimagen";

  var upfile = $(".uploadedfile").val();
  var file   = upfile.files;

  var data = new FormData();

    data.append('archivo',imagen);

  $.post(url,{file:upfile},function (responseText){
      console.log(responseText);
  });

}

function cargarProductoCarrito() {
  var url  = '/p2daw6/ajax/loadProductCart';

  $.post(url, function(responseText){
      $("#listProductCart").html(responseText);
      calcular();
  });

}

function calcular() {
  var precioFactura = 0;
  $("#listProductCart li").each(function(i){
    $(this).children().each(function(){
      if($(this).attr("class")== "price" ){
        precioFactura = precioFactura + parseInt($(this).html());
      }
    });
  });

  $(".priceTotalCart").html(precioFactura+"&euro;");
}

function addProductoCarrito(cantidad, producto ) {

  var url  = '/p2daw6/ajax/addProductCart';
  $.post(url, {cant: cantidad, ref: producto}, function(responseText){
        //console.log(responseText);
        switch(responseText){
          case 'error1':
            alertify.error("ERROR #12312312");
            break;
          case 'error2':
            alertify.error("Cantidad stock insuficiente");
            break;
          default:
            $("#listProductCart").html(responseText);
            calcular();
            alertify.success("Se han añadido: "+ cantidad + " unidades de \""+producto+"\"");
        }
  });
}

function cargarDetallesCarrito(){
  var url  = '/p2daw6/ajax/viewdetallcart';
  $.post(url, function(responseText){
    if(responseText != "false") {
      $(".contentPage").html(responseText);
      $("#targetNumber").html($('input:radio[name=target]:checked').next().text());
      $("#seconBreadLine").html("Detalles carrito");
    } else {
      alertify.error("No hay ningun producto");
    }
  });
}

/*****************
* LIST REGISTRO *
*****************/

$(".registerForm").submit(function(){

  if (comprobarPagina3Registro()) {
    return true;
  }

  return false;
});

$(".registerForm input").focus(function(){
  $(this).removeClass("invalid");
  });
var posicionLista = 0;

$("#camporegistro1").change(function(){
  if ($("#camporegistro1").val()!="") {
    comprobarUserName(function(userName){
      if (userName == "true") {
        alertify.error("Usuario ya existente");
        $("#camporegistro1").val('');
      }
    });
  }
});

$("#camporegistro2").change(function(){
  if ($("#camporegistro2").val()!="") {
    comprobarEmailExistente(function(userName){
      if (userName == "true") {
        alertify.error("Usuario ya existente");
        $("#camporegistro2").val("");
      }
    });
  }
});

$("#next").click(function(){
  if (posicionLista==0) {
    comprobarPagina1Registro();
  }else if (posicionLista==1) {
    comprobarPagina2Registro();
  }
});

$("#prev").click(function(){
  if (posicionLista==1) {
    $("#flecha2").removeClass("flechActive");
    $("#list2").removeClass("active");
    $("#inf2").removeClass("active");

    $("#flecha1").addClass("flechActive");
    $("#list1").addClass("active");
    $("#inf1").addClass("active");

    posicionLista--;
  } else if (posicionLista==2) {
    $("#list3").removeClass("active");
    $("#inf3").removeClass("active");

    $("#flecha2").addClass("flechActive");
    $("#list2").addClass("active");
    $("#inf2").addClass("active");

    $("#next").show();
    $("#sendRegister").hide();
    posicionLista--;
  }
});

function comprobarPagina1Registro() {

  var comprobarCaracteresMinimos  = /[A-Za-z0-9_-]{3,16}/;
  var comprobarPasswordSeguro     = /(?!^[0-9]*$)(?!^[a-zA-Z]*$)^([a-zA-Z0-9]{8,})$/;

    if(comprobarCaracteresMinimos.test($("#camporegistro1").val())
      && filtroEmail.test($("#camporegistro2").val())
      && comprobarPasswordSeguro.test($("#camporegistro3").val())
      && $("#camporegistro3").val() == $("#camporegistro4").val()
    ){

      $("#flecha1").removeClass("flechActive");
      $("#list1").removeClass("active");
      $("#inf1").removeClass("active");

      $("#flecha2").addClass("flechActive");
      $("#list2").addClass("active");
      $("#inf2").addClass("active");

      posicionLista++;
      $(".registerForm input").removeClass("invalid");//limpiar por si ha quedado alguno como la contraseña

    } else {
      if(!comprobarCaracteresMinimos.test($("#camporegistro1").val())){
        alertify.error("Campo usuario obligatorio minimo, 3 caracteres");
        $("#camporegistro1").addClass("invalid");
      }
      if(!filtroEmail.test($("#camporegistro2").val())){
        alertify.error("Email invalido");
        $("#camporegistro2").addClass("invalid");
      }
      if(!comprobarPasswordSeguro.test($("#camporegistro3").val())){
        alertify.error("Contraseña minima 8 caracteres, por lo menos un digito y un alfanumérico, y no puede contener caracteres espaciales");
        $("#camporegistro3").addClass("invalid");
      }
      if($("#camporegistro3").val() != $("#camporegistro4").val()){
        alertify.error("Contraseñas no coinciden");
        $("#camporegistro3").addClass("invalid");
        $("#camporegistro4").addClass("invalid");
      }

    }
}

function comprobarPagina2Registro() {

  var comprobarTelefono   = /^[0-9]{9}$/;
  var comprobarDNI        = /^[0-9]{8}[a-zA-Z]$/;
  var comprobarFecha      = /^[0-9]{4}-[0-9]{2}-[0-9]{2}$/;

  if( $("#camporegistro5").val().length > 2
    && $("#camporegistro6").val().length > 2
    && comprobarDNI.test($("#camporegistro7").val())
    && comprobarFecha.test($("#camporegistro8").val())
    && comprobarTelefono.test($("#camporegistro9").val())
    && $("#camporegistro10").val().length > 10
    ){

    $("#flecha2").removeClass("flechActive");
    $("#list2").removeClass("active");
    $("#inf2").removeClass("active");

    $("#list3").addClass("active");
    $("#inf3").addClass("active");

    $("#next").hide();
    $("#sendRegister").show();
    posicionLista++;

  } else {

    if($("#camporegistro5").val().length < 2){
      alertify.error("Nombre erroneo");
      $("#camporegistro5").addClass("invalid");
    }
    if($("#camporegistro6").val().length < 2){
      alertify.error("Apellidos erroneo");
      $("#camporegistro6").addClass("invalid");
    }
    if(!comprobarDNI.test($("#camporegistro7").val())){
      alertify.error("DNI erroneo");
      $("#camporegistro7").addClass("invalid");
    }
    if(!comprobarFecha.test($("#camporegistro8").val())){
      alertify.error("Fecha erronea");
      $("#camporegistro8").addClass("invalid");
    }
    if(!comprobarTelefono.test($("#camporegistro9").val())){
      alertify.error("Telefono erroneo");
      $("#camporegistro9").addClass("invalid");
    }
    if($("#camporegistro10").val().length < 10){
      alertify.error("Direccion erronea");
      $("#camporegistro10").addClass("invalid");
    }
  }
}

function comprobarPagina3Registro() {

  var comprobarURL = /^(ht|f)tp(s?)\:\/\/[0-9a-zA-Z]([-.\w]*[0-9a-zA-Z])*(:(0-9)*)*(\/?)( [a-zA-Z0-9\-\.\?\,\'\/\\\+&%\$#_]*)?$/;
  var comprobarCIF = /^[a-zA-Z]{1}[0-9]{8}$/;

  if( comprobarCIF.test($("#camporegistro11").val())
    && comprobarURL.test($("#camporegistro13").val())
    && $("#camporegistro12").val()!=""
    ){
      return true;
  } else {
    if(!comprobarCIF.test($("#camporegistro11").val())){
      $("#camporegistro11").addClass("invalid");
      alertify.error("CIF erronea");
    }
    if(!comprobarURL.test($("#camporegistro13").val())){
      $("#camporegistro13").addClass("invalid");
      alertify.error("URL erronea");
    }
    if($("#camporegistro12").val()==""){
      $("#camporegistro12").addClass("invalid");
      alertify.error("Pais erronea");
    }
  }
  return false;
}


/***********
* CONTACT *
***********/

$("#sendContact").submit(function(){

  if($("#contactName").val().length==0 || $("#contactMessage").val().length<2  || !filtroEmail.test($("#contactEmail").val())){
    if($("#contactName").val().length==0){//campo vacio
      $("#errorName").show();
      $("#contactName").addClass("invalid");
    }
    if($("#contactMessage").val().length==0){
      $("#errorMessage").show();
      $("#contactMessage").addClass("invalid");
    }
    if(!filtroEmail.test($("#contactEmail").val())){
      $("#errorEmailContact").show();
      $("#contactEmail").addClass("invalid");
    }
    alertify.error("El email no ha sido enviado");
    
  } else {

    if ((filtroEmail.test($("#contactEmail").val()))) {
      
      enviarEmail();
    
    } else {
      
      $("#errorEmailContact").show();
      $("#contactEmail").addClass("invalid");
      alertify.error("El email no ha sido enviado");
    }
  }
  
    return false;
});

$("#contactName").change(function(){
  $("#errorName").hide();
  $("#contactName").removeClass("invalid");

  if($("#contactName").val().length==0){
    $("#errorName").show();
    $("#contactName").addClass("invalid");
  }else{
    $("#errorName").hide();
    $("#contactName").removeClass("invalid");
  }
});

$("#contactName").focus(function(){
  $("#errorName").hide();
  $("#contactName").removeClass("invalid");
});

$("#camporegistro12").change(function(){
  $("#camporegistro12").removeClass("invalid");
});

$("#contactEmail").change(function(){
  $("#errorEmailContact").hide();
  $("#contactEmail").removeClass("invalid");

  if($("#contactEmail").val().length==0){
    $("#errorEmailContact").show();
    $("#contactEmail").addClass("invalid");
  }else{
     if((filtroEmail.test($("#contactEmail").val()))){
      $("#errorEmailContact").hide();
      $("#contactEmail").removeClass("invalid");
    }else{
      $("#errorEmailContact").show();
      $("#contactEmail").addClass("invalid");
    }

  }
});

$("#contactEmail").focus(function(){
  $("#errorEmailContact").hide();
  $("#contactEmail").removeClass("invalid");
});

$("#contactMessage").change(function(){
  $("#errorMessage").hide();
  $("#contactMessage").removeClass("invalid");

  if($("#contactMessage").val().length==0){
    $("#errorMessage").show();
    $("#contactMessage").addClass("invalid");
  }else{
    $("#errorMessage").hide();
    $("#contactMessage").removeClass("invalid");
  }
});

$("#contactMessage").focus(function(){
  $("#errorMessage").hide();
  $("#contactMessage").removeClass("invalid");
});

/*********************************
 * Comprobaciones Cambiar perfil *
 *********************************/

 $("#saveChangeUserData").click(function(){

  if( $("#editProfileUserName").val()     !=  "" &&
    $("#editProfileEmail").val()        !=  "" &&
    $("#editProfileEmail").val()        !=  "" &&
    $("#editProfilePassword").val()     !=  "" &&
    $("#editProfilePassword").val()     == $("#repeatEditProfilePassword").val()
    ){

    return true

  } else {
    if($("#editProfileUserName").val()  == "")
      alertify.error("Usuario incorrecto");
    if($("#editProfileEmail").val()     == "")
      alertify.error("Email incorrecto");
    if($("#editProfilePassword").val()  == "")
      alertify.error("Password incorrecto");
    if($("#editProfilePassword").val()  != $("#repeatEditProfilePassword").val())
      alertify.error("Contraseñas no coinciden ");
  }

  return false;
 });

/********
* MAPS *
********/

function mapGoogleHotel()
{
	var posicion = new google.maps.LatLng("41.301198", "2.001122");
	
	var mapProp = {
	  center:  posicion  ,
	  zoom:      16,
	  panControl: true,
	  zoomControl: true,
	  mapTypeControl: true,
	  scaleControl: true,
	  mapTypeId: google.maps.MapTypeId.ROADMAP
	  };

  var styleArray = [
    {
    featureType: "all",
    stylers: [
      { saturation: -80 }
    ]
    },{
    featureType: "road.arterial",
    elementType: "geometry",
    stylers: [
      { hue: "#f25e4e" },
      { saturation: 50 }
    ]
    },{
    featureType: "poi.business",
    elementType: "labels",
    stylers: [
      { visibility: "off" }
    ]
    }
  ];
	
	var map = new google.maps.Map(document.getElementById("mapGoogle"), mapProp);
	map.setOptions({styles: styleArray});
	
	var marker = new google.maps.Marker({
	  position: posicion,
	  map: map
});

}

if($("#mapGoogle").length){
	mapGoogleHotel();
}

/*******************************
* Otros                        *
********************************/
//primera conversacion, por lo que se le añade la clase "this"
$(".userList li").eq(0).addClass("this");

/*******************************
* Navegacion Menu              *
********************************/

$(".contactMenu li").click(function(){
  $("li").removeClass("active");
  $(this).addClass("active");
  $("li a").removeClass("this");
  $(this).children("a").addClass("this");
});

$(".tableActs a.delproducto").click(function(){

$url = $(this).attr("href");

  alertify.confirm("Seguro que lo desea eliminar", function (e) {
    if (e) {
      document.location = $url;
    } else {
      alertify.error( "No se ha eliminado el producto" );
    }
  });
return false;
});

/*******************************
* Añadir nuevos elementos      *
********************************/

$("#newCategorieFrom").submit(function(){
  if($("#txtNewCategorie").val()!=""){
     return true;
  } else {
    alertify.error( "no" );
  }
  return false;
});

/*******************************
* Añadir un nuevo Producto     *
********************************/

//comprobaciones

$("#formNewProduct input").focus(function(){$(this).removeClass("invalid");});


$("#saveProduct").click(function(){

  var comprobarCaracteresNumericos  = /[0-9]{1,4}/;

  if($("#saveRefProduct").val() != ""){
    comprobarReferenciaProducto ($("#saveRefProduct").val());
  }

  if(
      $("#saveNameProduct").val()         != ""
    &&  $("#listCategory").val()          != ""
    &&  $("#savePrecioProduct").val()     != ""
    &&  comprobarCaracteresNumericos.test(
        $("#savePrecioProduct").val()
        )
    &&  $("#saveRefProduct").val()        != ""
    &&  $("#savePriceCostProduct").val()  != ""
    &&  comprobarCaracteresNumericos.test(
        $("#savePriceCostProduct").val()
        )
    &&  $("#saveDeliveryProduct").val()   != ""
    &&  $("#saveStockProduct").val()      != ""
    &&  $("#listIVA").val()               != ""

    ) {

     return true;

  } else {
    if($("#saveNameProduct").val()  == ""){
      $("#saveNameProduct").addClass("invalid");
      alertify.error("Nombre erroneo");
    }
    if($("#listCategory").val() == ""){
      $("#listCategory").addClass("invalid");
      alertify.error("Categoria erronea");
    }
    if($("#savePrecioProduct").val() == ""){
      $("#savePrecioProduct").addClass("invalid");
      alertify.error("Precio erroneo");
    }
    if(!comprobarCaracteresNumericos.test($("#savePrecioProduct").val())){
      $("#savePrecioProduct").addClass("invalid");
      alertify.error("Precio debe ser numerico");
    }
    if($("#saveRefProduct").val() == ""){
      $("#saveRefProduct").addClass("invalid");
      alertify.error("Referencia erronea");
    }
    if($("#savePriceCostProduct").val() == ""){
      $("#savePriceCostProduct").addClass("invalid");
      alertify.error("Precio coste erroneo");
    }
    if(!comprobarCaracteresNumericos.test($("#savePriceCostProduct").val())){
      $("#savePriceCostProduct").addClass("invalid");
      alertify.error("Precio coste debe ser numerico");
    }
    if($("#saveDeliveryProduct").val() == ""){
      $("#saveDeliveryProduct").addClass("invalid");
      alertify.error("Plazo entrega erroneo");
    }
    if($("#saveStockProduct").val() == ""){
      $("#saveStockProduct").addClass("invalid");
      alertify.error("Stock erroneo");
    }
    if($("#listIVA").val() == ""){
      $("#listIVA").addClass("invalid");
      alertify.error("IVA erroneo");
    }
  }

  return false;
});

$("#uploadImageProduct").change(function(){
  console.log($(this).val())
});

/*******************************
* Editar un nuevo Producto     *
********************************/
$(".editPerfil input").change(function(){
  $(this).addClass("classInputChange");
});
/*******************************
* Editar Perfil                *
********************************/

$("#formEditProduct input").change(function(){
  $(this).addClass("classInputChange");
});

/******************************
 * Campos Defecto Registo     *
 ******************************/
 /*
 $("#camporegistro1").val("PioPio");
 $("#camporegistro2").val("asd@asd.asd");
 $("#camporegistro3").val("Sm12345678");
 $("#camporegistro4").val("Sm12345678");
 $("#camporegistro5").val("PioPio");
 $("#camporegistro6").val("Peco");
 $("#camporegistro7").val("11121111z");
 $("#camporegistro8").val("1988-05-05");
 $("#camporegistro9").val("999999999");
 $("#camporegistro10").val("algun lugar de la mancha");
 $("#camporegistro11").val("A58818501");
 $("#camporegistro13").val("https://www.google.es");
 */
/*********************************
 * Campos Defecto Nuevo Producto *
 *********************************/
 $("#saveNameProduct").val("Peco");
 $("#savePrecioProduct").val("12");
 $("#saveRefProduct").val("REF2324");
 $("#savePriceCostProduct").val("12");
 $("#saveDeliveryProduct").val("1");
 $("#saveStockProduct").val("12");



/*********************************
 * Subir Imagen                  *
 *********************************/

$('input[type="file"][data-preview="true"]').change(function(){
  console.log("entra");
  var reader = new FileReader();
  var capaAddImagen = $('[data-preview="' + $(this).attr('id') + '"]');

  // Eliminamos si ya había una imagen
  if ($('[data-preview="' + $(this).attr('id') + '"]').children().length > 0 ) {
    $('[data-preview="' + $(this).attr('id') + '"]').empty();
  }


  reader.readAsDataURL($(this).context.files[0]);

  reader.onloadend = function(e) {
    addImagen(e.target.result);
  };

  function addImagen(imagen) {

    var idAdd = capaAddImagen.parent().find('input').attr('id');
    // Añadimos la imagen
    capaAddImagen.append(
      $('.viewImage').attr('src', imagen)
    );
    console.log(imagen);

  }

});

/*********************************
 * Añadir al carrito             *
 *********************************/
    var primerRadio = $('input:radio[name=target]:first-child').val();
    var $radios = $('input:radio[name=target]');
    if($radios.is(':checked') === false) {
        $radios.filter('[value='+primerRadio+']').prop('checked', true);
    }

$('input:radio[name=target]').change(function(){
  var numeroTargeta = $(this).next().text();
  if($("#targetNumber").length){
    $("#targetNumber").html(numeroTargeta);
  }
});

 $(".btnAddCart").click(function(){
  var integer = /^[0-9]{1,4}$/;

  var referenciaProducto = $(this).attr("id");
  var cantidadProducto = $(this).prev().val();

  if(cantidadProducto != ""){
    if(integer.test(cantidadProducto)){
      addProductoCarrito(cantidadProducto, referenciaProducto);
    } else {
      alertify.error("Debe introducir un valor numerico");
    }

  } else {
    alertify.error("Debe introducir un valor numerico");
  }

 });

if($("#listProductCart").length){
  cargarProductoCarrito();
}

$(".continuar").click(function(){
  cargarDetallesCarrito();
});

$("#formCompra").submit(function(){
  //console.log($(".priceTotalCart").text());
  console.log($(".priceTotalCart").html());
  if($(".priceTotalCart").html() != "0€"){
    return true;
  } else{
    alertify.error("No hay ningun producto");
  }
  return false;
});