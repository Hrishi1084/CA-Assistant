<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$db = "ca_assistant";

$conn = new mysqli($servername, $username, $password, $db);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle the POST request to save goal data to the database
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data (JSON format)
    $data = file_get_contents("php://input");
    $goal = json_decode($data, true);

    // Check if data is properly received
    if (!$goal) {
        echo json_encode(["error" => "No data received or data is invalid"]);
        exit;
    }

    // Extract goal details
    $name = $goal['name'] ?? null;
    $amount = $goal['amount'] ?? null;
    $saving = $goal['saving'] ?? null;

    // Check if any value is null
    if (is_null($name) || is_null($amount) || is_null($saving)) {
        echo json_encode(["error" => "Missing goal details"]);
        exit;
    }

    // Prepare and execute SQL statement to insert the goal into the database
    $stmt = $conn->prepare("INSERT INTO goals (goalname, goalamt, goalsaving) VALUES (?, ?, ?)");
    $stmt->bind_param("sdd", $name, $amount, $saving);

    if ($stmt->execute()) {
        echo json_encode(["success" => "Goal saved successfully!"]);
    } else {
        echo json_encode(["error" => $stmt->error]);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goals</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(to bottom right, #4BB1FF, #FFAFD1);
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: -100px;
            height: 100vh;
        }

        .card {
            background-color: #fff;
            padding: 20px;
            width: 900px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            border-radius: 4px;
        }

        h1 {
            text-align: center;
            margin-top: 0;
        }

        label {
            display: block;
            margin-bottom: 8px;
        }

        input[type="text"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            margin-bottom: 16px;
        }

        button {
            background-color: #E02130;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            display: block;
            margin: 0 auto;
        }

        button:hover {
            background-color: #fe1428;
        }

        ul {
            list-style: none;
            padding: 0;
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
            border-radius: 4px;
        }

        li {
            margin-bottom: 8px;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>Goals</h1>
        <div>
            <label for="name">Goal name:</label>
            <input type="text" id="name">
        </div>
        <div>
            <label for="amount">Goal amount:</label>
            <input type="number" id="amount">
        </div>
        <div>
            <label for="saving">Monthly saving:</label>
            <input type="number" id="saving">
        </div>
        <button onclick="addGoal()">Add goal</button>
        <ul id="goalsList"></ul>
    </div>

    <script>
        let goals = [];

        async function addGoal() {
            const name = document.getElementById('name').value;
            const amount = document.getElementById('amount').value;
            const saving = document.getElementById('saving').value;

            if (!name || !amount || !saving) {
                alert("Please fill in all fields");
                return;
            }

            const goal = {
                name: name,
                amount: parseFloat(amount),
                saving: parseFloat(saving)
            };

            goals.push(goal);
            updateGoalsList();

            // Send goal to backend PHP to save in database
            const response = await fetch('' , {  // Submit the data to the current PHP file
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(goal)
            });

            const result = await response.json();

            if (result.error) {
                alert('Error: ' + result.error);
            } else {
                alert('Goal saved successfully!');
            }
        }

        function updateGoalsList() {
            const list = document.getElementById('goalsList');

            // Clear the list before updating it
            list.innerHTML = '';

            // Create a list item for each goal
            for (const goal of goals) {
                const listItem = document.createElement('li');
                listItem.textContent = `${goal.name} - $${goal.amount} - $${goal.saving}/month`;
                list.appendChild(listItem);
            }
        }
    </script>
</body>
</html>
