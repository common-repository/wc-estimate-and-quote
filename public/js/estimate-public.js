(function ($) {
  //'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */
  jQuery(document).ready(function ($) {


    $(document).on('click', '#estimateInsert', function (e) {
      e.preventDefault();
      var userId = $('#userId').val();
      var estimateName = $('#estimateName').val();
      var description = $('#description').val();
      var userName = $('#UserName').val();
      var userEmail = $('#UserEmail').val();
      var userContact = $('#UserContact').val();
      var userContactPerson = $('#UserContactPerson').val();
      var userAddress = $('#UserAddress').val();

      var data = {
        'action': 'estimate_insert',
        'userId': userId,
        'estimateName': estimateName,
        'description': description,
        'userName': userName,
        'userEmail': userEmail,
        'userContact': userContact,
        'userContactPerson': userContactPerson,
        'userAddress': userAddress,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response);
        if (response) {
          //  console.log(base_url + '/estimate?estimate-id=' + response);
          //  $('.estimateForm').fadeOut();
          window.location = base_url + '/estimate?estimate-id=' + response;
          // $('.estimateDetails').fadeIn();
        }

      });
    });
    $(document).on('click', '#estimateEdit', function (e) {
      e.preventDefault();
      var estimateId = $('#estimateIdEdit').val();
      var estimateName = $('#estimateNameEdit').val();
      var description = $('#descriptionEdit').val();
      var userName = $('#UserNameEdit').val();
      var userEmail = $('#UserEmailEdit').val();
      var userContact = $('#UserContactEdit').val();
      var userContactPerson = $('#UserContactPersonEdit').val();
      var userAddress = $('#UserAddressEdit').val();

      var data = {
        'action': 'estimate_edit',
        'estimateId': estimateId,
        'estimateName': estimateName,
        'description': description,
        'userName': userName,
        'userEmail': userEmail,
        'userContact': userContact,
        'userContactPerson': userContactPerson,
        'userAddress': userAddress,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response);
        if (response) {
          //  console.log(base_url + '/estimate?estimate-id=' + response);
          //  $('.estimateForm').fadeOut();
          window.location = base_url + '/estimate?estimate-id=' + response;
          // $('.estimateDetails').fadeIn();
        }

      });
    });

    $(document).on('click', '.estimateDelete', function (e) {
      e.preventDefault();
      // var userId = $('#userId').val(); 
      var id = $(this).attr("data-id");
      var nonce = $(this).attr("data-nonce");
      var $tr = $(this).closest('tr');

      var data = {
        'action': 'estimate_delete',
        'nonce': nonce,
        'estimateId': id,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response);
        if (response) {
          $tr.find('td').fadeOut(1000, function () {
            $tr.remove();
          });
        }

      });
    });

    $(document).on('click', '.add_list', function (e) {
      e.preventDefault();
      // var userId = $('#userId').val(); 
      var id = $(this).attr("data-id");
      var estimateId = $(this).attr("data-estimateId");
      // var nonce = $(this).attr("data-nonce");
      var $tr = $(this).closest('tr');

      var data = {
        'action': 'product_get_by_id',
        'productID': id,
        'estimateId': estimateId,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response);
        if (response) {
          $('.productListBody').html(response);
        }

      });
    });


    $(document).on('click', '.remove-product', function (e) {
      e.preventDefault();
      // var userId = $('#userId').val(); 
      var id = $(this).attr("data-id");
      var productId = $(this).attr("data-productId");
      var estimateId = $(this).attr("data-estimateId");
      var nonce = $(this).attr("data-nonce");
      var $tr = $(this).closest('.product');

      var data = {
        'action': 'estimate_product_delete',
        'nonce': nonce,
        'id': id,
        'estimateId': estimateId,
        'productId': productId,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response);
        if (response) {
          $tr.find('.product-removal').fadeOut(1000, function () {
            $tr.remove();
          });
        }

      });
    });



    $("#checkAll").click(function () {
      $('input:checkbox').not(this).prop('checked', this.checked);
    });

    $('#btn_delete').click(function (e) {
      e.preventDefault();

      var id = [];
      $(':checkbox:checked').each(function (i) {
        id[i] = $(this).val();
      });

      if (id.length === 0) //tell you if the array is empty
      {
        alert("Please Select atleast one checkbox");
      }
      
      else {
        if (confirm("Are you sure?")) {
          // your deletion code
     
        var $div = $(this).closest('.estimate-cart').find('.card-body').find('.product');
        var data = {
          'action': 'estimate_product_multiple_delete',
          'id': id,
        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajax_object.ajax_url, data, function (response) {
          // alert('Got this from the server: ' + response);
          if (response) {
            console.log(id);
            for (var i = 0; i < id.length; i++) {
              $('#remove' + id[i]).fadeOut(1000, function () {
                $(this).remove();
                window.location.reload();
              });
            }
          }

        });
      }
      return false; 
      }
    });



    $('#btn_convert').click(function (e) {
      e.preventDefault();

      var id = [];
      $(':checkbox:checked').each(function (i) {
        id[i] = $(this).val();
      });

      if (id.length === 0) //tell you if the array is empty
      {
        alert("Please Select atleast one checkbox");
      }
      else {
        var $div = $(this).closest('.estimate-cart').find('.card-body').find('.product');
        var data = {
          'action': 'estimate_product_converToCart',
          'id': id,
        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajax_object.ajax_url, data, function (response) {
          // alert('Got this from the server: ' + response);
          if (response) {
             // window.location.reload();
             window.location = base_url +'/cart';
           }

        });

      }
    }); 


    $('#estimate_clone').click(function (e) {
      e.preventDefault(); 

       var id = $(this).data('id');

         var data = {
          'action': 'estimate_clone',
          'id': id,
        };
        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
        jQuery.post(ajax_object.ajax_url, data, function (response) {
          // alert('Got this from the server: ' + response);
          if (response) {
             // window.location.reload();
             window.location = base_url +'/estimate?estimate-id=' + response;
           }

        });

     }); 



  $('#btn_export_csv').click(function (e) {
    e.preventDefault();

    var estimateId = $(this).data('id');

    var id = [];
    $(':checkbox:checked').each(function (i) {
      id[i] = $(this).val();
    });

    if (id.length === 0) //tell you if the array is empty
    {
      alert("Please Select at-least one checkbox");
    }
    else {
      var $div = $(this).closest('.estimate-cart').find('.card-body').find('.product');
      var data = {
        'action': 'wc_estimate_product_Export_CSV',
        'estimateId': estimateId,
        'id': id,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response);
        if (response) {
           // window.location.reload();
            window.location = plugin_url +'/includes/assets/estimate.csv';
         }

      });

    }
  }); 
  $('#btn_export_pdf').click(function (e) {
    e.preventDefault();

   var estimateId = $(this).data('id');

    var id = [];
    $(':checkbox:checked').each(function (i) {
      id[i] = $(this).val();
    });

    if (id.length === 0) //tell you if the array is empty
    {
      alert("Please Select at-least one checkbox");
    }
    else {
      var $div = $(this).closest('.estimate-cart').find('.card-body').find('.product');
      var data = {
        'action': 'estimate_product_Export_as_Pdf',
        'estimateId': estimateId, 
        'id': id,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response);
        if (response) {
          //  window.location.reload();
            // window.location = plugin_url +'/includes/assets/estimate.pdf';
            window.open(plugin_url +'/includes/assets/estimate.pdf', '_blank');
         }

      });

    }
  }); 

  $('#wc_btn_email').click(function (e) {
    e.preventDefault();

    var id = [];
    $(':checkbox:checked').each(function (i) {
      id[i] = $(this).val();
    });

    if (id.length === 0) //tell you if the array is empty
    {
      alert("Please Select atleast one checkbox");
    }
    else {
      var $div = $(this).closest('.estimate-cart').find('.card-body').find('.product');
      var data = {
        'action': 'wc_estimate_product_CSVEmail',
        'id': id,
      };
      // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
      jQuery.post(ajax_object.ajax_url, data, function (response) {
        // alert('Got this from the server: ' + response); 

      });

    }
  }); 

  
});



