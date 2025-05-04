<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Duo lumière - about us page</title>
    <link rel="stylesheet" type="text/css" href="..\css\user_style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css">
</head> 
<body>
    <?php include '..\componements\user_header.php'; ?>
    <div class="banner">
        <div class="detail">
            <h1>about us</h1>
            <p> je vas ecrire ici la paragraph</p>
            <span><a href="home.php"></a><i class="bx bx-right-arrow-alt"></i>about us</span>
        </div>
    </div>
    <div class="chef">
        <div class="box-container">
            <div class="heading">
                <span>Alex Doe</span>
                <h1>Masterchef</h1>
                <img src="image\separator-img.png">
            </div>
            <p> notre chef </p>
            <div class="flex-btn">
                <a href="" class="btn">explore our menu</a>
                <a href="menu.php" class="btn">visit ou shop</a>
            </div>
            <div class="box">
                <img src="image/ceaf.png" class="">
            </div>
        </div>
    </div>

    <div class="story">
        <div class="heading">
            <h1>our story</h1>
            <img src="image\separator-img.png">
        </div>
        <p>fczvdgebhnjrk</p>
        <a href="menu.php" class="btn"> our services</a>
    </div>
    <div class="container">
        <div class="box-container">
            <div class="img-box">
                <img src="image\about.png">
            </div>
            <div class="box">
                <div class="heading">
                    <h1> Taking Ice Cream To New Heights</h1>
                    <img src="image/separator-img.png">
                </div>
                <p> dxzcfvghebjr</p>
                <a href="" class="btn"> learn more </a>

            </div>
        </div>
    </div>        

    <div class="team">
        <div class="heading">
            <span>our tem</span>
            <h1> Quality & passion with our services</h1>
            <img src="image/separator-img.png" alt="">
        </div>
        <div cass="box-container">
            <div class="box">
                <img src="image\team-1.png" alt="">
                <div class="content">
                    <img src="image/shape-19.png" alt="shap">
                    <h2>Ralph Johnson<h2>
                    <p> coffee chef</p>
                </div>
            </div>
            <div class="box">
                <img src="image\team-2.png" alt="">
                <div class="content">
                    <img src="image/shape-19.png" alt="shap">
                    <h2>Ralph Johnson<h2>
                    <p> Pastry chef</p>
                </div>
            </div>
            <div class="box">
                <img src="image\team-3.png" alt="">
                <div class="content">
                    <img src="image/shape-19.png" alt="shap">
                    <h2>Ralph Johnson<h2>
                    <p> coffee chef</p>
                </div>
            </div>
        </div>
    </div>        


    <?php iclude 'components/footer.php';?>
    <script src="../js/user_script.js"></script>

    

    
</body>
</html>