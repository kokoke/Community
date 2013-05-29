<?php


require_once 'application/view/general.php';

function getPreference()
{
    $file = 'public_html/html/cpanel/preference.html';
    $template = file_get_contents($file);
    return $template;
}

function getConstructPreference($fileVista)
{
    $file = 'public_html/html/preference/' . $fileVista . '.html';
    $template = file_get_contents($file);
    return $template;
}

function vistaTemplatePreference ($accion)
{
    $html = get_template_ini();
    $html = str_replace('{nav}', Controller_General::actionLoadNav(), $html);
    $html = str_replace('{construct}', vistaPreference(), $html);
    $html = str_replace('{sidebar}', vistaSidebar(), $html);
    //CAMBIAR POR URL FRIEND
    $html = str_replace('{subSidebar}', vistaSubSidebar("Preference"), $html);

    $vista = "dates";
    $cargarValoresPreferencias = "";
    $bread = "Datos";
    if ( $accion ) {
        switch ( $accion ) {
            case 'contacts':
                $bread = "Contactos";
                $vista = 'contacts';
                $html = str_replace('{activeContact}', "active", $html);
                $html = str_replace('{thisContact}', "this", $html);
            break;
            case 'suppliers':
                $bread = "Buscar proveedores";
                $vista = "suppliers";
                $html = str_replace('{activeSuppliers}', "active", $html);
                $html = str_replace('{thisSuppliers}', "this", $html);
            break;
            case 'products':
                $bread = "Buscar productos";
                $vista = "products";
                $html = str_replace('{activeProducts}', "active", $html);
                $html = str_replace('{thisProducts}', "this", $html);
            break;
            case 'sellers':
                $bread = "Vendedores";
                $vista = "sellers";
                $html = str_replace('{activeSellers}', "active", $html);
                $html = str_replace('{thisSellers}', "this", $html);
            break;
            case 'pay':
                $bread = "Formas de pago";
                $vista = "pay";
                $html = str_replace('{activePay}', "active", $html);
                $html = str_replace('{thisPay}', "this", $html);
            break;
            default:
                Redirect::to_route("cpanel@preference");
            break;
        }

    } else if ( count( $accion ) > 1 ) {

        Redirect::to_route("cpanel@preference");

    } else {

        $vista = "dates";
        $html = str_replace('{activeDatos}', "active", $html);
        $html = str_replace('{thisDatos}', "this", $html);

    }

    //Para evitar repeticiones, en cada $accion, subtituyo lo que me interesa,
    //el resto lo dejo en blanco... como no encontrara lo que ya he substituido
    $html = str_replace('{activeDatos}', "", $html);
    $html = str_replace('{thisDatos}', "", $html);
    $html = str_replace('{activePay}', "", $html);
    $html = str_replace('{thisPay}', "", $html);
    $html = str_replace('{activeContact}', "", $html);
    $html = str_replace('{thisContact}', "", $html);
    $html = str_replace('{activeSuppliers}', "", $html);
    $html = str_replace('{thisSuppliers}', "", $html);
    $html = str_replace('{activeProducts}', "", $html);
    $html = str_replace('{thisProducts}', "", $html);
    $html = str_replace('{activeSellers}', "", $html);
    $html = str_replace('{thisSellers}', "", $html);

    //Sidebar - Seleccionado
    $html = str_replace('{dash}', "", $html);
    $html = str_replace('{capo}', "", $html);
    $html = str_replace('{sabu}', "", $html);
    $html = str_replace('{mess}', "", $html);
    $html = str_replace('{pref}', "menuSelected", $html);

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

    //SUBMENUS
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

    $html = str_replace('{breadLine}', vistaBreadline(), $html);
    $html = str_replace('{constructPreference}', vistaConstructPreference($vista), $html);

    //BREADLINE
    $html = str_replace('{urlPaginaActual}', HOME . "cpanel/preference", $html);
    $html = str_replace('{raiz}', "Preferencias", $html);
    $html = str_replace('{urlAccionPagina}', "#", $html);

    $html = str_replace('{accion}', $bread , $html);

    $html = getValuesForUploadProfile($html);
    $html = reemplazarCamposPaginaAccion($accion, $html);

    $html = translatePreference($html);
    $html = str_replace('{footer}', vistaFooterCpanel(), $html);
    print $html;

}



function vistaPreference ()
{
    $html = getPreference();
    return $html;
}

function vistaConstructPreference ( $fileVista )
{
    $html = getConstructPreference($fileVista);
    return $html;
}

