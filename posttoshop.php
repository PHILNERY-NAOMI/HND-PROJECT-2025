<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemName = $_POST['item_name'];
    $itemPrice = $_POST['item_price'];
    $itemCategory = $_POST['item_category'];
    $itemImage = $_FILES['item_image'];
    $itemQuantity = $_POST['item_quantity']; // New field

    // Handle image upload
    $targetDir = "assets/";
    $targetFile = $targetDir . basename($itemImage["name"]);

    // Check if the file was uploaded successfully
    if (move_uploaded_file($itemImage["tmp_name"], $targetFile)) {
        // Load existing items from items.json
        $items = [];
        if (file_exists('items.json')) {
            $items = json_decode(file_get_contents('items.json'), true);
        }

        // Check if the item already exists
        $itemExists = false;
        foreach ($items as $item) {
            if ($item['name'] === $itemName && $item['price'] === (int)$itemPrice && $item['category'] === $itemCategory) {
                $itemExists = true;
                break;
            }
        }

        // If the item does not exist, add it to the array
        if (!$itemExists) {
            $newItem = [
                'name' => $itemName,
                'price' => (int)$itemPrice,
                'image' => $targetFile,
                'category' => $itemCategory,
                'quantity' => (int)$itemQuantity // Add quantity
            ];
            $items[] = $newItem;

            // Save the updated items array back to items.json
            file_put_contents('items.json', json_encode($items));
        }

        // Redirect to shop.php
        header('Location: shop.php');
        exit();
    } else {
        echo "Error uploading file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Bootstrap file/bootstrap 4/css/bootstrap.min.css">
  <title>Post to Shop</title>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
  <nav class="nav fixed-top">
    <div class="logo"><h1>Casa<span style="color:yellow;">Fix</span></h1></div>
  </nav>

  <img src="assets/newestlogo.jpg" class="card-img-overlay fixed-top" style="width:100px; margin-top:-15px; height:130px; border-radius:50%;">
  <br><br><br><br><br><br><br>
  <center><h1>POST AN ITEM TO SHOP!🛒</h1></center>

  <div class="container">
    <form action="posttoshop.php" method="POST" enctype="multipart/form-data">
      <div class="form-group">
        <label for="item_name">Item Name</label>
        <input type="text" class="form-control" id="item_name" name="item_name" required>
      </div>
      <div class="form-group">
        <label for="item_price">Price</label>
        <input type="number" class="form-control" id="item_price" name="item_price" required>
      </div>

      <div class="form-group">
  <label for="item_quantity">Total Number Available</label>
  <input type="number" class="form-control" id="item_quantity" name="item_quantity" required>
</div>
      <div class="form-group">
        <label for="item_category">Category</label>
        <select class="form-control" id="item_category" name="item_category" required>
          <option value="all">All</option>
          <option value="kitchen">Kitchen</option>
          <option value="bathroom">Bathroom</option>
          <option value="living-room">Living Room</option>
          <option value="bed-room">Bed Room</option>
          <option value="outdoor">Outdoor</option>
          <option value="equipment">Equipment</option>
        </select>
      </div>
      <div class="form-group">
        <label for="item_image">Upload Image</label>
        <input type="file" class="form-control-file" id="item_image" name="item_image" required>
      </div>
      <button type="submit" class="btn btn-primary">Post Item</button>
    </form>
  </div>
</body>
</html>