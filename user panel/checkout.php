<?php
include '../components/connect.php';

if (!isset($_COOKIE['user_id'])) {
    header('location: login.php');
    exit;
}
$user_id = $_COOKIE['user_id'];

if (!isset($_GET['get_id']) || empty($_GET['get_id'])) {
    header('location: shop.php'); // ou ta page boutique
    exit;
}

$product_id = $_GET['get_id'];

// Récupérer les infos produit
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ? AND status = ?");
$stmt->execute([$product_id, 'active']);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "Produit introuvable ou non disponible.";
    exit;
}

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['place_order'])) {
    // Récupérer les champs
    $name = trim($_POST['name']);
    $number = trim($_POST['number']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $address_type = trim($_POST['address_type']);
    $method = trim($_POST['method']);
    $qty = intval($_POST['qty']);

    // Validation simple
    if (empty($name)) $errors[] = "Le nom est requis";
    if (empty($number)) $errors[] = "Le numéro est requis";
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
    if (empty($address)) $errors[] = "L'adresse est requise";
    if ($qty < 1 || $qty > $product['stock']) $errors[] = "Quantité invalide";

    if (empty($errors)) {
        // Calculer le prix total
        $price = $product['price'] * $qty;

        // Ici tu peux mettre seller_id si tu en as, sinon 0 ou NULL
        $seller_id = 0;

        $status = 'pending';
        $payment_status = 'pending';
        $date = date('Y-m-d H:i:s');

        // Insérer dans la table orders
        $insert = $conn->prepare("INSERT INTO orders (user_id, seller_id, name, number, email, address, address_type, method, product_id, price, qty, date, status, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $insert->execute([
            $user_id, $seller_id, $name, $number, $email, $address, $address_type,
            $method, $product_id, $price, $qty, $date, $status, $payment_status
        ]);

        // Mettre à jour le stock produit
        $new_stock = $product['stock'] - $qty;
        $update_stock = $conn->prepare("UPDATE products SET stock = ? WHERE id = ?");
        $update_stock->execute([$new_stock, $product_id]);

        $success = "Commande passée avec succès !";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Checkout - Candle Shop</title>
<link rel="stylesheet" href="../css/user_style.css?v=<?php echo time(); ?>" />
<link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet" />
</head>
<body>
<?php include '../components/user_header.php'; ?>

<div class="checkout-container">
    <h1>Checkout</h1>

    <?php if ($success): ?>
        <p class="success"><?= $success; ?></p>
        <a href="orders.php" class="btn">Voir mes commandes</a>
    <?php else: ?>
        <?php if ($errors): ?>
            <div class="errors">
                <ul>
                    <?php foreach ($errors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <div class="product-summary">
            <h2><?= htmlspecialchars($product['name']) ?></h2>
            <img src="uploaded_files/<?= htmlspecialchars($product['image']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" />
            <p>Prix unitaire: $<?= number_format($product['price'], 2) ?></p>
            <p>Stock disponible: <?= $product['stock'] ?></p>
        </div>

        <form action="" method="POST" class="billing-form">
            <label>Nom complet:</label>
            <input type="text" name="name" required value="<?= $_POST['name'] ?? '' ?>" />

            <label>Numéro de téléphone:</label>
            <input type="text" name="number" required value="<?= $_POST['number'] ?? '' ?>" />

            <label>Email:</label>
            <input type="email" name="email" required value="<?= $_POST['email'] ?? '' ?>" />

            <label>Adresse:</label>
            <textarea name="address" required><?= $_POST['address'] ?? '' ?></textarea>

            <label>Type d'adresse:</label>
            <select name="address_type" required>
                <option value="">-- Sélectionnez --</option>
                <option value="Maison" <?= (($_POST['address_type'] ?? '') == 'Maison') ? 'selected' : '' ?>>Maison</option>
                <option value="Bureau" <?= (($_POST['address_type'] ?? '') == 'Bureau') ? 'selected' : '' ?>>Bureau</option>
            </select>

            <label>Méthode de paiement:</label>
            <select name="method" required>
                <option value="">-- Sélectionnez --</option>
                <option value="Carte bancaire" <?= (($_POST['method'] ?? '') == 'Carte bancaire') ? 'selected' : '' ?>>Carte bancaire</option>
                <option value="PayPal" <?= (($_POST['method'] ?? '') == 'PayPal') ? 'selected' : '' ?>>PayPal</option>
                <option value="À la livraison" <?= (($_POST['method'] ?? '') == 'À la livraison') ? 'selected' : '' ?>>À la livraison</option>
            </select>

            <label>Quantité:</label>
            <input type="number" name="qty" required min="1" max="<?= $product['stock'] ?>" value="<?= $_POST['qty'] ?? 1 ?>" />

            <button type="submit" name="place_order" class="btn">Passer la commande</button>
        </form>
    <?php endif; ?>
</div>

<?php include '../components/footer.php'; ?>
</body>
</html>
