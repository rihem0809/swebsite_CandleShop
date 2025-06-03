<?php
include 'components/connect.php';

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = '';
}

if(isset($_POST['submit'])){
        $id = unique_id();
        
        // Le nom est bien assigné, mais il faut vérifier que $_POST['name'] est correctement récupéré
        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        // Vérifier la récupération et la sanitation de l'email
        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_EMAIL); // Utilisation de FILTER_SANITIZE_EMAIL pour l'email

        // Les variables pass et cpass étaient mal assignées en utilisant des crochets, cela devrait être $_POST et non sha1[]
        $pass = $_POST['pass']; // Remplacement de sha1['pass'] par $_POST['pass']
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);

        $cpass = $_POST['cpass']; // Remplacement de sha1['cpass'] par $_POST['cpass']
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
        
        // Vérification de la gestion de l'image
        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        
        // La construction de l'extension était incorrecte, il manquait un point après PATHINFO_EXTENSION
        $ext = pathinfo($image, PATHINFO_EXTENSION); 
        $rename = unique_id() . '.' . $ext; // Renommage de l'image
        
        // Vérification de la taille de l'image et du chemin temporaire
        $image_size = $_FILES['image']['size'];
        $image_tmp_name = $_FILES['image']['tmp_name']; // Correction de $_FIES['image'] en $_FILES['image']
        
        // Définir le chemin de destination pour le dossier des images
        $image_folder = 'uploaded_files/' . $rename;

        // L'utilisation des guillemets dans le nom de table et des colonnes était incorrecte (utilisation des apostrophes autour de 'sellers')
        $select_seller = $conn->prepare("SELECT * FROM users WHERE email=?"); // Supprimé les apostrophes autour de 'sellers'
        $select_seller->execute([$email]);

        if($select_seller->rowCount() > 0){
            $warning_msg[] = 'Email already exists!';
        } else {
            // Vérification si les mots de passe ne correspondent pas
            if($pass != $cpass){
                $warning_msg[] = 'Confirm password does not match';    
            } else {
                // L'insertion dans la base de données manque de valeur pour l'image
                $insert_seller = $conn->prepare("INSERT INTO users(id, name, email, password, image) VALUES(?,?,?,?,?)");
                $insert_seller->execute([$id, $name, $email, sha1($pass), $rename]); // Application de sha1 sur le mot de passe
                
                // Déplacement du fichier téléchargé dans le répertoire cible
                move_uploaded_file($image_tmp_name, $image_folder);
                
                // Message de succès pour l'enregistrement
                $success_msg[] = 'New user registered! Please login now.';
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8"> 
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Candle Shop - User Register page</title>
   <link rel="stylesheet" type="text/css" href="css/user_style.css?v=<?php echo time(); ?>">
   <link href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'components/user_header.php'; ?>
       <div class="banner">
        <div class="detail">
            <h1>register</h1>
            <p>Join us and light up your world with handcrafted candles.</p>
            <span><a href="home.php">home</a><i class="bx bx-right-arrow-alt"></i>about us</span>
        </div>
    </div>

    <div class="form-container">
    <form action="" method="post" enctype="multipart/form-data" class="register">
        <h3>Register now</h3>
        <div class="flex">
            <div class="col">
                <div class="input-field">
                    <p>Your name <span>*</span></p> 
                    <input type="text" name="name" placeholder="Enter your name" maxlength="50" required class="box">
                </div>

                <div class="input-field">
                    <p>Your email <span>*</span></p>
                    <input type="email" name="email" placeholder="Enter your email" maxlength="50" required class="box"> <!-- Correction du name="name" à name="email" -->
                </div>
            </div>
            <div class="col">
                <div class="input-field">
                    <p>Your password <span>*</span></p>
                    <input type="password" name="pass" placeholder="Enter your password" maxlength="50" required class="box">
                </div>

                <div class="input-field">
                    <p>Confirm password <span>*</span></p>
                    <input type="password" name="cpass" placeholder="Confirm your password" maxlength="50" required class="box">
                </div>
            </div>
        </div>
        <div class="input-field">
            <p>Your profile <span>*</span></p>
            <input type="file" name="image" accept="image/*" required class="box">
        </div>
        <p class="link">already have an account? <a href="login.php">Login now</a></p>
        <input type="submit" name="submit" value="Register now" class="btn">
    </form>
  </div>

  <!-- SweetAlert CDN link -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Custom JS link -->
  <script src="js/script.js"></script>
  <?php include 'components/alert.php'; ?>
  <?php include 'components/footer.php'; ?>
</body>
</html>
