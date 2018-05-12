$(document).ready(function () {

    $(window).scroll(function (){
        if($(this).scrollTop() > 200){
            $('.navbar').css('background-color', '#005f8f');
        } else{
            $('.navbar').css('background-color', 'transparent');
        }
    });

    
    //go down
    $('.down img').click(function (){
        $('html, body').animate({
            scrollTop: $('.best_clients').offset().top
        });
    });
    
    //show phone and mail in search result pages
    $('.search_result_side_socials .phone').click(function (){
        $('.search_result_side_socials .phone_num').toggle();
    });
    
    $('.portofolio_info .envelope').click(function (){
        $('.portofolio_info .envelope .envelope_mail').toggle();
    });
    $('.portofolio_info .phone').click(function (){
        $('.portofolio_info .phone .phone_num').toggle();
    });
    
    //go up
    $(window).scroll(function(){
        if ($(this).scrollTop() >= 600){
            $('.up').fadeIn();
        } else {
            $('.up').fadeOut();
        }
    });
    
    //up page
    $('.up').click(function (){
        $('html, body').animate({
            scrollTop: 0
        },600);
    });
    
    //fixed adverts
    $(window).scroll(function(){
        if( $(this).scrollTop() >= 500 ){
            $('.fixed_div').css({
                position: 'fixed',
                top: '40px',
                width: '300px'
            });
        } else{
            $('.fixed_div').css({
                position: 'static',
                width: '300px'
            });
        }
    });
});

