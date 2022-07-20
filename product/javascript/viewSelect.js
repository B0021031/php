
$(function(){
if($.cookie("access") == undefined) {
    //let date = new Date();
    //date.setTime(date.getTime() + (10*1000))
    $.cookie("access","onece");
        $("#splash-logo").delay(1200).fadeOut('slow');
        $("#splash").delay(1500).fadeOut('slow',function(){
            $('body').addClass('appear');
        });
} else {
    $("#splash-logo").empty();
    $("div").removeAttr("id");
    }
});
    