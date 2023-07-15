## Project Name: Simple Bank
### Project Summary: This project will create a bank simulation for users. They’ll be able to have various accounts, do standard bank functions like deposit, withdraw, internal (user’s accounts)/external(other user’s accounts) transfers, and creating/closing accounts.
### Github Link: (Prod Branch of Project Folder)
### Project Board Link: 
### Website Link: (Heroku Prod of Project folder)
### API Link: (the link to the documentation of your chosen API)
### Your Name: Michael Sluka

 
 
### Proposal Checklist and Evidence

- Milestone 1
  - (add link to milestone1.md from milestone1 branch)  
•	User will be able to register a new account
o	Form Fields
	Username, email, password, confirm password(other fields optional)
	Email is required and must be validated
	Username is required
	Confirm password’s match
o	Users Table
	Id, username, email, password (60 characters), created, modified
o	Password must be hashed (plain text passwords will lose points)
o	Email should be unique
o	Username should be unique
o	System should let user know if username or email is taken and allow the user to correct the error without wiping/clearing the form
	The only fields that may be cleared are the password fields
•	User will be able to login to their account (given they enter the correct credentials)
o	Form
	User can login with email or username
•	This can be done as a single field or as two separate fields
	Password is required
o	User should see friendly error messages when an account either doesn’t exist or if passwords don’t match
o	Logging in should fetch the user’s details (and roles) and save them into the session.
o	User will be directed to a landing page upon login
	This is a protected page (non-logged in users shouldn’t have access)
	This can be home, profile, a dashboard, etc
•	User will be able to logout
o	Logging out will redirect to login page
o	User should see a message that they’ve successfully logged out
o	Session should be destroyed (so the back button doesn’t allow them access back in)
•	Basic security rules implemented
o	Authentication:
	Function to check if user is logged in
	Function should be called on appropriate pages that only allow logged in users
o	Roles/Authorization:
	Have a roles table (see below)
•	Basic Roles implemented
o	Have a Roles table	(id, name, description, is_active, modified, created)
o	Have a User Roles table (id, user_id, role_id, is_active, created, modified)
o	Include a function to check if a user has a specific role 
•	Site should have basic styles/theme applied; everything should be styled
o	I.e., forms/input, navigation bar, etc
•	Any output messages/errors should be “user friendly”
o	Any technical errors or debug output displayed will result in a loss of points
•	User will be able to see their profile
o	Email, username, etc
•	User will be able to edit their profile
o	Changing username/email should properly check to see if it’s available before allowing the change
o	Any other fields should be properly validated
o	Allow password reset (only if the existing correct password is provided)
	Hint: logic for the password check would be similar to login

- Milestone 2
  - (add link to milestone2.md from milestone2 branch)
•	Create the Accounts table (id, account_number [unique, always 12 characters], user_id, balance (default 0), account_type, created, modified)
•	Project setup steps:
o	Create these as initial setup scripts in the sql folder
	Create a system user if they don’t exist (this will never be logged into, it’s just to keep things working per system requirements)
•	Hint: id should be a negative value to avoid conflicts
	Create a world account in the Accounts table created above (if it doesn’t exist)
•	Account_number must be “000000000000”
•	User_id must be the id of the system user from the previous step
•	Account type must be “world”
•	Hint: id should be a negative value to avoid conflicts
•	Create the Transactions table (see reference at end of document)
o	Id, account_src, account_dest, balance_change, transaction_type, memo, expected_total, created, modified
•	Dashboard page
o	Note: This is different from navigation and it’s more like an ATM or mobile app view of interaction options
o	Will have links for Create Account, My Accounts, Deposit, Withdraw Transfer, Profile
	Links that don’t have pages yet should just have href=”#”, you’ll update them later
•	User will be able to create a checking account
o	System will generate a unique 12 character account number
	Options (strike out the option you won’t do):
