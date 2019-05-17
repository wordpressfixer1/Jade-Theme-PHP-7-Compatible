<?php get_template_part('inc/template_header/logo') ?>

<div class="met_header_title_carousel">
    <div id="headerTitleCarousel" class="met_title_rotator clearfix" data-speed="500" data-pausetime="1000">
        <div class="met_vcenter met_title_rotator_title met_color2"><span>BREAKING |</span></div>

        <div class="met_title_rotator_el_wrap">
            <div class="met_title_rotator_el">
                <figure><a href="#" target="_blank">Title 1</a></figure>
                <figure><a href="#" target="_blank">Title 2</a></figure>
                <figure><a href="#" target="_blank">Title 3</a></figure>
                <figure><a href="#" target="_blank">Title 4</a></figure>
                <figure><a href="#" target="_blank">Title 5</a></figure>
                <figure><a href="#" target="_blank">Title 6</a></figure>
            </div>
        </div>
    </div>
    <script>jQuery(document).ready(function(){CoreJS.linkRotator('headerTitleCarousel');});</script>
</div>

<?php get_template_part('inc/template_header/menu','1') ?>
<?php get_template_part('inc/template_responsive/menu_trigger') ?>