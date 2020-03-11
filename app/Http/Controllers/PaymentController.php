<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AWXPhYjVAjROCABqPmy9z3rkc9WbIL-2PuJba-K_taXwX_RGxrTcGkcng7I8TTgfI7uyqfQu7_hJ3lrj',
                'EK-WXJCchSspxnLzm7oL1aNShPsGHyzh3tF9-0Z_5MmJmVa2c7X0UQIHudwv_qosXoqoMfSnAO2E2BFp'
            )
        );
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();

        $item_1->setName('Item 1')
            ->setCurrency('USD')
            ->setQuantity(1)
            ->setPrice($request->get('amount')); /** unit price **/

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->get('amount'));

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Your Transaction description');

        $redirectUrls = new RedirectUrls();
        $redirectUrls->setReturnUrl('http://localhost:8000/execute-payment')
            ->setCancelUrl('http://localhost:8000/cancel');

        $payment = new Payment();
        $payment->setIntent("sale")
            ->setPayer($payer)
            ->setRedirectUrls($redirectUrls)
            ->setTransactions(array($transaction));


        $payment->create($apiContext);

        return redirect($payment->getApprovalLink());
    }

    public function execute(Request $request)
    {
        $apiContext = new ApiContext(
            new OAuthTokenCredential(
                'AWXPhYjVAjROCABqPmy9z3rkc9WbIL-2PuJba-K_taXwX_RGxrTcGkcng7I8TTgfI7uyqfQu7_hJ3lrj',
                'EK-WXJCchSspxnLzm7oL1aNShPsGHyzh3tF9-0Z_5MmJmVa2c7X0UQIHudwv_qosXoqoMfSnAO2E2BFp'
            )
        );

        $paymentId = \request('paymentId');
        $payment = Payment::get($paymentId, $apiContext);

        $execution = new PaymentExecution();
        $execution->setPayerId(request('PayerID'));

        $transaction = new Transaction();


        $amount = new Amount();
        $amount->setCurrency('USD')
            ->setTotal($request->post('amount'));
        $transaction->setAmount($amount);

        $execution->addTransaction($transaction);

        $result = $payment->execute($execution, $apiContext);
        return $result;
    }
}
