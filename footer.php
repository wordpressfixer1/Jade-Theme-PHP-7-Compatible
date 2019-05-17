<?php global $footer_display_status; ?>

<?php if ( get_post_meta( get_the_ID(), 'dslc_code', true ) || isset( $_GET['dslc'] ) ) {} else { ?> </div><!-- .met_content --> <?php } ?>
</div><!-- .met_page_wrapper -->

<?php if($footer_display_status !== false) get_template_part('inc/template_footer/layout', met_option('footer_layout')) ?>
</div><!-- .met_wrapper -->

<?php echo met_option('tracking_code') ?>
<?php echo met_option('custom_body_codes') ?>
<?php wp_footer(); ?>
</body>
</html>