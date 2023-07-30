<?php
require_once(__DIR__ . "/../../partials/nav.php");
require_once(__DIR__ . "/../../lib/sanitizers.php");
is_logged_in(true);

// Check if the account_id is provided in the URL
if (isset($_GET['account_id'])) {
    $account_id = sanitize($_GET['account_id']);
    // Fetch account details from the Accounts table
    $db = getDB();
    $stmt = $db->prepare("SELECT account_number, account_type, balance, modified FROM Accounts WHERE id = :account_id");
    $stmt->execute([':account_id' => $account_id]);
    $account = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch transaction history from the Transactions table
    $stmt = $db->prepare("SELECT t.id, src.account_number AS account_src, dest.account_number AS account_dest, t.balance_change, t.transaction_type, t.memo, t.expected_total, t.created 
                          FROM Transactions t 
                          LEFT JOIN Accounts src ON t.account_src = src.id
                          LEFT JOIN Accounts dest ON t.account_dest = dest.id
                          WHERE account_src = :account_id OR account_dest = :account_id ORDER BY t.created DESC LIMIT 10");
    $stmt->execute([':account_id' => $account_id]);
    $transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    // If account_id is not provided in the URL, redirect to the My Accounts page
    header("Location: myAccounts.php");
    exit;
}
?>
<nav class="secondary">
        <ul>
        <li><a href="<?php echo get_url('newAccount.php'); ?>">Create Account</a></li>
            <li><a href="<?php echo get_url('myAccounts.php'); ?>">My Accounts</a></li>
            <li><a href="<?php echo get_url('deposit.php'); ?>">Deposit</a></li>
            <li><a href="<?php echo get_url('withdraw.php'); ?>">Withdraw</a></li>
            <li><a href="#">Transfer</a></li>
            <li><a href="#">Profile</a></li>
        </ul>
    </nav>
<h1>Transaction History</h1>

<h2>Account Details</h2>
<p><strong>Account Number:</strong> <?php echo htmlspecialchars($account['account_number']); ?></p>
<p><strong>Account Type:</strong> <?php echo htmlspecialchars($account['account_type']); ?></p>
<p><strong>Balance:</strong> <?php echo htmlspecialchars($account['balance']); ?></p>
<p><strong>Last Modified:</strong> <?php echo htmlspecialchars($account['modified']); ?></p>

<h2>Transaction History</h2>

<table>
    <thead>
        <tr>
            <th>Transaction ID</th>
            <th>Source Account</th>
            <th>Destination Account</th>
            <th>Balance Change</th>
            <th>Transaction Type</th>
            <th>Memo</th>
            <th>Expected Total</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactions as $transaction) : ?>
            <tr>
                <td><?php echo htmlspecialchars($transaction['id']); ?></td>
                <td><?php echo htmlspecialchars($transaction['account_src']); ?></td>
                <td><?php echo is_null($transaction['account_dest']) ? "" : htmlspecialchars($transaction['account_dest']); ?></td>
                <td><?php echo htmlspecialchars($transaction['balance_change']); ?></td>
                <td><?php echo htmlspecialchars($transaction['transaction_type']); ?></td>
                <td><?php echo is_null($transaction['memo']) ? "" : htmlspecialchars($transaction['memo']); ?></td>
                <td><?php echo htmlspecialchars($transaction['expected_total']); ?></td>
                <td><?php echo htmlspecialchars($transaction['created']); ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once(__DIR__ . "/../../partials/flash.php"); ?>
