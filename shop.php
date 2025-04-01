<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="Bootstrap file/bootstrap 4/css/bootstrap.min.css">
  <link rel="icon" href="assets/newestlogo.jpg">
  <title>Shop CaSaFix</title>
  <link rel="stylesheet" href="styles.css">
</head>
<style>
  /* General Styles */
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
}

nav {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
  background-color: #333;
  color: white;
}

.cart-icon {
  cursor: pointer;
}

/* Category Navigation */
.category-nav {
  padding: 10px 20px;
  background-color: transparent; /* No background color */
  display: flex;
  justify-content: center; /* Center the category navigation */
}

.category-nav ul {
  list-style: none;
  padding: 0;
  margin: 0;
  display: flex;
  gap: 20px; /* Space between category links */
  flex-wrap: wrap; /* Allow wrapping on smaller screens */
  justify-content: center; /* Center the list items */
}

.category-nav ul li {
  padding: 10px;
  cursor: pointer;
  transition: color 0.3s;
  color: #333; /* Default text color */
}

.category-nav ul li:hover,
.category-nav ul li.active {
  color:black; /* Yellow color on hover and active */
  background-color:rgb(238, 253, 28);
}

/* Shop Container */
.shop-container {
  display: grid;
  grid-template-columns: repeat(2, 1fr); /* Two cards per row by default */
  gap: 20px; /* Space between cards */
  padding: 20px;
  max-width: 1200px; /* Limit the maximum width of the shop container */
  margin: 0 auto; /* Center the shop container */
}

/* Item Card */
.item-card {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 15px;
  text-align: center;
  background-color: #f9f9f9;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  height:700px;
}

.item-card img {
  width: 100%;
  height: 500px; /* Fixed height for images */
  object-fit: cover; /* Ensure images cover the area without distortion */
  border-radius: 8px;
}

.item-card h3 {
  margin: 10px 0;
  font-size: 1.5em;
}

.item-card p {
  margin: 5px 0;
  font-size: 1.2em;
  color: #333;
}

.item-card button {
  background-color: yellow;
  color: black;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  font-size: 1em;
}

.item-card button:hover {
  background-color: rgb(238, 255, 0);
}
/* class popup */
.cart-popup {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
}

.cart-content {
  background-color: white;
  padding: 20px;
  border-radius: 8px;
  width: 400px; /* Increased width for better readability */
  max-height: 80vh; /* Limit height to 80% of the viewport height */
  overflow-y: auto; /* Enable vertical scrolling */
  text-align: center;
}

