<pre>
<?php var_dump($issue); ?>
</pre>
<?php 
	use Cake\I18n\Time;
	function prettyDate($time)
    {
    	$now = Time::now();
    	$pretty = "Hace ";
    	$yearDiff = $now->year - $time->year;
    	$monthDiff = $now->month - $time->month;
    	$dayDiff = $now->day - $time->day;
    	$hourDiff = $now->hour - $time->hour;
    	$minuteDiff = $now->minute - $time->minute;
    	if($yearDiff > 0){
    		$pretty .= strval($yearDiff);
    		if($yearDiff == 1)
    			$pretty .= " año";
    		else
    			$pretty .= " años";
    	}
    	elseif($monthDiff > 0){
    		$pretty .= strval($monthDiff);
    		if($monthDiff == 1)
    			$pretty .= " mes";
    		else
    			$pretty .= " meses";
    	}
    	elseif($dayDiff > 0){
    		$pretty .= strval($dayDiff);
    		if($dayDiff == 1)
    			$pretty .= " dia";
    		else
    			$pretty .= " dias";
    	}
    	elseif($hourDiff > 0){
    		$pretty .= strval($hourDiff);
    		if($hourDiff == 1)
    			$pretty .= " hora";
    		else
    			$pretty .= " horas";
    	}
    	elseif($minuteDiff > 0){
    		$pretty .= strval($minuteDiff);
    		if($minuteDiff == 1)
    			$pretty .= " minuto";
    		else
    			$pretty .= " minutos";
    	}
    	else{
    		$pretty = "Justo ahora";
    	}
    	return $pretty;
    }
?>	


<div class="container view-issue">
	<div class="row">
		<div class="eight columns">
			<article class="issue-body">
				<h1><?= $issue['title']; ?></h1>
				<div class="clear h30px"></div>
				<div class="row">
					<div class="status <?= $issue['is_closed']?'closed':'open'; ?> u-fl"><?= $issue['is_closed']?'Cerrado':'Abierto' ?></div>
					<div class="user u-fl"><strong><?= !$issue['is_private']?'An&oacute;nimo':$issue['user']['name'] ?></strong> <br><p></p><?= prettyDate($issue['created'])?></div> 
					<div class="clear"></div>
					<?php if($issue['parent_id'] != NULL): ?>
						<a href="#" class="edit-history">Ver historial</a>
					<?php endif; ?>
				</div>
				<p><?= $issue['body']; ?></p>
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
							<?= file_get_contents(WWW_ROOT.'./img/avatar.svg'); ?>
						</a>
						<div class="votes">
							<a href="#" class="caret caret-up">
								<?= file_get_contents(WWW_ROOT.'img/caret.svg'); ?>
							</a>
							<div class="clear"></div>
							<p>1980</p>
							<a href="#" class="caret caret-down">
								<?= file_get_contents(WWW_ROOT.'img/caret.svg'); ?>
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
					<?= file_get_contents(WWW_ROOT.'img/caret.svg'); ?>
				</a>
				<p class="vote-counter"><?= $vote_count ?></p>
				<a href="#" class="caret caret-down">
					<?= file_get_contents(WWW_ROOT.'img/caret.svg'); ?>
				</a>
			</section>
			<hr>
			<section class="tags">
				<h4>Etiquetas</h4>
				<div class="clear h20px"></div>
				<ul class="tag-list cf">
				<?php foreach ($issue['tags'] as $tag): ?>
					<li class="tag"><a href="#"><?= $tag['name']; ?></a></li>
				<?php endforeach; ?>
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
