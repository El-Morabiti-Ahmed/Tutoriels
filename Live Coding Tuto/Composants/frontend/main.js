const ul = document.querySelector('#ul');
const APIpath = '../backend/api.php';

fetch(APIpath)
.then(Response => Response.json())
.then(data =>{
    data.forEach(e => {
        const li = document.createElement('li');
        li.innerHTML = e.name;
        ul.appendChild(li);
    });
})
.catch(error => console.log("error: " + error));