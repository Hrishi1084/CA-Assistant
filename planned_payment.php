<?php
$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$dbname = "ca_assistant"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Planned Payment</title>
    <style>
        body {
            background-color: #f2f2f2;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #333;
            margin-top: 40px;
            text-align: center;
        }

        form {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin: 50px auto;
            padding: 30px;
            width: 600px;
        }

        table {
            border-collapse: collapse;
            margin-bottom: 20px;
            width: 100%;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
            font-weight: normal;
            padding: 10px;
            text-align: left;
        }

        td {
            padding: 10px;
        }

        input[type="text"],
        input[type="number"] {
            border-radius: 3px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 16px;
            padding: 10px;
            width: 100%;
        }

        input[type="text"][readonly] {
            background-color: #f2f2f2;
            border: none;
        }

        button[type="button"] {
            background-color: #E02130;
            border: none;
            border-radius: 3px;
            color: #fff;
            cursor: pointer;
            font-size: 16px;
            padding: 10px 20px;
            margin-top: 10px;
        }

        button[type="button"]:hover {
            background-color: #fe1428;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        li {
            background-color: #f2f2f2;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            margin: 10px 0;
            padding: 10px;
            text-align: left;
            position: relative;
        }

        li::before {
            display: inline-block;
            font-size: 20px;
            font-weight: bold;
            margin-right: 10px;
            text-align: center;
            width: 30px;
        }

        ul.my-list {
            counter-reset: myListCounter;
            padding: 0;
            text-align: left;
        }
    </style>

    <script type="text/javascript">
        function calculateDuration() {
            var price = document.getElementById("price").value;
            var emi = document.getElementById("emi").value;
            var duration = Math.round(price / emi);
            document.getElementById("duration").value = duration + " months";
        }

        function addToList() {
            var objectName = document.getElementById("object_name").value;
            var price = document.getElementById("price").value;
            var emi = document.getElementById("emi").value;
            var duration = document.getElementById("duration").value;

            var list = document.getElementById("emi_list");
            var listItem = document.createElement("li");
            listItem.innerHTML = objectName + " - Price: " + price + ", EMI: " + emi + ", Duration: " + duration;
            list.appendChild(listItem);
            saveInDb(objectName, price, emi, duration);
        }

        function saveInDb(objectName, price, emi, duration) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'planned_payment.php', true);

            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            const data = "object_name=" + encodeURIComponent(objectName) + "&price=" + encodeURIComponent(price) + "&emi=" + encodeURIComponent(emi) + "&duration=" + encodeURIComponent(duration);
            xhr.send(data);
        }

        function getallDataOnce() {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', 'planned_payment.php', true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    var planned_payment = JSON.parse(xhr.responseText);
                    loadDataInList(planned_payment)
                } else {
                    console.log("Error fetching planned payments.");
                }
            };

            xhr.send();
        }

        function loadDataInList(planned_payment) {
            for (var i = 0; i < planned_payment.length; i++) {
                var objectName = planned_payment[i]['objname'];
                var price = planned_payment[i]['objprice'];
                var emi = planned_payment[i]['objemi'];
                var duration = planned_payment[i]['objduration'];

                var list = document.getElementById("emi_list");
                var listItem = document.createElement("li");
                listItem.innerHTML = objectName + " - Price: " + price + ", EMI: " + emi + ", Duration: " + duration;
                list.appendChild(listItem);
            }
        }

        window.onload = getallDataOnce;
    </script>
</head>

<body>
    <h1>Planned Payment</h1>

    <form>
        <table>
            <tr>
                <th>Object Name</th>
                <th>Price</th>
                <th>EMI</th>
                <th>Duration</th>
            </tr>
            <tr>
                <td><input type="text" name="object_name" id="object_name"></td>
                <td><input type="number" name="price" id="price" onkeyup="calculateDuration()"></td>
                <td><input type="number" name="emi" id="emi" onkeyup="calculateDuration()"></td>
                <td><input type="text" name="duration" id="duration" readonly></td>
            </tr>
        </table>
        <button type="button" onclick="addToList()">Add to List</button>
    </form>

    <h2>List:</h2>
    <ul id="emi_list"></ul>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Saving the data to the database
        $object_name = $_POST['object_name'];
        $price = $_POST['price'];
        $emi = $_POST['emi'];
        $duration = $_POST['duration'];

        $sql = "INSERT INTO plannedpayment (objname, objprice, objemi, objduration) VALUES ('$object_name', '$price', '$emi', '$duration')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Fetching the data from the database
    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $sql = "SELECT * FROM plannedpayment";
        $result = $conn->query($sql);
        $plannedPayments = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $plannedPayments[] = $row;
            }
            echo json_encode($plannedPayments);
        } else {
            echo "No results";
        }
    }
    ?>
</body>

</html>
