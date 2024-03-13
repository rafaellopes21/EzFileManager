/*==== Constants and Global Declarations ====*/
const language = JSON.parse((document.querySelector('#sys_lang').value).replace(/'/g, '"'));
const navbar = document.querySelector("#main-navbar");
const sidebar = document.querySelector("#bdSidebar");
const main_content = document.querySelector("#main-content");
const general_content = document.querySelector("#general-content");
const button_theme = document.querySelector("#theme-button");
const page_links = document.querySelectorAll("a[to]");
const toastMessage = document.querySelector("#notificationToast");
const TOAST_WARNING = "text-bg-warning";
const TOAST_DANGER = "text-bg-danger";
const TOAST_SUCCESS = "text-bg-success";
const TOAST_INFO = "text-bg-info";
const TOAST_HELP = "text-bg-primary";
var current_theme = localStorage.getItem('user-theme') ? localStorage.getItem('user-theme') : 'light';

/*======== Call Starter Functions ========*/
$(document).ready(function (){
    getThemeMode();
    setMenuActive(window.location.pathname);
    loadingScreen(false);
});

/*======= Main Executions Fuctions ========*/
button_theme.addEventListener("click", setThemeMode);

page_links.forEach(l => {
    l.addEventListener("click", function (){loadLink(l);});
});

document.getElementById('notificationToastBtn').addEventListener('click', () => {
    bootstrap.Toast.getOrCreateInstance(toastMessage).show();
});

document.querySelectorAll(".lang-selection").forEach(l => {
    l.addEventListener("click", function (){changeLanguage(l);});
});

/*======= Callable Sys Functions ========*/
function translate(key){
    return language[key];
}

function changeLanguage(e){
    let dataSend = {language: e.getAttribute('lang')+".json"};
    request('/languages/change', 'post', dataSend, false, true);
}

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

        themeText.innerText = translate('navbar_theme_dark');
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

        themeText.innerText = translate('navbar_theme_light');
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

function loadingScreen(show = true){
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
        }, 750);
    }
}

function loadingContent(show = true, $message = false, elemInsert = false) {
    let msg = $message ? $message : "Loading...";
    let loadingElement = '<div class="loader-content" style="opacity: 1"><i class="fa-solid fa-spinner fa-spin"></i><span>'+msg+'</span></div>';

    if(elemInsert){
        elemInsert.innerHTML = show ? loadingElement : '';
        return true;
    } else {
        return show ? loadingElement : '';
    }
}

function loadLink(link) {
    includeContent(link.getAttribute('to'));
    setMenuActive(link.getAttribute('to'));
}

function setMenuActive(to) {
    let clickMenu = document.querySelector('a[to="'+to+'"]');
    page_links.forEach(l => { l.classList.remove("active"); });
    clickMenu.classList.add("active");
    if(clickMenu.parentElement.classList.contains("sidebar-item")){
        if(!clickMenu.parentElement.parentElement.classList.contains("show")){
            clickMenu.parentElement.parentElement.previousElementSibling.click();
        }
    }
}

function sendNotification(type = TOAST_HELP, message = false){
    let title = document.querySelector("#toast-title-txt");
    let icon = title.previousElementSibling;
    let msgBody = document.querySelector(".toast-body");
        msgBody.innerHTML = "";

    toastMessage.classList.forEach(className => {
        if(className != "toast"){toastMessage.classList.remove(className);}}
    );
    toastMessage.children[0].classList.forEach(className => {
        if(className != "toast-header"){toastMessage.children[0].classList.remove(className);}}
    );

    title.innerHTML = document.querySelector("#default-"+type).value;
    switch (type){
        case TOAST_WARNING: icon.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i>'; break;
        case TOAST_DANGER: icon.innerHTML = '<i class="fa-solid fa-circle-xmark"></i>'; break;
        case TOAST_SUCCESS: icon.innerHTML = '<i class="fa-solid fa-circle-check"></i>'; break;
        case TOAST_INFO: icon.innerHTML = '<i class="fa-solid fa-circle-info"></i>'; break;
        case TOAST_HELP: icon.innerHTML = '<i class="fa-solid fa-circle-question"></i>'; break;
    }

    if(message){
        msgBody.removeAttribute("hidden");
        msgBody.innerHTML = message;
    } else {
        msgBody.setAttribute("hidden", "hidden");
    }

    toastMessage.classList.add(type);
    toastMessage.children[0].classList.add(type);

    document.querySelector("#notificationToastBtn").click();
}

function includeContent(routeView){
    $instantLoad = "instantLoad=1";
    $renderView = routeView.includes("?") ? "&"+$instantLoad : "?"+$instantLoad

    loadingContent(true, false, main_content);
    $(main_content).load(routeView+$renderView, function (){
        history.pushState({ url: window.location.href }, '', routeView);
        persist(main_content);
        getThemeMode();
        loadingContent(false);
    });
}

window.addEventListener('popstate', function (event) {
    let olrUrl = window.location.pathname;
    if (olrUrl && olrUrl != "" && olrUrl != " ") {
        includeContent(olrUrl);
    }
});

async function request(route, method = 'GET', data = false, showServerMessage = true, forceReload = false) {
    try {
        method = method.toUpperCase();
        let options = {
            method: method,
            headers: { 'Content-Type': 'application/json' }
        };

        if(data){
            if (method === 'POST' || method === 'PUT' || method === 'DELETE') {
                options.body = JSON.stringify(data);
            } else {
                route += route.includes('?') ? '&' : '?';
                route +=  Object.keys(data).map(key => key + '=' + encodeURIComponent(data[key])).join('&');
            }
        }

        let response = await fetch(window.location.origin + route, options);

        if (!response.ok) {
            throw new Error(`Fetch Error: ${response.status} - ${response.statusText}`);
        }

        let jsonData = await response.json();
        if(jsonData.error){
            throw new Error(`Fetch Error: ${jsonData.status} - ${jsonData.message}`);
        }

        if(forceReload){
            location.reload();
        }

        if(showServerMessage){
            let msgType = jsonData.type ?? TOAST_HELP;
            let msgText = jsonData.message ?? false;
            sendNotification(msgType, msgText);
        }

        return jsonData;
    } catch (error) {
        console.error('Fail to Fetch Data:', error);
        throw error;
    }
}