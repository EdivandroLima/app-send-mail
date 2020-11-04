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

		<?php
			if (isset($_GET['erro']) && $_GET['erro'] == 'form' ) {
		?>
		<div class="alert alert-danger text-center mx-3">
			Preencha o formulário corretamente!
		</div>
		<?php } ?>


  		<div class="row">
  			

  			<div class="col-md-12">
				
				<div class="card-body font-weight-bold">
					<form action="processa_envio.php" method="post">
						<div class="form-group">
							<label for="para">Para</label>
							<input type="text" name="para" class="form-control" id="para" placeholder="joao@dominio.com.br">
						</div>

						<div class="form-group">
							<label for="assunto">Assunto</label>
							<input type="text" name="assunto" class="form-control" id="assunto" placeholder="Assundo do e-mail">
						</div>

						<div class="form-group">
							<label for="mensagem">Mensagem</label>
							<textarea class="form-control" id="mensagem" name="msg"></textarea>
						</div>

						<button type="submit" class="btn btn-primary btn-lg">Enviar Mensagem</button>
					</form>
				</div>
			</div>
  		</div>
  	</div>

</body>
</html>