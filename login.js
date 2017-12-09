"use strict";

window.onload = function () {
  // document.getElementById('submit').addEventListener("click", validateForm);

  function validateForm(e) {
    let form = document.getElementsByTagName("form")[0];
    let usernameCheck = checkUsername(form);
    let passwordCheck = checkPassword(form);
    
    if (usernameCheck === false || passwordCheck === false) {
      e.preventDefault();
    }
  }
  
  function checkUsername(f) {
    let check = true;
    
    if (f.elements["username"].value === "") {
      f.elements["username"].className = "error";
      check = false;
    } else {
      f.elements["username"].className = "valid";
    }
    return check;
  }
  
  function checkPassword(f) {
    let check = true;
    let passReg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    
    if (f.elements["username"].value !== "admin") {
      if (passReg.test(f.elements["password"].value) === false) {
        f.elements["password"].className = "error";
        check = false;
      } else {
        f.elements["password"].className = "valid";
      }
      return check;
    } else {
      f.elements["password"].className = "valid";
    }
  }
};

