<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Bootstrap file/bootstrap 4/css/bootstrap.min.css">
  <title>Payment Page</title>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color:rgba(215, 190, 0, 0.1);
    }
    .payment-form {
      background-color: white;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      width: 300px;
      text-align: center;
    }
    .payment-form h2 {
      margin-bottom: 20px;
    }
    .payment-form label {
      display: block;
      margin-bottom: 5px;
      text-align: left;
    }
    .payment-form input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .payment-form button {
      background-color: yellow;
      color: black;
      border: none;
      padding: 10px 20px;
      border-radius: 5px;
      cursor: pointer;
      font-size: 1em;
    }
    .payment-form button:hover {
      background-color: #218838;
    }
  </style>
</head>
<body>
  <div class="payment-form">
    <h2><b>Payment Details</b></h2>
    <form id="paymentForm">
      <label for="cardNumber">Card Number</label>
      <input type="text" id="cardNumber" name="cardNumber" placeholder="1234 5678 9012 3456" required>

      
      <label for="cardNumber">Delivery Address</label>
      <input type="text" id="Delivery Address" name="Delivery Address"required>

       <label for="Phone Number">Phone Number 1</label>
       <input type="text" required>
        
       <label for="Phone Number">Phone Number 2</label>
       <input type="text" required>
         
       <label> Pay Via  </label>
       <select>
        <option value="MTN">MTN Momo</option>
        <option value="ORANGE">ORANGE</option>
       </select> <br>
         
      <label for="totalAmount">Total Amount</label>
      <input type="text" id="totalAmount" name="totalAmount" readonly>
      
      <button type="submit">Pay Now</button>
    </form>
  </div>

  <script>
    // Retrieve cart data from session storage
    const cart = JSON.parse(sessionStorage.getItem('cart')) || [];
    let totalAmount = 0;

    // Calculate total amount
    cart.forEach(item => {
      totalAmount += item.price;
    });

    // Display total amount in the form
    document.getElementById('totalAmount').value = totalAmount.toLocaleString() + ' XAF';

    // Handle form submission
    document.getElementById('paymentForm').addEventListener('submit', function(event) {
      event.preventDefault();
      alert('Payment successful!');
      // Here you can add further processing like sending data to a server
    });
  </script>
</body>
</html>