<?php

use Cardinity\Client;
use Cardinity\Method\Payment;
use Cardinity\Method\Refund;
use Cardinity\Method\VoidPayment;
use Cardinity\Method\Settlement;


class CardinityController extends Controller
{
    private $client;

    public function __construct()
    {
        parent::__construct();

        $this->client = Client::create([
            'consumerKey' => getenv('CRD_CONSUMER_KEY'),
            'consumerSecret' => getenv('CRD_CONSUMER_SECRET'),
        ]);
    }

    public function index()
    {
        $render = 'index';

        $this->view->render($render);
    }

    public function payment()
    {
        $render = 'payment';

        if (isset($_POST['order']) && isset($_POST['card'])) {
            $method = new Payment\Create([
                'amount' => (float)sprintf('%.2f', $_POST['order']['amount']),
                'currency' => $_POST['order']['currency'],
                'settle' => ($_POST['order']['settle']) ? true : false,
                'description' => $_POST['order']['description'],
                'order_id' => $_POST['order']['order_id'],
                'country' => $_POST['order']['country'],
                'payment_method' => Payment\Create::CARD,
                'payment_instrument' => [
                    'pan' => $_POST['card']['pan'],
                    'exp_year' => (int)$_POST['card']['exp_year'],
                    'exp_month' => (int)$_POST['card']['exp_month'],
                    'cvc' => $_POST['card']['cvc'],
                    'holder' => $_POST['card']['holder']
                ],
                'threeds2_data' =>  [
                    "notification_url" => getenv('BASE_URL') . "/callback3dsv2", 
                    "browser_info" => [
                        "accept_header" => "text/html",
						"browser_language" => $_POST['browser_info']['browser_language'] ?? "en-US",
						"screen_width" => (int) $_POST['browser_info']['screen_width'] ?? 1920,
						"screen_height" => (int) $_POST['browser_info']['screen_height'] ?? 1040,
						'challenge_window_size' => $_POST['browser_info']['challenge_window_size'],
						"user_agent" => $_SERVER['HTTP_USER_AGENT'] ?? "Mozilla/5.0 (X11; Ubuntu; Linux x86_64; rv:21.0) Gecko/20100101 Firefox/21.0",
						"color_depth" => (int) $_POST['browser_info']['color_depth'] ?? 24,
						"time_zone" =>  (int) $_POST['browser_info']['time_zone'] ?? -60
                    ],
                ],
            ]);

            $result = $this->send($method);
            if ($result) {
                $render = $result;
            }
        }

        $this->view->render($render);
    }

    public function callback()
    {
        $render = 'payment';

        $sessionData = unserialize(base64_decode($_COOKIE['cardinitySessionData']));        
        $_SESSION = $sessionData;

        if (isset($_POST['MD']) && isset($_POST['PaRes']) && isset($_SESSION['cardinity'])) {
            if ($_SESSION['cardinity']['MD'] == $_POST['MD']) {
                $method = new Payment\Finalize(
                    $_SESSION['cardinity']['PaymentId'],
                    $_POST['PaRes']
                );

                $result = $this->send($method);
                if ($result) {
                    $render = $result;
                }
            }
            //unset($_SESSION['cardinity']);
        }

        $this->view->render($render);
    }

    public function callback3dsv2()
    {
      
        $render = 'payment';

        $sessionData = unserialize(base64_decode($_COOKIE['cardinitySessionData']));        
        $_SESSION = $sessionData;

        if (isset($_POST['cres']) && isset($_POST['threeDSSessionData']) && isset($_SESSION['cardinity'])) {
            if ($_SESSION['cardinity']['threeDSSessionData'] == $_POST['threeDSSessionData']) {
                $method = new Payment\Finalize(
                    $_SESSION['cardinity']['PaymentId'],
                    $_POST['cres'],
                    true
                );

                $result = $this->senddebug($method);

                if ($result) {
                    $render = $result;
                }
            }
        }

        $this->view->render($render);
    }

    public function refund()
    {
        $render = 'refund';

        if (isset($_POST['refund'])) {
            $method = new Refund\Create(
                $_POST['refund']['payment_id'],
                (float)sprintf('%.2f', $_POST['refund']['amount']),
                $_POST['refund']['description']
            );

            $result = $this->send($method);
            if ($result) {
                $render = $result;
            }
        }

        $this->view->render($render);
    }

    public function recurring()
    {
        $render = 'recurring';

        if (isset($_POST['recurring'])) {
            $method = new Payment\Create([
                'amount' => (float)sprintf('%.2f', $_POST['recurring']['amount']),
                'currency' => $_POST['recurring']['currency'],
                'settle' => ($_POST['recurring']['settle']) ? true : false,
                'description' => $_POST['recurring']['description'],
                'order_id' => $_POST['recurring']['order_id'],
                'country' => $_POST['recurring']['country'],
                'payment_method' => Payment\Create::RECURRING,
                'payment_instrument' => [
                    'payment_id' => $_POST['recurring']['payment_id']
                ],
            ]);

            $result = $this->send($method);
            if ($result) {
                $render = $result;
            }
        }

        $this->view->render($render);
    }

    public function settle()
    {
        $render = 'settle';

        if (isset($_POST['settle'])) {
            $method = new Settlement\Create(
                $_POST['settle']['payment_id'],
                (float)sprintf('%.2f', $_POST['settle']['amount']),
                $_POST['settle']['description']
            );

            $result = $this->send($method);
            if ($result) {
                $render = $result;
            }
        }

        $this->view->render($render);
    }

