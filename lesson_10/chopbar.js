const foods = ["Jollof Rice", "Waakye", "Kelewele"];
const drinks = ["Sobolo", "Asaana"];

document.getElementById("bar-name").textContent = "Night Market";

foods.push("Red Red");
console.log("After push: ", foods);
foods.pop();
console.log("After pop: ", foods);

const menu = foods.concat(drinks);
menu.sort();
menu.reverse();

document.getElementById("menu").textContent = "Menu: " + menu.join(", ");

console.log("Index of Sobolo:", menu.indexOf("Sobolo"))

menu.forEach(function(item) {
    console.log("Menu item: ", item);
});


const stock = {};
stock["Jollof Rice"] = 10;
stock["Waakye"] = 8;
stock["Kelewele"] = 12;
stock["Sobolo"] = 20;
stock["Asaana"] = 15;

const stockText =  Object.keys(stock)
    .map(function(dish) {
        return dish + ", " + stock[dish];
})
    .join(", ");

document.getElementById("stock").textContent = "Plates left - " + stockText;

const order = [
    ["Jollof Rice", 35, 2],
    ["Sobolo", 10, 3]
];

console.log("Price of the second line: ", order[1][1]);

const hasBigQty = order.some(function (line) {
    return line[2] > 2;
});

console.log("Any line with qty > 2:", hasBigQty);

function lineCost(price, qty) {
    return price * qty;
}


function orderLines(order) {
    return order.map(function(line) {
        const name = line[0];
        const price = line[1];
        const qty = line[2];
        return qty + " x " + name + " - GHS " + lineCost(price, qty);
    });
}

const lines = orderLines(order);

const orderList = document.getElementById("order");
lines.forEach(function (text) {
    const li = document.createElement("li");
    li.textContent = text;
    orderList.appendChild(li);
});

function Dish(name, price) {
    this.name = name;
    this.price = price;
}

Dish.prototype.describe = function () {
    return this.name + " - GHS " + this.price;
};

const jollof = new Dish("Jollof Rice", 35);
const sobolo = new Dish("Sobolo", 10);

console.log(jollof.describe());
console.log(sobolo.describe());


class Order {
    constructor() {
        this.lines = [];
    }
    add(dish, qty) {
        this.lines.push({ dish: dish, qty: qty });
        return this;
    }

    total() {
        let sum = 0;
        this.lines.forEach(function (line) {
            sum += lineCost(line.dish.price, line.qty);
        });
        return sum;
    }
}

const customerOrder = new Order().add(jollof, 2).add(sobolo, 3);
    
document.getElementById("total").textContent = "Total: GHS " + customerOrder.total().toFixed(2);