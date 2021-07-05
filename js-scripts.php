<script>
function qs($elem){
    return document.querySelector($elem);
}
function qsa($elem){
    return document.querySelectorAll($elem);
}
//====================================================//
function invalidPass(){
    let emailBox = qs("#loginEmail");
    let passwordBox = qs("#loginPass");
    emailBox.style.bordercolor = "red";
    emailBox.style.color = "red";
    passwordBox.style.bordercolor = "red";
    passwordBox.style.color = "red";
    let newlable = document.createElement("lable");
    newlable.innerHTML = " שם משתמש ו/או סיסמא שגויים ";
    newlable.style.color = "red";
    let singinBtn = qs("#singinBtn");
    document.body.insertBefore(newlable, singinBtn);
}

function emailAlreadyExists(){
    let regEmailBox = qs("#registerEmail");
    let newlable = document.createElement("lable");
    newlable.innerHTML = ' כתובת דוא"ל קיימת במערכת ';
    newlable.style.color = "red";
    let regPassBox = qs("#regPass");
    document.body.insertBefore(newlable, regPassBox);

}

function passConfirm(pass,confirm) {
        if(pass !== confirm){
            qs(".input.confirmPass").classList.add("err");
        } 
        else {  
            qs(".input.confirmPass").classList.remove("err");
        };
} ; 

function changeNavbarCurrentPageColor(currentItem) {
    var navItems = qsa(".userCurrPage");
    for (i = 0; i < navItems.length; ++i) {
        navItems[i].classList.remove('currentNavItem');
    }
    qs(currentItem).classList.add('currentNavItem');
} 
//===================================================================================================

function changeAdminCurrentComponentColor(currentBtn) {
    var currDiv = qs('#adminHeader');
    var chosenButton = currDiv.querySelector(currentBtn);
    chosenButton.style.background = "linear-gradient(rgba(189, 218, 156, 0.8), rgb(115, 175, 169, 0.6), rgb(115, 115, 188, 0.5))";
    chosenButton.style.fontSize = "1.03rem";
    chosenButton.style.border = "solid inline 1px rgb(97, 129, 143)";
} 
//===================================================================================================


//-----toggle visible/non-visible passwords----//

function togggleVisPass(e){
    const toggleIcon = qs(`#${e}`);
    passInput = qs(`.${toggleIcon.id}`);
    const inputType = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
    passInput.setAttribute('type', inputType);
    toggleIcon.classList.toggle('fa-eye-slash');
}

window.addEventListener('scroll', function (){
    let xAmountOfPixles = 5;
    // console.log(window.pageYOffset);
    if(window.pageYOffset > xAmountOfPixles){
        qs(".header").classList.add('fixed-transp');
    }else if(window.pageYOffset <= xAmountOfPixles){
        qs(".header").classList.remove('fixed-transp');
    }
})


//-----toggle checkbox for article table all/none----//

function toggleCheckbox(source){
    var checkboxes = qsa('.articleTableCheckboxes');
    for($i = 0; $i<checkboxes.length; $i++){
        if(checkboxes[$i] !== source){
            checkboxes[$i].checked = source.checked;
        }
    }
};
//==== edit article btn=========//

function fetchedArticeTopic($topic){
    $options = qsa(".opt");
    for($i=0; $options.length>$i; $i++){
        if (this.value == $topic){
            this.selected == true
        }
    }
};

</script>