function translatePreference( $codigo )
{
    $codigo = str_replace('{Language:}', Lang::p("Language:"), $codigo);
    $codigo = str_replace('{conversations}', Lang::p("conversations"), $codigo);
    $codigo = str_replace('{breadLine}', Lang::p("breadLine"), $codigo);

    return $codigo;
}

function getValuesForUploadProfile ( $codigo )
{
    $dataUserEmpresa = Preference::getDateUser();
    $dataUserEmpresa = $dataUserEmpresa[0];

    $codigo = str_replace('{editProfileUserName}'   , $dataUserEmpresa["userName"] , $codigo);
    $codigo = str_replace('{imagenEditAvatar}'      , HOME . "public_html/img/avatar/" . $dataUserEmpresa["avatar"] , $codigo);
    $codigo = str_replace('{editProfileEmail}'      , $dataUserEmpresa["email"] , $codigo);
    $codigo = str_replace('{editProfileNombre}'     , $dataUserEmpresa["nombre"] , $codigo);
    $codigo = str_replace('{editProfileApellido}'   , $dataUserEmpresa["apellidos"] , $codigo);
    $codigo = str_replace('{editProfileDNI}'        , $dataUserEmpresa["email"] , $codigo);
    $codigo = str_replace('{editProfilefecha}'      , $dataUserEmpresa["fechanacimiento"] , $codigo);
    $codigo = str_replace('{editProfileTelefono}'   , $dataUserEmpresa["telefono"] , $codigo);
    $codigo = str_replace('{editProfileAddress}'    , $dataUserEmpresa["direccion"] , $codigo);
    $codigo = str_replace('{editProfileDenominacion}', $dataUserEmpresa["denominacion"] , $codigo);
    $codigo = str_replace('{editProfileCIF}'        , $dataUserEmpresa["cif"] , $codigo);
    $codigo = str_replace('{editProfileWeb}'        , $dataUserEmpresa["web"] , $codigo);

    return $codigo;

}

function reemplazarCamposPaginaAccion( $accion, $codigo )
{

    switch ( $accion ) {
        case 'pay':
            $codigo = str_replace('{listaTargetasCredito}', vistaListaTargetasCredito(), $codigo);
            break;
        case 'suppliers':
            $codigo = str_replace('{listaSuppliers}', vistaListaSuppliers(), $codigo);
            break;
        case 'products':
            $codigo = str_replace('{listaProductos}', vistaListProducts(), $codigo);
            break;
        case 'sellers':
            $codigo = str_replace('{listaSellers}', vistaListSellers(), $codigo);
            break;
        case 'contacts':
            $codigo = str_replace('{listaContactosPendientes}'  , vistaListContactsSlope(), $codigo);
            $codigo = str_replace('{listaContactosAceptados}'   , vistaListContactsAcept(), $codigo);
            break;
    }

    return $codigo;
}

/************************************
 * Funciones para cargar las tablas *
 ************************************/

function vistaListaTargetasCredito(){
    $listaTargetas = Preference::getTarget();
    $codigo = "";
    if($listaTargetas){
        foreach ($listaTargetas as $value) {
            $codigo = $codigo. '
                <tr class="gradeA odd">
                    <td class="  sorting_1" style="text-align: left;">' . $value["targeta"] . '</td>
                    <td class="tableActs">
                        <a  href="' . Route::to("preference@delTarget", array($value["idTargeta"])) . '" class="tablectrl_small bDefault tipS icons delproducto" original-title="check">
                            <span class="iconb icoCheck">
                                <img src="'.HOME.'public_html/img/ico/icon-del.png">
                            </span>
                        </a>
                    </td>
                </tr>';
        }
    }

    return $codigo;
}

function vistaListaSuppliers()
{
    $listaProveedores = Preference::getContactList("1");
    $codigo = "";

    if($listaProveedores){
        foreach ($listaProveedores as $value) {
            $codigo .= '
                <tr class="gradeA odd">
                    <td class="  sorting_1">' . $value["nombre"] . '</td>
                    <td class="">' . $value["denominacion"] . '</td>
                    <td class="">' . $value["email"] . '</td>
                    <td class="">' . $value["web"] . '</td>
                    <td class="tableActs">
                        <a  href="' . Route::to("preference@addcontact", array($value["idUser"])) . '" class="tablectrl_small bDefault tipS icons" original-title="Remove">
                            <span class="iconb icoCheck">
                                <img src="'.HOME.'public_html/img/ico/icon-check.png">
                            </span>
                        </a>
                    </td>
                </tr>';
        }
    }

    return $codigo;
}

