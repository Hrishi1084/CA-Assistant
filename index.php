<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Home</title>
  <?php 
  $servername = "localhost";
  $username = "root";
  $password = "";
  $db = "ca_assistant";

  $conn = new mysqli($servername, $username, $password, $db);

  $categories_table = "CREATE TABLE IF NOT EXISTS Categories (
  sector VARCHAR(50) PRIMARY KEY
  )";

  $goals_table = " CREATE TABLE IF NOT EXISTS Goals(
  goalname VARCHAR(30) NOT NULL,
  goalamt INT(10) NOT NULL,
  goalsaving INT(10) NOT NULL
  )";

  $planned_payment_table = "CREATE TABLE IF NOT EXISTS PlannedPayment(
  objname VARCHAR(30) NOT NULL PRIMARY KEY,
  objprice INT(10) NOT NULL,
  objemi INT(10) NOT NULL,
  objduration INT(5) NOT NULL
  )";

  $conn->query($categories_table);
  $conn->query($goals_table);
  $conn->query($planned_payment_table);
  ?>
</head>

<body style="margin: 0%;">

  <div style="background-color: #E02130; display: flex;">
      <div style=" flex: 1; width: fit-content;  margin-left: 160px; padding-top:100px; ">
        <small
          style="text-align: left; font-family: 'Raleway', sans-serif; font-size: 3.2vw; color: #FFF; font-weight: 10; ">EFFICIENT WAY TO</small>
        <h1 style="text-align: left; font-family: 'Raleway', sans-serif; font-size: 3.2vw; color: #FFF; margin-top: 1px; font-weight: 900;">
            MANAGE YOUR BUDGET</h1>


        <p style="color: #FFABAB;">It is a simple yet effective method for managing all of your transactions.</p>

        <h3 style="font-weight: 100; font-size: 25px; color: #FFF; display: block; border-style: solid; width: fit-content; padding: 10px; border-width: thin; margin-top: 100px; cursor: pointer;">Know more</h3>

      </div>
      <div style="width: fit-content; margin: 50px;  margin-right: 200px;">
        <img src="./images/img.png">
      </div>
  </div>

   <div style="text-align: center; font-size: 38px; color: #222222; font-family: 'Raleway', sans-serif; margin-top: 50px; font-weight: 10;">SERVICES</div>
  
<div style=" justify-content: center; align-items: center; margin: auto;" >
      <div style="display: flex; justify-content: center; align-items: center; margin: auto;">

      <div style="text-align: center; margin: 50px;">
        <div style="display: inline-block; text-align: center;">
          <img style="cursor: pointer;" src="./images/ic_new_payment.png" width="100" height="100" onclick="openPage('make_payment.html')">
          <div style="font-size: 18px; color: #111111; font-family: 'Raleway', sans-serif; margin-top: 10px; font-weight: 600;">Make New Payment</div>
          <div style="font-size: 16px; color: #888888; font-family: 'Open Sans', sans-serif; margin-top: 10px;">Send money to your contacts and businesses<br/>with ease and security.</div>
        </div>
      </div>

      <div style="text-align: center; margin: 50px;">
        <div style="display: inline-block; text-align: center;">
          <img  style="cursor: pointer;" src="./images/ic_categories.png" width="100" height="100" onclick="openPage('categories.php')">
          <div style="font-size: 18px; color: #111111; font-family: 'Raleway', sans-serif; margin-top: 10px; font-weight: 600;">Categories</div>
          <div style="font-size: 16px; color: #888888; font-family: 'Open Sans', sans-serif; margin-top: 10px;">Manage your expense categories.</div>
        </div>
      </div>

      <div style="text-align: center; margin: 50px;">
        <div style="display: inline-block; text-align: center;">
          <img  style="cursor: pointer;" src="./images/ic_analytic.png" width="100" height="100" onclick="openPage('analysis.html')">
          <div style="font-size: 18px; color: #111111; font-family: 'Raleway', sans-serif; margin-top: 10px; font-weight: 600;">Analysis</div>
          <div style="font-size: 16px; color: #888888; font-family: 'Open Sans', sans-serif; margin-top: 10px;">Analysis of your monthly budget</div>
        </div>
      </div>
    </div>
    

    <div style="display: flex; justify-content: center; align-items: center; margin: auto;">

      <div style="text-align: center; margin: 50px;">
        <div style="display: inline-block; text-align: center;">
          <img   style="cursor: pointer;" src="./images/ic_transaction.png" width="100" height="100" onclick="openPage('payment_history.html')">
          <div style="font-size: 18px; color: #111111; font-family: 'Raleway', sans-serif; margin-top: 10px; font-weight: 600;">Transactions</div>
          <div style="font-size: 16px; color: #888888; font-family: 'Open Sans', sans-serif; margin-top: 10px;">see your payment history</div>
        </div>
      </div>

      <div style="text-align: center; margin: 50px;">
        <div style="display: inline-block; text-align: center;">
          <img   style="cursor: pointer;" src="./images/ic_goals.png" width="100" height="100" onclick="openPage('goals.php')">
          <div style="font-size: 18px; color: #111111; font-family: 'Raleway', sans-serif; margin-top: 10px; font-weight: 600;">Goals</div>
          <div style="font-size: 16px; color: #888888; font-family: 'Open Sans', sans-serif; margin-top: 10px;">Creat new goals and save money</div>
        </div>
      </div>

      <div style="text-align: center; margin: 50px;">
        <div style="display: inline-block; text-align: center;">
          <img   style="cursor: pointer;" src="./images/ic_planed_payment.png" width="100" height="100" onclick="openPage('planned_payment.php')">
          <div style="font-size: 18px; color: #111111; font-family: 'Raleway', sans-serif; margin-top: 10px; font-weight: 600;">Planned Payment</div>
          <div style="font-size: 16px; color: #888888; font-family: 'Open Sans', sans-serif; margin-top: 10px;">Manage your emi with </div>
        </div>
      </div>
    </div>
  </div>

  <div>

    <div style="background-color: #000; width: 100%; padding: 50px 0;">
      <form style="max-width: 500px; margin: 0 auto; font-family: Arial, sans-serif;">
        <h1 style="text-align: center; margin-bottom: 20px; color: #fff;">Feedback Form</h1>
        <label for="name" style="display: block; font-size: 16px; font-weight: bold; margin-bottom: 5px; color: #fff;">Name:</label>
        <input type="text" id="name" name="name" required style="padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; width: 100%; margin-bottom: 20px;">
        <label for="email" style="display: block; font-size: 16px; font-weight: bold; margin-bottom: 5px; color: #fff;">Email:</label>
        <input type="email" id="email" name="email" required style="padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; width: 100%; margin-bottom: 20px;">
        <label for="feedback" style="display: block; font-size: 16px; font-weight: bold; margin-bottom: 5px; color: #fff;">Feedback:</label>
        <textarea id="feedback" name="feedback" required style="padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px; width: 100%; height: 150px; margin-bottom: 20px;"></textarea>
        <button type="submit" style="padding: 10px 20px; background-color: #fff; color: #000; border: none; border-radius: 5px; font-size: 16px; cursor: pointer;">Submit</button>
      </form>
    </div>
    
  </div>



</body>
<script>
  function openPage(url) {
    window.open(url, "_self");
  }
</script>

</html>
