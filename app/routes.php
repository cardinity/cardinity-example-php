<?php

$routes = array(
    '/' => 'cardinity@index',
    '/payment' => 'cardinity@payment',
    '/payment_link' => 'cardinity@paymentLink',
    '/payment_link_view' => 'cardinity@paymentLinkView',
    '/callback' => 'cardinity@callback',
    '/refund' => 'cardinity@refund',
    '/recurring' => 'cardinity@recurring',
    '/settle' => 'cardinity@settle',
    '/void' => 'cardinity@void',
    '/callback3dsv2' => 'cardinity@callback3dsv2',
);
