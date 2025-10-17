</main>


<?php require('templates_part/modal.php'); ?>

<footer class="site-footer">
	<nav class="footer-nav">
		<div class="footer-inner">
			<!-- Menu du pied de page -->
			<?php
			wp_nav_menu([
				'theme_location' => 'footer', // correspond à "Menu du pied de page" dans functions.php
				'container'      => false,    // pas de conteneur supplémentaire
				'menu_class'     => 'footer-menu',
				'fallback_cb'    => false,    // rien si aucun menu n’est assigné
			]);
			?>
		</div>
	</nav>
</footer>

<?php wp_footer(); ?>
</body>
</html>