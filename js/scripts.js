// Menu burger
jQuery(document).ready(function(){
    let btn = jQuery('.menu-toggle');
    let nav = jQuery('.site-nav');

    jQuery(btn).on('click', function(){
        jQuery(nav).toggleClass('is-open');
        let open = jQuery(nav).hasClass('is-open');
        jQuery(btn).attr('aria-expanded', open);
    });
});

// Formulaire
let modal = jQuery('#myModal');
let btn = jQuery('.contact-modal');
let closeBtn = jQuery('.close-btn');
let contactBtn = jQuery('.btn-contact');

jQuery(btn).on('click', function(){
    jQuery(modal).css('display', 'block');
    jQuery('body').css('overflow-y', 'hidden');
    jQuery('.ref').val(jQuery('.reference').text());
});

jQuery(contactBtn).on('click', function(){
    jQuery(modal).css('display', 'block');
    jQuery('body').css('overflow-y', 'hidden');
    jQuery('.ref').val(jQuery('.reference').text());
});

jQuery(closeBtn).on('click', function(){
    jQuery(modal).css('display', 'none');
    jQuery('body').css('overflow-y', 'auto');
});

jQuery(window).on('click', function(e){
    if(e.target === jQuery(modal)[0]){
        jQuery(modal).css('display', 'none');
        jQuery('body').css('overflow-y', 'auto');
    }
});

jQuery('.arrowLeft').on('mouseenter', function(){
    jQuery('.prevImg').css('display', 'flex');
});

jQuery('.arrowLeft').on('mouseleave', function(){
    jQuery('.prevImg').css('display', 'none');
});

jQuery('.arrowRight').on('mouseenter', function(){
    jQuery('.nextImg').css('display', 'flex');
});

jQuery('.arrowRight').on('mouseleave', function(){
    jQuery('.nextImg').css('display', 'none');
});

let url = jQuery('.form-load').attr('action');
let nonce = jQuery('#nonce').val();
let action = jQuery('#action').val();
let paged = 1;
let images = [];

jQuery('.btn-load').on('click', function(e){
    e.preventDefault();
    let categorie = jQuery('#categorie').val();
    let format = jQuery('#format').val();
    let date = jQuery('#date').val();
    paged++;
    
    jQuery.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data:{
            nonce: nonce,
            action: action,
            paged: paged,
            categorie: categorie,
            format: format,
            date: date,
        },
        success: function(res){
            if(paged >= res.max){
                jQuery('.btn-load').hide();
            }
            jQuery('.liste-photos').append(res.html);
        }
    })
});

jQuery('#categorie, #format, #date').on('change', function(){
    paged = 1;
    let categorie = jQuery('#categorie').val();
    let format = jQuery('#format').val();
    let date = jQuery('#date').val();
    jQuery.ajax({
        type: 'POST',
        url: url,
        dataType: 'json',
        data:{
            action: action,
            nonce: nonce,
            paged: paged,
            categorie: categorie,
            format: format,
            date: date,
        },
        success: function(res){
            if(paged >= res.max){
                jQuery('.btn-load').hide();
            } else{
                jQuery('.btn-load').show();
            }
            jQuery('.liste-photos').empty();
            jQuery('.liste-photos').append(res.html);
        }
    })
});