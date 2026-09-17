let array = [8, 
    3, 
    6, 
    1,
    5
];

console.log("Before sorting: ", array);

for (let i = 0; i < array.length; i++) {
    for (let j = 0; j < array.length - i - 1; j++) {
        if (array[j] > array[j + 1]) {
            let temp = array[j];
            array[j] = array[j + 1];
            array[j + 1] = temp;
        }
    }
}
console.log("After sorting: ", array);