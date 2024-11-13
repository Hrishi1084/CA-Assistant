<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Categories</title>
</head>
<style>
  body {
    font: 300 16px/1.5 'Roboto', sans-serif;
    color: #333;
    background: #e3e9ff;
  }

  .container {
    margin: 0 auto;
    max-width: 640px;
    padding: 0 15px;
  }

  h1 {
    font-size: 24px;
    font-weight: 300;
  }

  p {
    margin: 0 0 15px;
  }

  input[type="text"] {
    width: 100%;
    height: 58px;
    border: 1px solid #ccc;
    background: #fff;
    padding: 10px;
    font: 300 25px/1.5 'Roboto', sans-serif;
    transition: border 0.3s linear;
  }

  input[type="text"]:focus {
    border-color: #E02130;
    outline: none;
  }

  .btn-primary {
    background: #E02130;
    border: none;
    padding: 10px;
    display: inline-block;
    vertical-align: top;
    width: 100%;
    height: 40px;
    color: #fff;
    cursor: pointer;
    font: 300 16px/1.5 'Roboto', sans-serif;
  }

  .btn-primary:hover {
    background: #fe1428;
  }

  .btn-primary:focus {
    outline: none;
  }

  .btn-icon {
    background: none;
    border: none;
    display: inline-block;
    vertical-align: top;
    color: #333;
    cursor: pointer;
  }

  .btn-icon:focus {
    outline: none;
  }

  .btn-icon:before {
    font-family: 'Font Awesome 5 Free';
    font-weight: 900;
  }

  .btn-icon.remove:before {
    content: '\f2ed';
  }

  .todoBlock {
    padding: 30px;
    margin: 30px 0;
    background: #fff;
    box-shadow: 5px 5px 20px -5px rgba(0, 0, 0, 0.2);
  }

  .todoBlock .titleHolder {
    margin: 0 0 30px;
  }

  .listHolder li {
    counter-increment: step-counter;
    overflow: hidden;
    padding: 0 0 20px 30px;
    position: relative;
  }

  .listHolder li:before {
    content: counter(step-counter);
    background: #E02130;
    color: #fff;
    font-size: 14px;
    padding: 0px 6px;
    border-radius: 3px;
    position: absolute;
    top: 0;
    left: 0;
  }

  .listHolder .listName {
    float: left;
  }

  .listHolder .btn-icon {
    float: right;
    margin: 0 0 0 20px;
  }

  .formHolder {
    margin: 0 -5px;
    overflow: hidden;
    position: relative;
  }

  .formHolder .col {
    float: left;
    width: 20%;
    padding: 0 5px;
  }

  .formHolder .col.big {
    width: 60%;
  }
</style>

<body>
  <div class="container">
    <div class="todoBlock">
      <div class="titleHolder">
        <h1>Categories</h1>
      </div>
      <form method="POST">
        <div class="formHolder">
          <div class="col big">
            <input type="text" id="addInput" placeholder="Enter category">
          </div>
          <div class="col">
            <button type="button" id="addBtn" class="btn-primary">Add Item</button>
          </div>
          <div class="col">
            <input type="submit" name="save" class="btn-primary" value="Save">
          </div>
        </div>
        <input type="hidden" name="categories" id="categoriesInput">
      </form>
      <div class="todoList">
        <div class="listHolder">
          <ul class="list">
          </ul>
        </div>
      </div>
    </div>
  </div>

  <script>
    const divList = document.querySelector('.listHolder');
    const addInput = document.querySelector('#addInput');
    const addBtn = document.querySelector('#addBtn');
    const listUl = document.querySelector('.list');
    const categoriesInput = document.querySelector('#categoriesInput');

    // Function to create delete button for each list item
    function createBtn(li) {
      const remove = document.createElement('img');
      remove.src = "./images/ic_delete.png";
      remove.style.height = "22px";
      remove.style.width = "22px";
      remove.className = 'btn-icon remove';
      li.appendChild(remove);
    }

    // Adding new list items
    function addLists() {
      if (addInput.value === '') {
        alert('Enter the list name please!!!');
      } else {
        const ul = divList.querySelector('ul');
        const li = document.createElement('li');
        const span = document.createElement("SPAN");
        span.className = 'listName';
        span.innerHTML = addInput.value;
        li.appendChild(span);
        ul.appendChild(li);
        createBtn(li);
        addInput.value = ''; // Clear the input field
      }
    }

    // Event to add list on clicking 'Add Item'
    addBtn.addEventListener('click', () => {
      addLists();
    });

    // Event to remove list item
    divList.addEventListener('click', (event) => {
      if (event.target.tagName === 'IMG') {
        const button = event.target;
        const li = button.parentNode;
        li.parentNode.removeChild(li); // Remove item from list
      }
    });

    // Event to save the form
    document.querySelector('form').addEventListener('submit', (event) => {
      const listItems = document.querySelectorAll('.listHolder .list li .listName');
      const categoriesArray = [];
      listItems.forEach((item) => {
        categoriesArray.push(item.textContent.trim());
      });

      const categoriesString = categoriesArray.join(',');
      categoriesInput.value = categoriesString; // Set hidden input value

      if (categoriesString === '') {
        alert('No categories to save!');
        event.preventDefault(); // Prevent form submission if no categories
      }
    });
  </script>

  <?php
  if (array_key_exists('save', $_POST)) {
    saveToDatabase();
  }

  function saveToDatabase()
  {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = "ca_assistant";
    $conn = new mysqli($servername, $username, $password, $db);

    if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
    }

    $categories = $_POST['categories'];
    $categoriesArray = explode(',', $categories);

    foreach ($categoriesArray as $category) {
      $category = trim($category);
      if (!empty($category)) { // Avoid inserting blank entries
        $sql = "INSERT INTO categories(sector) VALUES ('$category')";
        $conn->query($sql);
      }
    }

    $conn->close();
  }
  ?>
</body>

</html>
