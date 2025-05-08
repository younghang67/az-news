function togglePassword(id, event) {
  event.preventDefault();
  const passwordInput = document.getElementById(id);
  const toggleBtn = event.currentTarget;

  if (passwordInput.type === "password") {
    passwordInput.type = "text";
    toggleBtn.innerHTML = '<i class="bi bi-eye-slash"></i>';
  } else {
    passwordInput.type = "password";
    toggleBtn.innerHTML = '<i class="bi bi-eye"></i>';
  }
}
