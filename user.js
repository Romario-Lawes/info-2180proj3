window.onload = function () {
  document.getElementsByTagName("body")[0].style.backgroundImage = "none";
  
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
  
} 