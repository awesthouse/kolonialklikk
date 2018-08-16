(function() {
    $(document).ready(function() {

        //VISER/GJEMMER LEGG TIL VARE DIV I VAREUTVALG
        $('.add').click(function() {
            $(this).nextAll('.add_to_cart').fadeToggle();
        });

        //FUNKSJON FOR Å LUKKE LEGG TIL VARE DIV I VAREUTVALG
        $('.closeadd').click(function() {
            $(this).parent().parent().fadeToggle();
        })

        //FUNKSJON FOR Å ÅPNE HANDLEKURV FOR KNAPP, PUSHER BUTTON ID TIL URL
        //SLIK AT DEN KAN HENTES MED GET FUNKSJON I PHP
        $('.opencart').click(function() {
            var btnclicked = this.id;
            var urladd = '?button_id=' + btnclicked;
            //$('#whichcart').html(btnclicked);
            history.pushState(null, '', urladd);
            $('.cartcontainer').load('cart.php');
            document.location.reload(true);
        });

        //FUNKSJON SOM LEGGER TIL HOVERFUNKSJON TIL NAVIGASJONS-ELEMENTER
        $('.titles').append('<span class="hoverover"></span>');

        //FUNKSJON SOM LEGGER VAREN DU TRYKKER PÅ I SØKEBOKSEN SOM INPUT VALUE FOR SØKEBAREN
        $(document).on("click", ".result div", function(){
            $(this).parents(".search-box").find('input[type="text"]').val($(this).find('#name').text());
            var itemID = $(this).children(".itemId").val();
            $("#itemID").attr('value', itemID);
            $(this).parent(".result").empty();
        });

        //SELVE SØKEFUNKSJONEN
        $('.search-box input[type="text"]').on("keyup input", function(){
            var inputVal = $(this).val();
            var resultDropdown = $(this).siblings(".result");
            if(inputVal.length){
                $.get("backend-search.php", {term: inputVal}).done(function(data){
                    resultDropdown.html(data);
                });
            } else{
                resultDropdown.empty();
            }
        });
        
    });

})();