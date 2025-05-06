function loadPage(page) {
    if(localStorage.getItem("myID" == null)){
        window.location.href = "Login.php";
    }else{
        window.location.href = page;
    }
}
