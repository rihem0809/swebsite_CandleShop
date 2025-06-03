<?php
include '../components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if(isset($_POST['submit'])){

        // Récupération et nettoyage de l'email
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        // Récupération et nettoyage du mot de passe
        $pass = sha1($_POST['pass']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        // Vérification des identifiants dans la base de données
        $select_user = $conn->prepare("SELECT * FROM users WHERE email = ? AND password = ?"); 
        $select_user->execute([$email, $pass]);
        $row = $select_user->fetch(PDO::FETCH_ASSOC);

        if($select_user->rowCount() > 0){
            setcookie('user_id', $row['id'], time() + 60*60*24*30, "/");
            header('Location: home.php'); 
            exit;
        } else {
            $warning_msg[] = 'Email ou mot de passe incorrect';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> 
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Candle Shop - User Login page</title>
   <link rel="stylesheet" type="text/css" href="../css/user_style.css?v=<?php echo time(); ?>">
   <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <?php include '../components/user_header.php'; ?>
       <div class="banner">
        <div class="detail">
            <h1>register</h1>
            <p>Join us and light up your world with handcrafted candles.</p>
            <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>login</span>
        </div>
    </div>

    <div class="form-container">
    <form action="" method="post" enctype="multipart/form-data" class="login"   autocomplete="new-password">
        <h3>Login Now</h3>

        <div class="input-field">
            <p>Your email <span>*</span></p>
            <input type="email" name="email" placeholder="Entrez votre email" maxlength="50" required class="box"  autocomplete="new-password">
        </div>

        <div class="input-field">
            <p>Your password <span>*</span></p>
            <input type="password" name="pass" placeholder="Entrez votre mot de passe" maxlength="50" required class="box"  autocomplete="new-password">
        </div>

        <p class="link">Vous n'avez pas de compte ? <a href="register.php">Inscrivez-vous</a></p>
        <input type="submit" name="submit" value="Se connecter" class="btn">
    </form>
  </div>

  <!-- SweetAlert CDN link -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Custom JS link -->
  <script src="../js/script.js"></script>
  <?php include '../components/alert.php'; ?>
  <?php include '../components/footer.php'; ?>
</body>
</html>
