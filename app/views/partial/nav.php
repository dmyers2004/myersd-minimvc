<div class="navbar navbar-inverse navbar-fixed-top">
	<div class="navbar-inner">
		<div class="container">
		<a class="brand" href="#"><?=$projectname ?></a>
		<div class="nav-collapse collapse">
			<ul class="nav">
				<?php foreach ($menus as $href => $name) { ?>
					<li class="<?php echo ($name == $activemenu) ? 'active' : '' ?>"><a href="<?=$href ?>"><?=$name ?></a></li>
				<?php } ?>
			</ul>
		</div>
		</div>
	</div>
</div>
