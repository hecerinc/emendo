<?php 
	// use Cake\I18n\I18n;
	// use Cake\I18n\Time;
	use Symfony\Component\Translation\Translator;
	use Cake\Chronos\Chronos;
?>
<div class="container view-issue">
	<div class="row">
		<div class="eight columns">
			<article class="issue-body">
				<h1><?= $issue['title']; ?></h1>
				<div class="clear h30px"></div>
				<div class="row">
					<?php 
						// Parse date
						$carbon = Chronos::parse($issue['created'], 'America/Mexico_City');
						$carbon = $carbon->diffForHumans();
					?>
					<div class="status <?= $issue['is_closed']?'closed':'open'; ?> u-fl"><?= $issue['is_closed']?'Cerrado':'Abierto' ?></div>
					<div class="user u-fl">
						<strong><?= !$issue['is_private']?'An&oacute;nimo':$issue['user']['name'] ?></strong><br>
						<p><?= $carbon ?></p>
					</div> 
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
				<?php foreach ($issue["comments"] as $comment): ?>
					<div class="row comment">
						<div class="one column avatar-votes">
							<a href="#" class="avatar">
								<?= file_get_contents(WWW_ROOT.'./img/avatar.svg'); ?>
							</a>
							<div class="votes" id="comment-vote" rel="<?= "comment_id" ?>">
								<a href="#" class="caret caret-up vote-up">
									<?= file_get_contents(WWW_ROOT.'img/caret.svg'); ?>
								</a>
								<div class="clear"></div>
								<p>1980</p>
								<a href="#" class="caret caret-down vote-down">
									<?= file_get_contents(WWW_ROOT.'img/caret.svg'); ?>
								</a>
							</div>
						</div>
						<div class="eleven columns comment-body">
								<a href="#" class="user main">
									<?= $comment["user"]["name"] ?>
								</a>
								<div class="clear"></div>
								<div class="clear"></div>
								<?php 
									$carbon = Chronos::parse($comment['created'], 'America/Mexico_City');
								?>
								<a href="#" class="edit-history"><?= $carbon->diffForHumans(); ?></a>
								<?php if($comment['parent_id'] != NULL): ?>
									<a href="#" class="edit-history">Ver historial</a>
								<?php endif; ?>
								<p class="body"> 
								<?= $comment["body"]?>
								</p>
						</div>
					</div>
				<?php endforeach; ?>
				<a href="#" class="load-more">Load more...</a>
			</section>
		</div>
		<div class="three columns offset-by-one issue sidebar">
			<section class="votes" id="issue-votes" rel="<?= $issue['id'] ?>">
				<h4>Votos</h4>
				<a href="#" class="caret caret-up vote-up">
					<?= file_get_contents(WWW_ROOT.'img/caret.svg'); ?>
				</a>
				<p class="vote-counter"><?= $vote_count ?></p>
				<a href="#" class="caret caret-down vote-down">
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
					<a href="#" class="email">mbergoglio@vatican.holy</a>
				</div>
			</section>
			<hr>
		</div>
	</div>
</div>
<div class="clear h80px"></div>
<?php $this->start('bottomScripts'); ?>
<script>
	$('.vote-up, .vote-down').click(function(){
		var type = '';
		if($(this).parent().attr('id') == 'issue-votes')
			type = 'issue';
		else
			type = 'comment';
		var id = $(this).parent().attr('rel');
		updateVote(type, id, this);
	});
	function updateVote(type, id, btn){
		var vote = false;

		if($(btn).hasClass('vote-up'))
			vote = true;
		else 
			vote = false;
		var data = {
			'vote': vote
		};
		if(type == "issue")
			data['issue_id'] = id;
		else
			data['comment_id'] = id;
		data = JSON.stringify(data);
		$.post("<?= $this->Url->build(['controller'=>'Votes', 'action'=>'updatevote'])?>", data, function(response){
			console.log(response);
			var newCount = response.new_count;
			$('.vote-counter').html(newCount);
		}, 'json');
	}
</script>
<?php $this->end(); ?>
