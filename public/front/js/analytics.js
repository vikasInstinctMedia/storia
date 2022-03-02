
/**
 * product click,   -done
 * product details, -done
 * add to cart      -done
 * remove from cart --done
 * checkout         -done
 * purchase         -done
 */
const analytics = {
    /**
     * A function to handle a click on a checkout button. This function uses the eventCallback
     * data layer variable to handle navigation after the ecommerce data has been sent to Google Analytics.
     */
    onCheckout: function (cartProducts) {

        // console.log(cartProducts);
        console.log('Google event: checkout');

        let products = cartProducts.map(product => {
            const { id, name, price, quantity } = product;
            return { id, name, price, quantity };
        });

        // console.log(products);

        dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
        dataLayer.push({
            'event': 'checkout',
            'ecommerce': {
                'checkout': {
                    'actionField': { 'step': 1, 'option': 'Visa' },
                    'products': products
                }
            },
            'eventCallback': function () {
                // document.location = 'checkout.html';
            }
        });



    },

    /**
     * When user clicks on particular product
     */
    productClicked: function (product) {
        console.log('Google event: clicked');
        // dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
        dataLayer.push({
            'event': 'productClick',
            'ecommerce': {
                'click': {
                    'actionField': { 'list': 'Click On Product' },      // Optional list property.
                    'products': [{
                        'name': product.name + ' ' + product.base_pack.details.title,                      // Name or ID is required.
                        'id': product.base_pack.id,
                        'price': product.base_pack_price,
                        // 'brand': productObj.brand,
                        // 'category': productObj.cat,
                        // 'variant': productObj.variant,
                        // 'position': productObj.position
                    }]
                }
            },
            'eventCallback': function () {
                // document.location = productObj.url
            }
        });
    },
    /**
     * When user lands on details page
     */
    productDetailsImpression: function (product) {
        console.log('Google event: impression');

        dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
        dataLayer.push({
            'ecommerce': {
                'detail': {
                    'actionField': { 'list': 'product list' },    // 'detail' actions have an optional list property.
                    'products': [{
                        'name': product.name,         // Name or ID is required.
                        'id': product.pack_id,
                        'price': product.pack_price,
                        // 'brand': 'Google',
                        // 'category': 'Apparel',
                        // 'variant': 'Gray'
                    }]
                }
            }
        });
    },

    /**
     * Add to cart event
     */
    addToCart: function (product) {

        console.log('Google event: add cart');

        dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
        dataLayer.push({
            'event': 'addToCart',
            'ecommerce': {
                'currencyCode': 'INR',
                'add': {                                // 'add' actionFieldObject measures.
                    'products': [{                        //  adding a product to a shopping cart.
                        'name': product.name,
                        'id': product.pack_id,
                        'price': product.product_total,
                        // 'brand': 'Google',
                        // 'category': 'Apparel',
                        // 'variant': 'Gray',
                        'quantity': product.quantity
                    }]
                }
            }
        });
    },

    /**
     * Remove from cart event
     */
    removeFromCart: function (product) {

        console.log('Google event: remove cart');

        dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
        dataLayer.push({
            'event': 'removeFromCart',
            'ecommerce': {
                'remove': {                               // 'remove' actionFieldObject measures.
                    'products': [{                          //  removing a product to a shopping cart.
                        'name': product.name,
                        'id': product.pack_id,
                        'price': product.product_total,
                        // 'brand': 'Google',
                        // 'category': 'Apparel',
                        // 'variant': 'Gray',
                        'quantity': product.quantity
                    }]
                }
            }
        });
    },


    /**
     * On the checkout page when order is created
     */
    checkoutCompleted: function (cartOrder) {

        console.log('Google event: purchase');
        var cartProducts = cartOrder.items;
        // console.log(cartProducts);

        let products = cartProducts.map(product => {
            const { id, name, price, quantity } = product;
            return { id, name, price, quantity };
        });

        // console.log(products);
        dataLayer.push({ ecommerce: null });
        dataLayer.push({
            // 'event': 'ecomm_event',
            // 'transactionId': cartOrder.orderNumber, // Transaction ID - this is normally generated by your system.
            // 'transactionAffiliation': cartOrder.branchName, // Affiliation or store name
            // 'transactionTotal': cartOrder.total, // Grand Total
            // 'transactionTax': '0',
            // 'transactionShipping': '0', // Shipping cost
            // 'transactionProducts': products,
            'event': 'purchase',
            'transaction_id': cartOrder.orderNumber, // Transaction ID - this is normally generated by your system.
            'affiliation': cartOrder.branchName, // Affiliation or store name
            'value': cartOrder.total, // Grand Total
            'currency' : 'INR',
            'tax': '0',
            'shipping': '0', // Shipping cost
            'items': products,
        });
    }


}
