console.log(JSON.stringify(pass));

(function (){
    if(JSON.stringify(pass).replace(/\"/g, "") === "d56963fbad09a2b894c7cf6ed6fe3cd5"){
        window.location.href="admin.php";
    }
})();