$(function ($) {
    "use strict";


    $(document).ready(function () {

        // MODAL LOGIN FORM
        $("#userlogin").on('submit', function (e) {
          var $this = $(this).parent();
          e.preventDefault();
          $this.find('button.submit-btn').prop('disabled', true);
          $this.find('.alert-info').show();
          $('.signin-form .alert-info p').html('Authenticating...');
          $.ajax({
            method: "POST",
            url: $(this).prop('action'),
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
              if ((data.errors)) {
                $this.find('.alert-success').hide();
                $this.find('.alert-info').hide();
                $this.find('.alert-danger').show();
                $this.find('.alert-danger ul').html('');
                for (var error in data.errors) {
                  $('.signin-form .alert-danger p').html(data.errors[error]);
                }
              } else {
                $this.find('.alert-info').hide();
                $this.find('.alert-danger').hide();
                $this.find('.alert-success').show();
                $this.find('.alert-success p').html('Success !');
                if (data == 1) {
                  location.reload();
                } else {
                  window.location = data;
                }

              }
              $this.find('button.submit-btn').prop('disabled', false);
            }

          });

        });
        // MODAL LOGIN FORM ENDS


        $("#registerform").on('submit', function (e) {
          e.preventDefault();
          var $this = $(this).parent();
          $this.find('button.submit-btn').prop('disabled', true);
          $this.find('.alert-info').show();
          $this.find('.alert-info p').html('Processing...');
          $.ajax({
            method: "POST",
            url: $(this).prop('action'),
            data: new FormData(this),
            dataType: 'JSON',
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
              if (data == 1) {
                window.location = mainurl + '/user/dashboard';
                $this.find('.alert-info').hide();
                $this.find('.alert-danger').hide();
                $this.find('.alert-success').show();
                $this.find('.alert-success p').html(data);
                $this.find('button.submit-btn').prop('disabled', false);
              } else {
                if ((data.errors)) {
                  $this.find('.alert-success').hide();
                  $this.find('.alert-info').hide();
                  $this.find('.alert-danger').show();
                  $this.find('.alert-danger ul').html('');
                  for (var error in data.errors) {
                    $this.find('.alert-danger p').html(data.errors[error]);
                  }
                  $this.find('button.submit-btn').prop('disabled', false);
                } else {
                  $this.find('.alert-info').hide();
                  $this.find('.alert-danger').hide();
                  $this.find('.alert-success').show();
                  $this.find('.alert-success p').html(data);
                  $this.find('button.submit-btn').prop('disabled', false);
                }
              }

              $('.refresh_code').click();

            }
          });

        });


    });


