<header>
	<ul id="top_menu">
		<?php if($this->session->userdata('user_id')): ?>
		<li><?php echo anchor('/users/edit',$this->session->userdata('nickname')) ?> <?php echo _('welcome') ?></li>
		<li><?php echo anchor('/logout',_('logout')) ?></li>
		<?php else: ?>
		<li><?php echo anchor('/users/agree',_('link_user_agree')) ?></li>
		<li><?php echo anchor('/login',_('link_login')) ?></li>
		<?php endif ?>
  </ul>
	<nav class="container">
		<h1><?php echo anchor('/',_('Home Title')) ?></h1>
		<ul class="nav nav-pills">
  <li role="presentation" class="dropdown<?php echo sl_active_class(array('intro','histories','pages'),true) ?>">
    <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">
      <?php echo _('Intro') ?> <span class="caret"></span>
    </a>
    <ul class="dropdown-menu" role="menu">  	
			<li><?php echo anchor('intro',_('Intro'),array('title'=>_('Intro')))?></li>
			<li><?php echo anchor('histories',_('Histories'),array('title'=>_('Histories')))?></li>			
    </ul>
  </li>			
			<li <?php echo sl_active_class('contacts') ?>><?php echo anchor('contacts/add', _('Contact').'<span class="visible-xs glyphicon glyphicon-chevron-right pull-right"></span>', array('title' => _('Contact')));?></li>			
			<li <?php echo sl_active_class('blogs') ?>><?php echo anchor('blogs', _('Blog').'<span class="visible-xs glyphicon glyphicon-chevron-right pull-right"></span>', array('title' => _('Blog')));?></li>			
			<li <?php echo sl_active_class('galleries') ?>><?php echo anchor('galleries', _('Gallery').'<span class="visible-xs glyphicon glyphicon-chevron-right pull-right"></span>', array('title' => _('Gallery')));?></li>			
			<li <?php echo sl_active_class('questions') ?>><?php echo anchor('questions', _('Question').'<span class="visible-xs glyphicon glyphicon-chevron-right pull-right"></span>', array('title' => _('Question')));?></li>			
			<li <?php echo sl_active_class('faqs') ?>><?php echo anchor('faqs', _('Faq').'<span class="visible-xs glyphicon glyphicon-chevron-right pull-right"></span>', array('title' => _('Faq')));?></li>
			<li <?php echo sl_active_class('notices') ?>><?php echo anchor('notices', _('Notice').'<span class="visible-xs glyphicon glyphicon-chevron-right pull-right"></span>', array('title' => _('Notice')));?></li>
			<li <?php echo sl_active_class('guest_books') ?>><?php echo anchor('guest_books', _('Guest Book').'<span class="visible-xs glyphicon glyphicon-chevron-right pull-right"></span>', array('title' => _('Guest Book')));?></li>
			<li <?php echo sl_active_class('portfolios') ?>><?php echo anchor('portfolios', _('Portfolio').'<span class="visible-xs glyphicon glyphicon-chevron-right pull-right"></span>', array('title' => _('Portfolio')));?></li>								
		</ul>
	</nav>
</header>
