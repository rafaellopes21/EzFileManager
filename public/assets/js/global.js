/*==== Constants and Global Declarations ====*/
const navbar = document.querySelector("#main-navbar");
const sidebar = document.querySelector("#bdSidebar");
const main_content = document.querySelector("#main-content");
const general_content = document.querySelector("#general-content");
const button_theme = document.querySelector("#theme-button");
const page_links = document.querySelectorAll("a[to]");
var current_theme = localStorage.getItem('user-theme') ? localStorage.getItem('user-theme') : 'light';

/*======== Call Starter Functions ========*/
$(document).ready(function (){
    getThemeMode();
    setMenuActive(window.location.pathname);
    loadingContent(false);
});

/*======= Main Executions Fuctions ========*/
button_theme.addEventListener("click", setThemeMode);
page_links.forEach(l => {l.addEventListener("click", function (){loadLink(l);});});


/*======= Callable Sys Functions ========*/
function setThemeMode(){
    if(localStorage.getItem('user-theme') === 'dark'){
        localStorage.setItem('user-theme', 'light');
    } else {
        localStorage.setItem('user-theme', 'dark');
    }

    current_theme = localStorage.getItem('user-theme');
    getThemeMode();
}

function getThemeMode(){
    let htmlTag = document.querySelector("html");
    let logos = document.querySelectorAll(".logo");
    let allColorItems = document.querySelectorAll('.bg-theme');
    let themeIcon = button_theme.children[0];
    let themeText = button_theme.children[1];

    if(current_theme === 'dark'){
        themeIcon.classList.remove('fa-sun');
        themeIcon.classList.add('fa-moon');

        themeText.innerText = "Theme Dark";
        main_content.classList.add('bg-body-tertiary');

        navbar.classList.remove('bg-light');
        navbar.setAttribute("style", 'border-bottom: 1px solid #6d6d6d;');

        sidebar.classList.remove('bg-light');
        sidebar.setAttribute("style", 'border-right: 1px solid #6d6d6d;');

        logos.forEach(logo =>{ logo.src = logo.getAttribute('light'); });
        allColorItems.forEach(changer => {
            changer.classList.remove('bg-light');
            changer.classList.add('bg-dark');
        });

        htmlTag.setAttribute("data-bs-theme", "dark");
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
        allColorItems.forEach(changer => {
            changer.classList.remove('bg-dark');
            changer.classList.add('bg-light');
        });

        htmlTag.setAttribute("data-bs-theme", "light");
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

function loadLink(link){
    includeContent(link.getAttribute('to'));
    setMenuActive(link.getAttribute('to'));
}

function setMenuActive(to){
    let clickMenu = document.querySelector('a[to="'+to+'"]');
    page_links.forEach(l => { l.classList.remove("active"); });
    clickMenu.classList.add("active");
    if(clickMenu.parentElement.classList.contains("sidebar-item")){
        if(!clickMenu.parentElement.parentElement.classList.contains("show")){
            clickMenu.parentElement.parentElement.previousElementSibling.click();
        }
    }
}

function includeContent(routeView){
    $instantLoad = "instantLoad=1";
    $renderView = routeView.includes("?") ? "&"+$instantLoad : "?"+$instantLoad
    //loadingContent();

    $(main_content).load(routeView+$renderView, function (){
        history.pushState({ url: window.location.href }, '', routeView);
        getThemeMode();
        //loadingContent(false);
    });
}

window.addEventListener('popstate', function (event) {
    let olrUrl = window.location.pathname;
    if (olrUrl && olrUrl != "" && olrUrl != " ") {
        includeContent(olrUrl);
    }
});