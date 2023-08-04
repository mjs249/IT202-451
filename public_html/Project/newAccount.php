<?php
require_once(__DIR__ . "/../../partials/nav.php");
require_once(__DIR__ . "/../../lib/sanitizers.php");
is_logged_in(true);

function generate_unique_account_number()
{
    $db = getDB();
    do {
        $account_number = str_pad(mt_rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
        $stmt = $db->prepare("SELECT COUNT(1) FROM Accounts WHERE account_number = :account_number");
        $stmt->execute([":account_number" => $account_number]);
    } while ($stmt->fetchColumn() > 0);
    return $account_number;
}

if (isset($_POST["create_account"])) {
    $user_id = get_user_id();
    $account_number = generate_unique_account_number();
    $account_type = "checking";
    $initial_deposit = 5;

    try {
        $db = getDB();
        $db->beginTransaction(); 

        // Step 1: Record the transaction from the world account to the new checking account
        $stmt = $db->prepare("INSERT INTO Transactions (account_src, account_dest, balance_change, transaction_type, expected_total) VALUES (:account_src, NULL, :balance_change, 'initial_deposit', :expected_total)");
        $stmt->execute([
            ":account_src" => -1,
            ":balance_change" => -$initial_deposit,
            ":expected_total" => $initial_deposit,
        ]);

        // Get the last inserted transaction ID
        $transaction_id = $db->lastInsertId();

        // Step 2: Update the Accounts table with the new checking account data
        $stmt = $db->prepare("INSERT INTO Accounts (account_number, user_id, balance, account_type) VALUES (:account_number, :user_id, :balance, :account_type)");
        $stmt->execute([
            ":account_number" => $account_number,
            ":user_id" => $user_id,
            ":balance" => $initial_deposit,
            ":account_type" => $account_type,
        ]);

        // Get the last inserted account ID
        $account_id = $db->lastInsertId();

        // Update the transaction with the correct 'account_dest' value
        $stmt = $db->prepare("UPDATE Transactions SET account_dest = :account_dest WHERE id = :transaction_id");
        $stmt->execute([
            ":account_dest" => $account_id,
            ":transaction_id" => $transaction_id,
        ]);

        // Step 3: Update the balance of the world account
        $stmt = $db->prepare("UPDATE Accounts SET balance = balance - :balance_change WHERE id = :world_account_id");
        $stmt->execute([
            ":world_account_id" => -1,
            ":balance_change" => $initial_deposit,
        ]);

        // Commit the transaction
        $db->commit();

        // User-friendly success message
        flash("Checking account created successfully!", "success");

        // Redirect user to their Accounts page upon success
        header("Location: " . get_url('dashboard.php'));
        exit;
    } catch (PDOException $e) {
        $db->rollBack(); 

        // Don't show specific error messages, just a general one
        flash("Error creating checking account. Please try again later.", "danger");

        header("Location: " . get_url('newAccount.php'));
        exit;
    }
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
<h1>Create Checking Account</h1>

<form method="POST">
    <div class="mb-3">
        <label for="account_number">Account Number</label>
        <input type="text" name="account_number" id="account_number" value="<?php echo generate_unique_account_number(); ?>" readonly />
    </div>
    <!-- Include other input fields for account creation (e.g., account holder name, etc.) -->
    <!-- ... -->

    <input type="submit" value="Create Account" name="create_account" />
</form>

<?php require_once(__DIR__ . "/../../partials/flash.php"); ?>
