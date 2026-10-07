const form = document.getElementById("form");
const Fname = document.getElementById("Fname");
const Lname = document.getElementById("Lname");
const showbtn = document.getElementById("magic_btn");
const APIpath = "../backend/api.php";



function show(){
    fetch(APIpath)
    .then(res => res.json())
    .then(ppl =>{
        tbody.innerHTML = '';
        ppl.forEach(person => {
            tbody.insertAdjacentHTML("beforeend", `
            <tr>
                <td>${person.id}</td>
                <td>${person.Fname}</td>
                <td>${person.Lname}</td>
            </tr>
            `)
        });
    })
}


function add(){
    fetch(APIpath, {
        method:"POST",
        headers:{"Content-Type": "application/json"},
        body: JSON.stringify({
            Fname:Fname.value,
            Lname:Lname.value
        })
    })
    show();
}












document.addEventListener("DOMContentLoaded", ()=>{
    show();
    showbtn.addEventListener("click", ()=>{
        if(form.hidden){
            form.hidden = false;
        }else{
            form.hidden = true;
        }

    form.addEventListener("submit", (e)=>{
        e.preventDefault();
        add();
    })
    })
})