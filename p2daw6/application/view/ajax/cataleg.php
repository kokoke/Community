<?php

function ajaxReloadListProduct()
{
    $data = Ajax::getProducts();
    $html = "";

    foreach ($data as  $value) {
        //pd($value);
        $html =  $html.'
            <tr class="gradeA odd">
                <td class="  sorting_1">'.$value["nombre"].'</td>
                <td class=" ">'.$value["categoria"].'</td>
                <td class=" ">'.$value["subcategoria"].'</td>
                <td class=" ">'.$value["precio"].'</td>
                <td class="tableActs">
                    <a href="' . Route::to("cataleg@edit", array($value["id"])) . '" class="tablectrl_small bDefault tipS icons" original-title="Edit">
                        <span class="iconb icoEdit">
                            <img src="'.HOME.'public_html/img/ico/icon-edit.png">
                        </span>
                    </a>
                    <a onclick="eliminarProduct('.$value["id"].')" class="tablectrl_small bDefault tipS icons" original-title="Remove">
                        <span class="iconb icoDel">
                            <img src="'.HOME.'public_html/img/ico/icon-del.png">
                        </span>
                    </a>
                </td>
            </tr>';
        }

    return $html;
}
