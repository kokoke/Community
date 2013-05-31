<?php

require_once 'application/models/ajax.php';
require_once 'application/view/ajax/contact.php';
require_once 'application/view/ajax/cataleg.php';
require_once 'application/view/ajax/preference.php';
require_once 'application/view/ajax/pos.php';


/**
 * Controlador de todas las functiones de Ajax
 */
class Controller_Ajax
{

    /**
     * Acción  para registrar los usuarios al "Newsletter"
     */
    public function action_newsletter()
    {
        //se llama al Modelo enviandole el nuevo email para comprobar si existe
        $email = Ajax::getNewsletter( $_POST["newsletter"] );
        //si no devuelve nada, el email no existe, por lo que se inserta.
        if( $email == 0 ) {
            //se llama al modelo para insertar el nuevo usuario
            Ajax::setNewsletter( $_POST["newsletter"] );
            echo "true";
        } else {
            //se devuelve "false" indicando que el usuario ya existe
            echo "false";
        }

    }

    /**
     * Acción para comprobar si el usuario existe y hacer login
     */
    public function action_checkUser()
    {
        //se le envia al modelo "Ajax" la informacián del usuario y contraseña
        $user = Ajax::getUser($_POST["user"], $_POST["pass"]);
        if( count($user) == 0 ) {
            //si devuelve nada "false";
            echo "false";
        } else {
            //si devuelve algo, se crea la sesion de login
            Session::set("userLogin", $user);
            echo "true";
        }
    }

    /**
     * Acción para comprobar si el nombre de usuario existe para el registro
     */
    public function action_userName()
    {
        //se le envia el usuario, del registro
        $user = Ajax::getUserName( $_POST["user"] );
        if( count($user) == 0 ) {
            //no existe el usuario
            echo "false";
        }else {
            //existe el usuario
            echo "true";
        }
    }

    /**
     * Acción para comprobar si el email existe
     */
    public function action_userEmail()
    {
        //se le envia el email, del registro
        $user = Ajax::getUserEmail( $_POST["email"] );
        if ( count($user)==0 ) {
            //no existe el email
            echo "false";
        } else {
            //existe el email
            echo "true";
        }
    }

    /**
     * Acción para mostrar el listado de mensajes
     */
    public function action_listMessage()
    {
        $user = $_POST["id"]; //usuario conversacion
        $data = $_SESSION["userLogin"][0];//usuario logeado
        //Se cargan los mensajes
        $dataContact = Ajax::getContactMessage($data["idUser"], $user);
        //se llama a la vista para cargar la informacion
        $html = ajaxVistaContactMessage($dataContact);
        echo $html;
    }

    /**
     * Acción para guardar un nuevo mensaje en la BBDD
     */
    public function action_newMessage()
    {
        $userSend   = $_POST["send"];  //a quein se lo envia
        $mensaje    = $_POST["msj"];   //mensaje que se envia
        $data       = $_SESSION["userLogin"][0];//quien lo envia
        //se llama al modelo Ajax para guardar el mensaje
        Ajax::setNewMessage($data["idUser"], $userSend, $mensaje);
    }

    /**
     * Acción para eliminar productos
     */
    public function action_delProduct()
    {
        //se llama al modelo ajax, para comprobar que el producto a eliminar
        //le pertenezca
        $confirm = AJAX::comprobarProducto($_POST["product"]);

        if( $confirm == true ) {
            //una vez comprobado, se elimina dicho producto
            AJAX::delProduct($_POST["product"]);
            //volver a cargar la página,
            $html = ajaxReloadListProduct();
            echo $html;
        } else {
            //no le pertenece ese producto
            echo "false";
        }
    }

    /**
     * Acción para recargar el breadline
     */
    public function action_breadLine()
    {
        //Coger el nombre del usuario para incorporarloa en el breadline
        $data =  AJAX::getUserBreadline($_POST["id"]);
        echo $data[0]["userName"];
    }

    /**
     * Acción para comprobar las referencias
     */
    public function action_comprobarref()
    {
        //comprobar que el producto no funciona
        $data =  AJAX::getRefProducto($_POST["ref"]);

        if(count($data)>0){
            //el produco le pertenece
            echo "true";
        } else {
            //el producto no le pertenece
            echo "false";
        }
    }

    /**
     * Acción para agregar nuevas tarjetas
     */
    public function action_newTarget()
    {
        // se inserta la tarjeta nueva
        AJAX::setNewTarget($_POST["send"]);
    }

