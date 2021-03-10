# omnipay-globalpayments

Omnipay 3.x driver for Global Payments

# Installation

    composer require globalpayments/omnipay-globalpayments
    
# Global Paymens payment gateways

This driver handles server-to-server requests for multiple Global Payments payment gateways 
by connecting to [Global Payments' PHP-SDK](https://github.com/globalpayments/php-sdk), which is the key dependency.
Currently supported payment gateways are: Heartland/Portico, TransIt, and Merchantware/Genius.

### Single-use Tokenization

The  integration is fairly straight forward. Essentially you just pass
a `token` field through instead of (or sometimes in addition to) the regular credit card data.

Start by following the standard Heartland Single-use Tokenization guide [here](https://developer.heartlandpaymentsystems.com/Ecommerce/Card).

After that you will have a `payment_token` field which will be submitted to your server.
In the typical Omnipay fashion, simply pass this through to the gateway as `token`:

```php
$token = $_POST['payment_token'];

$response = $gateway->purchase([
    'amount' => '10.00',
    'card' => $formData, // still used for things like cardholder name and address
    'currency' => 'USD',
    'token' => $token,
])->send();
```

# Examples & Samples

Our [Examples folder](Examples) contains ready-to-run examples for your reference. We're especially keen to provide notated examples for transactions we support that differ from the basic Omnipay examples.