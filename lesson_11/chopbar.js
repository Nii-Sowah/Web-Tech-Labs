function asyncRequest() {
    let request;
    try {
        request = new XMLHttpRequest();
    } catch (e1) {
        try {
            request = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e2) {
            try {
                request = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e3) {
                request = false;
            }
        }
    }
    return request;
}

const menuRequest = asyncRequest();

if (menuRequest) {
    menuRequest.onreadystatechange = function () {
        console.log("menu.xml readyState:", menuRequest.readyState);

        if (menuRequest.readyState === 4 && menuRequest.status === 200) {
            const dishes = menuRequest.responseXML.getElementsByTagName("dish");
            const menuList = document.getElementById("menu");

            for (let i = 0; i < dishes.length; i++) {
                const name = dishes[i].getElementsByTagName("name")[0].textContent;
                const price = dishes[i].getElementsByTagName("price")[0].textContent;

                const li = document.createElement("li");
                li.textContent = name + " - GHS " + price;
                menuList.appendChild(li);
            }
        }
    };

    menuRequest.open("GET", "menu.xml?nocache=" + Math.random() * 1000000, true);
    menuRequest.send();
    console.log("Request sent");
}


const specialsRequest = asyncRequest();

if (specialsRequest) {
    specialsRequest.onreadystatechange = function () {
        if (specialsRequest.readyState === 4 && specialsRequest.status === 200) {
            const specials = JSON.parse(specialsRequest.responseText);
            const specialsList = document.getElementById("specials");

            specials.forEach(function (special) {
                const li = document.createElement("li");
                li.textContent = special.name + " - GHS " + special.price;
                specialsList.appendChild(li);
            });
        }
    };

    specialsRequest.open("GET", "specials.json", true);
    specialsRequest.send();
}

const orderRequest = asyncRequest();

if (orderRequest) {
    orderRequest.onreadystatechange = function () {
        if (orderRequest.readyState === 4 && orderRequest.status === 200) {
            let id;
            try {
                id = JSON.parse(orderRequest.responseText).id;
            } catch (e) {
                id = orderRequest.responseText;
            }
            document.getElementById("confirmation").textContent =
                "Order received! Order number: " + id;
        }
    };

    orderRequest.open(
        "POST",
        "http://169.239.251.102:341/~hamison-addy/dish.php",
        true
    );
    orderRequest.setRequestHeader("Content-Type", "application/json");
    orderRequest.send(JSON.stringify({ dish: "Jollof Rice", qty: 2 }));
}