$(document).ready(function(){
    
    // AJAX function for å slette varer fra handleliste
    $('.delete').click(function(){
        var el = this;
        var deleteid = this.id;

        // AJAX Request
        $.ajax({
        url: 'includes/delete_item.php',
        type: 'POST',
        data: { id:deleteid },
            success: function(response){
                $(el).parent().remove();
                writeFullPrice();
            }
        });
    }); //end delete

    //AJAX funksjon for å øke antall av vare
    $('.plus').click(function(){
        var input_n = $(this).nextAll('input');
        var number = input_n.val();
        number++;
        $(input_n).val(number);

        var newnumber = $(this).nextAll('input').val();
        var itemCartId = this.id;
        console.log(newnumber);

        $.ajax({
            url: 'includes/update_count.php',
            type: 'POST',
            data: { 'item_cart_id': itemCartId, 'newnumber': newnumber},
            success: function(response){
                document.location.reload(true)
            }
        });
    });

    //AJAX funksjon for å minske antall av vare
    //Funksjonen passer på at antall ikke er mindre enn 1
    $('.minus').click(function(){
        var input_n = $(this).prevAll('input');
        var number = input_n.val();
        number--;
        if(number > 1) {
            $(input_n).val(number); 
        } else {
            number = 1;
            $(input_n).val(number);
        }

        var newnumber = $(this).prevAll('input').val();
        var itemCartId = this.id;
        console.log(number);

        $.ajax({
            url: 'includes/update_count.php',
            type: 'POST',
            data: { 'item_cart_id': itemCartId, 'newnumber': newnumber},
            success: function(response){
                document.location.reload(true)
            }
        });
    });

    //AJAX funksjon for å legge til vare fra vareutvalg
    $('.addToCart').click(function(){
        var item = $(this).prev().prev().prev().val();
        var prefix = $(this).prev().prev().val();
        var buttonDiv = $(this).prev();
        var buttonVal = buttonDiv.val();
        $.ajax({
            url: 'includes/add_from_cart.php',
            type: 'POST', 
            data: { 'item': item, 'prefix': prefix, 'choose_button': buttonVal },
            success: function(response) {
                $('.add_to_cart').fadeOut();
            }
        });
    });

    //AJAX funksjon for å lagre endringer på innstillinger av knapp
    $('.save_edits').click(function(){
        var buttonID = $('#buttonID').val();
        var buttonName = $('#buttonName').val();
        var prefix = $('#prefix').val();
        var pushNotif = $('#pushNotif').val();
        var deliveryTime = $('#delivTime').val();;
        console.log(deliveryTime);

        $.ajax({
            url: 'includes/update_button_new.php',
            type: 'POST',
            data: {'button_id': buttonID, 'button_name': buttonName, 'prefix': prefix, 'push_notif': pushNotif, 'delivery_time': deliveryTime },
            success: function(response) {
                window.location.href = 'user.php?button_id=0';
            }
        });
    });

    //Funksjon for å legge sammen totalsum av varer
    //Passer også på at det er to desimaler i float
    function writeFullPrice() {
        var fullPrice = 0;
        var newfullPrice;
        $('.prices').each(function(i, el) {
            x = $(el).html();
            y = parseFloat(x);
            fullPrice += y;
            newfullPrice = fullPrice.toFixed(2);
         });
         if(fullPrice == 0) {
            $('.price_span').html('0.00');
         } else {
            $('.price_span').html(newfullPrice);
         }
        }
    
    writeFullPrice(); //Kaller på funksjonen writeFullPrice
});