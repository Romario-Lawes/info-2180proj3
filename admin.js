"use strict";
window.onload = function () {
  document.getElementsByTagName("body")[0].style.backgroundImage = "none";
  
  // if (document.URL.includes("adduser.php")) {
  //   document.getElementById('submit').addEventListener("click", validateForm);
  // }
  
  let xhr = new XMLHttpRequest();
  let msgs = document.getElementsByClassName("msgs");
  let showAllBtn = document.getElementById("showAll");
  let showLessBtn = document.getElementById("showLess");
  showLessBtn.style.display = "none";

  for (let i =0; i < msgs.length; i++) {
	  msgs[i].addEventListener("click", function() {
		  window.location.href = "readmessage.php?id=" + msgs[i].id;
	  });
  }
  
  function showAllMsgs() {
    for (let i =10; i < msgs.length; i++) {
      msgs[i].style.display = "table-row";
    }
    showAllBtn.style.display = "none";
    showLessBtn.style.display = "initial";
  }
  
  function showLessMsgs() {
    if (msgs.length > 10) {
      showLessBtn.style.display = "none";
      showAllBtn.style.display = "initial";
      for (let i =10; i < msgs.length; i++) {
        msgs[i].style.display = "none";
      }
    } else {
      showAllBtn.style.display = "none";
    }
  }
  
  showLessMsgs();
  showAllBtn.addEventListener("click", showAllMsgs);
  showLessBtn.addEventListener("click", showLessMsgs);
  
  function validateForm(e) {
    let form = document.getElementsByTagName("form")[0];
    let firstnameCheck = checkName(form, "firstname");
    let lastnameCheck = checkName(form, "lastname");
    let usernameCheck = checkName(form, "username");
    let passwordCheck = checkPassword(form);
    
    if (firstnameCheck === false || lastnameCheck === false || usernameCheck === false || passwordCheck === false) {
      e.preventDefault();
    }
  }
  
  function checkName(f, name) {
    let check = true;
    
    if (f.elements[name].value === "") {
      f.elements[name].className = "error";
      check = false;
    } else {
      f.elements[name].className = "valid";
    }
    return check;
  }
  
  function checkPassword(f) {
    let check = true;
    let passReg = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
    
    if (passReg.test(f.elements["password"].value) === false || f.elements["password"].value !== f.elements["passwordConfirm"].value) {
      f.elements["password"].className = "error";
      f.elements["passwordConfirm"].className = "error";
      check = false;
    } else {
      f.elements["password"].className = "valid";
      f.elements["passwordConfirm"].className = "valid";
    }
    return check;
  }

}; 
