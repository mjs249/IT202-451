<?php
require_once(__DIR__ . "/../../partials/nav.php");
require_once(__DIR__ . "/../../lib/sanitizers.php");
is_logged_in(true);

$user_id = get_user_id();

// Function to fetch user accounts
function get_user_accounts($user_id, $limit = 5)
{
    $db = getDB();
    $stmt = $db->prepare("SELECT id, account_number, account_type, modified, balance FROM Accounts WHERE user_id = :user_id LIMIT :limit");
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get user accounts
$user_accounts = get_user_accounts($user_id);

?>

<h1>My Accounts</h1>

<table>
    <thead>
        <tr>
            <th>Account Number</th>
            <th>Account Type</th>
            <th>Last Modified</th>
            <th>Balance</th>
            <th>Transaction History</th> <!-- New column header for the link -->
        </tr>
    </thead>
    <tbody>
        <?php foreach ($user_accounts as $account) : ?>
            <tr>
                <td><?php echo htmlspecialchars($account['account_number']); ?></td>
                <td><?php echo htmlspecialchars($account['account_type']); ?></td>
                <td><?php echo htmlspecialchars($account['modified']); ?></td>
                <td><?php echo htmlspecialchars($account['balance']); ?></td>
                <td>
                    <a href="transactionHistory.php?account_id=<?php echo urlencode($account['id']); ?>">View</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require_once(__DIR__ . "/../../partials/flash.php"); ?>