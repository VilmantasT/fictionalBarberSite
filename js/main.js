function writeMessage(id, name, date, time){
    var divs = document.getElementById('message');
    divs.textContent += name + ", Jūs jau esate rezervavęs apsilankymą šiuo laiku " + date + " " + time + " <a href='klientu_reg.php?delete=id'>Trinti</a>";
}
