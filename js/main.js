/*
**主页js
*/
$(function () {
    $("#faded").faded();
    var music = document.getElementById("bgMusic");
    $("#audioBtn").click(function(){
        if(music.paused){
            music.play();
            $(this).addClass('start');
        }else{
            music.pause();
            $(this).removeClass('start');
        }
    });
    $('#up').click(function(){
        $('html,body').animate({scrollTop: '0px'}, 800);
    });
});

