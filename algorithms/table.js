let numbers = [4, 7, 2, 7, 9, 4, 5];

let repeatedValues = [];

for (let i = 0; i < numbers.length; i++) {
    let currentValue = numbers[i];
    let count = 0;

    for (let j = 0; j < numbers.length; j++) {
        if (numbers[j] === currentValue) {
            count++;
        }
    }

    if (count > 1 && repeatedValues.includes(currentValue) === false) {
        repeatedValues.push(currentValue);
    }
}

console.log(repeatedValues);