    public function void()
    {
        $render = 'void';

        if (isset($_POST['void'])) {
            $method = new VoidPayment\Create(
                $_POST['void']['payment_id'],
                $_POST['void']['description']
            );

            $result = $this->send($method);
            if ($result) {
                $render = $result;
            }
        }

        $this->view->render($render);
    }


    private function senddebug($method)
    {
        $errors = [];

        try {
            $payment = $this->client->call($method);
            $status = $payment->getStatus();

            if ($status == 'approved') {
                $_SESSION['success'] = 'Transactions successfully completed<br /><b>' . $payment->getId() . '</b>';
                unset($_SESSION['cardinity']);
            } elseif ($status == 'pending') {

                //if both set its v1
                if ($payment->isThreedsV2() && !$payment->isThreedsV1()) {

                    $auth = $payment->getThreeds2data();

                    $pending = [
                        'acs_url' => $auth->getAcsUrl(),
                        'creq' => $auth->getCreq(),
                        'threeDSSessionData' => $payment->getOrderId(),
                        'PaymentId' => $payment->getId(),
                    ];
                    $_SESSION['cardinity'] = $pending;
    
                    setcookie('cardinitySessionData',base64_encode(serialize($_SESSION)), time() + 60*60*24);
    
                    return 'pendingv2';
                }else{

                    $auth = $payment->getAuthorizationInformation();

                    $pending = [
                        'ThreeDForm' => $auth->getUrl(),
                        'PaReq' => $auth->getData(),
                        'MD' => $payment->getOrderId(),
                        'PaymentId' => $payment->getId(),
                    ];
                    $_SESSION['cardinity'] = $pending;

                   
                    setcookie('cardinitySessionData',base64_encode(serialize($_SESSION)), time() + 60*60*24);
    
                    return 'pending';
                }
               
            }
        } catch (Cardinity\Exception\InvalidAttributeValue $exception) {
            foreach ($exception->getViolations() as $key => $violation) {
                array_push($errors, $violation->getPropertyPath() . ' ' . $violation->getMessage());
            }
        } catch (Cardinity\Exception\ValidationFailed $exception) {
            foreach ($exception->getErrors() as $key => $error) {
                array_push($errors, $error['message']);
            }
        } catch (Cardinity\Exception\Declined $exception) {
            foreach ($exception->getErrors() as $key => $error) {
                array_push($errors, $error['message']);
            }
        } catch (Cardinity\Exception\NotFound $exception) {
            foreach ($exception->getErrors() as $key => $error) {
                array_push($errors, $error['message']);
            }
        } catch (Exception $exception) {
            $errors = [
                $exception->getMessage(),
                //$exception->getPrevious()->getMessage()
            ];
        }

        
        if ($errors) {
            $_SESSION['errors'] = $errors;
        }
    }

    private function send($method)
    {
        $errors = [];

        try {
            $payment = $this->client->call($method);
            $status = $payment->getStatus();

            if ($status == 'approved') {
                $_SESSION['success'] = 'Transactions successfully completed<br /><b>' . $payment->getId() . '</b>';
            } elseif ($status == 'pending') {

                if ($payment->isThreedsV2()) {
                    $auth = $payment->getThreeds2data();

                    $pending = [
                        'acs_url' => $auth->getAcsUrl(),
                        'creq' => $auth->getCreq(),
                        'threeDSSessionData' => $payment->getOrderId(),
                        'PaymentId' => $payment->getId(),
                    ];
                    $_SESSION['cardinity'] = $pending;
    
                    setcookie('cardinitySessionData',base64_encode(serialize($_SESSION)), time() + 60*60*24);
    
                    return 'pendingv2';
                }else{
                    $auth = $payment->getAuthorizationInformation();

                    $pending = [
                        'ThreeDForm' => $auth->getUrl(),
                        'PaReq' => $auth->getData(),
                        'MD' => $payment->getOrderId(),
                        'PaymentId' => $payment->getId(),
                    ];
                    $_SESSION['cardinity'] = $pending;
    
                    setcookie('cardinitySessionData',base64_encode(serialize($_SESSION)), time() + 60*60*24);
    
                    return 'pending';
                }
               
            }
        } catch (Cardinity\Exception\InvalidAttributeValue $exception) {
            foreach ($exception->getViolations() as $key => $violation) {
                array_push($errors, $violation->getPropertyPath() . ' ' . $violation->getMessage());
            }
        } catch (Cardinity\Exception\ValidationFailed $exception) {
            foreach ($exception->getErrors() as $key => $error) {
                array_push($errors, $error['message']);
            }
        } catch (Cardinity\Exception\Declined $exception) {
            foreach ($exception->getErrors() as $key => $error) {
                array_push($errors, $error['message']);
            }
        } catch (Cardinity\Exception\NotFound $exception) {
            foreach ($exception->getErrors() as $key => $error) {
                array_push($errors, $error['message']);
            }
        } catch (Exception $exception) {
            $errors = [
                $exception->getMessage(),
                //$exception->getPrevious()->getMessage()
            ];
        }

        
        if ($errors) {
            $_SESSION['errors'] = $errors;
        }
    }
}
