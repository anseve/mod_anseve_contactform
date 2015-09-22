<?php 
/**
 * @package     ANSEVE Contact Form Module
 * @autor		Andreas Vennemann
 * @website		http://anseve.de
 * Shows default form
 */

defined ('_JEXEC') or die;

?>  
  	<form class="form-horizontal anseve_form" method="post" action="<?php echo JRoute::_('index.php'); ?>">
    	<fieldset>       	
        	<?php if ( $params->get("showlabelname") == 1 ) : ?>
              <label class="anseve_label" for="name_<?php echo $module->id; ?>"><?php echo $params->get("namelabel"); ?></label>
			<?php endif; ?>
              <input type="text" name="name" required placeholder="<?php echo $params->get ("nametext"); ?>" id="name_<?php echo $module->id; ?>" class="anseve_control"<?php echo $name; ?>>
                      
            <?php if ( $params->get("showlabelemail") == 1 ) : ?>
              <label class="anseve_label" for="email_<?php echo $module->id; ?>"><?php echo $params->get("emaillabel"); ?></label>
            <?php endif; ?>
              <input type="email" name="email" required placeholder="<?php echo $params->get ("emailtext"); ?>" id="email_<?php echo $module->id; ?>" class="anseve_control"<?php echo $email; ?>> 
                     
            <?php if ( $params->get("showlabelsubject") == 1 ) : ?>
              <label class="anseve_label" for="subject_<?php echo $module->id; ?>"><?php echo $params->get("subjectlabel"); ?></label>
            <?php endif; ?>
              <input type="text" name="subject" required placeholder="<?php echo $params->get ("subjecttext"); ?>" id="subject_<?php echo $module->id; ?>" class="anseve_control"<?php echo $subject; ?>> 
                       
              <label class="anseve_label anseve_secure" for="secure_<?php echo $module->id; ?>">Honeypot</label>
              <input type="text" name="secure" placeholder="<?php echo $params->get("honeypottext") ?>" id="secure_<?php echo $module->id; ?>" class="anseve_secure"> 
                         
            <?php if ( $params->get("showlabelmessage") == 1 ) : ?>
              <label class="anseve_label" for="message_<?php echo $module->id; ?>"><?php echo $params->get("messagelabel"); ?></label>
            <?php endif; ?>
              <textarea name="message" required placeholder="<?php echo $params->get("messagetext"); ?>" id="message_<?php echo $module->id; ?>" class="anseve_message"><?php echo $message; ?></textarea>   
                    
            <?php if ( $params->get("captcha") == 1 ) : ?>              
			  <?php if ( $params->get("showlabelcaptcha") == 1 ) : ?>
                <label class="anseve_label" for="captcha_<?php echo $module->id; ?>"><?php echo $params->get("captchalabel"); ?></label>
              <?php endif; ?>
                <div id="anseve_form_recaptcha">
                </div>
            <?php endif; ?>
            
            <?php if ( $params->get("email_copy") == 1 ) : ?>             
                <label class="anseve_label" for="copy_mail_<?php echo $module->id; ?>">
                <input type="checkbox" name="copy_mail" value="1" class="anseve_copy_mail" id="copy_mail_<?php echo $module->id; ?>">
                <span><?php echo $params->get("email_copy_label"); ?></span>
              </label>            
            <?php endif; ?> 
                        
              <button type="submit" class="button"><?php echo $params->get("buttontext"); ?></button>            
            <?php echo JHtml::_( 'form.token' ); ?>                
              <input type="hidden" name="check" value="1">
        </fieldset>    	
    </form>
 