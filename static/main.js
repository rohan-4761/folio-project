const nav = document.querySelector('#nav');
var icon = document.getElementById("mode");
const logButton = document.getElementById('loginButton');
const formContainer = document.getElementById("formContainer")
const signUpButton = document.getElementById('signUp');
const logInButton = document.getElementById('logIn');
const container = document.getElementById('formContainer');
const filterbox = document.getElementById('filterbox')

function displayForm(){
  formContainer.style.display = 'block';
}
function displayFilterbox(){
  filterbox.style.display = 'block';
}
function displayManage(){
  window.location.href = "http://localhost/FolioProject/views/manage.php";
}

signUpButton.addEventListener('click', () => {
  container.classList.add("right-panel-active");
});

logInButton.addEventListener('click', () => {
  container.classList.remove("right-panel-active");
});


const observer = new IntersectionObserver((entries) => {
  entries.forEach((entry) => {
    console.log(entry);
    if (entry.isIntersecting) {
      entry.target.classList.add('show');
    }
    else {
      entry.target.classList.remove('show');
    }
  })
})


const hiddenElements = document.querySelectorAll('.hidden');
hiddenElements.forEach((hiddenElement) => {
  observer.observe(hiddenElement);
});



icon.onclick = function () {
  document.body.classList.toggle("lightMode");
  if (document.body.classList.contains("lightMode")) {
    icon.src = "../static/Image/lightMode.png";
  }
  else {
    icon.src = "../static/Image/darkMode.png";
  }
}


const onScroll = (event) => {
  const scrollPosition = event.target.scrollingElement.scrollTop;
  if (scrollPosition > 10) {
    if (!nav.classList.contains("scrolled-down")) {
      nav.classList.add("scrolled-down");
    }
  } else {
    if (nav.classList.contains("scrolled-down")) {
      nav.classList.remove("scrolled-down");
    }
  }
};

document.addEventListener("scroll", onScroll);


