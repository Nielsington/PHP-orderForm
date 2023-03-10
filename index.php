<?php

declare(strict_types=1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL & ~E_WARNING);

session_start();
$_SESSION['domainZipError'] = null;
$_SESSION['domainError'] = null;
$_SESSION['zipError'] = null;
$_SESSION['orders'] = null;
$_SESSION['selectionError'] = null;

function whatIsHappening() {
    // echo '<h2>$_GET</h2>';
    // var_dump($_GET);
    // echo '<h2>$_POST</h2>';
    // echo "<pre>";
    // var_dump($_POST);
    // echo "</pre>";
    // echo '<h2>$_COOKIE</h2>';
    // var_dump($_COOKIE);
    // echo '<h2>$_SESSION</h2>';
    // echo "<pre>";
    // var_dump($_SESSION);
    // echo "</pre>";
}
whatIsHappening();

$products = [
    [
    'price' => 25,
    'name' => 'Drunk Jenga',
    'description' => 
    'A variation on the classic game of Jenga, where each block has a challenge or rule written on it that must be
    followed if the block is successfully removed. Challenges might include taking a drink, telling a joke, or doing a silly dance.'
    ],
    [
    'price' => 30,
    'name' => 'What Do You Meme?',
    'description' => 
    'A card game where players compete to create the funniest meme by combining a photo card with a caption card. This game is perfect 
    for meme lovers and social media enthusiasts.'
    ],
    [
    'price' => 20,
    'name' => 'Exploding Kittens',
    'description' => 
    "A card game where players draw cards from a deck until someone draws an exploding kitten card, at which point they are out of the 
    game. The game also features various action cards that allow players to strategically alter the game's outcome."
    ],
    [
    'price' => 20,
    'name' => 'Bananagrams',
    'description' => 
    'A word game where players race to create a crossword grid using letter tiles. The game is fast-paced and portable, making it 
    perfect for parties and travel.'
    ],
    [
    'price' => 25,
    'name' => 'Codenames',
    'description' => 
    'A team-based game where players must guess the identities of secret agents based on one-word clues given by their team leader. 
    The game is easy to learn but challenging to master, and is great for groups of all sizes.'
    ],
    [
    'price' => 25,
    'name' => 'Telestrations',
    'description' => 
    'A party game where players alternate drawing and guessing what was drawn, resulting in hilarious misinterpretations and mix-ups. 
    The game is easy to play and appeals to all ages.'
    ],
    [
    'price' => 30,
    'name' => 'Cards Against Humanity',
    'description' => 
    'A card game where players fill in the blanks of outrageous statements with equally outrageous cards. The game is known for its 
    dark humor and inappropriate content, making it a hit at parties.'
    ],
    [
    'price' => 25,
    'name' => 'Apples to Apples',
    'description' => 
    'A card game where players take turns being the judge and choosing the best card from their hand to match a description card. 
    The game is easy to learn and great for groups of all sizes and ages.'
    ]
];

$_SESSION['products'] = $products;

$totalValue = 0;
function navigation(){
    $navigation = $_GET['food'];
}


function validateMail()
{
    $email = $_POST['email'];
    $allowedDomains = ['gmail', 'hotmail', 'outlook', 'skynet', 'proton', 'yahoo'];

    // TODO: This function will send a list of invalid fields back
    if(filter_var($email, FILTER_VALIDATE_EMAIL)){
    $emailSplit = explode('@', $email);
    $emailSplit2 = explode('.', $emailSplit[1]);
    $emailDomain = reset($emailSplit2);

        if(!in_array($emailDomain, $allowedDomains)){
            $wrongDomain = 'Wrong domain name';
            return $wrongDomain;
        }
        }else {
            return;
        }
    
}

function validateZip()
{
    $zipcode = $_POST['zipcode'];

    if (ctype_digit($zipcode) === false){
        $wrongZip = 'Wrong zip format';
        return $wrongZip;
    } else {
        return;
    }
}

function handleForm()
{
    $adress = [
        "street" => $_POST['street'],
        "streetnumber" => $_POST['streetnumber'],
        "city" => $_POST['city'],
        "zipcode" => $_POST['zipcode'],
        ];

    $_SESSION['adress'] = $adress;
    $invalidFields = validateMail();
    $invalidZip = validateZip();


    if (!empty($invalidFields)) {
        // handle email & zipcode error
        $_SESSION['domainError'] = 'Oops! Wrong email domain. Please use an emailadress from: <ul><li>gmail</li><li>hotmail</li> <li>outlook</li> <li>skyne</li> <li>proton</li> <li>yahoo</li></ul>';
    
        if (!empty($invalidZip)) {
            $_SESSION['zipError'] = 'Oops! The zipcode may only contain numbers...';
            $_SESSION['domainZipError'] = 'Oops! Wrong email domain. Please use an emailadress from: <ul><li>gmail</li><li>hotmail</li> <li>outlook</li> <li>skyne</li> <li>proton</li> <li>yahoo</li></ul><br>Also, the zipcode may only contain numbers...';
        }
    
    } else if (!empty($invalidZip)) {
        $_SESSION['zipError'] = 'Oops! The zipcode may only contain numbers...';
    
    } else if (!$_POST['products']) {
        $_SESSION['selectionError'] = 'Oops! Select some products before pushing submit :)';
    
    }else {
        // handle successful submission
        $_SESSION['orders'] = $_POST['products'];
    }
    
}

function totalPrice($order, $products)
{
    $allProducts = $_SESSION['orders'];
    $totalPrice = 0;
    foreach($products as $product)
        foreach($order as $index => $game){
            if($product['name'] === $index){
                $totalPrice += $product['price'];
            }
        }
    $_SESSION['totalPrice'] = $totalPrice;
    return $_SESSION['totalPrice'];
}

if (isset($_POST["games"])) {
    navigation();
}

if (isset($_POST["submit"])) {
    handleForm();
}

require './form-view.php';

?>