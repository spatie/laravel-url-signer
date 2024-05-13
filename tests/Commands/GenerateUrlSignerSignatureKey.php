<?php

use Illuminate\Support\Env;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

beforeEach(function () {
    File::copy(__DIR__.'/../Stubs/.env', base_path('.env'));
});

test('it can generate a URL signer signature key', function () {
    Artisan::call('generate:url-signer-signature-key');

    $env = trim(File::get(base_path('.env')));

    expect($env)->toContain('URL_SIGNER_SIGNATURE_KEY=');
});

test('it can display a URL signer signature key', function () {
    Artisan::call('generate:url-signer-signature-key --show');

    $output = trim(Artisan::output());

    expect($output)
        ->toBeString()
        ->toHaveLength(64);
});
