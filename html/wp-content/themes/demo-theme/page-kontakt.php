<?php get_header(); ?>

<div class="content-container contact-page-container">
    <h1><?php the_title(); ?></h1>

    <div class="contact-grid">
        <div class="contact-info">
            <?php
            if (have_posts()):
                while (have_posts()):
                    the_post();
                    the_content();
                endwhile;
            endif;
            ?>
        </div>

        <div class="contact-form-wrapper">
            <h2>Napisz do nas</h2>

            <?php
            if (isset($_GET['contact_status'])) {
                if ($_GET['contact_status'] === 'success') {
                    echo '<div class="alert alert-success">Dziękujemy! Wiadomość została wysłana.</div>';
                } elseif ($_GET['contact_status'] === 'error') {
                    echo '<div class="alert alert-error">Błąd: Wypełnij wszystkie pola poprawnie!</div>';
                }
            }
            ?>

            <form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="POST"
                class="custom-contact-form">
                <input type="hidden" name="action" value="submit_contact_form">
                <?php wp_nonce_field('contact_form_submit', 'contact_nonce'); ?>

                <p>
                    <label for="contact_name">Imię i nazwisko:</label><br>
                    <input type="text" id="contact_name" name="contact_name" required>
                </p>

                <p>
                    <label for="contact_email">Adres e-mail:</label><br>
                    <input type="email" id="contact_email" name="contact_email" required>
                </p>

                <p>
                    <label for="contact_message">Wiadomość:</label><br>
                    <textarea id="contact_message" name="contact_message" rows="5" required></textarea>
                </p>

                <p>
                    <button type="submit" class="btn-primary">Wyślij wiadomość</button>
                </p>
            </form>
        </div>
    </div>
</div>

<?php get_footer(); ?>