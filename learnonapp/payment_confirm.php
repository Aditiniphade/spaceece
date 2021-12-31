<?php
$payment_success = false;

// instamojo payment confirm
if (isset($_GET['payment_id']) && $_GET['payment_id'] != '' && isset($_GET['payment_request_id']) && $_GET['payment_request_id'] != '') {

    $payment_id = $_GET['payment_id'];
    $payment_request_id = $_GET['payment_request_id'];

    $api_url = 'https://test.instamojo.com/api/1.1/payment-requests/' . $payment_request_id . '/' . $payment_id . '/';

    // Verify payment by payment_id and payment_request_id
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            "X-Api-Key:test_d93c3d591e0abb22ab505118e62",
            "X-Auth-Token:test_76954866b66d6b27022e3086fd6"
        )
    );

    $response = curl_exec($ch);
    curl_close($ch);

    $response = json_decode($response);

    if ($response->success == true) {
        // Payment is successful
        $payment_success = true;
    } else {
        // Payment is not successful
        $payment_success = false;
    }
}

include_once './header_local.php';
include_once '../common/header_module.php';
include_once '../common/banner.php';

?>

<?php
if ($payment_success) {
?>
    <div id="payment-success">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="payment-success-content">
                        <h1 class="text-success">Payment Successful</h1>
                        <p>Your payment has been successfully processed. You will receive an email confirmation shortly.</p>
                        <a href="./index.php" class="btn btn-success">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php } else { ?>

    <div id="payment-error">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-12">
                    <div class="payment-error-content">
                        <h1 class="text-danger">Payment Failed</h1>
                        <p>Your payment has been failed. Please try again.</p>
                        <a href="./index.php" class="btn btn-danger">Back to Home</a>
                    </div>
                </div>
            </div>
        </div>

    <?php
}
include_once '../common/footer_module.php';
    ?>