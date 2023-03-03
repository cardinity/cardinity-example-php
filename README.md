# Cardinity Client PHP Example

This example project will give you a working project that use Cardinity payments. Use it for reference in development.

## DISCLAIMER

This sample code is provided for illustrative purposes only. Any use of this repository or any of its code in a production environment is highly discouraged.

## Setup

0) Download the files
1) Navigate to directory location
2) Run composer ```php composer.phar install```
3) Rename file ```.env.example``` into ```.env``` and fill the Cardinity API credentials
4) Add your Cardinity API keys to `.env` file
5) Start internal PHP server ```php -S localhost:8000 -t public```
6) Launch browser with url ```http://localhost:8000```

### Note on testing 3D-Secure flow

Testing 3D-Secure flow involves redirecting purchase flow to an external website and redirecting back. Therefore, this step requires a public address and does not allow `localhost` addresses. To test full 3D-Secure flow, this application requires a public IP, which can be obtained either via hosting this project publicly or tunneling your local setup using [ngrok](https://ngrok.com/) or similar tunneling software.

### Running project using Docker

If you wish to run this project using Docker, take the following steps:

0) Download the files
1) Navigate to directory location
2) Rename file `.env.example` into `.env` and fill the Cardinity API credentials
3) Add your Cardinity API keys to `.env` file
4) Run  `docker-compose up -d`
5) Install the Composer dependencies: `docker-compose run php composer install`
6) Launch browser with url `http://localhost:8000`

## Documentation

Official Cardinity API documentation can be found [here]("https://developers.cardinity.com/api/v1/")

## Having problems?  

Feel free to contact us regarding any problems that occurred during integration via info@cardinity.com. We will be more than happy to help.

-----

## About us

Cardinity is a licensed payment institution, active in the European Union, registered on VISA Europe and MasterCard International associations to provide **e-commerce credit card processing services** for online merchants. We operate not only as a **payment gateway** but also as an **acquiring Bank**. With over 10 years of experience in providing reliable online payment services, we continue to grow and improve as a perfect payment service solution for your businesses. Cardinity is certified as PCI-DSS level 1 payment service provider and always assures a secure environment for transactions. We assure a safe and cost-effective, all-in-one online payment solution for e-commerce businesses and sole proprietorships.

### Our features

* Fast application and boarding procedure.
* Global payments - accept payments in major currencies with credit and debit cards from customers all around the world.
* Recurring billing for subscription or membership based sales.  
* One-click payments - let your customers purchase with a single click.
* Mobile payments. Purchases made anywhere on any mobile device.
* Payment gateway and free merchant account.
* PCI DSS level 1 compliance and assured security with our enhanced protection measures.
* Simple and transparent pricing model. Only pay per transaction and receive all the features for free.

## Get started

[Click here]("https://cardinity.com/sign-up") to sign-up and start accepting credit and debit card payments on your website or [here]("https://cardinity.com/company/contact-us") to contact us

## Keywords

payment gateway, credit card payment, online payment, credit card processing, online payment gateway, cardinity client php example.

 [▲ back to top](#cardinity-client-php-example)
