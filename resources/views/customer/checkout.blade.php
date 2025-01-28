<div class="card">
    <div class="card-body">
        <form action="{{ route('customer.order') }}" method="POST" id="order-frm">
            @csrf
            <div class="form-outline mt-3">
                <input class="form-control active" type="text" name="name"
                       value="{{ auth('web')->user()->name }}" id="example-name" required>
                <label for="example-name" class="form-label">Your Name</label>
            </div>

            <!-- Contact Phone -->
            <div class="row mt-3">
                <div class="col">
                    <div class="form-outline">
                        <input class="form-control active" type="tel" name="phone"
                               value="{{ auth('web')->user()->phone }}" id="example-phone" required>
                        <label for="example-phone" class="form-label">Contact Phone</label>
                    </div>
                </div>
                <div class="col">
                    <div class="form-outline">
                        <input class="form-control active" type="email" name="email"
                               value="{{ auth('web')->user()->email }}" id="example-email" required>
                        <label for="example-email" class="form-label">Contact Email</label>
                    </div>
                </div>
            </div>

            <!-- Delivery Address -->
            <div class="form-outline mt-3">
                <input class="form-control active" type="text" name="address" id="example-address" required>
                <label for="example-address" class="form-label">Delivery Address</label>
            </div>

            <!-- Payment Method -->
            <div class="form-outline m-2">
                <label class="form-label">Payment Method: </label>
                <div class="form-check-inline">
                    <input class="form-check-input" type="radio" name="payment_method"
                           id="radio_cod" value="cod" checked required>
                    <label class="form-check-label" for="radio_cod">Cash On Delivery</label>
                </div>
                <div class="form-check-inline">
                    <input class="form-check-input" type="radio" name="payment_method"
                           id="radio_paypal" value="paypal">
                    <label class="form-check-label" for="radio_paypal">PayPal/Credit Card</label>
                </div>
            </div>

            <!-- Dynamic Payment Details -->
            <div id="payment-details" class="mt-3" style="display: none;">
                <!-- PayPal Email -->
                <div id="paypal-details" style="display: none;">
                    <div class="form-group text-center">
                        <span id="paypal-button" ></span>
                    </div>
                </div>

                <!-- Credit/Debit Card Details -->
            </div>

            <!-- Submit Button -->
            <p>
                <input type="submit" value="Save" name="submit" class="btn theme-btn">
            </p>
        </form>
    </div>
</div>

<style>
    #uni_modal .modal-footer {
        display: none;
    }
</style>

<script>
    const paymentMethods = document.getElementsByName('payment_method');
    const paymentDetails = document.getElementById('payment-details');
    const paypalDetails = document.getElementById('paypal-details');

    paymentMethods.forEach(method => {
        method.addEventListener('change', function () {
            paymentDetails.style.display = 'none';
            paypalDetails.style.display = 'none';

            if (this.value === 'paypal') {
                paymentDetails.style.display = 'block';
                paypalDetails.style.display = 'block';
            }
        });
    });
    paypal.Button.render({
        env: 'sandbox', // change for production if app is live,

        //app's client id's
        client: {
            // for test only
            sandbox:    'AdDNu0ZwC3bqzdjiiQlmQ4BRJsOarwyMVD_L4YQPrQm4ASuBg4bV5ZoH-uveg8K_l9JLCmipuiKt4fxn',
            // for live only
            //production: 'AaBHKJFEej4V6yaArjzSx9cuf-UYesQYKqynQVCdBlKuZKawDDzFyuQdidPOBSGEhWaNQnnvfzuFB9SM'
        },

        commit: true, // Show a 'Pay Now' button

        style: {
            layout:  'vertical',
            color:   'blue',
            shape:   'rect',
            label:   'paypal'
        },

        payment: function(data, actions) {
            return actions.payment.create({
                payment: {
                    transactions: [
                        {
                            //total purchase
                            amount: {
                                total: {{$total}},
                                currency: 'PHP'
                            }
                        }
                    ]
                }
            });
        },

        onAuthorize: function(data, actions) {
            return actions.payment.execute().then(function(payment) {
                // //sweetalert for successful transaction
                // swal('Thank you!', 'Paypal purchase successful.', 'success');
                console.log(data)
                console.log(payment)
                var tracking_code = data.paymentID;
                $('fieldset#pay-field').find('[name="payment_code"]').val(tracking_code)
                $('#transaction_form').submit();
            });
        },
        onError: (err) => {
            console.error('error from the onError callback', err);
            notify('error',err)
        }

    }, '#paypal-button');


</script>
