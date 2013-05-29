<?php
//PAGINAS HOME
Route::in('/'           ,'home@home');
Route::in('/home'       ,'home@home');
Route::in('/contact'    ,'home@contact');
Route::in('/register'   ,'home@register');
Route::in('/newuser'    ,'home@newuser');
Route::in('/errorpage'  ,'home@errorpage');
Route::in('/sindication','home@sindication');

//PAGINAS SIMPLE CPANEL
Route::in('/cpanel/preference'   ,'cpanel@preference');
Route::in('/cpanel/administrator','cpanel@administrator');
Route::in('/cpanel/message'      ,'cpanel@message');
Route::in('/cpanel/cataleg'      ,'cpanel@cataleg');
Route::in('/cpanel/sales'        ,'cpanel@sales');
Route::in('/cpanel/pos'          ,'cpanel@pos');
Route::in('/cpanel/buy'          ,'cpanel@buy');
Route::in('/admin/login'         ,'admin@login');
Route::in('/admin/remember'      ,'admin@remember');
Route::in('/general/logout'      ,'general@logout');

//PAGINAS COMPLEJAS CPANEL
//-------------------------
//CATEGORIES
Route::in('/cpanel/cataleg/add'         ,'cataleg@add');
Route::in('/cpanel/cataleg/categories'  ,'cataleg@categories');
Route::in('/cpanel/cataleg/products'    ,'cpanel@cataleg');
Route::in('/cpanel/cataleg/taxation'    ,'cataleg@taxations');
Route::in('/cpanel/cataleg/addCategorie','cataleg@addCategorie');
Route::in('/cpanel/cataleg/saveProduct' ,'cataleg@saveProduct');

//Preference
Route::in('/cpanel/preference/pay',             'preference@pay');
Route::in('/cpanel/preference/contacts',        'preference@contacts');
Route::in('/cpanel/preference/suppliers',       'preference@suppliers');
Route::in('/cpanel/preference/products',        'preference@products');
Route::in('/cpanel/preference/sellers',         'preference@sellers');
Route::in('/cpanel/preference/saveDatesUser',   'preference@saveDatesUser');
Route::in('/cpanel/preference/delTarget/{argument}',   'preference@delTarget');
Route::in('/cpanel/preference/addcontact/{argument}',  'preference@addcontact');
Route::in('/cpanel/preference/acceptcontact/{argument}',  'preference@acceptcontact');
Route::in('/cpanel/preference/delcontact/{argument}',     'preference@delcontact');

//AJAX
Route::in('/ajax/newsletter',       'ajax@newsletter');     //Home - Newsletter
Route::in('/ajax/checkUser',        'ajax@checkUser');      //Home - Comprobar que el usuario existe
Route::in('/ajax/newMessage',       'ajax@newMessage');
Route::in('/ajax/listMessage',      'ajax@listMessage');
Route::in('/ajax/userName',         'ajax@userName');
Route::in('/ajax/userEmail',        'ajax@userEmail');
Route::in('/ajax/refrescarContacto','ajax@refrescarContacto');
Route::in('/ajax/breadLine',        'ajax@breadLine');
Route::in('/ajax/comprobarref',     'ajax@comprobarref');
Route::in('/ajax/cargarimagen',     'ajax@cargarimagen');
Route::in('/ajax/newTarget',        'ajax@newTarget');
Route::in('/ajax/addProductCart',   'ajax@addProductCart');
Route::in('/ajax/loadProductCart',  'ajax@loadProductCart');
Route::in('/ajax/delProductCart',   'ajax@delProductCart');
Route::in('/ajax/viewdetallcart',   'ajax@viewdetallcart');
Route::in('/ajax/email'			,   'ajax@email');

//POS
Route::in('/cpanel/pos/delProduct/{argument}',  'pos@delProduct');
Route::in('/cpanel/pos/delCart',                'pos@delCart');
Route::in('/cpanel/pos/addPedido',              'pos@addPedido');

//PAGINAS COMPLEJAS CATALOGO
Route::in('/cpanel/cataleg/edit/{argument}',            'cataleg@edit');   // Editar un product
Route::in('/cpanel/cataleg/del/{argument}',             'cataleg@del');     // Eliminar un producto
Route::in('/cpanel/cataleg/view/{argument}',            'cataleg@view');
Route::in('/cpanel/cataleg/delCategorie/{argument}',    'cataleg@delCategorie');
Route::in('/cpanel/cataleg/saveEditProduct/{argument}','cataleg@saveEditProduct');

// SALES (Ventas)
Route::in('/cpanel/sales/view/{argument}' ,'sales@view');
Route::in('/cpanel/sales/del/{argument}'  ,'sales@del');
Route::in('/cpanel/sales/del/{argument}'  ,'sales@xml');

//BUY
Route::in('/cpanel/buy/view/{argument}' ,'buy@viewDetallePedido');
Route::in('/cpanel/buy/pdf/{argument}'  ,'buy@PDF');

//LOGIN
Route::in('/cpanel', 'cpanel@administrator');

//IDIOMAS
Route::in('/lang/index', 'lang@index');