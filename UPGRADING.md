# From v2 to v3

Breaking changes between v1 and v2 that you need to account for:
- When passing the expiration time to `sign()` as an int, it will be interpreted as seconds instead of days.
- the `default_expiration_time_in_days` has been renamed to `default_expiration_time_in_seconds`
- the default config file now uses the `URL_SIGNER_SIGNATURE_KEY` env variable instead of the app key
- the `ValidateSignature` middleware isn't registered by default anymore, you must do this manually. Check the installation instructions for more details.
