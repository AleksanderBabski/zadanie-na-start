<?php get_header(); ?>

<div class="content-container">
    <?php
    // To jest klasyczna Pętla (The Loop) WordPressa
    if ( have_posts() ) :
        while ( have_posts() ) : the_post(); ?>
            
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <!-- Semantyczny nagłówek H2 dla listy wpisów -->
                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                
                <div class="entry-content">
                    <?php the_excerpt(); ?>
                </div>
            </article>

        <?php endwhile;
    else : ?>
        <p>Brak treści do wyświetlenia.</p>
    <?php endif; ?>
</div>

<?php get_footer(); ?>