.cart-content button {
  margin: 5px;
  padding: 10px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.cart-content button:first-of-type {
  background-color: rgb(238, 253, 28);
  color: #000;
}

.cart-content button:last-of-type {
  background-color: #dc3545;
  color: white;
}
.logo{
    margin-left:85px;
}
 .nav{
    height:120px;
    opacity: 40%;
 }
/* Responsive Design */
@media (max-width: 768px) {
  .shop-container {
    grid-template-columns: 1fr; /* One card per row on smaller screens */
  }

  .category-nav ul {
    gap: 10px; /* Reduce gap between category links */
  }

  .category-nav ul li {
    padding: 8px; /* Reduce padding for smaller screens */
  }
}

@media (max-width: 480px) {
  .category-nav ul {
    flex-direction: column; /* Stack category links vertically on very small screens */
    align-items: center; /* Center the links */
  }

  .category-nav ul li {
    padding: 5px; /* Further reduce padding for very small screens */
  }
}
</style>
<body>
  <!-- Navigation Bar -->
  <nav class="nav fixed-top">
    <div class="logo"><h1>Casa<span style="color:yellow;">Fix</span></h1></div>
    <div class="cart-icon" onclick="toggleCartPopup()">
      🛒 <span id="cart-count">0</span>
    </div>
  </nav>
                   
  <img src="assets/newestlogo.jpg" class="card-img-overlay fixed-top" style="width:100px; 
       margin-top:-15px; height:130px; border-radius:50%;">
/
        <br><br><br><br><br><br><br>
        <center><h1>SHOP AND SELL!🛒</h1></center>
  <!-- Category Navigation -->
  <div class="category-nav">
    <ul>
      <li class="active" onclick="filterItems('all')">All</li>
      <li onclick="filterItems('kitchen')">Kitchen</li>
      <li onclick="filterItems('bathroom')">Bathroom</li>
      <li onclick="filterItems('living-room')">Living Room</li>
      <li onclick="filterItems('bed-room')">Bed Room</li>
      <li onclick="filterItems('outdoor')">Outdoor</li>
      <li onclick="filterItems('equipment')">Equipment</li>
    </ul>
  </div>

  <!-- Shop Items -->
  <div class="shop-container">
    <!-- Items will be dynamically inserted here by JavaScript -->
  </div>

  <!-- Cart Popup -->
  <div id="cart-popup" class="cart-popup">
    <div class="cart-content">
      <h2><b>Your Cart</b></h2>
      <div id="cart-items"></div>
      <p>Total: <span id="cart-total">0</span> XAF</p>
      <button onclick="proceedToPayment()">Proceed to Payment</button>
      <button onclick="toggleCartPopup()">Close</button>
    </div>
  </div>

  <script>

let cart = [];
let cartCount = 0;
let cartTotal = 0;
let items = []; // Initialize items array

// fucntion to load items
function loadItems() {
  const cacheBuster = new Date().getTime(); // Generate a unique timestamp
  fetch(`items.json?${cacheBuster}`) // Append the timestamp as a query parameter
    .then(response => response.json())
    .then(data => {
      items = data.filter(item => item.quantity > 0); // Only load items with quantity > 0
      filterItems('all'); // Display all items initially
    })
    .catch(error => console.error('Error loading items:', error));
}


// Function to display items based on category
function filterItems(category) {
  const shopContainer = document.querySelector('.shop-container');
  shopContainer.innerHTML = ''; // Clear existing items

  // Filter items based on category
  const filteredItems = category === 'all' ? items : items.filter(item => item.category === category);

  // Display filtered items
  filteredItems.forEach(item => {
    const itemCard = document.createElement('div');
    itemCard.className = 'item-card';
    itemCard.innerHTML = `
      <img src="${item.image}" alt="${item.name}">
      <h3>${item.name}</h3>
      <p>${item.price.toLocaleString()} XAF</p>
      <p>Available: ${item.quantity}</p>
      <button onclick="addToCart('${item.name}', ${item.price}, '${item.image}', ${item.quantity})">Add to Cart</button>
    `;
    shopContainer.appendChild(itemCard);
  });

  // Update active category
  const categoryLinks = document.querySelectorAll('.category-nav ul li');
  categoryLinks.forEach(link => link.classList.remove('active'));
  const activeLink = Array.from(categoryLinks).find(link => link.textContent.toLowerCase() === category || (category === 'all' && link.textContent === 'All'));
  if (activeLink) activeLink.classList.add('active');
}

// Function to add items to the cart
function addToCart(name, price, image, quantity) {
  if (quantity > 0) {
    cart.push({ name, price, image });
    cartCount++;
    cartTotal += price;
    updateCartUI();
  } else {
    alert("This item is out of stock!");
  }
}

// Function to update the cart UI
function updateCartUI() {
  document.getElementById('cart-count').textContent = cartCount;
  document.getElementById('cart-total').textContent = cartTotal.toLocaleString();

  const cartItems = document.getElementById('cart-items');
  cartItems.innerHTML = '';
  cart.forEach(item => {
    const itemDiv = document.createElement('div');
    itemDiv.innerHTML = `
      <img src="${item.image}" alt="${item.name}" width="50">
      <p>${item.name} - ${item.price.toLocaleString()} XAF</p>
    `;
    cartItems.appendChild(itemDiv);
  });
}

// Function to toggle the cart popup
function toggleCartPopup() {
  const popup = document.getElementById('cart-popup');
  popup.style.display = popup.style.display === 'flex' ? 'none' : 'flex';
}

// Function to proceed to payment
function proceedToPayment() {
  // Save cart data to session or local storage
  sessionStorage.setItem('cart', JSON.stringify(cart));

  // Redirect to payment.php
  window.location.href = 'payment.php';
}

// Initialize the page by loading items
window.onload = () => loadItems();
  </script>
</body>
</html>