let arrayx = [
    10,
    20,
    15,
    67,
    49,
    100
];

let arrayy = [
    20,
    7,
    13,
    5,
    9
];

function findMax(array){
    let max = array[0];
    for (let i = 1; i < array.length; i++) {
        if(array[i] > max){
            max = array[i];
        }
    }
    return max;
}

let maxx = findMax(arrayx);
let maxy = findMax(arrayy);

console.log("max array x: " + maxx);
console.log("max array y: " + maxy);