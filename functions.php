<?php

// add this to functions.php
add_action('woocommerce_after_single_product','custom_woocommerce_additional_variation_images');

function custom_woocommerce_additional_variation_images(){
    ?>
    <script type="text/javascript">
   (function($) {
        $(window).load(function(){
            // alert('test');
            $( "a.swatch-anchor").click(function() {
                //console.log(variation);
                var atts = $(this).parent().attr('data-value');
                var product_variations = $('form.variations_form').data('product_variations');           
                var variation_id= '';
                    for ( var i = 0; i < product_variations.length; i++ ) {
                        var variation    = product_variations[i];
                            if( product_variations[i].attributes.attribute_pa_color == atts){
                                    variation_id = product_variations[i].variation_id;
                            }
                    }

                console.log(variation_id);
               
                var data = {
                    security: wc_additional_variation_images_local.ajaxImageSwapNonce,
                    variation_id: variation_id,
                    post_id: $( 'form.variations_form' ).data( 'product_id' )
                };
                $.ajax({
                  type: "POST",
                  url: $.wc_additional_variation_images_frontend.getAjaxURL( 'get_images' ),
                  data: data,
                  cache: false,
                  success: function(data,response){                  
                      data = $.parseJSON(data);
                      console.log(data['main_images']);
                      $('.woocommerce-product-gallery').replaceWith(data['main_images']);

                  },
                  
                });

            });
        })

    })(jQuery);
</script>
<?php 
}

add_filter( 'wc_additional_variation_images_custom_swap', '__return_true');
add_filter( 'wc_additional_variation_images_custom_reset_swap', '__return_true' );
add_filter( 'wc_additional_variation_images_custom_original_swap', '__return_true' );
add_filter( 'wc_additional_variation_images_get_first_image', '__return_true' );