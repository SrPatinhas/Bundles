 <script>
  $(function() {
    $( "#slider-range-min" ).slider({
        range: "min",
        step: 0.10,
        value: 3,
        min: 1,
        max: 50,
        slide: function( event, ui ) {
            
            var value = 0;

            if( ui.value <= 50 / 3 ) {
                value = parseFloat( 12/47 * ui.value + 35 / 47 ).toFixed(2);

            } else if( ui.value > (100/3) ) {
                value = parseFloat( ui.value * 2.4 - 70 ).toFixed(2);

            } else {
                value = parseFloat( ui.value * 0.3 ).toFixed(2);
            }

            $( "#price" ).val( '€ ' + value );
        }
    });
    $( "#price" ).val( "€" + $( "#slider-range-min" ).slider( "value" ) );
    $("#gift").click(function(){
        if( $(this).is(':checked') ) {
            $(".giftbox").slideDown();
        } else {
            $(".giftbox").slideUp();
            $(".giftbox input").val('');
        }
    });
    $('#btn_pay').click(function() {   
        $('#buy_cart').animate({width:'toggle'},350);
    });
  });
  </script>
 
 
            <div id="paymentoptions">
                      
                    <form id="paypal_sent" method="post" action="/users/payment_handler" target="_top">
                        <div id="topPayment">
                            <a id="buy"><h2>Payment Options</h2></a>
                        </div>
                        <div id="slider">
                            <div id="slider-range-min" class="ui-slider ui-slider-horizontal ui-widget ui-widget-content ui-corner-all" aria-disabled="false">
                              <div class="ui-slider-range ui-widget-header ui-corner-all ui-slider-range-min"></div>
                              <a class="ui-slider-handle ui-state-default ui-corner-all" href="#"></a>
                            </div>
                            <span>ENTER YOUR OWN:</span>
                            <input type="text" id="price" name="amount" style="font-weight: bold;">
                        </div>

                        <div id="wallet" class="payment_option">
                            <input id="radio_wallet" type="radio" name="payment" value="wallet">
                            <label for="radio_wallet"><img src="public/img/wallet-logo.gif"></label>
                        </div>
                        
                                                <div id="paypal" class="payment_option">
                            <input id="radio_paypal" type="radio" name="payment" value="paypal">
                            <label for="radio_paypal"><img src="public/img/paypal-logo.gif"></label>
                        </div>
                        <div class="emailbox">
                            <input type="text" name="email" value="" placeholder="E-MAIL">
                        </div>
                        <div id="loginsignup">
                            <span>LOGIN</span>
                            <a href="/users/login" class="modal" data-width="619" data-height="899">
                                HERE
                            </a>
                            <span> OR</span>
                            <a href="/users/register" class="modal" data-width="619" data-height="899">
                                REGISTER NOW
                            </a>
                        </div>


                        <div id="makeitgift">
                            <input type="checkbox" name="gift" id="gift"> <label for="gift"><span>Make it a Gift</span><span class="icon-gift"></span></label>
                        </div>
                        <div class="emailbox giftbox">
                            <input type="text" name="friend" placeholder="FRIEND'S E-MAIL">
                        </div>

                        
                        <div id="buybundle">
                            <div class="buybundlebtn">
                                <input name="submit" type="submit" value="BUY BUNDLE">
                            </div>
                        </div>
                    </form>
                </div>