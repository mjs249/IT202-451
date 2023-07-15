<?php
require(__DIR__ . "/../../partials/nav.php");
reset_session();
?>

<?php
function has_flash_messages($type = null)
{
    if (isset($_SESSION["flash_messages"])) {
        $flashMessages = $_SESSION["flash_messages"];
        if ($type !== null) {
            foreach ($flashMessages as $message) {
                if ($message["type"] === $type) {
                    return true;
                }
            }
            return false;
        } else {
            return count($flashMessages) > 0;
        }
    }
    return false;
}

$hasError = false;

if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm"]) && isset($_POST["username"])) {
    $email = se($_POST, "email", "", false);
    $password = se($_POST, "password", "", false);
    $confirm = se($_POST, "confirm", "", false);
    $username = se($_POST, "username", "", false);

    if (empty($email)) {
        flash("Email must not be empty", "danger");
        $hasError = true;
    } else {
        //sanitize
        $email = sanitize_email($email);
        //validate
        if (!is_valid_email($email)) {
            flash("Invalid email address", "danger");
            $hasError = true;
        }
    }

    if (!is_valid_username($username)) {
        flash("Username must only contain 3-16 characters a-z, 0-9, _, or -", "danger");
        $hasError = true;
    }

    if (empty($password)) {
        flash("Password must not be empty", "danger");
        $hasError = true;
    }

    if (empty($confirm)) {
        flash("Confirm password must not be empty", "danger");
        $hasError = true;
    }

    if (!is_valid_password($password)) {
        flash("Password too short", "danger");
        $hasError = true;
    }

    if ($password !== $confirm) {
        flash("Passwords must match", "danger");
        $hasError = true;
    }

    if (!$hasError) {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Users (email, password, username) VALUES(:email, :password, :username)");
        try {
            $stmt->execute([":email" => $email, ":password" => $hash, ":username" => $username]);
            flash("Successfully registered!", "success");
        } catch (Exception $e) {
            users_check_duplicate($e->errorInfo);
        }
    }
}
?>

<form onsubmit="return validate(this)" method="POST">
    <div>
        <label for="email">Email</label>
        <input type="email" name="email" value="<?php echo isset($_POST["email"]) ? htmlspecialchars($_POST["email"]) : ""; ?>" required />
    </div>
    <div>
        <label for="username">Username</label>
        <input type="text" name="username" value="<?php echo isset($_POST["username"]) ? htmlspecialchars($_POST["username"]) : ""; ?>" required maxlength="30" />
    </div>
    <div>
        <label for="pw">Password</label>
        <input type="password" id="pw" name="password" required minlength="8" />
    </div>
    <div>
        <label for="confirm">Confirm</label>
        <input type="password" name="confirm" required minlength="8" />
    </div>
    <input type="submit" value="Register" />
</form>

<script>
    function validate(form) {
        // TODO: implement JavaScript validation
        // ensure it returns false for an error and true for success

        return true;
    }
</script>

<?php
require(__DIR__ . "/../../partials/flash.php");
?>