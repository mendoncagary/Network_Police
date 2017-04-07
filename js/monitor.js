
$(document).ready(function() {

    setInterval( function () { 

        $.get('server/monitor.php', {}, function (data) {
            if(data.length > 0) {
                data = JSON.parse(data);
                console.log(data);
                for(var i = 0; i < data.length; i++) {
                    console.log(data[i]);
                    //alert("Illegal application execution @ " + data[i].id + ": " + data[i].exe);
                    $("#alerter").html("<img src='img/alert.png'/>Illegal application execution @ " + data[i].id + ": " + data[i].exe);
                    $("#alerter").slideUp();
                    document.getElementById('aud').play();
                    setTimeout(function() { $("#alerter").slideDown();}, 6000);   
                }
            }
                            
         });


    }, 10000);
    
 });