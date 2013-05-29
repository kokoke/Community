<?php

require_once 'application/view/cpanel/cataleg.php';
require_once 'application/models/cataleg.php';

require_once 'application/controllers/general.php';
/**
 * Controlador de los productos
 */
class Controller_Cataleg
{
    /**
     * Acción para editar los productos
     */
    public function action_edit( $product )
    {

        if ( isset($_SESSION["userLogin"]) ){
            vistaTemplateCataleg("edit", $product);
        }

    }

    /**
     * Acción para ver los productos
     */
   public function action_view( $product )
    {

        if ( isset($_SESSION["userLogin"]) ) {
            vistaTemplateCataleg("view", $product);
        }

    }

    /**
     * Acción para eliminar producto
     */
    public function action_del( $product_ref )
    {

        if ( isset($_SESSION["userLogin"]) ) {
            vistaTemplateCataleg("del", $product_ref);
        }
    }
    /**
     * Acción para añadir producto
     */
    public function action_add()
    {

       if( isset($_SESSION["userLogin"]) ) {
            vistaTemplateCataleg("add","none");
       }

    }

    /**
     * Acción para cargar las categorias
     */
    public function action_cat()
    {

       if ( isset($_SESSION["userLogin"]) ) {
            vistaTemplateCataleg("categories","none");
       }

    }

    /**
     * Acción para cargar los IVAs
     */
    public function action_tax()
    {

       if( isset($_SESSION["userLogin"]) ) {
            vistaTemplateCataleg("taxations","none");
       }

    }


    public function action_products( $product )
    {
        if ( isset($_SESSION["userLogin"]) ) {
            vistaTemplateCataleg("del", $product);
        }

    }

    public function action_categories()
    {

        if(isset($_SESSION["userLogin"])){
            vistaTemplateCataleg("categories", "none");
        }

    }

    public function action_taxations()
    {

        if(isset($_SESSION["userLogin"])){
            vistaTemplateCataleg("taxations", "none");
        }

    }

    /*
     * Añadir categoría
     */
    public function action_addCategorie() {
       if($_GET["categorie"]){
            Cataleg::setNewCataleg($_GET["categorie"]);
       }
       Redirect::to_route("cataleg@categories");
    }

    /*
     * Eliminar categoría
     */
    public function action_delCategorie($categoria)
    {
        //pd($categoria);
        Cataleg::delNewCataleg($categoria);
        Redirect::to_route("cataleg@categories");    
    }

    /*
     * Accion para guardar el nuevo producto
     */
    public function action_saveProduct()
    {

        //Cargar la imagen del producto al servidor
        $uploads_dir    = RutaProductosImagen;
        $tmp_name       = $_FILES["imagenAddProduct"]["tmp_name"];
        $name           = $_FILES["imagenAddProduct"]["name"];
        move_uploaded_file($tmp_name, "$uploads_dir/$name");

        if ( $_POST ) {
            $data["saveNameProduct"] = $_POST["saveNameProduct"];
            $data["checkEnambleBuy"] = ($_POST["checkEnambleBuy"]) ? "1" : "0";
            $data["listCategory"] = $_POST["listCategory"];
            $data["savePrecioProduct"] = $_POST["savePrecioProduct"];
            $data["saveRefProduct"] = $_POST["saveRefProduct"];
            $data["savePriceCostProduct"] = $_POST["savePriceCostProduct"];
            $data["saveDeliveryProduct"] = $_POST["saveDeliveryProduct"];
            $data["saveStockProduct"] = $_POST["saveStockProduct"];
            $data["listIVA"] = $_POST["listIVA"];

            //Añadir una imagen, o la que se sube o una por defecto
            if ( $_FILES )
                $data["imagenProducto"] = $_FILES["imagenAddProduct"]["name"];
            else
                $data["imagenProducto"] = "defaultProduct.jpg";

            //insertar los datos
            Cataleg::insertNewProduct($data);
            Redirect::to_route("cpanel@cataleg");

        }
    }

    /*
     * Accion para Modificar el nuevo producto
     */
    public function action_saveEditProduct(){

        /**
         * subir la imagen al servidor
         */
        $uploads_dir    = RutaProductosImagen;
        $tmp_name       = $_FILES["editImageProduct"]["tmp_name"];
        $name           = $_FILES["editImageProduct"]["name"];
        move_uploaded_file($tmp_name, "$uploads_dir/$name");

        if ( $_POST ) {

            $data["editNameProduct"] = $_POST["editNameProduct"];
            $data["editCheckProduct"] = ($_POST["editCheckProduct"]) ? "1" : "0";
            $data["editCategoryProduct"] = $_POST["editCategoryProduct"];
            $data["editPrecioProduct"] = $_POST["editPrecioProduct"];
            $data["editRefProduct"] = $_POST["editRefProduct"];
            $data["editPrecioCostProduct"] = $_POST["editPrecioCostProduct"];
            $data["editEntregaProduct"] = $_POST["editEntregaProduct"];
            $data["editStockProduct"] = $_POST["editStockProduct"];
            $data["editIvaProduct"] = $_POST["editIvaProduct"];
            $data["hiddenRefProduct"] = $_POST["hiddenRefProduct"];

            if($_FILES){
                $data["imagenProducto"] = $_FILES["editImageProduct"]["name"];
            }
            else
                $data["imagenProducto"] = "defaultProduct.jpg";

            Cataleg::updateProduct($data);
            Redirect::to_route("cpanel@cataleg");
        }
    }
}