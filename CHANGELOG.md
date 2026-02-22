# Changelog

All notable changes to this project will be documented in this file.

## [3.1.0] - 2026-02-22

### Changed
- OHLC endpoint: renamed `setCurrency()` to `setQuote()` and request parameter from `currency` to `quote` to align with API response field names.

## [3.0.0] - 2026-02-19

### Added
- New `ohlc()` endpoint for OHLC (Open, High, Low, Close) candlestick data (requires paid plan).
- New `setCurrency()` method to set the quote currency for the OHLC endpoint.
- New `setInterval()` method to set the candle interval for the OHLC endpoint (`5m`, `15m`, `30m`, `1h`, `4h`, `12h`, `1d`).

### Changed
- Upgraded to API v2 (`/api/v2/`).

### Removed
- `setLimit()` method and `limit` parameter — API v2 no longer supports filtering currencies by a limit. All supported currencies are always returned (with `null` for unavailable ones).

## [2.0.0] - 2026-02-13

### Changed
- Minimum PHP version raised from 7.1 to 8.1.
- Updated PHPUnit from ^8.5|^9.6 to ^10.5|^11.5.
- Updated php-mock-phpunit from ^2.7 to ^2.10.
- Updated php-coveralls from ^2.6 to ^2.7.
- Updated phpunit.xml configuration to PHPUnit 10+ format.
- Updated Dockerfile default PHP version to 8.5.
- Updated GitHub Actions workflow to test PHP 8.1, 8.2, 8.3, 8.4, and 8.5.
- Updated GitHub Actions checkout action from v2 to v4.

### Fixed
- Removed deprecated `curl_close()` call (no effect since PHP 8.0).
- Removed deprecated `ReflectionMethod::setAccessible()` and `ReflectionProperty::setAccessible()` calls in tests (no effect since PHP 8.1).

### Removed
- Dropped support for PHP 7.x.
