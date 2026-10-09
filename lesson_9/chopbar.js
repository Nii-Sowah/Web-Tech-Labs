const items = ["Jollof Rice", "Sobolo", "Kelewele"]
const prices = [35, 10, 15]

const BAR_NAME = "Night Market";
const JOLLOF_RICE = 35;
const SOBOLO_PRICE = 10;
let jollofQty = "2";
let soboloQty  = "3";
let isOpen = true;
let customer = {name: "Ama", table: 5};

document.getElementById("bar-name").textContent = BAR_NAME;

const subtotal = JOLLOF_RICE * Number(JollofQty) + SOBOLO_PRICE * Number(soboloQty);


console.log("Subtotal > 100", subtotal > 100);
console.log ("Subtotal <= 100", subtotal <= 100);
console.log("Subtotal === 100", subtotal === 100);

console.log('"10" == 10:', "10" == 10);
console.log('"10" === 10:', "10" === 10);

const messageEl = document.getElementById("message");
if (subtotal >= 100) {
    messageEl.textContent = "Big order! Free drinks on us.";
} else if (subtotal >= 50) {
    messageEl.textContent = "Thanks for your order!";
} else {
    messageEl.textContent = "Small chop, still sweet!";
}



document.getElementById("status").textContent = isOpen ? "Open" : "Closed";

document.getElementById("total").textContent = "Total: GHS " + subtotal.toFixed(2);


const menuEl = document.getElementById("menu");

for (let i = 0; i< items.length; i++) {
    const li = document.createElement("li");
    li.textContent = items[i] + " - GHS " + prices[i];
    menuEl.appendChild(li);
}

document.getElementById("customer").textContent = "Customer: " + customer.name + ", Table " + customer.table;