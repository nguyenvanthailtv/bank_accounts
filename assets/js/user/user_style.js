$(document).ready(function() {

    $('.create-new-user').click(function() {
        $('.user-impacts').addClass('active');
    })

    $('.update-user').click(function() {
        $('.user-impacts').addClass('active');
    })
    const listForminput = document.querySelectorAll('.insert-form__input.insert-fonm__list');
    listForminput.forEach((input)=>{
        var label = $(input).find('.label');
        var inputhidden = $(input).find('.input--hidden');
        var listWrapper = $(input).find('.list-wrapper');
        var icon =$(input).find('.icon');
        
        $(label).click(function(){
            $(this).addClass('active');
            $(icon).addClass('active');
            $(listWrapper).slideDown();
            const listitem = $(listWrapper).find('li');
            
            for(let item = 0 ; item < listitem.length ; item++){

                $(listitem[item]).click(function(){
                    value = listitem[item].textContent
                    $(inputhidden).val(value);
                    $(listWrapper).slideUp();
                    $(icon).removeClass('active');
                    $(label).html(value);
                })
            }
            
        })
    })

    $('.btn--close').click(function(){
        $('.user-impacts').removeClass('active');
    })
})