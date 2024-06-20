console.log("1");
window.onscroll = function() {myFunction()};
console.log("2");

function myFunction() {
    if (document.documentElement.scrollTop > 1) {
        console.log("3");
        document.getElementById("Nav").style.width = "15vw";
    } else {
        console.log("4");
        document.getElementById("Nav").style.width = "50vw";
    }
}