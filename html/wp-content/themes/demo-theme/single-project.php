<?php get_header(); ?>

<div class="content-container">
    <?php
    if (have_posts()):
        while (have_posts()):
            the_post();
            $github_url = get_post_meta(get_the_ID(), '_project_github_url', true);
            $deadline = get_post_meta(get_the_ID(), '_project_deadline', true);

            $terms = get_the_terms(get_the_ID(), 'technology');
            ?>

            <article id="project-<?php the_ID(); ?>" <?php post_class('single-project-article'); ?>>

                <div class="project-main-column">
                    <header class="project-header">
                        <h1 class="project-title"><?php the_title(); ?></h1>

                        <?php if ($terms && !is_wp_error($terms)): ?>
                            <div class="project-technologies">
                                <span class="tech-label">Wykorzystane technologie:</span>
                                <ul class="tech-list">
                                    <?php foreach ($terms as $term): ?>
                                        <li class="tech-item"><?php echo esc_html($term->name); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </header>

                    <div class="project-content entry-content">
                        <?php the_content(); ?>
                    </div>
                </div>
                <aside class="project-sidebar-info">
                    <h2>Metadane projektu</h2>
                    <dl class="meta-details">
                        <?php if ($deadline): ?>
                            <dt>Termin wykonania:</dt>
                            <dd><?php echo esc_html($deadline); ?></dd>
                        <?php endif; ?>

                        <?php if ($github_url): ?>
                            <dt>Kod źródłowy:</dt>
                            <dd>
                                <a href="<?php echo esc_url($github_url); ?>" target="_blank" rel="noopener noreferrer"
                                    class="github-btn">
                                    Zobacz na GitHubie &rarr;
                                </a>
                            </dd>
                        <?php endif; ?>
                    </dl>
                </aside>
            </article>
            <?php
        endwhile;
    endif;
    ?>
</div>

<?php get_footer(); ?>