// --- EASY VALIDATION MODE ---

// function to handle login-form validation
function loginValidate(loginForm) {
    var errorMessage = "";

    if (loginForm.myusername.value == "") {
        errorMessage += "Email not filled!\n";
    }
    if (loginForm.mypassword.value == "") {
        errorMessage += "Password not filled!\n";
    }

    // Basic check: Email must contain '@'
    if (!loginForm.myusername.value.includes('@') && loginForm.myusername.value !== "") {
        errorMessage += "Invalid email address (must contain @).\n";
    }

    if (errorMessage !== "") {
        alert(errorMessage);
        return false;
    } else {
        alert("Click OK to login");
        return true;
    }
}

// function to handle register-form validation
function registerValidate(registerForm) {
    var errorMessage = "";

    // Check empty fields
    if (registerForm.firstname.value == "") {
        errorMessage += "Firstname not filled!\n";
    }
    if (registerForm.lastname.value == "") {
        errorMessage += "Lastname not filled!\n";
    }
    if (registerForm.email.value == "") {
        errorMessage += "Email not filled!\n";
    }
    if (registerForm.voter_id.value == "") {
        errorMessage += "Voter Id not filled!\n";
    }
    if (registerForm.password.value == "") {
        errorMessage += "Password not provided!\n";
    }
    if (registerForm.ConfirmPassword.value == "") {
        errorMessage += "Confirm password not filled!\n";
    }

    // Check if passwords match
    if (registerForm.password.value !== registerForm.ConfirmPassword.value) {
        errorMessage += "Passwords do not match!\n";
    }

    // Basic email check (Must contain @)
    if (!registerForm.email.value.includes('@') && registerForm.email.value !== "") {
        errorMessage += "Invalid email address (must contain @).\n";
    }

    if (errorMessage !== "") {
        alert(errorMessage);
        return false;
    } else {
        alert("Click OK to process registration");
        return true;
    }
}

// function to handle update-profile validation
function updateProfile(registerForm) {
    var errorMessage = "";

    if (registerForm.firstname.value == "") {
        errorMessage += "Firstname not filled!\n";
    }
    if (registerForm.lastname.value == "") {
        errorMessage += "Lastname not filled!\n";
    }
    if (registerForm.email.value == "") {
        errorMessage += "Email not filled!\n";
    }
    if (registerForm.password.value == "") {
        errorMessage += "New password not provided!\n";
    }
    if (registerForm.ConfirmPassword.value == "") {
        errorMessage += "Confirm password not filled!\n";
    }
    if (registerForm.password.value !== registerForm.ConfirmPassword.value) {
        errorMessage += "Passwords do not match!\n";
    }

    if (errorMessage !== "") {
        alert(errorMessage);
        return false;
    } else {
        alert("Click OK to update your account");
        return true;
    }
}

// Helper: Basic Email Check (Only checks for @)
function isValidEmail(val) {
    // Simply returns true if it contains @ symbol
    return val.includes('@');
}

// Helper: Voter ID (Always true - removed strict rules)
function isValidVoterId(val) {
    return true;
}

// Helper: Special PIN (Always true - removed strict rules)
function isValidSpecialPIN(val) {
    return true;
}

// Helper: Length (Always true - removed strict rules)
function isValidLength(val) {
    return true;
}


// --- STANDARD ORDER / RESERVE FUNCTIONS (Unchanged) ---

function getProductTotal(field) {
    clearErrorInfo();
    var form = field.form;
    if (field.value == "") field.value = 0;
    if ( !isPosInt(field.value) ) {
        var msg = 'Please enter a positive integer for quantity.';
        addValidationMessage(msg);
        addValidationField(field)
        displayErrorInfo( form );
        return;
    } else {
        var product = field.name.slice(0, field.name.lastIndexOf("_") ); 
        var price = form.elements[product + "_price"].value;
        var amt = field.value * price;
        form.elements[product + "_tot"].value = formatDecimal(amt);
        doTotals(form);
    }
}

function doTotals(form) {
    var total = 0;
    for (var i=0; PRODUCT_ABBRS[i]; i++) {
        var cur_field = form.elements[ PRODUCT_ABBRS[i] + "_qty" ]; 
        if ( !isPosInt(cur_field.value) ) {
            var msg = 'Please enter a positive integer for quantity.';
            addValidationMessage(msg);
            addValidationField(cur_field)
            displayErrorInfo( form );
            return;
        }
        total += parseFloat(cur_field.value) * parseFloat( form.elements[ PRODUCT_ABBRS[i] + "_price" ].value );
    }
    form.elements['total'].value = formatDecimal(total);
}

function finalCheck(orderForm) {
    var validationVerified = true;
    var errorMessage = "";
    var okayMessage = "click OK to process your order";

    if (orderForm.quantity.value == "") {
        errorMessage += "Please provide a quantity.\n";
        validationVerified = false;
    }
    if (orderForm.quantity.value == 0) {
        errorMessage += "Please provide a quantity rather than 0.\n";
        validationVerified = false;
    }
    if (orderForm.total.value == "") {
        errorMessage += "Total has not been calculated! Please provide first the quantity.\n";
        validationVerified = false;
    }
    if (!validationVerified) {
        alert(errorMessage);
    }
    if (validationVerified) {
        alert(okayMessage);
    }
    return validationVerified;
}

function updateValidate(updateForm) {
    var validationVerified = true;
    var errorMessage = "";
    var okayMessage = "click OK to change your password";

    if (updateForm.opassword.value == "") {
        errorMessage += "Please provide your old password.\n";
        validationVerified = false;
    }
    if (updateForm.npassword.value == "") {
        errorMessage += "Please provide a new password.\n";
        validationVerified = false;
    }
    if (updateForm.cpassword.value == "") {
        errorMessage += "Please confirm your new password.\n";
        validationVerified = false;
    }
    if (updateForm.cpassword.value != updateForm.npassword.value) {
        errorMessage += "Confirm password and new password do not match!\n";
        validationVerified = false;
    }
    if (!validationVerified) {
        alert(errorMessage);
    }
    if (validationVerified) {
        alert(okayMessage);
    }
    return validationVerified;
}

function reserveValidate(reserveForm) {
    var validationVerified = true;
    var errorMessage = "";
    var okayMessage = "click OK to reserve this table";

    if (reserveForm.tNumber.selectedIndex == 0) {
        errorMessage += "Please select a table by its number!\n";
        validationVerified = false;
    }
    if (!validationVerified) {
        alert(errorMessage);
    }
    if (validationVerified) {
        alert(okayMessage);
    }
    return validationVerified;
}

function positionValidate(positionForm) {
    var validationVerified = true;
    var errorMessage = "";
    var okayMessage = "click OK to see the candidates under the chosen position";

    if (positionForm.position.selectedIndex == 0) {
        errorMessage += "Position not set!\n";
        validationVerified = false;
    }
    if (!validationVerified) {
        alert(errorMessage);
    }
    if (validationVerified) {
        alert(okayMessage);
    }
    return validationVerified;
}