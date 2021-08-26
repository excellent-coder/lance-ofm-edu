const makePayment = (
    public_key,
    tx_ref,
    amount,
    currency = "NGN",
    country = 'NG',
    redirect_url,
    meta= {
        consumer_id: 'user_id',
        consumer_mac: 'user_ip',
    },
    customer ={
        email: 'email',
        phone_number: 'phone',
        name: 'name',
    },
    customizations={
        title: 'title',
        description: 'desc',
        logo: 'logo',
      },

    )=> {
    console.log('fluter wave called');
    FlutterwaveCheckout({
        public_key,
        tx_ref,
        amount,
        currency,
        country,
        payment_options: "card, ussd",
        redirect_url: redirect_url,
        meta,
        customer,
        callback: function (data) {
            console.log(data);
        },
        onclose: function() {
            // close modal
        },
        customizations
    });
  }

export { makePayment }
