document.addEventListener("DOMContentLoaded", () => {
    const loginForm = document.getElementById("login-form");
    const signupForm = document.getElementById("signup-form");
    const toSignup = document.getElementById("to-signup");
    const toLogin = document.getElementById("to-login");
  
    // Switch to sign-up form
    toSignup.addEventListener("click", (e) => {
      e.preventDefault();
      loginForm.classList.remove("active");
      signupForm.classList.add("active");
    });
  
    // Switch to login form
    toLogin.addEventListener("click", (e) => {
      e.preventDefault();
      signupForm.classList.remove("active");
      loginForm.classList.add("active");
    });
  
    // Show login form by default
    loginForm.classList.add("active");
  });
  