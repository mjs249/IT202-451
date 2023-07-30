<?php
require_once(__DIR__ . "/../../partials/nav.php");
require_once(__DIR__ . "/../../lib/sanitizers.php");
is_logged_in(true);

$user_id = get_user_id();

// Function to fetch user accounts
function get_user_accounts($user_id)
{
    $db = getDB();
    $stmt = $db->prepare("SELECT id, account_number, account_type, balance FROM Accounts WHERE user_id = :user_id");
    $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Get user accounts
$user_accounts = get_user_accounts($user_id);

// Get world account id
$db = getDB();
$stmt = $db->prepare("SELECT id FROM Accounts WHERE account_number = '000000000000'");
$stmt->execute();
$world_account = $stmt->fetch(PDO::FETCH_ASSOC);
$world_account_id = $world_account['id'];

// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account_id = $_POST["account_id"];
    $amount = $_POST["amount"];
    $memo = $_POST["memo"]; // Add memo variable

    $db = getDB();
    $db->beginTransaction(); // Start a transaction to handle both INSERTs as a pair

    try {
        // Step 1: Get the selected account with the provided account_id
        $stmt = $db->prepare("SELECT id, balance FROM Accounts WHERE id = :account_id");
        $stmt->execute([':account_id' => $account_id]);
        $account = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$account) {
            // Account not found, show an error message
            flash("Account not found!", "danger");
            header("Location: " . get_url('deposit.php'));
            exit;
        }

        // Step 2: Update the account balance by adding the deposit amount
        $new_balance = $account['balance'] + $amount;

        // Step 3: Record the deposit transaction from "world account" to the user's account
        $stmt = $db->prepare("INSERT INTO Transactions (account_src, account_dest, balance_change, transaction_type, expected_total, memo) VALUES (:world_account_id, :account_id, :balance_change, :transaction_type, :expected_total, :memo)");
        $stmt->execute([
            ':world_account_id' => $world_account_id,
            ':account_id' => $account['id'],
            ':balance_change' => $amount,
            ':transaction_type' => "deposit",
            ':expected_total' => $new_balance,
            ':memo' => $memo,
        ]);

        // Step 4: Update the balance of the user's account
        $stmt = $db->prepare("UPDATE Accounts SET balance = :new_balance WHERE id = :account_id");
        $stmt->execute([':new_balance' => $new_balance, ':account_id' => $account['id']]);

        // Step 5: Update the balance of the "world account" by subtracting the deposit amount
        $stmt = $db->prepare("UPDATE Accounts SET balance = balance - :amount WHERE id = :world_account_id");
        $stmt->execute([':amount' => $amount, ':world_account_id' => $world_account_id]);

        $db->commit(); // Commit the transaction

        // Success message and redirect
        flash("Deposit successful!", "success");
        header("Location: " . get_url('myAccounts.php'));
        exit;
    } catch (Exception $e) {
        $db->rollBack(); // If an error occurs, roll back the transaction

        // Display a generic error message in the flash message
        flash("An error occurred during the transaction. Please try again.", "danger");

        header("Location: " . get_url('deposit.php'));
        exit;
    }
}

?>

<h1>Make a Deposit</h1>

<form method="POST">
    <div class="mb-3">
        <label for="account_id">Select Account:</label>
        <select name="account_id" id="account_id">
            <?php foreach ($user_accounts as $account) : ?>
                <option value="<?php echo htmlspecialchars($account['id']); ?>"><?php echo htmlspecialchars($account['account_type'] . ' - ' . $account['account_number'] . ' ($' . $account['balance'] . ')'); ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="amount">Amount:</label>
        <input type="number" name="amount" id="amount" step="0.01" min="0" required />
    </div>
    <div class="mb-3">
        <label for="memo">Memo (optional):</label>
        <input type="text" name="memo" id="memo" />
    </div>
    <input type="hidden" name="transaction_type" value="deposit" />
    <input type="submit" value="Make Deposit" />
</form>

<?php require_once(__DIR__ . "/../../partials/flash.php"); ?>
