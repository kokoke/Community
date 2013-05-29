<?php

require_once 'application/view/general.php';
require_once 'application/view/cpanel/cataleg.php';

function getCataleg()
{
    $file = 'public_html/html/cpanel/cataleg.html';
    $template = file_get_contents($file);
    return $template;
}

function getProducts()
{
    $file = 'public_html/html/cataleg/products.html';
    $template = file_get_contents($file);
    return $template;
}

function getVistaEditProducts( $accion )
{
    $file = 'public_html/html/cataleg/'.$accion.'Product.html';
    $template = file_get_contents($file);
    return $template;
}

function getvistaProductCategories ()
{
    $file = 'public_html/html/cataleg/categories.html';
    $template = file_get_contents($file);
    return $template;
}

function getvistaProductTaxation ()
{
    $file = 'public_html/html/cataleg/taxation.html';
    $template = file_get_contents($file);
    return $template;
}



function vistaTemplateCataleg ( $action, $producto )
{
    $html = get_template_ini();
    $html = str_replace('{nav}', Controller_General::actionLoadNav(), $html);
    $html = str_replace('{construct}', vistaCataleg(), $html);
    $html = str_replace('{sidebar}', vistaSidebar(), $html);
    $html = str_replace('{subSidebar}', vistaSubSidebar("Cataleg"), $html);
    $html = str_replace('{breadLine}', vistaBreadline(), $html);

    $confirm = Cataleg::comprobarProductoAccion( $producto );

    $vista = "";
    switch ($action) {
        case 'edit':
            $vista = vistaEditProducts("edit", $producto);
        break;
        case 'view':
            if ( $confirm ) {
                $vista = vistaViewProducts("view", $producto);
            } else {
                Redirect::to_route("cpanel@cataleg");
            }

        break;
        case 'del':
            if ( $confirm ) {
                Cataleg::delProduct($producto);
            }
            Redirect::to_route("cpanel@cataleg");
        break;
        case 'list':
            $vista = vistaProducts();
            $html = str_replace('{activeCatalegCategory}', "class=\"\"", $html);
            $html = str_replace('{thisCatalegCategory}', "class=\"\"", $html);
            $html = str_replace('{activeCatalegProducts}', "class=\"active\"", $html);
            $html = str_replace('{thisCatalegProduct}', "class=\"this\"", $html);
        break;
        case 'add':
            $vista = vistaNewProducts();
        break;
        case 'categories':
            $vista = vistaProductCategories();
            $html = str_replace('{activeCatalegCategory}', "class=\"active\"", $html);
            $html = str_replace('{thisCatalegCategory}', "class=\"this\"", $html);
            $html = str_replace('{activeCatalegProducts}', "aa", $html);
            $html = str_replace('{thisCatalegProduct}', "class=\"\"", $html);
        break;
        case 'taxations':
            $vista = vistaProductTaxation();
        break;
        case 'buy':
            $vista = vistaListBuy();
        break;
        default:
            Redirect::to_route("cpanel@cataleg");
        break;
    }

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
    $html = str_replace('{capo}', "menuSelected", $html);
    $html = str_replace('{sabu}', "", $html);
    $html = str_replace('{mess}', "", $html);
    $html = str_replace('{pref}', "", $html);

    //BREADLINE
    $html = str_replace('{urlPaginaActual}', HOME . "cpanel/cataleg", $html);
    $html = str_replace('{raiz}', "Catalogo", $html);
    $html = str_replace('{urlAccionPagina}', "#", $html);

    if ( $producto == "all" || $producto == "none" )
        $subaccion = "";
    else
        $subaccion = $producto;

    $html = str_replace('{accion}', $subaccion , $html);

    $html = str_replace('{footer}', vistaFooterCpanel(), $html);

    $html = str_replace('{constructCataleg}', $vista, $html);
    $html = str_replace('{listaDeProductos}', vistaListProducto(), $html);

    print $html;
}



