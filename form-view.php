<?php // This file is mostly containing things for your view / html ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <title>Goofy Games</title>
    <script>
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>
</head>
<body class='.bg-info'>
    <section>
        <?php if(isset($_SESSION['domainError'])){
                echo '<div class="alert alert-danger">'.$_SESSION["domainError"].'</div>';
            }else if(isset($_SESSION['orders'])){
                echo '<div class="alert alert-success">Order saved!</div>';
            }
        ?>
        <?php 
            if(isset($_POST['submit'])){
                echo '<h3> Thanks for your order! </h3><br>';
                echo '<h5> Your order: </h5';
            };
        ?>
        <ul>
            <?php
            if(isset($_SESSION['orders'])){
                foreach($_SESSION["orders"] as $index => $order){
                    echo '<li>'.$index.'</li>' ;
                };
                echo '<br><br>';
            };
            ?>
        </ul>
        <?php
            if(isset($_SESSION['adress'])){
                echo '<h5> Delivery address: </h5><br>';
                echo $_SESSION['adress']['street'].' '.$_SESSION['adress']['streetnumber'].'<br>';
                echo $_SESSION['adress']['zipcode'].' '.$_SESSION['adress']['city'];
            }
        ?>
</section>

<div class="container">
    <h1>Place your order</h1>
    <?php // Navigation for when you need it ?>
    <?php /*
    <nav>
        <ul class="nav">
            <li class="nav-item">
                <a class="nav-link active" href="?food=1">Order food</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="?food=0">Order drinks</a>
            </li>
        </ul>
    </nav>
    */ ?>

    <form method="post" action="index.php">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" class="form-control" required>
            </div>
            <div></div>
        </div>

        <fieldset>
            <legend>Address</legend>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="street">Street:</label>
                    <input type="text" name="street" id="street" class="form-control" value="<?php if(isset($_SESSION['adress'])){echo $_SESSION['adress']['street'];} ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="streetnumber">Street number:</label>
                    <input type="text" id="streetnumber" name="streetnumber" class="form-control" value="<?php if(isset($_SESSION['adress'])){echo $_SESSION['adress']['streetnumber'];} ?>" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="city">City:</label>
                    <input type="text" id="city" name="city" class="form-control" value="<?php if(isset($_SESSION['adress'])){echo $_SESSION['adress']['city'];} ?>" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="zipcode">Zipcode</label>
                    <input type="text" id="zipcode" name="zipcode" class="form-control" value="<?php if(isset($_SESSION['adress'])){echo $_SESSION['adress']['zipcode'];} ?>" required>
                </div>
            </div>
        </fieldset>

        <fieldset>
            <legend>Products</legend>
            <?php foreach ($products as $i => $product): ?>
                <label>
					<?php // <?= is equal to <?php echo ?>
                    <span class="d-inline-block small text-primary font-weight-bold" tabindex="0" data-toggle="tooltip" title="<?= $product['description'] ?>" >?</span>
                    <input type="checkbox" value="1" name="products[<?php echo $product['name']; ?>]"/> <?php echo $product['name'] ?> -
                    &euro; <?= number_format($product['price'], 2) ?>
                </label><br />
            <?php endforeach; ?>
        </fieldset>

        <button type="submit" name="submit" value="submit" id="submit" class="btn btn-primary">Order!</button>
    </form>

    <footer>You already ordered <strong>&euro; <?php echo totalPrice($_SESSION['orders'], $products) ?></strong> in food and drinks.</footer>
</div>

<style>
    footer {
        text-align: center;
    }
</style>
</body>
</html>