•	Option 1: Generate a random 12 digit/character value; must regenerate if a duplicate collision occurs
•	Option 2: Generate the number based on the id column; requires inserting a null first to get the last insert id, then update the record immediately after
o	System will associate the account to the user
o	Account type will be set as checking
o	Will require a minimum deposit of $5 (from the world account)
	Entry will be recorded in the Transaction table as a transaction pair (per notes at end of document)
	Account Balance will be updated based on SUM of balance_change of account_src
•	Do not set this value directly
o	User will see user-friendly error messages when appropriate
o	User will see user-friendly success message when account is created successfully
	Redirect user to their Accounts page upon success
•	User will be able to list their accounts
o	Limit results to 5 for now
o	Show account number, account type, modified, and balance
•	User will be able to click an account for more information (a.k.a Transaction History page)
o	Show account number, account type, balance, opened/created date of the selected account (from Accounts table)
o	Show transaction history (from Transactions table)
	For now limit results to 10 latest
	Show the src/dest account numbers (not account id), the transaction type, the change in balance, when it occurred, expected total, and the memo
•	User will be able to deposit/withdraw from their account(s)
o	Clearly label each view with a heading as “Withdraw” or “Deposit” according to the application context/state
o	Form should have a dropdown of their accounts to pick from
	World account should not be in the dropdown as it’s not owned by anyone
	Account list should show account number and balance
o	Form should have a field to enter a positive numeric value
	For now, allow any deposit value (1 - inf)
o	For withdraw, add a check to make sure they can’t withdraw more money than the account has
	This must include a proper error message
o	Form should allow the user to record a memo for the transaction; memos are an optional value from the user
o	Each transaction is recorded as a transaction pair in the Transaction table per the details below and at the end of the document
	Note: These will reflect on the transaction history page (Account page’s “more info”)
	Note: if the world account is part of a transaction
•	 If the world account is using a positive id you must fetch the world account’s id (do not hard code the id as it may change if the application migrates or gets rebuilt)
•	If using a negative value and you’re sure it won’t change across migrations you can hard code it but label (via a comment) what it refers to
	Process
•	Requires two accounts (always)
o	Fetch the current balance of each account
o	Add or subtract the incoming balance change to calculate the expected totals of each account
•	Insert two records into the Transactions Table
o	Account A losing funds to Account B
o	Account B gaining funds from Account A
o	Ensure each record includes the proper balance_change, expected total, memo, the proper account ids (not account number), and the proper account type
•	Deposits will be from the “world account” to the user’s account
•	Withdraws will be from the user’s account to the “world account”
•	After the transactions are inserted update the balance of each account
o	By SUMing the balance_change for the account_src against the Transactions table
o	Show appropriate user-friendly error messages
	If any part of the process fails, the entire process should fail
o	Show user-friendly success messages

- Milestone 3
  - (add link to milestone3.md from milestone3 branch)
•	User will be able to transfer between their accounts
o	Clearly label this activity with a heading showing “Internal Transfer”
o	Form should include a dropdown for account_src and a dropdown for account_dest (only accounts the user owns; no world account)
	Account list should show account number and balance
o	Form should include a field for a positive numeric value
o	System shouldn’t allow the user to transfer more funds than what’s available in account_src
o	Form should allow the user to record a memo for the transaction
o	Each transaction is recorded as a transaction pair in the Transaction table
	These will reflect in the transaction history page
	Note: Same process as withdraw/deposit
o	Show appropriate user-friendly error messages
o	Show user-friendly success messages
•	Transaction History page (Same rules as the previous Milestone plus the below)
o	User will be able to filter transactions between two dates
o	User will be able to filter transactions by type (deposit, withdraw, transfer)
o	Transactions should paginate results after the initial 10
•	User’s profile page should record and show First and Last name
o	You may also capture this on the registration page, make note if you do
o	This will require an Alter Table statement for the Users table to include two new fields with default values
•	User will be able to transfer funds to another user’s account
o	Clearly label this activity with a heading showing “External Transfer”
o	Form should include a dropdown of the current user’s accounts (as account_src)
	Account list should show account number and balance
