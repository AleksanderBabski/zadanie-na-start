<?php get_header(); ?>

<div class="content-container error-404-container">
    <section class="error-404">
        <header class="page-header">
            <h1 class="page-title">404</h1>
            <h2>Strona nie została znaleziona</h2>
        </header>

        <div class="page-content">
            <p>Przepraszamy, ale strona, której szukasz, nie istnieje lub została przeniesiona pod inny adres.</p>

            <!-- Prosta wyszukiwarka natywna WordPressa -->
            <div class="search-form-wrapper">
                <?php get_search_form(); ?>
            </div>

            <p>
                <a href="<?php echo esc_url(home_url('/')); ?>" class="btn-primary">&larr; Wróć na stronę główną</a>
            </p>
        </div>
    </section>
</div>

<?php get_footer(); ?>