function vistaCataleg ()
{
    $html = getCataleg();
    return $html;
}

function vistaProducts ()
{
    $html = getProducts();
    return $html;
}

function vistaNewProducts()
{
    $html = getVistaNewProducts();

    $dataCategoria = Cataleg::getCategoria();
    $dataOptionCategory = "";

    foreach ($dataCategoria as $data) {
        $dataOptionCategory = $dataOptionCategory . '<option value="' . $data["idCategory"] . '">' . $data["category"] . '</option>';
    }

    $dataIVA = Cataleg::getIVA();
    $dataOptionIVA = "";
    foreach ( $dataIVA as $data ) {
        $dataOptionIVA = $dataOptionIVA . '<option value="' . $data["idIVA"] . '">' . $data["cotizacion"] . '%</option>';
    }

    $html = str_replace('{listIVA}', $dataOptionIVA, $html);
    $html = str_replace('{listaProductsCategory}', $dataOptionCategory, $html);
    return $html;
}

function getVistaNewProducts()
{
    $file = 'public_html/html/cataleg/addProduct.html';
    $template = file_get_contents($file);
    return $template;
}

function vistaViewProducts ( $accion, $producto )
{
    $data = Cataleg::getProducto($producto);
    $data = $data[0];//paso de $data[0]["producto"] a $data["producto"];

    $html = getVistaEditProducts($accion);
    $html = str_replace('{ivaProducto}', $data["cotizacion"] . '%', $html);
    $html = str_replace('{stockProducto}', $data["stock"] . " unidades", $html);
    $html = str_replace('{entregaProducto}', $data["plazoEntrega"] . " dias", $html);
    $html = str_replace('{precioCosteProducto}', ($data["precioCoste"]) . "&euro;", $html);
    $html = str_replace('{REFProducto}', $data["referencia"], $html);
    $html = str_replace('{precioProducto}', $data["precio"] . "&euro;", $html);
    $html = str_replace('{categoriaProducto}', $data["category"], $html);
    $html = str_replace('{nombreProduct}', $data["producto"], $html);
    $html = str_replace('{imgProduct}', HOME . "public_html/img/product/" . $data["imagen"], $html);

    //valor del checked 0, no se puede comprar, 1 se puede comprar
    if($data["comprar"] == 0){
        $html = str_replace('{valorCompra}', "", $html);
    } else {
        $html = str_replace('{valorCompra}', "checked", $html);
    }

    return $html;
}

function vistaEditProducts ( $accion, $producto )
{
    $data = Cataleg::getProducto($producto);
    $data = $data[0];//paso de $data[0]["producto"] a $data["producto"];

    $html = getVistaEditProducts($accion);

    $dataCategoria = Cataleg::getCategoria();
    $dataOptionCategory = "";

    foreach ($dataCategoria as $value) {
        $select = ($value["idCategory"] == $data["idCategory"]) ? "selected":"";
        $dataOptionCategory = $dataOptionCategory . '<option value="' . $value["idCategory"] . '" ' . $select . '>' . $value["category"] . '</option>';
    }

    $dataIVA = Cataleg::getIVA();
    $dataOptionIVA = "";

    foreach ($dataIVA as $value) {
        $select = ($value["idIVA"] == $data["idIVA"]) ? "selected":"";
        $dataOptionIVA = $dataOptionIVA . '<option value="' . $value["idIVA"] . '" ' . $select . ' >' . $value["cotizacion"] . '%</option>';
    }

    $html = str_replace('{productEditToSave}', $data["referencia"], $html);
    $html = str_replace('{stockEditProduct}', 'value="' . $data["stock"] . '"', $html);
    $html = str_replace('{plazoEditProduct}', 'value="' . $data["plazoEntrega"] . '"', $html);
    $html = str_replace('{priceCostEditProduct}', 'value="' . ($data["precioCoste"]) . '"', $html);
    $html = str_replace('{refEditProduct}', 'value="' . $data["referencia"] . '"', $html);
    $html = str_replace('{priceEditProduct}', 'value="' . $data["precio"] . '"', $html);
    $html = str_replace('{nameEditProduct}', 'value="' . $data["producto"] . '"', $html);
    $html = str_replace('{imgEditProduct}', HOME . "public_html/img/product/" . $data["imagen"] . '"', $html);
    $html = str_replace('{listaProductEdit}', $dataOptionCategory, $html);
    $html = str_replace('{listaProductIva}', $dataOptionIVA, $html);

    //valor del checked 0, no se puede comprar, 1 se puede comprar
    if($data["comprar"] == 0){
        $html = str_replace('{editCheckProduct}', "", $html);
    } else {
        $html = str_replace('{editCheckProduct}', "checked", $html);
    }

    return $html;
}