-$(document).ready(function() {
   
      /* Set rates + misc */
        var taxRate = 0.05;
        var shippingRate = 0.00; 
        var fadeTime = 300;

         /* Assign actions */
-    $(document).on('change','.product-quantity input', function() {
  -      updateQuantity(this);
         updateQtyByajax(this);
        });
     $(document).on('click','.product-removal a', function() {
               removeItem(this);
      });
      function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
      // return  Number(nStr).toLocaleString('en');
    } 
        /* Recalculate cart */
    function recalculateCart()
     {
       var subtotal = 0;
       var subtotaltax = 0;
       
      /* Sum up row totals */
      $('.product').each(function () {
         var $price = parseFloat($(this).children('.product-line-price').text().replace(/,/g, ''));  
        //  console.log($price); 
        //  var $subtax = parseFloat($(this).children('.sub-tax-amount').val().replace(',','')); 
         var $subtax = $(this).children('.sub-tax-amount').val();  
        //  console.log($price); 
        //  parseInt($(this).html().replace(',',''));

        if(typeof $subtax !== "undefined"){
         var $getTax = $subtax.replace(/,/g, ''); 
        //  console.log($getTax);

          if($.isNumeric( $getTax ) != false){
            subtotaltax += parseFloat($getTax); 
             
          }
        }

         if($.isNumeric( $price ) != false){
          
          // var getPrice =  $price.replace(',','');
           subtotal += $price;
          //  console.log(subtotal); 
          }
        
          
       });
     

      //  console.log(subtotaltax);
       /* Calculate totals */
      // var tax = subtotal * taxRate;
      // var tax = subtotaltax * subtotaltax;
      var shipping = (subtotal > 0 ? shippingRate : 0);
      var total = subtotal + subtotaltax + shipping;
      var subtotalPrice = subtotal.toFixed(2);
      var subtotalPriceFormating = addCommas(subtotalPrice);
      /* Update totals display */
      $('.totals-value').fadeOut(fadeTime, function() {
        $('#cart-subtotal').html(subtotalPriceFormating);
        $('#cart-tax').html(addCommas(subtotaltax.toFixed(2)));
        $('#cart-shipping').html(shipping.toFixed(2));
        $('#cart-total').html(addCommas(total.toFixed(2)));
        if(total == 0){
          $('.checkout').fadeOut(fadeTime);
        }else{
          $('.checkout').fadeIn(fadeTime);
        }
        $('.totals-value').fadeIn(fadeTime); 
      });
    }
  /* Update quantity */
  function updateQuantity(quantityInput)
  {
    /* Calculate line price */
    var productRow = $(quantityInput).parent().parent();
    var price = parseFloat(productRow.children('.product-price').text().replace(/,/g, ''));
    var $tax = parseFloat(productRow.children('.tax-amount').val()); 
    var quantity = $(quantityInput).val(); 
    var linePrice = price * quantity;
    var Subtotaltax = quantity * $tax;
     console.log('tax' + $tax);
     var singlePrice = addCommas(linePrice.toFixed(2));
     
    /* Update line price display and recalc cart totals */
    productRow.children('.product-line-price').each(function () {
      $(this).fadeOut(fadeTime, function() {
        $(this).text(singlePrice);
        $(this).find('.sub-tax-amount').val(Subtotaltax); 
        recalculateCart(); 
        $(this).fadeIn(fadeTime);
      });
    });  
    /* Update line price display and recalc cart totals */
    productRow.children('.sub-tax-amount').each(function () {
      $(this).fadeOut(fadeTime, function() {
         $(this).val(Subtotaltax); 
        recalculateCart(); 
        $(this).fadeIn(fadeTime);
      });
    });  
  }

  function updateQtyByajax(quantityInput){ 
    /* Calculate line price */
    var productRow = $(quantityInput).parent().parent();
    var price = parseFloat(productRow.children('.product-price').text().replace(/,/g, ''));
    var id = $(quantityInput).data('id');
    var quantity = $(quantityInput).val(); 
    var linePrice = price * quantity;

    var data = {
      'action': 'estimate_product_updateByQty',
      'id': id,
      'quantity': quantity,
      'totalPrice': linePrice,
    };
    // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
    jQuery.post(ajax_object.ajax_url, data, function (response) {
      // alert('Got this from the server: ' + response);
      if (response) {
         // window.location.reload();
        }

    });
  }

   /* Remove item from cart */
   function removeItem(removeButton)
    {
      /* Remove row from DOM and recalc cart total */
      var productRow = $(removeButton).parent().parent();
      productRow.slideUp(fadeTime, function() {
        productRow.remove();
        recalculateCart();
      });
    }      

  
});

   	// AJAX call for autocomplete  
	jQuery(document).on("keyup",".innovs-pe-product-search",function(){
  		var datas = {
			'action': 'product_search',
			'keyword': $(this).val(), 
      }; 
  jQuery.ajax({
		type: "POST",
		url: ajax_object.ajax_url,
		data:datas,
		beforeSend: function(){
			jQuery(".innovs-pe-product-search").css("background","#FFF url(LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
      console.log(data);
      jQuery(".innovs-pe-suggestion-box").show();
      jQuery(".innovs-pe-suggestion-box").html(data);
      jQuery(".innovs-pe-product-search").css("background","#FFF");
			}
		});
	}); 
//To select country name
function selectCountry(val) {
  jQuery(".innovs-pe-product-search").val(val);
  jQuery(".suggesstion-box").hide();
} 

// Insert quote form data

$(document).on('click', '#insert_qoute', function (e) {
  e.preventDefault();
  var quote_f_name = $('#quote_f_name').val();
  var quote_l_name = $('#quote_l_name').val();
  var qoute_email = $('#qoute_email').val();
  var qoute_area_code = $('#qoute_area_code').val();
  var qoute_pn = $('#qoute_pn').val();
  var qoute_add_1 = $('#qoute_add_1').val();
  var qoute_add_2 = $('#qoute_add_2').val();
  var qoute_city = $('#qoute_city').val();
  var qoute_state = $('#qoute_state').val();
  var qoute_post_code = $('#qoute_post_code').val();
  var qoute_country = $('#qoute_country').val();
  var qoute_product = $('#qoute_product').val();
  var qoute_quantity = $('#qoute_quantity').val();
  var qoute_add_info = $('#qoute_add_info').val();


  var data = {
    'action': 'qoute_insert',
    'quote_f_name': quote_f_name,
    'quote_l_name': quote_l_name,
    'qoute_email': qoute_email,
    'qoute_area_code': qoute_area_code,
    'qoute_pn': qoute_pn,
    'qoute_add_1': qoute_add_1,
    'qoute_add_2': qoute_add_2,
    'qoute_city': qoute_city,
    'qoute_state': qoute_state,
    'qoute_post_code': qoute_post_code,
    'qoute_country': qoute_country,
    'qoute_product': qoute_product,
    'qoute_quantity': qoute_quantity,
    'qoute_add_info': qoute_add_info,
  };
  // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
  jQuery.post(ajax_object.ajax_url, data, function (response) {
    // alert('Got this from the server: ' + response);
    if (response) {
      //  console.log(base_url + '/estimate?estimate-id=' + response);
      //  $('.estimateForm').fadeOut();
      //window.location = base_url + '/estimate?estimate-id=' + response;
       window.location = base_url + '/estimate_quote';
      // $('.estimateDetails').fadeIn();
    }

  });
});

// Insert quote form data

$(document).on('click', '#pe_quote_send_btn', function (e) {
  e.preventDefault();
  var estimate_id = $('#estimate_id').val();
  var pe_quote_price = $('#pe_quote_price').val();
  var pe_quote_desc = $('#pe_quote_desc').val();


  var data = {
    'action': 'send_quote',
    'estimate_id': estimate_id,
    'pe_quote_price': pe_quote_price,
    'pe_quote_desc': pe_quote_desc,
  };
  // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
  jQuery.post(ajax_object.ajax_url, data, function (response) {
    // alert('Got this from the server: ' + response);
    if (response) {
      //  console.log(base_url + '/estimate?estimate-id=' + response);
      //  $('.estimateForm').fadeOut();
      //window.location = base_url + '/estimate?estimate-id=' + response;
       //window.location = base_url + '/estimate_quote';
      // $('.estimateDetails').fadeIn();
    }

  });
});




// Showing quote form
$(document).ready(function(){
  $("#btn_quote").click(function(){
    $(".pe-quote-input").show();
  });
 
});

})(jQuery);
