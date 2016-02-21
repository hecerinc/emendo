<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'CakePHP: the rapid development php framework';
?>
<!DOCTYPE html>
<html>
<head>
	<?= $this->Html->charset() ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>
		<?= $this->fetch('title') ?>
	</title>
	<?php // echo $this->Html->meta('icon'); ?>

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,300,500' rel='stylesheet' type='text/css'>

	<?= $this->Html->css(['normalize', 'skeleton', '/style.css',]); ?>

	<script src="http://code.jquery.com/jquery-1.12.0.min.js"></script>
	
	<?= $this->fetch('meta') ?>
	<?= $this->fetch('css') ?>
	<?= $this->fetch('script') ?>
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
	<?= $this->Flash->render() ?>
	<?= $this->fetch('content') ?>
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
	<?= $this->fetch('bottomScripts'); ?>
</body>
</html>
