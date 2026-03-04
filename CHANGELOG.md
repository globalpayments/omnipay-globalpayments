<a href="https://github.com/globalpayments" target="_blank">
    <img src="https://developer.globalpay.com/static/media/logo.db1c4126172e20a5c31cf9d5150cc88a.svg" alt="Global Payments logo" title="Global Payments" align="right" width="225" />
</a>

# Changelog

All notable changes to the `omnipay-globalpayments` package will be documented in this file.

This project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added

- **Gateway Support**
  - GP-API Gateway integration

- **Features**
  - Global Payments PHP-SDK v14 integration
  - PHP 8.2+ support

### Dependencies

- `globalpayments/php-sdk` ^14
- `php` >= 8.2

## [1.0.0] - 2026-03-04

### Added

- **Gateway Support**
  - Heartland/Portico Gateway integration
  - Transit Gateway integration
  - Genius (Merchantware) Gateway integration

- **Transaction Types**
  - `purchase()` - Direct sale transactions
  - `authorize()` - Authorization-only transactions
  - `capture()` - Capture previously authorized transactions
  - `refund()` - Full and partial refunds
  - `void()` - Full and partial voids
  - `createCard()` - Tokenize cards for future use

- **Payment Methods**
  - Credit card payments (Visa, Mastercard, Amex, Discover, JCB)
  - ACH/eCheck payments
  - Apple Pay support
  - Single-use token payments
  - Card-on-file (stored credential) transactions

- **Features**
  - PSR-4 autoloading
  - Omnipay 3.x compatibility
  - Comprehensive test suite
  - Example implementations for all transaction types

### Dependencies

- `league/omnipay` ^3
- `globalpayments/php-sdk` ^2.2
