<?php
require_once(__DIR__ . "/../../partials/nav.php");
require_once(__DIR__ . "/../../lib/sanitizers.php"); // Replace "path/to/sanitizers.php" with the actual path to your sanitizers.php file
is_logged_in(true);
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

$showProfileSavedMessage = false;

if (isset($_POST["save"])) {
    $email = se($_POST, "email", null, false);
    $username = se($_POST, "username", null, false);

    $params = [":email" => $email, ":username" => $username, ":id" => get_user_id()];
    $db = getDB();
    $updateSuccess = false;

    // Update email and username
    $stmt = $db->prepare("UPDATE Users SET email = :email, username = :username WHERE id = :id");
    try {
        $stmt->execute($params);

        // Update session data
        $_SESSION["user"]["email"] = $email;
        $_SESSION["user"]["username"] = $username;

        $updateSuccess = true;
    } catch (Exception $e) {
        if ($e->errorInfo[1] === 1062) {
            preg_match("/Users.(\w+)/", $e->errorInfo[2], $matches);
            if (isset($matches[1])) {
                flash("The chosen " . $matches[1] . " is not available.", "warning");
            } else {
                echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
            }
        } else {
            echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
        }
    }

    // Password Reset
    $current_password = se($_POST, "currentPassword", null, false);
    $new_password = se($_POST, "newPassword", null, false);
    $confirm_password = se($_POST, "confirmPassword", null, false);
    if (!empty($current_password) && !empty($new_password) && !empty($confirm_password)) {
        if ($new_password === $confirm_password) {
            $stmt = $db->prepare("SELECT password FROM Users WHERE id = :id");
            try {
                $stmt->execute([":id" => get_user_id()]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if (isset($result["password"])) {
                    if (password_verify($current_password, $result["password"])) {
                        if ($current_password !== $new_password) {
                            // Validate the new password
                            if (is_valid_password($new_password)) {
                                $query = "UPDATE Users SET password = :password WHERE id = :id";
                                $stmt = $db->prepare($query);
                                $stmt->execute([
                                    ":id" => get_user_id(),
                                    ":password" => password_hash($new_password, PASSWORD_BCRYPT)
                                ]);

                                flash("Password reset", "success");
                                $updateSuccess = true;
                            } else {
                                flash("The new password doesn't meet the password requirements.", "warning");
                            }
                        } else {
                            flash("The new password cannot be the same as the current password.", "warning");
                            $updateSuccess = false; // Set the update success flag to false
                        }
                    } else {
                        flash("Current password is invalid", "warning");
                    }
                }
            } catch (Exception $e) {
                echo "<pre>" . var_export($e->errorInfo, true) . "</pre>";
            }
        } else {
            flash("New passwords don't match", "warning");
        }
    }

    if ($updateSuccess) {
        $showProfileSavedMessage = true;
    }
}

$email = get_user_email();
$username = get_username();
?>

<form method="POST" onsubmit="return validate(this);">
    <div class="mb-3">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" value="<?php se($email); ?>" />
    </div>
    <div class="mb-3">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" value="<?php se($username); ?>" />
    </div>
    <!-- DO NOT PRELOAD PASSWORD -->
    <div>Password Reset</div>
    <div class="mb-3">
        <label for="cp">Current Password</label>
        <input type="password" name="currentPassword" id="cp" />
    </div>
    <div class="mb-3">
        <label for="np">New Password</label>
        <input type="password" name="newPassword" id="np" />
    </div>
    <div class="mb-3">
        <label for="conp">Confirm Password</label>
        <input type="password" name="confirmPassword" id="conp" />
    </div>
    <input type="submit" value="Update Profile" name="save" />
</form>

<script>
    function validate(form) {
        let pw = form.newPassword.value;
        let con = form.confirmPassword.value;
        let isValid = true;
        // TODO: Add other client-side validation....

        if (!isEqual(pw, con)) {
            flash("Password and Confirm password must match", "warning");
            isValid = false;
        }
        return isValid;
    }
</script>

<?php
require_once(__DIR__ . "/../../partials/flash.php");

if ($showProfileSavedMessage && !has_flash_messages("success")) {
    flash("Profile saved", "success");
}
?>