    /**
     * Acción para cargar el carrito de la compra
     */
    public function action_loadProductCart()
    {
        $resultado = "";
        if ( isset($_SESSION["carrito"]) ) {
            $resultado = vistaListaCarrito();
        } else {
            //si no hay productos, que muestre el siguiente mensaje
            $resultado = '
                <li><span class="cartBlockName"> Sin productos </span></li>
            ';
        }
        echo $resultado;
    }

    /**
     * Acción para añadir al carrito de la compra
     */
    public function action_addProductCart()
    {
        $cantidad = $_POST["cant"];
        $producto = $_POST["ref"];
        //coger los datos del producto y la empresa
        $data = AJAX::getProductoCarrito( $producto );
        $resultado = "";

        if ( $data ) {
            if ( isset($_SESSION["carrito"]) ) {
                $posicion = count($_SESSION["carrito"]);//numero de elementos del carrito
                for ( $i=0; $i< count($_SESSION["carrito"]); $i++ ) {
                    //compruebo si el elemento en cuestion existe
                    if ( $_SESSION["carrito"][$i]["Producto"] === $producto ) {
                        //recojo la cantidad del carrito y le sumo la nueva
                        $cantidad = $cantidad + $_SESSION["carrito"][$i]["Cantidad"];
                        //guardo en que posicion se encuentra
                        $posicion = $i;
                    }
                }
                //compruebo que la cantidad solicitada no sea superior al stock
                if ( $data[0]["stock"] >= $cantidad ) {
                    $_SESSION["carrito"][$posicion] = array(
                        "Producto" => $producto,
                        "Cantidad" => $cantidad
                    );
                    //cargar el carrito
                    $resultado = vistaListaCarrito();

                } else {
                    //la cantidad solicitada es superior al stock
                    $resultado = "error2";
                }

            } else {
                //crear un carrito nuevo
                //comprobar el stock
                if ( $data[0]["stock"] >= $cantidad ) {
                    $_SESSION["carrito"][0] = array(
                        "Producto" => $producto,
                        "Cantidad" => $cantidad
                    );
                    $resultado = vistaListaCarrito();

                } else {
                    $resultado = "error2";
                }
            }
        } else {
            //no puede comprar el producto
            $resultado =  "error1";
        }

        echo $resultado;

    }

    /**
     * Acción para ver la página de detalles del carrito
     */
    public function action_viewdetallcart()
    {
        //array con los carritos
        $datosCompletosProductosCarrito = array();//inicializacion
        //comprobar que el carrito existe
        if ( isset($_SESSION["carrito"]) ) {
            //reccorer el carro
            foreach ( $_SESSION["carrito"] as $value ) {
                //obtencion de los datos del producto
                $data = Ajax::getProductoCarrito( $value["Producto"] );
                $data = $data[0]; //para quitarle el $data[0]["producto"] y que seq $data["producto"]
                if ( $data ) {
                    //añadir a los datos del producto la cantidad solicitada
                    $data["cantidadSolicitada"] = $value["Cantidad"];
                    //"ordenar" la array
                    array_push( $datosCompletosProductosCarrito, $data );
                }
            }
            //se manda a la vista todo los datos.
            $code = vistaDetalladaProductosCarrito( $datosCompletosProductosCarrito );
            print_r( $code );

        }   else {
            //el carrito no existe
            echo "false";
        }
    }
    
    public function action_email()
    {
    	$myemail = 'sgmm1989@gmail.com';
	    $email 	 = $_POST["email"];
	    $nombre  = $_POST["name"];
	    $textMensaje = $_POST["msj"];
	    
	    $titulo = 'Gracias por contactar con nosotros';

		// message
		$mensaje = '
			<html>
				<head>
				  <title>Community Service</title>
				</head>
				<body>
				  <span>'.$nombre.'</span>
					<p> Gracias por contactar con nosotros. Recibira lo antes posible una respuesta a peticion</p>				  
				</body>
			</html>
		';
		// Para enviar un correo HTML mail, la cabecera Content-type debe fijarse
		$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
		$cabeceras .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		// Cabeceras adicionales
		$cabeceras .= 'To:'. $email . '\r\n';
		$cabeceras .= 'From: Community <community@gmail.com>' . "\r\n";
		
		// Mail it
		mail($email, $titulo, $mensaje, $cabeceras);
		
		
		//Mensaje que recibo
		// Send
		mail($myemail, 'contacto', $textMensaje.":".$email);
			
		
		
	    
    }
}