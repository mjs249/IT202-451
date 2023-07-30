<?php
require_once(__DIR__ . "/../../partials/nav.php");
require_once(__DIR__ . "/../../lib/sanitizers.php");
is_logged_in(true);

function generate_unique_account_number()
{
    return str_pad(mt_rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
}

if (isset($_POST["create_account"])) {
    $user_id = get_user_id();
    $account_number = generate_unique_account_number();
    $account_type = "checking";
    $initial_deposit = 5;

    try {
        $db = getDB();
        $db->beginTransaction(); // Start a transaction to handle both INSERTs as a pair

        // Step 1: Record the transaction from the world account to the new checking account
        $stmt = $db->prepare("INSERT INTO Transactions (account_src, account_dest, balance_change, transaction_type, expected_total) VALUES (:account_src, NULL, :balance_change, 'initial_deposit', :expected_total)");
        $stmt->execute([
            ":account_src" => -1, // Use -1 for the world account
            ":balance_change" => -$initial_deposit, // Negative change for the world account
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
            ":world_account_id" => -1, // Use -1 for the world account ID
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
        $db->rollBack(); // If an error occurs, roll back the transaction and show an error message

        // Check the error code for specific constraint violations
        if ($e->getCode() == 23000) {
            flash("Error creating checking account: Account number is already in use. Please try again.", "danger");
        } else {
            flash("Error creating checking account: An unexpected error occurred. Please try again later.", "danger");
        }

        header("Location: " . get_url('newAccount.php'));
        exit;
    }
}
?>

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