<?php

class CardinityController extends Controller
{
    private $client;

    public function __construct()
    {
        parent::__construct();

        $this->client = Cardinity\Client::create([
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
            $method = new Cardinity\Method\Payment\Create([
                'amount' => (float)sprintf('%.2f', $_POST['order']['amount']),
                'currency' => $_POST['order']['currency'],
                'settle' => ($_POST['order']['settle']) ? true : false,
                'description' => $_POST['order']['description'],
                'order_id' => $_POST['order']['order_id'],
                'country' => $_POST['order']['country'],
                'payment_method' => Cardinity\Method\Payment\Create::CARD,
                'payment_instrument' => [
                    'pan' => $_POST['card']['pan'],
                    'exp_year' => (int)$_POST['card']['exp_year'],
                    'exp_month' => (int)$_POST['card']['exp_month'],
                    'cvc' => $_POST['card']['cvc'],
                    'holder' => $_POST['card']['holder']
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

        if (isset($_POST['MD']) && isset($_POST['PaRes']) && isset($_SESSION['cardinity'])) {
            if ($_SESSION['cardinity']['MD'] == $_POST['MD']) {
                $method = new Cardinity\Method\Payment\Finalize(
                    $_SESSION['cardinity']['PaymentId'],
                    $_POST['PaRes']
                );

                $result = $this->send($method);
                if ($result) {
                    $render = $result;
                }
            }
            unset($_SESSION['cardinity']);
        }

        $this->view->render($render);
    }

    public function refund()
    {
        $render = 'refund';

        if (isset($_POST['refund'])) {
            $method = new Cardinity\Method\Refund\Create(
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
            $method = new Cardinity\Method\Payment\Create([
                'amount' => (float)sprintf('%.2f', $_POST['recurring']['amount']),
                'currency' => $_POST['recurring']['currency'],
                'settle' => ($_POST['recurring']['settle']) ? true : false,
                'description' => $_POST['recurring']['description'],
                'order_id' => $_POST['recurring']['order_id'],
                'country' => $_POST['recurring']['country'],
                'payment_method' => Cardinity\Method\Payment\Create::RECURRING,
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
            $method = new Cardinity\Method\Settlement\Create(
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
            $method = new Cardinity\Method\Void\Create(
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

    private function send($method)
    {
        $errors = [];

        try {
            $payment = $this->client->call($method);
            $status = $payment->getStatus();

            if ($status == 'approved') {
                $_SESSION['success'] = 'Transactions successfully completed<br /><b>' . $payment->getId() . '</b>';
            } elseif ($status == 'pending') {
                $auth = $payment->getAuthorizationInformation();

                $pending = [
                    'ThreeDForm' => $auth->getUrl(),
                    'PaReq' => $auth->getData(),
                    'MD' => $payment->getOrderId(),
                    'PaymentId' => $payment->getId(),
                ];
                $_SESSION['cardinity'] = $pending;

                return 'pending';
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
                $exception->getPrevious()->getMessage()
            ];
        }

        if ($errors) {
            $_SESSION['errors'] = $errors;
        }
    }
}
