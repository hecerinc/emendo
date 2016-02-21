<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Basic Page Needs
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	<meta charset="utf-8">
	<title>Issue #3</title>
	<meta name="description" content="">
	<meta name="author" content="">

	<!-- Mobile Specific Metas
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- FONT
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500' rel='stylesheet' type='text/css'>

	<!-- CSS
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->
	<link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/skeleton.css">
	<link rel="stylesheet" href="style.css">

	<!-- Favicon
	–––––––––––––––––––––––––––––––––––––––––––––––––– -->

</head>
<body>
	<div class="container headC">
		<header class="header">
			<a href="#" class="logo">Logo</a>
			<nav class="main-nav u-fr">
				<ul class="inline cf">
					<li><a href="#">Inicio</a></li>
					<li><a href="#">Issues</a></li>
					<li><a href="#">Contacto</a></li>
				</ul>
			</nav>
		</header>
		<div class="clear h80px"></div>
	</div>
	<div class="container view-issue">
		<div class="row">
			<div class="eight columns">
				<article class="issue-body">
					<h1>Can't upload to Github via a very large method</h1>
					<div class="clear h30px"></div>
					<div class="row">
						<div class="status open u-fl">Abierto</div>
						<div class="user u-fl"><strong>Eclippsers</strong> <br> <p>Hace 2 horas</p></div>
						<div class="clear"></div>
						<a href="#" class="edit-history">Ver historial</a>
					</div>
					<p>Vitae dolorum, quasi doloribus neque possimus vero sit quaerat consectetur eaque. Alias assumenda nemo animi quasi doloribus porro, voluptatem! Ut, expedita maxime dolorum quia tempora cumque vitae laudantium placeat quasi. Adipisci vero perspiciatis modi cumque officia asperiores, nisi cupiditate ipsam eos totam sunt dicta possimus sed, veniam nihil in dolore. <br> <br> Nemo quas facere dolorum, distinctio, cumque mollitia exercitationem obcaecati, sequi modi alias ex dolorem optio quos. Minus, explicabo expedita sed libero facere excepturi soluta, amet a fuga dignissimos. Porro quod voluptatibus ut architecto et aliquam laboriosam, natus nam officia repudiandae, a ab nesciunt, quisquam possimus.</p>
				</article>
				<hr>
				<section class="comments">
					<h3 class="text">Comentarios</h3>
					<div class="clear"></div>
					<div class="u-fr filter">
						<p>Ordenar por: &nbsp; <a href="#" class="timeline strong text">Tiempo</a>&nbsp; <a href="#" class="votes">Votos</a></p>
					</div>
					<div class="clear h20px"></div>
					<?php for($i = 0; $i < 3; $i++): ?>
					<div class="row comment">
						<div class="one column avatar-votes">
							<a href="#" class="avatar">
								<?= file_get_contents('./img/avatar.svg'); ?>
							</a>
							<div class="votes">
								<a href="#" class="caret caret-up">
									<?= file_get_contents('img/caret.svg'); ?>
								</a>
								<div class="clear"></div>
								<p>1980</p>
								<a href="#" class="caret caret-down">
									<?= file_get_contents('img/caret.svg'); ?>
								</a>
							</div>
						</div>
						<div class="eleven columns comment-body">
							<a href="#" class="user main">EliasMera</a>
							<div class="clear"></div>
							<a href="#" class="edit-history">Ver historial</a>
							<p class="body">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad ipsam nam maxime architecto modi eligendi vitae minima quia, ut consequuntur, delectus, officia porro corporis fugit natus, numquam molestiae optio in rerum tenetur? Numquam fugiat, laudantium totam recusandae magnam eligendi natus corporis alias, dolor saepe quos quaerat impedit dolorum, ex voluptas quae. </p>
						</div>
					</div>
					<?php endfor; ?>
					<a href="#" class="load-more">Load more...</a>
				</section>
			</div>
			<div class="three columns offset-by-one issue sidebar">
				<section class="votes">
					<h4>Votos</h4>
					<a href="#" class="caret caret-up">
						<?= file_get_contents('img/caret.svg'); ?>
					</a>
					<p class="vote-counter">250</p>
					<a href="#" class="caret caret-down">
						<?= file_get_contents('img/caret.svg'); ?>
					</a>
				</section>
				<hr>
				<section class="tags">
					<h4>Etiquetas</h4>
					<div class="clear h20px"></div>
					<ul class="tag-list cf">
					<?php for ($i=0; $i < 2; $i++):?>
						<li class="tag"><a href="#">lorem</a></li>
						<li class="tag"><a href="#">ipsum</a></li>
						<li class="tag"><a href="#">dolor</a></li>
						<li class="tag"><a href="#">really long tag along play</a></li>
					<?php endfor; ?>
					</ul>
				</section>
				<hr>
				<section class="responsible">
					<h4>Responsable</h4>
					<div class="clear h20px"></div>
					<div class="datos">
						<p class="name"><strong>Mario Bergoglio</strong></p>
						<p class="desc">Representante de la CCNA en Monterrey</p>
						<a href="#" class="email">mbergoglio@vaticon.holy</a>
					</div>
				</section>
				<hr>
			</div>
		</div>
	</div>
	<div class="clear h80px"></div>
	<footer class="footer">
		<div class="container">
			<div class="u-fl">
				<a href="#"><strong>Lorem ipsum</strong></a>
				<nav class="footer-nav">
					<ul class="cf">
						<li><a href="#">Contact</a></li>
						<li><a href="#">About us</a></li>
						<li><a href="#">Issues</a></li>
					</ul>
				</nav>
			</div>
			<div class="u-fr">
				<a href="#" class="logo-small">Logo</a>
			</div>
		</div>
	</footer>
	<div class="clear h40px"></div>
</body>
</html>
