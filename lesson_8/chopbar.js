console.log("Page Loading...")

const BAR_NAME = "B's Chop Bar"
const TAX_RATE = 0.15
let isMember = true;

console.log("BAR_NAME: is a", typeof BAR_NAME);
console.log("TAX_RATE is a ", typeof TAX_RATE);
console.log("isMember is a ", typeof isMember);

function lineCost(price, qty) {
    return price * qty;
}

function calculateTotal(subtotal) {
    const tax = subtotal * TAX_RATE;
    return subtotal + tax;
}

const items = ["Jollof Rice", "Sobolo"];
const prices = [35, 10];
const quantities = [2, 3];

const subtotal = lineCost(prices[0], quantities[0]) + lineCost(prices[1], quantities[1]);
console.log("Subtotal:", subtotal);

const getsDiscount = isMember && subtotal >= 100;
console.log("Gets discount:", getsDiscount);

const total = calculateTotal(subtotal);
console.log("Total:", total);

document.getElementById("bar-name").textContent = BAR_NAME;
document.getElementById("bill").textContent = "Total: GHS " + total.toFixed(2);

const receipt = document.getElementById("receipt");

for (let i = 0; i < items.length; i++) {
    const line = document.createElement("p")
    line.textContent = items[i] + " x" + quantities[i] + ": GHS " + lineCost(prices[i], quantities[i]).toFixed(2);
receipt.appendChild(line);
}


const subtotalLine = document.createElement("p")
subtotalLine.textContent = "Subtotal: GHS " + subtotal.toFixed(2);
receipt.appendChild(subtotalLine);