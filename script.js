// 1. onfocus
function focusField(x) {
    x.style.border = "3px solid #f2c14e";
}

// 2. onsubmit (Register)
function validateRegister() {
    let valid = true;

    document.querySelectorAll(".error").forEach(function (el) {
        el.innerHTML = "";
    });

    let name = document.getElementById("name").value.trim();
    let email = document.getElementById("email").value.trim();
    let phone = document.getElementById("phone").value.trim();
    let address = document.getElementById("address").value.trim();
    let pincode = document.getElementById("pincode").value.trim();
    let username = document.getElementById("username").value.trim();
    let password = document.getElementById("password").value;
    let confirm = document.getElementById("confirm").value;

    let emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
    let phonePattern = /^[0-9]{10}$/;
    let pincodePattern = /^[0-9]{6}$/;

    if (name === "") {
        document.getElementById("nameError").innerHTML = "Name is required";
        valid = false;
    }

    if (email === "") {
        document.getElementById("emailError").innerHTML = "Email is required";
        valid = false;
    } else if (!email.match(emailPattern)) {
        document.getElementById("emailError").innerHTML = "Invalid email format";
        valid = false;
    }

    if (!phone.match(phonePattern)) {
        document.getElementById("phoneError").innerHTML = "Enter valid 10 digit phone number";
        valid = false;
    }

    if (address.length < 10) {
        document.getElementById("addressError").innerHTML = "Enter proper address";
        valid = false;
    }

    if (!pincode.match(pincodePattern)) {
        document.getElementById("pincodeError").innerHTML = "Invalid pincode";
        valid = false;
    }

    if (username.length < 4) {
        document.getElementById("usernameError").innerHTML = "Minimum 4 characters";
        valid = false;
    }

    if (password.length < 6) {
        document.getElementById("passwordError").innerHTML = "Password must contain at least 6 characters";
        valid = false;
    }

    if (confirm !== password) {
        document.getElementById("confirmError").innerHTML = "Passwords do not match";
        valid = false;
    }

    return valid;
}

// 3. onsubmit (Login)
function validateLogin() {
    let valid = true;

    document.getElementById("loginUsernameError").innerHTML = "";
    document.getElementById("loginPasswordError").innerHTML = "";

    let username = document.getElementById("username").value.trim();
    let password = document.getElementById("password").value.trim();

    if (username === "") {
        document.getElementById("loginUsernameError").innerHTML = "Username is required";
        valid = false;
    }

    if (password === "") {
        document.getElementById("loginPasswordError").innerHTML = "Password is required";
        valid = false;
    }

    return valid;
}

// 4. Category and Search filtering
let currentCategory = "all";

function filterCategory(category, element) {
    currentCategory = category;

    // Update active class on sidebar links
    document.querySelectorAll(".sidebar-link").forEach(link => {
        link.classList.remove("active");
    });
    if (element) {
        element.classList.add("active");
    }

    applyFilters();
}

function searchItems() {
    applyFilters();
}

function applyFilters() {
    let searchInput = document.getElementById("searchBox").value.toLowerCase();

    // Filter section headers
    let sections = ["breed", "accessory", "food"];
    sections.forEach(cat => {
        let section = document.getElementById("section-" + (cat === "breed" ? "breeds" : cat === "accessory" ? "accessories" : "food"));
        if (section) {
            let items = section.getElementsByClassName("item");
            let hasVisibleItem = false;

            for (let i = 0; i < items.length; i++) {
                let itemCategory = items[i].getAttribute("data-category");
                let text = items[i].innerText.toLowerCase();

                let matchesCategory = (currentCategory === "all" || itemCategory === currentCategory);
                let matchesSearch = text.includes(searchInput);

                if (matchesCategory && matchesSearch) {
                    items[i].style.display = "block";
                    hasVisibleItem = true;
                } else {
                    items[i].style.display = "none";
                }
            }

            // Hide the entire section if no items match
            if ((currentCategory === "all" || cat === currentCategory) && hasVisibleItem) {
                section.style.display = "block";
            } else {
                section.style.display = "none";
            }
        }
    });
}

