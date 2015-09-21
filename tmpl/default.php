<?php 
/**
 * @package     ANSEVE Contact Form Module
 * @autor		Andreas Vennemann
 * @website		http://anseve.de
 */

defined ('_JEXEC') or die;
//Import plugin captcha
if($params->get("captcha") == 1) {   
  JPluginHelper::importPlugin('captcha');
  $dispatcher = JDispatcher::getInstance();
  $dispatcher->trigger('onInit','anseve_form_recaptcha');
}
//if error get value
if ( isset( $status ) && $status["check"] === false ) {
  $name = " value='" . $input->getString("name", null) . "'";	
  $email = " value='" . $input->getString("email", null) . "'";  
  $subject = " value='" . $input->getString("subject", null) . "'";	
  $message = htmlspecialchars($input->get("message",  "", "RAW"), ENT_QUOTES);
} else {
  $name = "";	
  $email = "";
  $message = "";
  $subject = "";		
}
//hide honeypot with CSS
$document = JFactory::getDocument();
$style = '.anseve_secure {'
        . 'display: none !important;'
        . '}'; 
$document->addStyleDeclaration( $style );

?>

<div class="anseve_contact_form<?php echo $params->get("moduleclass_sfx"); ?>">
 
  <?php if ( $params->get("pretext") != "" ) : ?>
    <div class="anseve_pretext"><?php echo $params->get("pretext"); ?></div>
  <?php endif; ?>
  
  <?php //Load form   
	require JModuleHelper::getLayoutPath("mod_anseve_contactform", "default_" . $params->get("layout"));   
  ?>
    
  <?php if ( $params->get("posttext") != "" ) : ?>
    <div class="anseve_posttext"><?php echo $params->get("posttext"); ?></div>
  <?php endif; ?>
</div>

<?php
  //display messages for email send / email error	
  if ( isset($status) && $status["check"] === true) {
	JFactory::getApplication()->enqueueMessage( $status["info"] );
	
  } elseif ( isset( $status ) && $status["check"] === false ) {
	JFactory::getApplication()->enqueueMessage( $status["info"], "error" );  
  }

 //Check if captcha plugin enabled
  $captcha_enabled = JPluginHelper::isEnabled("captcha");			
  if( $params->get("captcha") == 1 && $captcha_enabled === false ) {
	  JFactory::getApplication()->enqueueMessage( JText::_("JLIB_CAPTCHA_ERROR_PLUGIN_NOT_FOUND"), "error" ); 
  }
  
?> 