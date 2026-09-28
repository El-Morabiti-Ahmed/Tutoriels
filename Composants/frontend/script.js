//1. This is called an existing public API
fetch('https://jsonplaceholder.typicode.com/users')
  //2. We transform the response into a usable JSON object
  .then(answer => answer.json())
  // 3. We use the data
  .then(users => {
      console.log("First user name:", users[0].name);
  })
  .catch(error => console.error("Error:", error));