o	Form should include a field for the destination user’s last name
o	Form should include a field for the last 4 characters of the destination user’s account number (to lookup account_dest)
o	Form should include a field for a positive numerical value
o	Form should allow the user to record a memo for the transaction
o	System shouldn’t let the user transfer more than the balance of their account
o	System shouldn’t allow the user to transfer a negative value (i.e., can’t pull money from target user’s account)
o	System will lookup appropriate account based on destination user’s last name and the last 4 digits of the account number
o	Show appropriate user-friendly error messages
o	Show user-friendly success messages
o	Transaction will be recorded with the type as “ext-transfer”
o	Each transaction is recorded as a transaction pair in the Transaction table
	These will reflect in the transaction history page
	Note: Same process as withdraw/deposit/transfer

- Milestone 4
  - (add link to milestone4.md from milestone4 branch)
•	User can set their profile to be public or private (will need another column in Users table)
o	If profile is public, hide email address from other users (email address should not be publicly visible to others)
o	Profile should show total net worth
•	Create a table for System Properties 
o	Columns: id, name, value, modified, created
•	Alter the Accounts table to include a timestamp for last_apy_calc, default to current_timestamp, and a boolean for is_active default to true
•	User will be able open a savings account
o	System will generate a 12 digit/character account number per the existing rules (see Checking Account above)
o	System will associate the account to the user
o	Account type will be set as savings
o	Will require a minimum deposit of $5 (from the world account)
	Entry will be recorded in the Transaction table in a transaction pair (per notes previously and below)
	Account Balance will be updated based on SUM of balance_change of account_src
o	System sets an APY that’ll be used to calculate monthly interest based on the balance of the account
	APY pulled from System Properties table 
•	Hint: name could be “savings” and value could be the specific APY
o	User will see user-friendly error messages when appropriate
o	User will see user-friendly success message when account is created successfully
	Redirect user to their Accounts page
o	
•	User will be able to take out a loan
o	System will generate a 12 digit/character account number per the existing rules (see Checking Account above)
o	Account type will be set as loan
o	Will require a minimum value of $500
o	System will show an APY (before the user submits the form, so on original page load)
	This will be used to add monthly interest to the loan account
	APY pulled from System Properties table 
•	Hint: name could be “loan” and value could be the specific APY
o	Form will have a dropdown of the user’s accounts of which to deposit the money into
	Hint: World account is not part of the loan process
	Account list should show account number and balance
o	Special Case for Loans:
	Loans will show/display on the UI with a positive balance of what’s required to pay off (although it is a negative value in the database since the user owes it)
	User will transfer funds to the loan account to pay it off
•	Transfers will continue to be recorded in the Transactions table per normal rules
	Loan account’s balance will be the balance minus any transfers to this account
	Interest will be applied to the current loan balance and add to it (causing the user to owe more) (i.e. subtract from the negative balance)
	A loan with 0 balance will be considered paid off and will not accrue interest and will be eligible to be marked as closed
	User can’t transfer more money from a loan once it’s been opened and a loan account should not appear in the Account Source dropdowns
o	User will see user-friendly error messages when appropriate
o	User will see user-friendly success message when account is created successfully
	Redirect user to their Accounts page
•	Listing accounts and/or viewing Account Details should show any applicable APY or “-” if none is set for the particular account
o	Hint: Applies to Account List page and Transaction Details
•	User will be able to close an account
o	User must transfer or withdraw all funds out of the account before doing so (i.e., balance must be 0)
o	Account’s “is_active” column will get set as false
	All queries for Accounts should be updated to select only “is_active” = true accounts (i.e., dropdowns, My Accounts, etc)
	Do not delete the record, we’re doing a soft delete so it doesn’t break transactions
o	Closed accounts should not be visible to the user anymore
o	If the account is a loan, it must be paid off in full first

- Demo Link
  - (add youtube link to unlisted or public demo) Note you'll need to verify your youtube account to upload videos > 15mins
  

