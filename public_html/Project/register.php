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

    $db = getDB();
    $db->beginTransaction(); // Start a transaction to handle both INSERTs as a pair

    // Step 1: Record the transaction from the world account to the new checking account
    $stmt = $db->prepare("INSERT INTO Transactions (account_src, account_dest, balance_change, transaction_type, expected_total) VALUES (-1, :account_dest, :balance_change, 'initial_deposit', :expected_total)");
    try {
        $stmt->execute([
            ":account_dest" => $account_number,
            ":balance_change" => $initial_deposit,
            ":expected_total" => $initial_deposit,
        ]);
    } catch (Exception $e) {
        $db->rollBack(); // If an error occurs, roll back the transaction and show an error message
        echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
        // User-friendly error message
        flash("Error creating checking account. Please try again later.", "danger");
        header("Location: " . get_url('create_account.php'));
        exit;
    }

    // Step 2: Update the Accounts table with the new checking account data
    $stmt = $db->prepare("INSERT INTO RM_Accounts (account, user_id, balance, account_type) VALUES (:account, :user_id, :balance, :account_type)");
    try {
        $stmt->execute([
            ":account" => $account_number,
            ":user_id" => $user_id,
            ":balance" => $initial_deposit,
            ":account_type" => $account_type,
        ]);

        // Commit the transaction
        $db->commit();

        // User-friendly success message
        flash("Checking account created successfully!", "success");

        // Redirect user to their Accounts page upon success
        header("Location: " . get_url('dashboard.php'));
        exit;
    } catch (Exception $e) {
        $db->rollBack(); // If an error occurs, roll back the transaction and show an error message
        echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
        // User-friendly error message
        flash("Error creating checking account. Please try again later.", "danger");
        header("Location: " . get_url('create_account.php'));
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