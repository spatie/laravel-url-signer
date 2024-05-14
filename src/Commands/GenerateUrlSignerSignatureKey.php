<?php

namespace Spatie\UrlSigner\Laravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateUrlSignerSignatureKey extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:url-signer-signature-key
        {--s|show : Display the key instead of modifying files.}
        {--always-no : Skip generating key if it already exists.}
        {--f|force : Skip confirmation when overwriting an existing key.}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a new URL signer signature key.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $key = Str::random(64);

        if ($this->option('show')) {
            $this->comment($key);

            return;
        }

        if (file_exists($path = $this->envPath()) === false) {
            $this->displayKey($key);

            return;
        }

        if (Str::contains(file_get_contents($path), 'URL_SIGNER_SIGNATURE_KEY') === false) {
            // create new entry
            file_put_contents($path, PHP_EOL."URL_SIGNER_SIGNATURE_KEY=$key".PHP_EOL, FILE_APPEND);
        } else {
            if ($this->option('always-no')) {
                $this->comment('Secret key already exists. Skipping...');

                return;
            }

            if ($this->isConfirmed() === false) {
                $this->comment('Phew... No changes were made to your secret key.');

                return;
            }

            // update existing entry
            file_put_contents($path, str_replace(
                'URL_SIGNER_SIGNATURE_KEY='.$this->laravel['config']['url-signer.signature_key'],
                'URL_SIGNER_SIGNATURE_KEY='.$key,
                file_get_contents($path)
            ));
        }

        $this->displayKey($key);

    }

    /**
     * Display the key.
     */
    protected function displayKey(string $key): void
    {
        $this->laravel['config']['url-signer.signature_key'] = $key;

        $this->info("Url-signer key [$key] set successfully.");

    }

    /**
     * Check if the modification is confirmed.
     */
    protected function isConfirmed(): bool
    {
        return $this->option('force') || $this->confirm(
            'This will invalidate all existing tokens. Are you sure you want to override the secret key?'
        );
    }

    /**
     * Get the .env file path.
     */
    protected function envPath(): string
    {
        if (method_exists($this->laravel, 'environmentFilePath')) {
            return $this->laravel->environmentFilePath();
        }

        return $this->laravel->basePath('.env');
    }
}
