$(document).ready(function() {
    console.log('aaaaa');
    // create roles
    $('.create-new-roles').click(function() {
        $('.roles-impacts').addClass('active');
    })

    // update roles
    $('.update-roles').click(function() {
        $('.roles-impacts').addClass('active');
    })

    $('.btn--close').click(function(){
        $('.roles-impacts').removeClass('active');
    })

    const listForminput = document.querySelectorAll('.insert-form__input');
    listForminput.forEach((input)=>{
        var label = $(input).find('.label');
        var label2 = $(input).find('.input--hidden');
        var listWrapper = $(input).find('.list-wrapper');
        var icon =$(input).find('.icon');
        let value = '';
        
        $(label).click(function(){
            $(this).addClass('active');
            $(icon).addClass('active');
            $(listWrapper).slideDown();
            const listitem = $(listWrapper).find('li');
            
            for(let item = 0 ; item < listitem.length ; item++){

                $(listitem[item]).click(function(){
                    value = listitem[item].textContent
                    $(label2).val(value);
                    $(listWrapper).slideUp();
                    $(icon).removeClass('active');
                    $(label).html(value);
                })
            }
            
        })
    })
})




