$(window).on('load',function(){
    $("#splash-logo").delay(1200).fadeOut('slow');
    
    $("#splash").delay(1500).fadeOut('slow',function(){
    
    $('body').addClass('appear');
    });    
});