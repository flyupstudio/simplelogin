<?
	require_once('mail/class.phpmailer.php');
	class Mailer
	{
		var $Recepients			= array();
		var $Type				= 'text/html';
		var $Charset			= 'UTF-8';
		var $MessageContent		= '';
		var $TemplateVars		= array();
		var $Files				= array();
		var $RootUrl			= '';

		function AddRecepient($email)
		{
			array_push($this->Recepients, $email);
		}
		
		function DelRecepient()
		{
			unset($this->Recepients);
			$this->Recepients = array();
		}
		
		function AddVars($vars)
		{
			$this->TemplateVars = $vars;
		}
		
		function AddFile($file)
		{
			$this->Files[] = $file;
		}
		
		function DelVars()
		{
			unset($this->TemplateVars);
			$this->TemplateVars	= array();
		}
		
		function Send($template, $subject= '', $sender_email = '', $sender_name = '')
		{
			global $config;
			$this->RootUrl = $config['site_url'];
			$this->_load_template($template);
			
			
			$mail				= new PHPMailer();			// defaults to using php "mail()"
			
			$mail->IsSMTP();								// telling the class to use SMTP
  			// $mail->Host		= "mx1.mirohost.net";		// SMTP server
  			$mail->Host			= $config['smtp']['host'];			// SMTP server
  			$mail->Port			= $config['smtp']['port'];
  			// $mail->Port		= 587;
  			$mail->SMTPAuth		= true;						// enable SMTP authentication
  			$mail->Username		= $config['smtp']['username'];	// SMTP account username
  			$mail->Password		= $config['smtp']['password'];				// SMTP account password
  			
			$mail->CharSet = $this->Charset;
			
			$mail->SetFrom($sender_email, $sender_name);
			$mail->AddReplyTo($sender_email, $sender_name);
			
			if(get_magic_quotes_gpc()){
				$mail->Subject = stripslashes($subject);
			}else{
				$mail->Subject = $subject;
			}
			
			$mail->MsgHTML($this->MessageContent);
			
			for($i = 0, $count = sizeof($this->Files); $i < $count; $i++)			
			{
				$mail->AddAttachment($this->Files[$i]['path'],$this->Files[$i]['name']);      // attachment
			}
			error_log(serialize($Files),3,$config['absolute-path'].'log.txt');
			$recepients_sz = count($this->Recepients);
		
			for($i = 0; $i < $recepients_sz; $i++)			
			{
				$mail->AddAddress($this->Recepients[$i], "");
				$mail->Send();

			
			
				$mail->ClearAddresses();
			}
			 
			
			
			
		}
		
		function _load_template($template)
		{
			foreach($this->TemplateVars as $key => $val)
			{
				$code = 'global $'.$key.'; $'.$key.' = "'.htmlspecialchars  ($val,ENT_QUOTES ).'";';
				
				eval($code);
			}
			
			ob_start();
			include PATH_MAIL_TEMPLATES.$template;
			$this->MessageContent = ob_get_contents();
			ob_end_clean();
		}
	}
?>