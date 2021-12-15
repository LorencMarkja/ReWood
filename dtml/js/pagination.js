const urlParams = new URLSearchParams(window.location.search);
const param = urlParams.get('page-number');
console.log("page".concat(param));

var elements = document.querySelectorAll('.uk-pagination');
for (var i = 0; i < elements.length; i++) {
    elements[i].classList.remove('active');
    elements[i].onclick = function (event) {
        console.log("ONCLICK");
    }
}

if(param === null){
var activePage = document.getElementById("page1")
activePage.classList.add("uk-active");
}else{
var activePage = document.getElementById("page".concat(param))
activePage.classList.add("uk-active");
}
