<?php
// this file makes use of mollie-php-client, a php library for interaction between the application and mollie
include './../../mollie-api-php/src/MollieApiClient.php';
include "config.php";

// Make a new MollieApiClient object and set the API key.
/**
 * Returns the client object if everything goes well, otherwise it'll return null.
 * @return \Mollie\Api\MollieApiClient|null
 */
function getClient()
{

    try {
        $config = new Config();

        $client = new \Mollie\Api\MollieApiClient();
        $client->setApiKey($config->mollie_api());
        return $client;
    } catch (\Mollie\Api\Exceptions\IncompatiblePlatform | \Mollie\Api\Exceptions\ApiException $e) {

    }
    return null;
}

/**
 * @param $cost double The cost of the payment (REQ). FORMAT: '.' for decimals and nothing for thousands
 * @param $description String The description of the payment (REQ), default is NONE
 * @param $redirectUrl String The url it redirects to once the payment has been completed
 *
 * @throws \Mollie\Api\Exceptions\ApiException
 *
 * @return \Mollie\Api\Resources\Payment Object the payment object. Use getCheckoutUrl to get the url to header them to and id to check if the transaction was paid
 */
function makeTransaction($cost, $description = 'None', $redirectUrl = 'http://localhost/WWI-webshop/index.php?payment=yes')
{
    return getClient()->payments->create([
        "amount" => [
            "currency" => "EUR",
            "value" => "" . $cost . "" // needs to be a string.
        ],
        "method" => \Mollie\Api\Types\PaymentMethod::IDEAL,
        "description" => $description,
        "redirectUrl" => $redirectUrl,
    ]);
}

/**
 * Check if the transaction has been piad
 *
 * @param $id int The id of the payment
 * @return bool true/false depending on the payment status
 *
 * @throws \Mollie\Api\Exceptions\ApiException
 */
function isTransactionPaid($id)
{
    return (boolean)getClient()->payments->get($id)->isPaid();
}

/**
 * @return \Mollie\Api\Resources\Method
 *
 * @throws \Mollie\Api\Exceptions\ApiException
 */
function getIdealIssuers()
{
    return getClient()->methods->get(\Mollie\Api\Types\PaymentMethod::IDEAL, ["include" => "issuers"]);
}