<?php


require_once 'application/view/general.php';

function getMessage()
{
    $file = 'public_html/html/cpanel/messages.html';
    $template = file_get_contents($file);
    return $template;
}

function vistaTemplateMessage ()
{
    $html = get_template_ini();
    $html = str_replace('{nav}', Controller_General::actionLoadNav(), $html);
    $html = str_replace('{construct}', vistaMessage(), $html);
    $html = str_replace('{sidebar}', vistaSidebar(), $html);

    $html = str_replace('{subSidebar}', vistaSubSidebar("Message"), $html);
    $html = str_replace('{breadLine}', vistaBreadline(), $html);

    $html = str_replace('{listaUsersContact}', VistaListContact(), $html);
    $html = str_replace('{secondListUsersContact}', VistaSecondListContact(), $html);//lista con imagen

    $html = str_replace('{loadMessages}', VistaMessageDefault(), $html);

    $html = translateMessage($html);

    $html = str_replace('{raiz}', "<span id=\"spanMsj\">Mensajes</span>" , $html);
    $html = str_replace('{accion}', getUserPrincipalBreadline(), $html);

    $nivel = $_SESSION["userLogin"][0]["nivelUser"];
    if($nivel == 1){
        $CatalegPos = "productos";
        $urlCatalegPos = "cataleg";
        $SalesBuy = "Ventas";
        $urlSalBuy = "sales";
    } else {
        $CatalegPos = "pos";
        $urlCatalegPos = "pos";
        $SalesBuy = "Compras";
        $urlSalBuy = "buy";
    }

    $html = str_replace('{imgAvatar}',  RutaImagenAvatar . $_SESSION["userLogin"][0]["avatar"], $html);
    $html = str_replace('{CatalegPos}', ucwords($CatalegPos), $html);
    $html = str_replace('{nameUser}',   $_SESSION["userLogin"][0]["userName"], $html);
    $html = str_replace('{urlDash}',    HOME . "cpanel/administrator", $html);
    $html = str_replace('{urlCatPos}',  HOME . "cpanel/" . $urlCatalegPos, $html);
    $html = str_replace('{urlSalBuy}',  HOME . "cpanel/" . $urlSalBuy, $html);
    $html = str_replace('{SalesBuy}',   $SalesBuy, $html);
    $html = str_replace('{urlMes}',     HOME . "cpanel/message", $html);
    $html = str_replace('{messages}',   "Mensajes", $html);
    $html = str_replace('{urlPre}',     HOME . "cpanel/preference" , $html);
    $html = str_replace('{preferences}', "Preferencias", $html);

    //Sidebar - Seleccionado
    $html = str_replace('{dash}', "", $html);
    $html = str_replace('{capo}', "", $html);
    $html = str_replace('{sabu}', "", $html);
    $html = str_replace('{mess}', "menuSelected", $html);
    $html = str_replace('{pref}', "", $html);

    $html = str_replace('{footer}', vistaFooterCpanel(), $html);
    print $html;
}

function VistaListContact()
{
    $data = vistaLoadContactList();

    $user = $_SESSION["userLogin"][0]["idUser"];
    $html = ""; //inicializar
    if ( $data ) {
        foreach ( $data["Valores"] as $value ) {
            if ( $value["idUsuario1"] == $user )
                $html .= '<option value="' . $value["idUsuario2"] . '">' . $value["receptor"] . '</option>';
            else
                $html .= '<option value="' . $value["idUsuario1"] . '">' . $value["emisor"] . '</option>';
        }
    }
    return $html;
}

function VistaSecondListContact()
{
    $data = vistaLoadContactList();
    $user = $_SESSION["userLogin"][0]["idUser"];
    $contactos = $data["Valores"];
    $numeroMensajes = $data["Cantidades"];

    $html = ""; //inicializar
    foreach ( $contactos as $value ) {
        //activeMessage
        //pd(count($numeroMensajes));
        if ( $value["idUsuario1"] == $user ) {
            
            $resultadoNumeroMensajes = 0;
            
            if(count($numeroMensajes) > 0) { 
	            foreach ($numeroMensajes as $result) {
	                    if($result["idEmisor"] == $value["idUsuario2"] ){
	                        $resultadoNumeroMensajes = $result["numeroDeMensajes"];
	                        $resultadoNumeroMensajes = '(' . $resultadoNumeroMensajes . ')';
	                    }
	            }
            }
            
            $html .= '
            <li id="' . $value["idUsuario2"] . '">
                <a href="#" title="">
                    <img src="' . AVATAR . $value["receptorAvatar"] . '" alt="">
                    <span class="contactName">
                        <strong>' . $value["receptor"] . ' <span class="' . $value["idUsuario2"] . '">' . $resultadoNumeroMensajes . '</span></strong>
                    </span>
                </a>
            </li>
            ';
        } else {
            $resultadoNumeroMensajes = "";
            foreach ($numeroMensajes as $result) {
                    if($result["idEmisor"] == $value["idUsuario1"] ){
                        $resultadoNumeroMensajes = $result["numeroDeMensajes"];
                        $resultadoNumeroMensajes = '(' . $resultadoNumeroMensajes . ')';
                    }

            }

            $html .='
            <li id="' . $value["idUsuario1"] . '">
                <a href="#" title="">
                    <img src="' . AVATAR . $value["emisorAvatar"] . '" alt="">
                    <span class="contactName">
                        <strong>' . $value["emisor"] . ' <span class="' . $value["idUsuario1"] . '">' . $resultadoNumeroMensajes . '</span></strong>
                    </span>
                </a>
            </li>
            ';
        }
    }

    return $html;
}

function VistaMessageDefault ()
{
    $data = vistaLoadContactList();
   
    if ( count($data["Valores"]) > 0 ) {
    	$data = $data["Valores"][0]; //unicamente me interesa el primer registro
        $dataMessage = LoadMessage( $data );
    
	    $html = ""; //inicializar
	    if ( $dataMessage ) {
	        foreach ( $dataMessage as $value ) {
	
	            if ( $value["idEmisor"] == $_SESSION["userLogin"][0]["idUser"] ) {
	                $by =  "by_my";
	            } else {
	                $by =  "by_user";
	            }
	
	            $html .='
	            <li class="' . $by . '" style="width: 100%;">
	                <a href="#" title=""><img src="' . AVATAR . $value["avatar"] . '" alt=""></a>
	                <div class="messageArea">
	                    <div class="msj">
	                        <span class="name"><strong>' . $value["userName"] . '</strong> comento:</span>
	                        <span class="ico_delete ico_message"></span>
	                    </div>
	                    <p>' . $value["mensaje"] . '</p>
	                </div>
	            </li>
	            ';
	        }
	    }
    }
    return $html;
}

function vistaMessage ()
{
    $html = getMessage();
    return $html;
}

function translateMessage( $codigo )
{
    $codigo = str_replace('{Language:}', Lang::p("Language:"), $codigo);
    $codigo = str_replace('{conversations}', Lang::p("conversations"), $codigo);
    $codigo = str_replace('{breadLine}', Lang::p("breadLine"), $codigo);

    return $codigo;
}
