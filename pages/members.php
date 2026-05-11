<?php
/**
 * Page des membres
 */
require_once '../php/config.php';

$db = new Database();
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$search = isset($_GET['search']) ? clean_input($_GET['search']) : '';

// Construire la requête
$where = "WHERE role = 'member' AND status = 'active'";
$params = [];

if ($search) {
    $where .= " AND name LIKE ?";
    $params = ["%$search%"];
}

// Compter le total
$total = $db->count("SELECT COUNT(*) as count FROM users $where", $params);
$pagination = paginate($total, 12, $page);

// Récupérer les membres
$sql = "SELECT * FROM users $where ORDER BY name ASC LIMIT ?, ?";
$params[] = $pagination['offset'];
$params[] = $pagination['items_per_page'];
$members = $db->fetchAll($sql, $params);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membres - <?php echo SITE_NAME; ?></title>
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo ASSETS_URL; ?>/css/responsive.css">
    <style>
        .member-card {
            text-align: center;
            background: white;
            border-radius: 8px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .member-avatar {
            width: 100px;
            height: 100px;
            margin: 0 auto 1rem;
            background: linear-gradient(135deg, #3498db, #2c3e50);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            font-weight: bold;
        }

        .member-name {
            font-size: 1.2rem;
            font-weight: bold;
            color: #2c3e50;
            margin-bottom: 0.5rem;
        }

        .member-info {
            color: #7f8c8d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <nav>
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 2rem; display: flex; justify-content: space-between; align-items: center;">
            <div class="logo" style="font-size: 1.5rem; font-weight: bold; color: white;">
                <span>🏛️ AMJB</span>
            </div>
            <ul style="display: flex; list-style: none; gap: 2rem; margin: 0;">
                <li><a href="<?php echo SITE_URL; ?>/index.php" style="color: white;">Accueil</a></li>
                <li><a href="members.php" style="color: white;">Membres</a></li>
                <li><a href="events.php" style="color: white;">Événements</a></li>
                <li><a href="blog.php" style="color: white;">Blog</a></li>
                <li><a href="gallery.php" style="color: white;">Galerie</a></li>
                <li><a href="contact.php" style="color: white;">Contact</a></li>
                <?php if (is_logged_in()): ?>
                    <li><a href="profile.php" style="color: white;">Mon Profil</a></li>
                    <?php if (is_admin()): ?>
                        <li><a href="../admin/index.php" style="color: white;">Admin</a></li>
                    <?php endif; ?>
                    <li><a href="logout.php" style="color: white;">Déconnexion</a></li>
                <?php else: ?>
                    <li><a href="login.php" style="color: white;">Connexion</a></li>
                    <li><a href="register.php" style="color: white;">Inscription</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </nav>

    <section class="container" style="max-width: 1200px; padding: 3rem 2rem;">
        <h2 style="text-align: center; margin-bottom: 2rem;">👥 Nos Membres (<?php echo format_number($pagination['total_items']); ?>)</h2>

        <form method="GET" style="margin-bottom: 2rem; display: flex; gap: 1rem;">
            <input type="text" name="search" placeholder="Rechercher un membre..." value="<?php echo htmlspecialchars($search); ?>" style="flex: 1; padding: 0.8rem; border: 1px solid #bdc3c7; border-radius: 5px;">
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>

        <?php if (count($members) > 0): ?>
            <div class="grid grid-4">
                <?php foreach ($members as $member): ?>
                    <div class="member-card">
                        <div class="member-avatar">
                            <?php echo get_initials($member['name']); ?>
                        </div>
                        <div class="member-name"><?php echo htmlspecialchars($member['name']); ?></div>
                        <div class="member-info">
                            <p><?php echo htmlspecialchars($member['phone'] ?? 'N/A'); ?></p>
                            <p style="font-size: 0.8rem; margin-top: 0.5rem;">
                                Membre depuis: <?php echo format_date($member['created_at'], 'd/m/Y'); ?>
                            </p>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php if ($pagination['total_pages'] > 1): ?>
                <div class="pagination" style="margin-top: 2rem;">
                    <?php if ($pagination['current_page'] > 1): ?>
                        <a href="?page=1">« Première</a>
                        <a href="?page=<?php echo $pagination['current_page'] - 1; ?>">« Précédente</a>
                    <?php endif; ?>

                    <?php foreach (get_pagination_pages($pagination['total_pages'], $pagination['current_page']) as $p): ?>
                        <?php if ($p == $pagination['current_page']): ?>
                            <span class="active"><?php echo $p; ?></span>
                        <?php else: ?>
                            <a href="?page=<?php echo $p; ?>"><?php echo $p; ?></a>
                        <?php endif; ?>
                    <?php endforeach; ?>

                    <?php if ($pagination['current_page'] < $pagination['total_pages']): ?>
                        <a href="?page=<?php echo $pagination['current_page'] + 1; ?>">Suivante »</a>
                        <a href="?page=<?php echo $pagination['total_pages']; ?>">Dernière »</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <p style="text-align: center; color: #7f8c8d; padding: 2rem;">Aucun membre trouvé.</p>
        <?php endif; ?>
    </section>

    <footer style="background: #2c3e50; color: white; padding: 2rem; text-align: center;">
        <p>&copy; <?php echo date('Y'); ?> <?php echo SITE_NAME; ?></p>
    </footer>

    <script src="<?php echo ASSETS_URL; ?>/js/main.js"></script>
</body>
</html>
