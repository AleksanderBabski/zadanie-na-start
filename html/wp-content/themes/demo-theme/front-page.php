<?php get_header(); ?>

<div class="content-container">
    <section class="hero-section">
        <h1>Zadanie na start - Demo motyw</h1>
    </section>

    <section class="projects-archive">
        <h2>Najnowsze Projekty</h2>

        <div class="projects-grid">
            <?php
            // ZAPYTANIE WP_QUERY
            $args = array(
                'post_type' => 'project',
                'posts_per_page' => 6,
                'orderby' => 'date',
                'order' => 'DESC',
            );

            $projects_query = new WP_Query($args);

            if ($projects_query->have_posts()):
                while ($projects_query->have_posts()):
                    $projects_query->the_post();

                    // Pobieranie Custom Fields
                    $github_url = get_post_meta(get_the_ID(), '_project_github_url', true);
                    $deadline = get_post_meta(get_the_ID(), '_project_deadline', true); // true - zwraca pojedynczą wartość
            
                    // Pobieranie Custom Taxonomy (Technologie)
                    $terms = get_the_terms(get_the_ID(), 'technology');
                    ?>

                    <article id="post-<?php the_ID(); ?>" <?php post_class('project-card'); ?>>
                        <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

                        <?php if ($terms && !is_wp_error($terms)): ?>
                            <div class="project-tags">
                                <strong>Technologie:</strong>
                                <?php foreach ($terms as $term): ?>
                                    <span class="tag"><?php echo esc_html($term->name); ?></span>
                                    <?php //esc_html - funkcja zabezpieczająca przed wstrzykiwaniem kodu XSS (Cross-Site Scripting),
                                                    ?>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <div class="project-meta">
                            <?php if ($deadline): ?>
                                <p><strong>Termin wykonania:</strong> <?php echo esc_html($deadline); ?></p>
                            <?php endif; ?>

                            <?php if ($github_url): ?>
                                <p><a href="<?php echo esc_url($github_url); ?>" target="_blank" rel="noopener">Zobacz
                                        Repozytorium GitHub &rarr;</a></p>
                            <?php endif; ?>
                        </div>

                        <div class="project-excerpt">
                            <?php // the_excerpt() - wyświetla skrót opisu wpisu
                                    the_excerpt(); ?>
                        </div>
                    </article>

                <?php endwhile;
                wp_reset_postdata(); // Przywrócenie oryginalnego zapytania głównego
            else: ?>
                <p>Brak projektów do wyświetlenia. Dodaj pierwsze wpisy w panelu /wp-admin!</p>
            <?php endif; ?>
        </div>
    </section>
</div>

<?php get_footer(); ?>