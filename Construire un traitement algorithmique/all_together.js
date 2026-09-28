let products = [
    { name: "Product A", price: 30, views: 1200 },
    { name: "Product B", price: 20, views: 2500 },
    { name: "Product C", price: 15, views: 1800 },
    { name: "Product D", price: 40, views: 3000 },
    { name: "Product E", price: 10, views: 900 },
    { name: "Product F", price: 25, views: 2000 }
];

let budget = 100;

let popularProducts = [];
products.forEach(product => {
    if (product.views > 1500) {
        popularProducts.push(product);
    }
});

console.log("Popular products: ", popularProducts);

let sortedProducts = [...popularProducts];

for (let i = 0; i < sortedProducts.length - 1; i++) {
    for (let j = 0; j < sortedProducts.length - 1 - i; j++) {
        if (sortedProducts[j].views > sortedProducts[j + 1].views) {
            let temp = sortedProducts[j];
            sortedProducts[j] = sortedProducts[j + 1];
            sortedProducts[j + 1] = temp;
        }
    }
}

console.log("Sorted products: ", sortedProducts);

let Cost = 0;
let affordableProducts = [];

for (let product of sortedProducts) {
    if (Cost + product.price > budget) {
        break;
    }
    Cost += product.price;
    affordableProducts.push(product);
}

console.log("Total cost: ", Cost);
console.log("Affordable products: ", affordableProducts);