function vistaListProducts()
{
    $listaProductos = Preference::getProducts();
    $codigo = "";

    if($listaProductos){
        foreach ($listaProductos as $value) {
            $codigo .= '
                <tr class="gradeA odd">
                    <td class="  sorting_1">' . $value["producto"] . '</td>
                    <td class=" ">' . $value["precio"] . '</td>
                    <td class=" ">' . $value["nombre"] . '</td>
                    <td class=" ">' . $value["email"] . '</td>
                    <td class="tableActs">
                        <a  href="' . Route::to("preference@addcontact", array($value["idUser"])) . '" class="tablectrl_small bDefault tipS icons" original-title="Remove">
                            <span class="iconb icoCheck">
                                <img src="' . HOME . 'public_html/img/ico/icon-check.png">
                            </span>
                        </a>
                    </td>
                </tr>';
        }
    }

    return $codigo;
}


function vistaListSellers()
{
    $listaProductos = Preference::getContactList("2");
    $codigo = "";

    if($listaProductos){
        foreach ($listaProductos as $value) {

            $codigo .= '
                <tr class="gradeA odd">
                    <td class="  sorting_1">' . $value["nombre"] . '</td>
                    <td class="">' . $value["denominacion"] . '</td>
                    <td class="">' . $value["email"] . '</td>
                    <td class="">' . $value["web"] . '</td>
                    <td class="tableActs">
                        <a  href="' . Route::to("preference@addcontact", array($value["idUser"])) . '" class="tablectrl_small bDefault tipS icons" original-title="Remove">
                            <span class="iconb icoCheck">
                                <img src="' . HOME . 'public_html/img/ico/icon-check.png">
                            </span>
                        </a>
                    </td>
                </tr>';
        }
    }
    return $codigo;
}

function vistaListContactsSlope() {
    $dataContactSlope = Preference::getPreferenceContactList("0");
    $codigo = "";

    if($dataContactSlope){
        foreach ($dataContactSlope as $value) {
            $codigo .= '
                <tr class="gradeA odd">
                    <td class="  sorting_1">' . $value["nombreUsu1"] . '</td>
                    <td class="  sorting_1">' . $value["empresa1"] . '</td>
                    <td class="tableActs">
                        <a  href="' . Route::to("preference@acceptcontact", array($value["usuario1"])) . '" class="tablectrl_small bDefault tipS icons" original-title="Remove">
                            <span class="iconb icoCheck">
                                <img src="' . HOME . 'public_html/img/ico/icon-check.png">
                            </span>
                        </a>
                    </td>
                </tr>';
        }
    }

    return $codigo;
}

function vistaListContactsAcept()
{
    $dataContact = Preference::getPreferenceContactList("1");
    $codigo = "";

    $user = $_SESSION["userLogin"][0]["idUser"];

    if($dataContact){
        foreach ( $dataContact as $value ) {
            //comprobar que el usuario no sea el mismo
            if($value["usuario2"] == 0 || $value["usuario1"] == 0){
                $codigo .= '
                        <tr class="gradeA odd">
                            <td class="  sorting_1">Administrador</td>
                            <td class="  sorting_1">Community</td>
                            <td class="tableActs"></td>
                        </tr>';
            } else {
            
	            if ( $value["aceptadoUsuario1"] == 1 and $value["aceptadoUsuario2"] == 1 ) {
	                if ( $value["usuario1"] == $user ) {
	                    $codigo .= '
	                        <tr class="gradeA odd">
	                            <td class="  sorting_1">' . $value["nombreUsu2"] . '</td>
	                            <td class="  sorting_1">' . $value["empresa2"] . '</td>
	                            <td class="tableActs">
	                                <a  href="' . Route::to("preference@delcontact", array($value["usuario2"])) . '" class="tablectrl_small bDefault tipS icons delproducto" original-title="Remove">
	                                    <span class="iconb icoDel">
	                                        <img src="' . HOME . 'public_html/img/ico/icon-del.png">
	                                    </span>
	                                </a>
	                            </td>
	                        </tr>';
	                } else if ($value["usuario2"] == $user){
	                    $codigo .= '
	                        <tr class="gradeA odd">
	                            <td class="  sorting_1">' . $value["nombreUsu1"] . '</td>
	                            <td class="  sorting_1">' . $value["empresa1"] . '</td>
	                            <td class="tableActs">
	                                <a  href="' . Route::to("preference@delcontact", array($value["usuario1"])) . '" class="tablectrl_small bDefault tipS icons delproducto" original-title="Remove">
	                                    <span class="iconb icoDel">
	                                        <img src="' . HOME . 'public_html/img/ico/icon-del.png">
	                                    </span>
	                                </a>
	                            </td>
	                        </tr>';
	                }
	           }
            }
        }
    }

    return $codigo;
}