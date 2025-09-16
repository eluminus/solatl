<?php /* Wrapper Name: Header */ ?>
	<div class="hashAncor" id="homePage"></div>

<div class="stuck_wrapper">
	<div class="container">
		<div class="row">
			<div class="span6" data-motopress-type="static" data-motopress-static-file="static/static-logo.php">
				<?php get_template_part("static/static-logo"); ?>
			</div>
			<div class="span6" data-motopress-type="static" data-motopress-static-file="static/static-nav.php">
				<div class="header-widgets"><?php dynamic_sidebar("header-sidebar-1"); ?></div>
				<?php get_template_part("static/static-nav"); ?>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="hidden-phone span12" data-motopress-type="static" data-motopress-static-file="static/static-search.php">
		<?php get_template_part("static/static-search"); ?>
	</div>
</div>