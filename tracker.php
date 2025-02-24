<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardNumber = trim($_POST["card_number"]);

    if (empty($cardNumber)) {
        $message = "Please enter a card number.";
    } else {
        $jsonFile = 'data.json';

        if (!file_exists($jsonFile)) {
            $message = "Error: JSON file not found!";
        } else {
            $jsonData = file_get_contents($jsonFile);
            $giftCards = json_decode($jsonData, true);

            if (!is_array($giftCards)) {
                $message = "Error: Invalid JSON format.";
            } else {
                $cardFound = false;
                foreach ($giftCards as $card) {
                    if ($card["card_number"] == $cardNumber) {
                        $cardFound = true;
                        $balance = isset($card["amount"]) ? htmlspecialchars($card["amount"]) : "N/A";
                        $status = isset($card["status"]) ? htmlspecialchars($card["status"]) : "N/A";
                        $gift_cards = isset($card["gift_cards"]) ? htmlspecialchars($card["gift_cards"]) : "N/A";
               // Mask the card number (show only the last 4 digits)
               $masked_card_number = 'XXX-XXXX-XXXX-' . substr($card["card_number"], -4);
    
                        $message = "
                        
                        <table class='status-table'>
                            <tr ><th>Gift Card</th><td>" . htmlspecialchars($gift_cards ?? "N/A") . "</td></tr>
                            <tr ><th>Card Number</th><td>" . htmlspecialchars($masked_card_number ?? "N/A") . "</td></tr>
                            <tr><th>Balance</th><td>$" . htmlspecialchars($balance ?? "N/A") . "</td></tr>
                            <tr><th>Status</th><td class='status " . strtolower($status ?? "unknown") . "'>" . htmlspecialchars($status ?? "Unknown") . "</td></tr>
                        </table>
                         <script>
                            document.getElementById('verification-form').style.display = 'none';
                        </script>
                        ";
                        break;
                    }
                }

                if (!$cardFound) {
                    $message = "Card not found or invalid.";
                }
            }
        }
    }
}
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
            .status-table {
        width: 60%;
        margin: 20px auto;
        border-collapse: collapse;
        font-family: Arial, sans-serif;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .status-table th, .status-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        .status-table th {
            background: #cf4501;
            color: white;
        }

        .status.active { color: green; }
        .status.blocked { color: red; }
        .status.pending { color: orange; }
        .status.unknown { color: gray; }

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
        width: 100%;
        font-size: 12px;
        text-align: center;
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
            <a href="/index.php">Verify Gift Card</a>
        </div>
    </div>

    <div class="form-section">
        <div class="contain">
            <div class="formal">
                <form action="" id="verification-form" method="post">
                <h3>Confirm Verification Status</h3>
                <p>Enter gift card details to check verification status.</p>
              <br>
                <label for="#">Card Number</label> <br>
                <input type="text" name="card_number" placeholder=""> <br> <br>
                <button type="submit">Check Status</button>
            </form>
            <?php if (!empty($message)) { 

  
                    // Define image based on status
    $status_images = [
        "Active" => "data:image/png;base64,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",
        "Pending" => "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAAAwCAYAAABXAvmHAAAACXBIWXMAAAsTAAALEwEAmpwYAAACmklEQVR4nO1ZyW4TQRCtYhGCG9uF5SsQKJwi4apREBzZBB8C5MIFiLlGKAjxAYQgcgDElRsSkt2VBPMBAQcwHnMl8aVRDYFYkwye8Sw9FvOkJ1njlue9XqufASpUqJAaC5dhd7MGZw3BtGF8IYwfDeEPYewr9bMhbOl3huF2g2DC3oFd4BofPDhpGOuGsS2MNgkN4WdhnFmeghOFCzdTcNQQPjaEG0mF72BkQxjn3tfgcDHiCa4bwl5a4TvQX/Lgam7CG6dgrzA+yUG4DfHR20nYk634i3BACN8UIN4G04rxtb4zu54vULwMmMhkJAqaNjaCc+nEe3DDoXgbkODKSOJ1WxPGrnMDjH5jEo4kNqD7fAnE22A9ED5MJF5PxywOqQwNrMs5OB6/9xnrrkVLmIT3Y4nXImuzTnEvmgdGgbGtReNQA1pVuhYrUfTgzPDpQzDtXChHjALBrRgGcNG1UIki4fM4BlpRP7B0fp/tPHtg+70vtu+v2c58PXiWdzv5MwKMK3EMRJbK+oIw9Fne7WSL3TgGIvd/7akw+r2vubeTv2sA19MZ8Ne2v7Dbzr2dJDSQaAp9ezqTeztJOIX+vYjn60HPDV2cGbaTRIv4dyxiS8qFsT7IhODmUAMaOjkXyhFTqAan4xZzn1yLle1cjZ3maWJWAsE2xHvw31xoFJoIuBYuW5yFpGh5cEgIv5dAvD9ybtpkuObagGG4BGmgWeVYTZ0w9B7q4pJjCF9lFvJq0KpZZYHiX76bgP2QJbQ3CtqZZjOP1wehWWUekaMh7KResEm2WI37ggMmvfif2usrF+AgFA09HTUxG7F2WjWMd5sEx8A1tMjS0ElzG40+9OKhNzstRzapt7xl/U5LYq0qS/E3a4UKMP74BY3DGYjJHEbfAAAAAElFTkSuQmCC",
        "blocked" => "https://img.icons8.com/color/48/denied.png",
        "expired" => "https://img.icons8.com/color/48/cancel.png",
        "N/A" => "https://img.icons8.com/color/48/question-mark.png" // Default for unknown status
    ];

    // Use the correct image, default to "N/A" if status is not recognized
    $image_url = $status_images[$status] ?? $status_images["N/A"];
    echo "
    <div style='text-align: center; margin-top: 20px;'>
        <img width='48' height='48' src='$image_url' alt='Connection Status Off'/>
    </div>
    <div class='message' style='text-align: center;'>$message</div> <br>
    <div style='text-align: center; margin-top: 20px;'>

  <a href=''>  <button>Continue</button> </a>
    </div>

  "
  
    ;
} 
?>
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
    </script>
</body>
</html>
