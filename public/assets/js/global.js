/*==== Constants and Global Declarations ====*/
const navbar = document.querySelector("#main-navbar");
const sidebar = document.querySelector("#bdSidebar");
const main_content = document.querySelector("#main-content");
const general_content = document.querySelector("#general-content");
const button_theme = document.querySelector("#theme-button");
const current_theme = localStorage.getItem('user-theme') ? localStorage.getItem('user-theme') : 'light';

/*======== Call Starter Functions ========*/
$(document).ready(function (){
    getCurrentTheme();
    loadingContent(false);
});

/*======= Main Executions Fuctions ========*/
button_theme.addEventListener("click", themeModeChanger);

function themeModeChanger(){
    let htmlTag = document.querySelector("html");
    let logos = document.querySelectorAll(".logo");
    let themeIcon = this.children[0];
    let themeText = this.children[1];

    if(themeIcon.classList.contains('fa-sun')){
        themeIcon.classList.remove('fa-sun');
        themeIcon.classList.add('fa-moon');

        themeText.innerText = "Theme Dark";
        main_content.classList.add('bg-body-tertiary');

        navbar.classList.remove('bg-light');
        navbar.setAttribute("style", 'border-bottom: 1px solid #6d6d6d;');

        sidebar.classList.remove('bg-light');
        sidebar.setAttribute("style", 'border-right: 1px solid #6d6d6d;');

        logos.forEach(logo =>{ logo.src = logo.getAttribute('light'); });

        htmlTag.setAttribute("data-bs-theme", "dark");
        localStorage.setItem('user-theme', 'dark');
    } else {
        themeIcon.classList.remove('fa-moon');
        themeIcon.classList.add('fa-sun');

        themeText.innerText = "Theme Light";
        main_content.classList.remove('bg-body-tertiary');

        navbar.classList.add('bg-light');
        navbar.setAttribute("style", 'border-bottom: 1px solid #e0e1e2;');

        sidebar.classList.add('bg-light');
        sidebar.setAttribute("style", 'border-right: 1px solid #e0e1e2;');

        logos.forEach(logo =>{ logo.src = logo.getAttribute('dark'); });

        htmlTag.setAttribute("data-bs-theme", "light");
        localStorage.setItem('user-theme', 'light');
    }
}

function getCurrentTheme(){
    if(current_theme === 'dark'){
        button_theme.click();
    }
}

function loadingContent(show = true){
    let loader = document.querySelector(".loading-content");
    if(show){
        loader.classList.remove('hide-loader');
        loader.classList.add("loader");
        loader.classList.add('show-loader');
        general_content.classList.add("blur-content");
    } else {
        loader.classList.remove('show-loader');
        loader.classList.add('hide-loader');
        general_content.classList.remove("blur-content");
        setTimeout(function (){
            loader.classList.remove("loader");
        }, 1050);
    }
}

function includeContent(routeView){
    loadingContent();
    $(main_content).load(routeView, function (){
        loadingContent(false);
    });
}