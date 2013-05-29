<?php

function ajaxVistaContactMessage( $dataMessage )
{
	//pd2(count($dataMessage), $dataMessage."+");
	$html = "";
	if($dataMessage) {
	    foreach ( $dataMessage as $value ) {
	        
	        if ( $value["idEmisor"] == $_SESSION["userLogin"][0]["idUser"] ) {
	            $by =  "by_my";
	        } else {
	            $by =  "by_user";
	        }
	
	        $html .='
		        <li class="'.$by.'" style="width: 100%;">
		            <a href="#" title=""><img src="'.AVATAR.$value["avatar"].'" alt=""></a>
		            <div class="messageArea">
		                <div class="msj">
		                    <span class="name"><strong>'.$value["userName"].'</strong> comento:</span>
		                    <span class="ico_delete ico_message"></span>
		                </div>
		                <p>'.$value["mensaje"].'</p>
		            </div>
		        </li>
	        ';
	    }
    }
    return $html;
}