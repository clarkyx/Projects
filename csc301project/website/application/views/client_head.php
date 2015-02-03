<header>
	<nav>
		<ul>
			<li>
				<a href="<?php echo base_url(); ?>" class="logo-link">
					Storefront Calendar
					<span class="logo-caret icon"></span>
				</a>
				<ul>
					<li><?= anchor('main/form_add_booking', 'New Event') ?></li>
					<li><?= anchor('main/form_edit_booking', 'Edit Event') ?></li>
				</ul>
			</li>
		</ul>
	</nav>

	<?= anchor('account/logout', 'Logout', 'class="logo-link" id=logout') ?>
</header>