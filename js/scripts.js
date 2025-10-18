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
let currentIndex = -1;

function updateGallery(){
    images = [];
    jQuery('.full-screen').each(function(){
        images.push(this.href);
    }); 
}

updateGallery();

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

            updateGallery();
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

            updateGallery();
        }
    })
});

let lightbox = jQuery('.lightbox');
let lightboxImg = jQuery('.lightbox-container > img');
let lightboxPrev = jQuery('.lightbox-prev');
let lightboxNext = jQuery('.lightbox-next');
let lightboxClose = jQuery('.lightbox-close');

jQuery('.liste-photos').on('mouseenter', '.photo-block', function(){
    jQuery(this).find('.photo-content').css('opacity', '1');
});

jQuery('.liste-photos').on('mouseleave', '.photo-block', function(){
    jQuery(this).find('.photo-content').css('opacity', '0');
});

jQuery(lightboxClose).on('click', function(){
    jQuery(lightbox).css('display', 'none');
});

function updateLightbox(index){
    jQuery(lightboxImg).attr('src', images[index]);

    let photoBlock = jQuery('.photo-block').eq(index);
    let categorie = photoBlock.find('.title-cat').text();
    let reference = photoBlock.find('.title-reference').text();
    
    jQuery('.lightbox-categorie').text(categorie);
    jQuery('.lightbox-reference').text(reference);
}

jQuery('.liste-photos').on('click', '.full-screen', function(e){
    e.preventDefault();
    currentIndex = images.indexOf(this.href);
    jQuery(lightbox).css('display', 'block');
    updateLightbox(currentIndex);
});

jQuery(lightboxNext).on('click', function(){
    if(currentIndex < images.length - 1){
        currentIndex++;
    } else{
        currentIndex = 0;
    }

    updateLightbox(currentIndex);
});

jQuery(lightboxPrev).on('click', function(){
    if(currentIndex > 0){
        currentIndex--;
    } else{
        currentIndex = images.length - 1;
    }

    ipdateLightbox(currentIndex);
});

jQuery(document).on('keydown', function(e){
    if(e.key === "ArrowRight"){
        if(currentIndex < images.length - 1){
            currentIndex++;
        } else{
            currentIndex = 0;
        }

        updateLightbox(currentIndex);
    }

    if(e.key === "ArrowLeft"){
        if(currentIndex > 0){
            currentIndex--;
        } else{
            currentIndex = images.length - 1;
        }

        updateLightbox(currentIndex);
    }

    if(e.key === "Escape"){
        jQuery(lightbox).css('display', 'none');
    }
});