# Requirements Document

## Introduction

This feature allows users to spend more money than their available wallet balance when using the Cash/Check payment method (overdraft). Bank payments remain unchanged — the existing insufficient-balance validation is preserved. When a Cash/Check overdraft occurs, the net calculation view reflects the loan state: the net box turns red, displays a "Team Loan" label, and shows the positive loan amount instead of a negative balance.

## Glossary

- **Wallet**: The main financial record that tracks a user's credits and debits via wallet entries.
- **WalletEntry**: A single credit or debit transaction recorded against a Wallet, with an associated payment method.
- **WalletNet**: A saved snapshot of a net calculation (received total, used total, net amount) for a given date range and focus.
- **Payment_Method**: The method used for a transaction — either `Cash/Check` or `Bank`.
- **Cash/Check**: The payment method that allows overdraft spending beyond the available balance.
- **Bank**: The payment method that does NOT allow overdraft; existing balance validation is preserved.
- **Overdraft**: The state where total Cash/Check debits exceed total Cash/Check credits, resulting in a negative Cash/Check balance.
- **Team_Loan**: The label displayed in the net calculation UI when a Cash/Check overdraft is detected, representing the positive amount owed.
- **Net_Calculation_Box**: The UI component in the wallet net view that displays the net balance result (received minus used).
- **WalletNetController**: The Laravel controller responsible for computing and displaying net calculation results.
- **WalletController**: The Laravel controller responsible for storing wallet entries and enforcing payment method validation.

## Requirements

### Requirement 1: Cash/Check Overdraft Allowed

**User Story:** As a wallet user, I want to spend more than my available Cash/Check balance, so that I can record transactions even when funds are temporarily insufficient.

#### Acceptance Criteria

1. WHEN a user submits a debit entry with `Payment_Method` = `Cash/Check`, THE `WalletController` SHALL store the entry regardless of whether the resulting Cash/Check balance becomes negative.
2. THE `WalletController` SHALL NOT apply a balance pre-validation check for entries with `Payment_Method` = `Cash/Check`.
3. WHEN a user submits a debit entry with `Payment_Method` = `Bank` and the selected bank's balance is less than the entry amount, THE `WalletController` SHALL reject the entry and return an error message.

---

### Requirement 2: Bank Payment Validation Unchanged

**User Story:** As a wallet user, I want Bank payments to continue enforcing balance limits, so that I cannot accidentally overdraw a bank account.

#### Acceptance Criteria

1. WHILE `Payment_Method` = `Bank`, THE `WalletController` SHALL validate that the selected bank's current balance is greater than or equal to the requested debit amount before storing the entry.
2. IF the selected bank's balance is less than the debit amount, THEN THE `WalletController` SHALL return the error message "not enough money chooses some other bank/method" and redirect back without storing the entry.
3. THE `WalletController` SHALL update the bank's balance only after a successful Bank entry is stored.

---

### Requirement 3: Net Calculation Box — Team Loan State

**User Story:** As a wallet user, I want the net calculation box to visually indicate when I am in a loan state due to Cash/Check overdraft, so that I can clearly see how much the team owes.

#### Acceptance Criteria

1. WHEN the computed net balance for a Cash/Check overdraft scenario is less than zero, THE `Net_Calculation_Box` SHALL display the label "Team Loan" instead of "Net Balance".
2. WHEN the computed net balance is less than zero, THE `Net_Calculation_Box` SHALL apply a red background style to the box.
3. WHEN the computed net balance is less than zero, THE `Net_Calculation_Box` SHALL display the absolute (positive) value of the net amount as the loan amount.
4. WHEN the computed net balance is greater than or equal to zero, THE `Net_Calculation_Box` SHALL display the label "Net Balance" with the standard purple gradient background and the actual net amount.
5. THE `Net_Calculation_Box` SHALL NOT display any negative number — all displayed amounts SHALL be positive values.

---

### Requirement 4: Live Asset Summary — Cash/Check Card Reflects Overdraft

**User Story:** As a wallet user, I want the live Cash/Check asset card on the net view to accurately reflect a negative balance when overdraft has occurred, so that I have a true picture of my cash position.

#### Acceptance Criteria

1. WHEN the combined Cash/Check balance (`liveTotalCashCheck`) is negative due to overdraft, THE `WalletNetController` SHALL pass the negative value to the view without clamping or hiding it.
2. THE Cash/Check asset card in the net view SHALL display the raw `liveTotalCashCheck` value, whether positive or negative, so the user can see the true cash/check position.