function vistaProductCategories()
{
    $html = getvistaProductCategories();
    $html = str_replace('{listaDeCategorias}', cargarListaDeCategorias(), $html);

    return $html;
}

function cargarListaDeCategorias()
{
    $dataCategoria = Cataleg::getCategoria();
    $htmlCategoria = "";
    foreach ($dataCategoria as $value) {
        $htmlCategoria .='
            <tr class="gradeA odd">
                <td class="  sorting_1">'.$value["category"].'</td>
                <td class=" ">'.$value["userName"].'</td>
        ';

        if($value["creador"] == 0) {
            //campo vacio para que no pueda eliminarlo
            $htmlCategoria .= '<td class="tableActs"></td>';
        } else {
            $htmlCategoria .= '
                <td class="tableActs">
                        <a  href="' . Route::to("cataleg@delCategorie", array($value["idCategory"])) . '" class="tablectrl_small bDefault tipS icons delproducto" original-title="Remove">
                            <span class="iconb icoDel">
                                <img src="'.HOME.'public_html/img/ico/icon-del.png">
                            </span>
                        </a>
                </td>
            ';
        }
        $htmlCategoria .= ' </tr>';
    }

    return $htmlCategoria;
}

function vistaProductTaxation()
{
    $html = getvistaProductTaxation();
    return $html;
}

function translateCataleg( $codigo )
{
    $codigo = str_replace('{Language:}', Lang::p("Language:"), $codigo);
    $codigo = str_replace('{conversations}', Lang::p("conversations"), $codigo);
    $codigo = str_replace('{breadLine}', Lang::p("breadLine"), $codigo);

    return $codigo;
}

function vistaListProducto()
{
    $data = Cataleg::get();
    $html = "";

    if ( $data ) {
        foreach ( $data as  $value ) {
            //pd($value);
            $html .= '
                <tr class="gradeA odd">
                    <td class="  sorting_1">' . $value["referencia"] . '</td>
                    <td class="  sorting_1">' . $value["producto"] . '</td>
                    <td class=" ">' . $value["category"] . '</td>
                    <td class=" ">' . $value["precio"] . '</td>
                    <td class="tableActs">
                        <a href="' . Route::to("cataleg@view", array($value["referencia"])) . '" class="tablectrl_small bDefault tipS icons" original-title="Edit">
                            <span class="iconb icoEdit">
                                <img src="'.HOME.'public_html/img/ico/icon-view.png">
                            </span>
                        </a>
                        <a href="' . Route::to("cataleg@edit", array($value["referencia"])) . '" class="tablectrl_small bDefault tipS icons" original-title="Edit">
                            <span class="iconb icoEdit">
                                <img src="'.HOME.'public_html/img/ico/icon-edit.png">
                            </span>
                        </a>
                        <a  href="' . Route::to("cataleg@del", array($value["referencia"])) .'" class="tablectrl_small bDefault tipS icons delproducto" original-title="Remove">
                            <span class="iconb icoDel">
                                <img src="'.HOME.'public_html/img/ico/icon-del.png">
                            </span>
                        </a>
                    </td>
                </tr>';
            }
        }
    return $html;
}
