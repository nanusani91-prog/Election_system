// --- EASY VALIDATION MODE (UPDATED) ---

// Function to handle login-form validation
function loginValidate(loginForm) {
    var errorMessage = "";

    if (loginForm.myusername.value == "") {
        errorMessage += "Email not filled!\n";
    } else if (!loginForm.myusername.value.includes('@')) {
        errorMessage += "Invalid email address (must contain @).\n";
    }

    if (loginForm.mypassword.value == "") {
        errorMessage += "Password not filled!\n";
    }

    if (errorMessage !== "") {
        alert(errorMessage);
        return false;
    }

    alert("click OK to continue");
    return true;
}

// Function to handle register-form validation
function registerValidate(registerForm) {
    var errorMessage = "";

    if (registerForm.firstname.value == "") errorMessage += "Firstname not filled!\n";
    if (registerForm.lastname.value == "") errorMessage += "Lastname not filled!\n";
    
    if (registerForm.email.value == "") {
        errorMessage += "Email not filled!\n";
    } else if (!isValidEmail(registerForm.email.value)) {
        errorMessage += "Invalid email address provided!\n";
    }

    if (registerForm.voter_id.value == "") {
        errorMessage += "Voter Id not filled!\n";
    } else if (!isValidVoterId(registerForm.voter_id.value)) {
        // This currently allows anything not empty. 
        // If you want STRICT 17 chars, see the function below.
        errorMessage += "Invalid Voter Id provided!\n";
    }

    if (registerForm.password.value == "") errorMessage += "Password not provided!\n";
    if (registerForm.ConfirmPassword.value == "") errorMessage += "Confirm password not filled!\n";
    
    if (registerForm.ConfirmPassword.value !== registerForm.password.value) {
        errorMessage += "Confirm password and password do not match!\n";
    }

    if (errorMessage !== "") {
        alert(errorMessage);
        return false;
    }

    alert("click OK to process registration");
    return true;
}

// Function to handle update-form validation
function updateProfile(registerForm) {
    var errorMessage = "";

    if (registerForm.firstname.value == "") errorMessage += "Firstname not filled!\n";
    if (registerForm.lastname.value == "") errorMessage += "Lastname not filled!\n";
    
    if (registerForm.email.value == "") {
        errorMessage += "Email not filled!\n";
    } else if (!isValidEmail(registerForm.email.value)) {
        errorMessage += "Invalid email address provided!\n";
    }

    // Checking voter ID in update profile as per your previous code
    if (registerForm.voter_id.value == "") errorMessage += "Voter ID not filled!\n";

    if (registerForm.password.value == "") errorMessage += "New password not provided!\n";
    if (registerForm.ConfirmPassword.value == "") errorMessage += "Confirm password not filled!\n";
    
    if (registerForm.ConfirmPassword.value !== registerForm.password.value) {
        errorMessage += "Confirm password and new password do not match!\n";
    }

    if (errorMessage !== "") {
        alert(errorMessage);
        return false;
    }

    alert("click OK to update your account");
    return true;
}

// Validate email function (Checks for @ symbol)
function isValidEmail(val) {
    return val.includes('@');
}

// Validate voter ID (Set to Easy Mode: Not Empty)
// To restore 17-char rule: change 'return true' to 'return val.length === 17;'
function isValidVoterId(val) {
    return true; 
}

// Validate special PIN (Strict Rule: 2Num + 3Alpha + 7Num)
function isValidSpecialPIN(val) {
    var re = /^[0-9][0-9][A-Z][A-Z][A-Z][0-9][0-9][0-9][0-9][0-9][0-9][0-9]$/;
    if (!re.test(val)) return false;
    return true;
}

// Validate special PIN length (Fixed undefined variable bug)
function isValidLength(val) {
    var length = 12;
    // Logic: Must be exactly 12 characters
    if (val.length !== length) {
        return false;
    }
    return true;
}

// Onchange of qty field entry totals the price
function getProductTotal(field) {
    clearErrorInfo();
    var form = field.form;
    if (field.value == "") field.value = 0;
    if (!isPosInt(field.value)) {
        var msg = 'Please enter a positive integer for quantity.';
        addValidationMessage(msg);
        addValidationField(field)
        displayErrorInfo(form);
        return;
    } else {
        var product = field.name.slice(0, field.name.lastIndexOf("_"));
        var price = form.elements[product + "_price"].value;
        var amt = field.value * price;
        form.elements[product + "_tot"].value = formatDecimal(amt);
        doTotals(form);
    }
}

function doTotals(form) {
    var total = 0;
    for (var i = 0; PRODUCT_ABBRS[i]; i++) {
        var cur_field = form.elements[PRODUCT_ABBRS[i] + "_qty"];
        if (!isPosInt(cur_field.value)) {
            var msg = 'Please enter a positive integer for quantity.';
            addValidationMessage(msg);
            addValidationField(cur_field)
            displayErrorInfo(form);
            return;
        }
        total += parseFloat(cur_field.value) * parseFloat(form.elements[PRODUCT_ABBRS[i] + "_price"].value);
    }
    form.elements['total'].value = formatDecimal(total);
}

// Validate orderform
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

// Validate updateForm
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

// Validate reserve form
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

// Validate position form
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