// Cart Section
  toastr.options = {
        "debug": false,
        "positionClass": "toast-bottom-center",
        "progressBar" : true,
        "fadeIn": 300,
        "fadeOut": 1000,
        "timeOut": 3000,
        "extendedTimeOut": 200
  }

  $(document).on('click', '.add-to-cart', function() {

      var selectedPack
      if($(this).data('page') == 'listing') {
        // If button is cliked from listing page
         selectedPack = $(this).closest(".product-item").find('.pack-select').find(":selected").val();
      } else {
          if($(this).attr('data-pk') == 'feq'){
            //   alert('ehere');
            selectedPack = $(this).closest(".product-item").find('.pack-select').find(":selected").val();
          }else{
            selectedPack = $('#pack').children("option:selected").val();
          }
      }
      let productId    = $(this).data('product-id');

      $.get(mainurl+`/addcart/${productId}/${selectedPack}`, function(data) {

          data =JSON.parse(data)

          if(data['status'] == 1) {
            // let cartCount = data['data']['cart']['items'].length;
            $(".cart-count").attr('data-count',  data['data']['items_count'] );
            $("#cart-items").load(mainurl+'/carts/view');
		        toastr.success("Product Added to cart");

            var product = data.data.product;

            var cartProduct = data.data.cart.items.find(x => x.id == productId );

            analytics.addToCart(cartProduct);
            console.log('added to cart');
            fbq('track', 'AddToCart');

          }
      });
      return false;
  });

  $(document).on('click', '.add-to-cart-listing', function() {

  });

  $(document).on('click', '.cart-remove', function(){

      var $selector = $(this).data('class');

      var product = $(this).data('product');

      $('.'+$selector).hide();

        $.get( $(this).data('href') , function( data ) {

          data = JSON.parse(data)
          if(data['status'] == 1) {

                // let cartCount = data['data']['cart']['items'].length;
                // console.log(cartCount);
                $(".cart-count").attr('data-count',  data['data']['items_count'] );
                $("#cart-items").load(mainurl+'/carts/view');
                // toastr.success("Product Removed to cart");


                analytics.removeFromCart(product);
          }
        });
    });


    // Pack select change text

    $(document).on('change', '.pack-select', function() {
        let product_id = $(this).data('product-id');
        let pack_id = $(this).find(":selected").val();
        // alert(title);
        // console.log(pack_id);
        var check_det_page = $(this).attr('data-list');
        // alert(check_det_page);
        $.ajax({
          method:'get',
          url: mainurl+"/get_price_and_pack",
          data: {
           product_id,
           pack_id
          }
        }).done((res) => {
          var data = JSON.parse(res);
          if(data['status'] == 1) {
            data = data['data'];
            // console.log($(this).closest('.product-info').find('.pack-price'));
            console.log(data);
            let parent = $(this).closest('.product-item');
            parent.find('.pack-price').text(data['price']);
            parent.find('.pack-name').text(data['pack_title']);


            // update for product detail page
            if(check_det_page == 1)
            {
                $('#pack-price').text(data['price']);
                $('#pack-name').text(data['pack_title']);
            }

            console.log(data['is_product_in_stock']);

            if(data['is_product_in_stock']) {
              $('#in-stock').removeClass('d-none');
              $('#not-in-stock').addClass('d-none');
              parent.find('.in-stock').removeClass('d-none');
              parent.find('.not-in-stock').addClass('d-none');

            } else {
              $('#in-stock').addClass('d-none');
              $('#not-in-stock').removeClass('d-none');
              parent.find('.in-stock').addClass('d-none');
              parent.find('.not-in-stock').removeClass('d-none');
            }

            if(parseInt(data['discount']) != 0 ) {
              parent.find('.pack-discount-price').text(data['price_without_discount']);
            }
          }
        });

    });






  //   // Cart price change on change of qty
  //   $(document).on('change','.change-qty', function() {
  //     let qty     = $(this).val();
  //     let unique_id = $(this).data('unique_id');
  //     // alert($(this).val());

  //     $.get( $(this).data('href') + "?qty="+qty , function( data ) {
  //       var data =JSON.parse(data)
  //       console.log(data);
  //       if(data['status'] == 1) {

  //             let cartCount = data['data']['cart']['items'].length;
  //             console.log(cartCount);
  //             $(".cart-count").attr('data-count',  cartCount )
  //             $("#cart-items").load(mainurl+'/carts/view');
  //             window.location.reload();
  //             // toastr.success("Product Removed to cart");
  //       }
  //     });
  //   });



  //   $(document).on('click','.change-qty-btn', function() {
  //     // alert('clicked');
  //     let unique_id = $(this).data('unique_id');
  //     console.log($('#qty-1243'));
  //     let qty = $('#qty-1234').val();
  //     let urlSubmit = $('#qty['+unique_id+']').data('href');

  //     console.log(unique_id);
  //     console.log(qty);
  //     console.log(urlSubmit);


  //     $.get( urlSubmit + "?qty="+qty , function( data ) {
  //       var data =JSON.parse(data)
  //       console.log(data);
  //       if(data['status'] == 1) {

  //             let cartCount = data['data']['cart']['items'].length;
  //             console.log(cartCount);
  //             $(".cart-count").attr('data-count',  cartCount )
  //             $("#cart-items").load(mainurl+'/carts/view');
  //             window.location.reload();
  //             // toastr.success("Product Removed to cart");
  //       }
  //     });

  // });



    // Remove element from cart list
    $(document).on('click', '.cart-remove-list', function() {
      var $selector = $(this).data('class');
      $('.'+$selector).hide();
        $.get( $(this).data('href') , function( data ) {

          var data =JSON.parse(data)
          console.log(data);
          if(data['status'] == 1) {

                let cartCount = data['data']['cart']['items'].length;
                console.log(cartCount);
                $(".cart-count").attr('data-count',  cartCount )
                $("#cart-items").load(mainurl+'/carts/view');
                // toastr.success("Product Removed to cart");
                window.location.reload();
          }
        });
    });


    $(document).on('click', '.product-clicked', function() {
      var product = $(this).parents('.product-item').first().data('product');
      analytics.productClicked(product);
      return true;
    });


});
