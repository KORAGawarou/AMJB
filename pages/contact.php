<?php
/**
 * Page Contact
 */
require_once '../php/config.php';

$db_instance = new Database();
$message_sent = false;
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = clean_input($_POST['name'] ?? '');
    $email = clean_input($_POST['email'] ?? '');
    $phone = clean_input($_POST['phone'] ?? '');
    $subject = clean_input($_POST['subject'] ?? '');
    $message_content = clean_input($_POST['message'] ?? '');

    if (empty($name) || empty($email) || empty($subject) || empty($message_content)) {
        $error = 'Tous les champs obligatoires doivent être remplis';
    } else {
        $query = "INSERT INTO contact_messages (name, email, phone, subject, message, created_at) 
                  VALUES (?, ?, ?, ?, ?, NOW())";
        $result = $db_instance->insert($query, [$name, $email, $phone, $subject, $message_content]);

        if ($result) {
            $message_sent = true;
            // Envoyer un email de notification
            $admin_email = SITE_EMAIL;
            $notification_subject = 'Nouveau message de contact - ' . SITE_NAME;
            $notification_message = "
                <h3>Nouveau message de contact</h3>
                <p><strong>Nom:</strong> $name</p>
                <p><strong>Email:</strong> $email</p>
                <p><strong>Téléphone:</strong> $phone</p>
                <p><strong>Sujet:</strong> $subject</p>
                <p><strong>Message:</strong></p>
                <p>$message_content</p>
            ";
            send_email($admin_email, $notification_subject, $notification_message);
        } else {
            $error = 'Erreur lors de l\'envoi du message';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/responsive.css">
</head>
<body>
    <nav>
        <div class="navbar-content">
            <div class="logo">
                <span>🏛️</span>
                <span>AMJB</span>
            </div>
            <ul class="navbar-menu">
                <li><a href="<?php echo SITE_URL; ?>/index.php">Accueil</a></li>
                <li><a href="members.php">Membres</a></li>
                <li><a href="events.php">Événements</a></li>
                <li><a href="blog.php">Blog</a></li>
                <li><a href="gallery.php">Galerie</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (is_logged_in()): ?>
                    <li><a href="profile.php">Mon Profil</a></li>
                    <?php if (is_admin()): ?>
                        <li><a href="../admin/index.php">Admin</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="login.php">Connexion</a></li>
                    <li><a href="register.php">Inscription</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <main>
        <section class="container" style="max-width: 800px;">
            <h2>Nous Contacter</h2>

            <div class="grid-2" style="margin-bottom: 2rem;">
                <div class="card" style="padding: 1.5rem;">
                    <h3 style="color: #3498db; margin-bottom: 1rem;">📍 Adresse</h3>
                    <p><?php echo SITE_URL; ?></p>
                </div>
                <div class="card" style="padding: 1.5rem;">
                    <h3 style="color: #27ae60; margin-bottom: 1rem;">📞 Téléphone</h3>
                    <p><?php echo SITE_PHONE; ?></p>
                </div>
                <div class="card" style="padding: 1.5rem;">
                    <h3 style="color: #e74c3c; margin-bottom: 1rem;">📧 Email</h3>
                    <p><?php echo SITE_EMAIL; ?></p>
                </div>
                <div class="card" style="padding: 1.5rem;">
                    <h3 style="color: #f39c12; margin-bottom: 1rem;">⏰ Horaires</h3>
                    <p>Lun-Ven: 8h-17h<br>Samedi: 9h-13h</p>
                </div>
            </div>

            <div class="card" style="padding: 2rem;">
                <?php if ($message_sent): ?>
                    <div class="alert alert-success text-center mb-4">
                        ✓ Merci! Votre message a été envoyé avec succès. Nous vous répondrons bientôt.
                    </div>
                <?php elseif ($error): ?>
                    <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>

                <form method="POST" id="contactForm">
                    <div class="form-group">
                        <label for="name">Nom *</label>
                        <input type="text" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" id="phone" name="phone">
                    </div>

                    <div class="form-group">
                        <label for="subject">Sujet *</label>
                        <input type="text" id="subject" name="subject" required>
                    </div>

                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%;">
                        Envoyer
                    </button>
                </form>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?></p>
    </footer>

    <script src="<?php echo ASSETS_URL; ?>/js/main.js"></script>
</body>
</html>
