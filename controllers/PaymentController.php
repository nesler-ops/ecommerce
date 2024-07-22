<?php
require_once '../config/paypal.php';
require_once '../controllers/CartController.php';
require_once '../init.php';

class PaymentController {
    private $paypal;

    public function __construct() {
        global $paypal;
        $this->paypal = $paypal;
    }

    public function createPayment($returnUrl, $cancelUrl) {
        $cartController = new CartController();
        $total = $cartController->getTotal();

        $payer = new \PayPal\Api\Payer();
        $payer->setPaymentMethod('paypal');

        $amount = new \PayPal\Api\Amount();
        $amount->setTotal($total);
        $amount->setCurrency('USD');

        $transaction = new \PayPal\Api\Transaction();
        $transaction->setAmount($amount);

        $redirectUrls = new \PayPal\Api\RedirectUrls();
        $redirectUrls->setReturnUrl($returnUrl)
                     ->setCancelUrl($cancelUrl);

        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions(array($transaction))
                ->setRedirectUrls($redirectUrls);

        try {
            $payment->create($this->paypal);
            return $payment;
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
    }

    public function executePayment($paymentId, $payerId) {
        $payment = \PayPal\Api\Payment::get($paymentId, $this->paypal);
        
        $execution = new \PayPal\Api\PaymentExecution();
        $execution->setPayerId($payerId);

        try {
            $result = $payment->execute($execution, $this->paypal);
            return $result;
        } catch (\PayPal\Exception\PayPalConnectionException $ex) {
            echo $ex->getCode();
            echo $ex->getData();
            die($ex);
        } catch (Exception $ex) {
            die($ex);
        }
    }
}

if (isset($_GET['action'])) {
    $paymentController = new PaymentController();
    $action = $_GET['action'];

    switch ($action) {
        case 'create':
            $returnUrl = 'http://yourwebsite.com/payment_success.php';
            $cancelUrl = 'http://yourwebsite.com/payment_cancel.php';
            $payment = $paymentController->createPayment($returnUrl, $cancelUrl);
            $approvalUrl = $payment->getApprovalLink();
            header("Location: {$approvalUrl}");
            break;
        case 'execute':
            if (isset($_GET['paymentId']) && isset($_GET['PayerID'])) {
                $paymentId = $_GET['paymentId'];
                $payerId = $_GET['PayerID'];
                $result = $paymentController->executePayment($paymentId, $payerId);
                // Handle successful payment (e.g., update order status, clear cart)
                header("Location: ../views/payment_success.php");
            } else {
                header("Location: ../views/payment_error.php");
            }
            break;
    }
}
?>