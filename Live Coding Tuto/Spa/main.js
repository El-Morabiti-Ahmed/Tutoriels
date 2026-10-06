const form = document.getElementById("form");
const nameINP = document.getElementById("nameINP");
const ul = document.getElementById("ul");
const showbtn = document.getElementById("magic_btn");


document.addEventListener("DOMContentLoaded", ()=>{
    showbtn.addEventListener("click", ()=>{
        if(form.hidden){
            form.hidden = false;
        }else{
            form.hidden = true;
        }

    form.addEventListener("submit", (e)=>{
        e.preventDefault();
        const li = document.createElement('li');
        li.textContent = nameINP.value;
        ul.appendChild(li);
        form.reset();
    })
    })
})