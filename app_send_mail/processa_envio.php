<?php

	require "../app_send_mail/libs/PHPMailer/Exception.php";
	require "../app_send_mail/libs/PHPMailer/OAuth.php";
	require "../app_send_mail/libs/PHPMailer/PHPMailer.php";
	require "../app_send_mail/libs/PHPMailer/POP3.php";
	require "../app_send_mail/libs/PHPMailer/SMTP.php";

	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	class Mensagem {
		private $para= null;
		private $assunto= null;
		private $msg= null;
		public $status= array(
			'codigo_status'=>null,
			'descricao_status'=>''
		);

		public function __get($atr) {
			return $this->$atr;
		}
		public function __set($atr, $valor) {
			$this->$atr= $valor;
		}

		// Se existe dados do formulário
		public function mensagemValida() {
			if (empty($this->para) || empty($this->assunto) || empty($this->msg)){
				return false;
			}

			return true;
		}
	}

	$mensagem= new Mensagem();
	$mensagem->__set('para',$_POST['para']);
	$mensagem->__set('assunto',$_POST['assunto']);
	$mensagem->__set('msg',$_POST['msg']);


	if (!$mensagem->mensagemValida()) {
		echo "Mensagem inválida";
		header('Location: ./?erro=form');
	}


	// (!) Dados do email de envio não está configurado

	$mail = new PHPMailer(true);
	try {
	    // Server settings
	    $mail->SMTPDebug = false;                                 // Enable verbose debug output
	    $mail->isSMTP();                                      // Set mailer to use SMTP
	    $mail->Host = 'smtp1.example.com';  // Specify main and backup SMTP servers
	    $mail->SMTPAuth = true;                               // Enable SMTP authentication
	    $mail->Username = 'user@example.com';                 // SMTP username
	    $mail->Password = 'secret';                           // SMTP password
	    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
	    $mail->Port = 587;                                    // TCP port to connect to


	    //Recipients
	    $mail->setFrom('from@example.com', 'Mailer');
	    $mail->addAddress($mensagem->__get('para'));     // Add a recipient

	    // $mail->addAddress('ellen@example.com');               // Name is optional
	    // $mail->addReplyTo('info@example.com', 'Information');
	    // $mail->addCC('cc@example.com');
	    // $mail->addBCC('bcc@example.com');

	    //Attachments
	    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
	    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	    //Content
	    $mail->isHTML(true);                                  // Set email format to HTML
	    // usa utf8_decode() para corrigir erros de caracteres
	    $mail->Subject = utf8_decode($mensagem->__get('assunto'));
	    $mail->Body    = utf8_decode($mensagem->__get('msg'));
	    $mail->AltBody = utf8_decode($mensagem->__get('msg'));

	    $mail->SMTPOptions = array(
		'ssl' => array(
		    'verify_peer' => false,
		    'verify_peer_name' => false,
		    'allow_self_signed' => true
		));

	    $mail->send();

	    // se não tiver erro
	    $mensagem->status['codigo_status']= 1;
	    $mensagem->status['descricao_status']= 'E-mail enviado com successo!';

	} catch (Exception $e) {
		// se tiver erro
	    $mensagem->status['codigo_status']= 2;
	    $mensagem->status['descricao_status']= 'Não foi possivel enviar esse e-mail.'.' <br> Mailer Error: ' . $mail->ErrorInfo;
	    // echo 'Mailer Error: ' . $mail->ErrorInfo;
	}
	
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
	<title>App Mail Send</title>
</head>
<body>
	<div class="container">
		<div class="py-3 text-center">
			<img class="d-block mx-auto mb-2" src="logo.png" alt="" width="72" height="72">
			<h2>Send Mail</h2>
			<p class="lead">Seu app de envio de e-mails particular!</p>
		</div>

		<div class="row">
			<div class="col-md-12">
				<? if($mensagem->status['codigo_status'] == 1) { ?>
					<div class="container">
						<h1 class="display-4 text-success">Sucesso</h1>
						<p><?= $mensagem->status['descricao_status'] ?></p>
						<a href="./" class="btn btn-success btn-lg mt-5">
							Voltar
						</a>
					</div>
				<? } ?>
				<? if($mensagem->status['codigo_status'] == 2) { ?>
					<div class="container">
						<h1 class="display-4 text-danger">Ops</h1>
						<p><?= $mensagem->status['descricao_status'] ?></p>
						<a href="./" class="btn btn-danger btn-lg mt-5">
							Voltar
						</a>
					</div>
				<? } ?>	
			</div>
		</div>
	</div>
</body>
</html>