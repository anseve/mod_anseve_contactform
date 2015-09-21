<?php 
/**
 * @package     ANSEVE Contact Form Module
 * @autor		Andreas Vennemann
 * @website		http://anseve.de
 */

defined ('_JEXEC') or die;

	$input = JFactory::getApplication()->input;
	$check = $input->getInt( "check", null );
	
	//form not send
	if ( $check == null ) {	
		//default layout	
		require JModuleHelper::getLayoutPath( "mod_anseve_contactform" );
	//form send 
	} elseif ( $check === 1 ) {
		//Check Token
		JSession::checkToken() or die( 'Invalid Token' );
		
		require_once __DIR__ . "/helper.php";  
		$status = modIcContactFormHelper::sendMail( $params );		
		require JModuleHelper::getLayoutPath( "mod_anseve_contactform" );
	}
		

?>

