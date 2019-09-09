function checkPass()
{
    var pass1 = document.getElementById('pass1');
    var pass2 = document.getElementById('pass2');
    var message1 = document.getElementById('error-nwlpass1');
    var message2 = document.getElementById('error-nwlpass2');
    var goodColor = "#66cc66";
    var badColor = "#ff6666";

    if(pass1.value.length > 5)
    {
        pass1.style.borderColor = goodColor;
        message1.style.color = goodColor;
        message1.innerHTML = "<p class='col-md-9 col-sm-9 col-9'><i class='fa fa-check-circle fa-lg' aria-hidden='true'></i>  character number ok!</p>"
    }
    else
    {
        pass1.style.borderColor = badColor;
        message1.style.color = badColor;
        message1.innerHTML = "<p class='col-md-9 col-sm-9 col-9'><i class='fa fa-times-circle-o fa-lg' aria-hidden='true'></i>  you have to enter at least 6 digit!</p>"
        return;
    }

    if(pass1.value == pass2.value)
    {
        pass2.style.borderColor = goodColor;
        message2.style.color = goodColor;
        message2.innerHTML = "<p class='col-md-9 col-sm-9 col-9'><i class='fa fa-check-circle fa-lg' aria-hidden='true'></i>  Passwords match</p>"
    }
    else
    {
        pass2.style.borderColor = badColor;
        message2.style.color = badColor;
        message2.innerHTML = "<p class='col-md-9 col-sm-9 col-9'><i class='fa fa-times-circle-o fa-lg' aria-hidden='true'></i>  These passwords don't match!</p>"
    }
}

function checkPassSignUp()
{
    var pass = document.getElementById('pass');
    var message = document.getElementById('error-nwlpass');
    var goodColor = "#66cc66";
    var badColor = "#ff6666";

    if(pass.value.length > 5)
    {
        pass.style.borderColor = goodColor;
        message.style.color = goodColor;
        message.innerHTML = "<p class='col-md-9 col-sm-9 col-9'><i class='fa fa-check-circle fa-lg' aria-hidden='true'></i>  character number ok!</p>"
    }
    else
    {
        pass.style.borderColor = badColor;
        message.style.color = badColor;
        message.innerHTML = "<p class='col-md-9 col-sm-9 col-9'><i class='fa fa-times-circle-o fa-lg' aria-hidden='true'></i>  you have to enter at least 6 digit!</p>"
        return;
    }
}