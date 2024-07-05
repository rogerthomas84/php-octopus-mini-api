<?php
require __DIR__ . '/../vendor/autoload.php';

$tmpAccountNumber = getenv('OCTOPUS_ACCOUNT_NUMBER');
$tmpEmail = getenv('OCTOPUS_EMAIL');
$tmpPassword = getenv('OCTOPUS_PASSWORD');

if (empty($tmpAccountNumber) || empty($tmpEmail) || empty($tmpPassword)) {
    echo 'Please set the OCTOPUS_ACCOUNT_NUMBER, OCTOPUS_EMAIL, and OCTOPUS_PASSWORD environment variables.' . PHP_EOL;
    exit(1);
}