// 5. onclick (Add to cart)
function addToCart(item, price) {
    fetch("add_to_cart.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "item=" + encodeURIComponent(item) + "&price=" + price
    })
        .then(response => response.text())
        .then(data => {
            data = data.trim();
            if (data === "success") {
                alert(item + " added to cart!");
                updateQuantity(item);
            } else if (data === "out_of_stock") {
                alert("Sorry, " + item + " is out of stock.");
            } else if (data === "login_required") {
                alert("Please login first.");
                window.location.href = "login.php";
            } else {
                alert("Could not add to cart: " + data);
            }
        });
}

// 6. Update quantity on dashboard
function updateQuantity(item) {
    fetch("get_stock.php?item=" + encodeURIComponent(item))
        .then(response => response.text())
        .then(quantity => {
            let id = item.replace(/\s/g, '');
            let qtyElement = document.getElementById(id + "Qty");
            let button = document.getElementById(id + "Btn");
            let qty = parseInt(quantity, 10);

            if (qtyElement) {
                qtyElement.innerHTML = isNaN(qty) ? 0 : qty;
            }

            if (button) {
                if (qty <= 0) {
                    button.disabled = true;
                    button.innerText = "Out of stock";
                } else {
                    button.disabled = false;
                    button.innerText = "Add To Cart";
                }
            }
        });
}

// 7. onmouseover (Highlight item)
function highlight(x) {
    x.style.transform = "scale(1.05)";
    x.style.boxShadow = "0px 0px 22px rgba(18, 107, 91, 0.35)";
}

// 8. onmouseout (Remove highlight)
function removeHighlight(x) {
    x.style.transform = "scale(1)";
    x.style.boxShadow = "none";
}

// 9. onchange (Payment Method)
function showPaymentFields() {
    let payment = document.getElementById("paymentMethod").value;

    document.getElementById("upiField").style.display = "none";
    document.getElementById("cardField").style.display = "none";

    if (payment === "UPI") {
        document.getElementById("upiField").style.display = "block";
    }

    if (payment === "Card") {
        document.getElementById("cardField").style.display = "block";
    }
}

// 10. onblur
function blurField(x) {
    x.style.border = "";
}

// 11. onsubmit (payment validation)
function validatePayment() {
    let payment = document.getElementById("paymentMethod").value;
    let valid = true;

    // clear old errors
    document.getElementById("upiError").innerHTML = "";
    document.getElementById("cardError").innerHTML = "";
    document.getElementById("cvvError").innerHTML = "";

    // UPI Validation
    if (payment === "UPI") {
        let upi = document.getElementById("upiId").value.trim();
        let upiPattern = /^[a-zA-Z0-9._-]{2,}@[a-zA-Z]{2,}$/;

        if (!upiPattern.test(upi)) {
            document.getElementById("upiError").innerHTML = "Enter valid UPI ID";
            valid = false;
        }
    }

    // Card Validation
    if (payment === "Card") {
        let card = document.getElementById("cardNumber").value.trim();
        let cvv = document.getElementById("cvv").value.trim();

        let cardPattern = /^[0-9]{16}$/;
        let cvvPattern = /^[0-9]{3}$/;

        if (!cardPattern.test(card)) {
            document.getElementById("cardError").innerHTML = "Card number must be 16 digits";
            valid = false;
        }

        if (!cvvPattern.test(cvv)) {
            document.getElementById("cvvError").innerHTML = "CVV must be 3 digits";
            valid = false;
        }
    }

    return valid;
}

// 12. Toggle Sidebar
function toggleSidebar() {
    let sidebar = document.getElementById("sidebar");
    if (sidebar) {
        sidebar.classList.toggle("collapsed");
    }
    document.body.classList.toggle("sidebar-collapsed");
}

// 13. Initialize Collapsed Sidebar on Mobile
document.addEventListener("DOMContentLoaded", function () {
    if (window.innerWidth <= 900) {
        let sidebar = document.getElementById("sidebar");
        if (sidebar) {
            sidebar.classList.add("collapsed");
        }
        document.body.classList.add("sidebar-collapsed");
    }
});
