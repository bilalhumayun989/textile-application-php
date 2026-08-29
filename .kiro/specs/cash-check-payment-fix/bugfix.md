# Bugfix Requirements Document

## Introduction

Cash and Check payment methods always fail with "not enough amount" even when the user has
sufficient balance. This affects both the Run Balance (customer ledger) and Wallet sections.
The root cause is that `payment_method` is an encrypted column in `wallet_entries`, so
database-level `whereIn` queries on it always return zero rows — making the computed
available balance appear as 0 regardless of the actual balance.

## Bug Analysis

### Current Behavior (Defect)

1.1 WHEN a user submits a Cash or Check payment in the Run Balance section AND the wallet
    has sufficient balance THEN the system returns "Insufficient balance in Cash/Check vault"
    and rejects the transaction.

1.2 WHEN a user submits a Cash or Check payment in the Wallet section AND the wallet has
    sufficient balance THEN the system returns "not enough money" and rejects the transaction.

1.3 WHEN the system queries wallet entries to compute the available Cash/Check balance THEN
    it uses a SQL `whereIn('payment_method', [...])` clause on an encrypted column, which
    always returns 0 rows, causing the computed balance to be 0.

### Expected Behavior (Correct)

2.1 WHEN a user submits a Cash or Check payment AND the actual decrypted Cash/Check balance
    is sufficient THEN the system SHALL accept the transaction and record it successfully.

2.2 WHEN a user submits a Cash or Check payment AND the actual decrypted Cash/Check balance
    is insufficient THEN the system SHALL reject the transaction with an accurate error message
    showing the real available balance.

2.3 WHEN the system computes the available Cash/Check balance THEN it SHALL load all wallet
    entries into PHP memory, decrypt them, and filter by payment method in PHP — not in SQL.

### Unchanged Behavior (Regression Prevention)

3.1 WHEN a user submits a Bank payment THEN the system SHALL CONTINUE TO validate against
    the bank's stored balance and reject if insufficient.

3.2 WHEN a user submits any payment type with genuinely insufficient balance THEN the system
    SHALL CONTINUE TO reject the transaction with an appropriate error message.

3.3 WHEN a user submits a valid transaction of any type (opening_balance, deposit, sale,
    payment_received, return, discount) THEN the system SHALL CONTINUE TO record it correctly
    and update the customer ledger balance.

3.4 WHEN wallet entries are created or read THEN the system SHALL CONTINUE TO encrypt and
    decrypt the `payment_method`, `amount`, and `description` fields as before.
