const Name = $("#fname");
const Surname = $("#lname");
const Email = $("#email1");
const Bdate = $("#date");
const Password = $("#pass1");
const ComPassword = $("#pass2");

const emailValidate = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
const passwordValidate = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;

function validateEmail() {
  if (!emailValidate.test(Email.val())) {
    console.log("Invalid email address");
  } else {
    console.log("valid email address");
  }
}

function validatePassword() {
  if (!passwordValidate.test(password.val())) {
    console.log("Invalid password");
  } else {
    console.log("valid email address");
  }
}

Email.on("input", validateEmail);
Password.on("input", validatePassword);




$('form').on("submit", (event) => {
  event.preventDefault();

  validateEmail();
  validatePassword();
  if (Name.val() === '' || Surname.val() === '' || Email.val() === '' || Password.val() === ''|| Bdate.val() === ''|| ComPassword.val() === '') {
    alert('Please fill out all fields.');
    return;
  }
  

  // If there are no errors, submit the form
  $('form').unbind('submit').submit();
//     form.submit();
});
