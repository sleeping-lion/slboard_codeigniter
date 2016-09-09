<header>
	<div class="container">
		<div class="row">
			<h1><?php echo anchor('/',_('Home Title')) ?></h1>	
			<?php if($this->session->userdata('user_id')): ?>
			<ul id="top_menu">
				<li><?php echo anchor('/users/edit',$this->session->userdata('nickname')) ?> <?php echo _('welcome') ?></li>
				<li><?php echo anchor('/logout',_('logout')) ?></li>
			</ul>
			<?php endif ?>
			<nav>
				<ul class="nav nav-pills">
					<li <?php echo sl_active_class('intro') ?>><?php echo anchor('intro', _('Intro').'<span class="visible-xs glyphicon glyphicon-chevron-right pull-right"></span>', array('title' => _('Intro'))) ?></li>			
					<li <?php echo sl_active_class('galleries') ?>><?php echo anchor('galleries', _('Gallery').'<span class="visible-xs glyphicon glyphicon-chevron-right pull-right"></span>', array('title' => _('Gallery'))) ?></li>
					<li <?php echo sl_active_class('blogs') ?>><?php echo anchor('blogs', _('Blog').'<span class="visible-xs glyphicon glyphicon-chevron-right pull-right"></span>', array('title' => _('Blog'))) ?></li>
					<li <?php echo sl_active_class('questions') ?>><?php echo anchor('questions', _('Question').'<span class="visible-xs glyphicon glyphicon-chevron-right pull-right"></span>', array('title' => _('Question'))) ?></li>
					<li <?php echo sl_active_class('guest_books') ?>><?php echo anchor('guest_books', _('Guest_book').'<span class="visible-xs glyphicon glyphicon-chevron-right pull-right"></span>', array('title' => _('Guest Book'))) ?></li>
					<li <?php echo sl_active_class('programs') ?>><?php echo anchor('programs', _('Program').'<span class="visible-xs glyphicon glyphicon-chevron-right pull-right"></span>', array('title' => _('Program'))) ?></li>												
				</ul>
			</nav>
		</div>
	</div>
</header>
