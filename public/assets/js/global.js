/*==== Constants and Global Declarations ====*/
const language = getLanguagePattern('#sys_lang');
const languageDefault = getLanguagePattern('#sys_lang_default');
const navbar = document.querySelector("#main-navbar");
const sidebar = document.querySelector("#bdSidebar");
const main_content = document.querySelector("#main-content");
const general_content = document.querySelector("#general-content");
const button_theme = document.querySelector("#theme-button");
const page_links = document.querySelectorAll("a[to]");
const toastMessage = document.querySelector("#notificationToast");
const MSG_WARNING = "text-bg-warning";
const MSG_DANGER = "text-bg-danger";
const MSG_SUCCESS = "text-bg-success";
const MSG_INFO = "text-bg-info";
const MSG_HELP = "text-bg-primary";
var current_theme = localStorage.getItem('user-theme') ? localStorage.getItem('user-theme') : 'light';

/*======== Call Starter Functions ========*/
$(document).ready(function (){
    getThemeMode();
    setMenuActive(window.location.pathname);
    loadingScreen(false);
    revalidateFunctions();
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

window.addEventListener('popstate', function (event) {
    let olrUrl = window.location.pathname;
    if (olrUrl && olrUrl != "" && olrUrl != " ") {
        setMenuActive(olrUrl);
        includeContent(olrUrl);
    }
});

/*======= Callable Sys Functions ========*/
function translate(key){
    return language[key] ?? languageDefault[key];
}

function getLanguagePattern(element){
    let dom = document.querySelector(element);
    let lang = JSON.parse((dom.value).replace(/'/g, '"'));
    dom.remove();
    return lang;
}

function changeLanguage(e, forceChange){
    let dataSend = {language: (e ? e.getAttribute('lang') : forceChange)+".json"};
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

function enableContextMenu(){
    if(window.location.pathname === "/"){
        document.addEventListener("contextmenu", showContextMenu);
        document.addEventListener("click", hideContextMenu);
    } else {
        document.removeEventListener("contextmenu", showContextMenu);
        document.removeEventListener("click", hideContextMenu);
    }
}

function showContextMenu(event) {
    event.preventDefault();
    let contextMenu = document.getElementById("contextMenu");
    if(contextMenu){
        contextMenu.style.display = "block";
        contextMenu.style.left = event.pageX + "px";
        contextMenu.style.top = event.pageY + "px";
    }
}

function hideContextMenu(event) {
    let contextMenu = document.getElementById("contextMenu");
    if(contextMenu){
        contextMenu.style.display = "none";
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
    let msg = $message ? $message : translate('form_loading');
    let loadingElement = '<div class="loader-content" style="opacity: 1"><i class="fa-solid fa-spinner fa-spin"></i><span>'+msg+'</span></div>';

    if(elemInsert){
        elemInsert.innerHTML = show ? loadingElement : '';
        return true;
    } else {
        return show ? loadingElement : '';
    }
}

function loadLink(link) {
    let toUrl = link.getAttribute('to');
    includeContent(toUrl);
    if(!toUrl.includes("dir_path")){
        setMenuActive(toUrl);
    }
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

function sendNotification(type = MSG_HELP, message = false){
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
        case MSG_WARNING: icon.innerHTML = '<i class="fa-solid fa-triangle-exclamation"></i>'; break;
        case MSG_DANGER: icon.innerHTML = '<i class="fa-solid fa-circle-xmark"></i>'; break;
        case MSG_SUCCESS: icon.innerHTML = '<i class="fa-solid fa-circle-check"></i>'; break;
        case MSG_INFO: icon.innerHTML = '<i class="fa-solid fa-circle-info"></i>'; break;
        case MSG_HELP: icon.innerHTML = '<i class="fa-solid fa-circle-question"></i>'; break;
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

function loadDirContents(pathDir){
    includeContent("/?dir_path="+encodeURIComponent(pathDir));
    updateStorage(document.querySelector("#btn-updt-stg"), false);
}

function includeContent(routeView, loadInto = main_content, cleanRefresh = true){
    instantLoad = "instantLoad=1";
    renderView = routeView.includes("?") ? "&"+instantLoad : "?"+instantLoad

    loadingContent(true, false, loadInto);
    $(loadInto).load(routeView+renderView, function (){
        if(cleanRefresh){
            history.pushState({ url: window.location.href }, '', routeView);
            persist(loadInto);
            revalidateFunctions();
        }
        getThemeMode();
    });
}

function revalidateFunctions(){
    formValidate();
    enableContextMenu();
}

function fieldValidate(field){
    let valid = "is-valid";
    let invalid = "is-invalid";

    switch (field.nodeName.toLowerCase()){
        case 'select':
            let valSelected = Array.from(field.options).some(option => option.selected);
            if(valSelected && !field.options[field.selectedIndex].hasAttribute('hidden')){
                field.classList.remove(invalid);
                field.classList.add(valid);
                return true;
            } else {
                field.classList.remove(valid);
                if(field.required){
                    field.classList.add(invalid);
                    return false;
                }
                return true;
            }

        default:
            if(field.value.trim() && field.value.trim().length > 0){
                field.classList.remove(invalid);
                field.classList.add(valid);
                return true;
            } else {
                field.classList.remove(valid);
                if(field.required){
                    field.classList.add(invalid);
                    return false;
                }
                return true;
            }
    }
}

function formValidate(){
    document.querySelectorAll(".form-validator").forEach(form => {
        form.addEventListener("submit", function (event){
            event.preventDefault();

            let isValid = true;
            form.querySelectorAll('[required]').forEach(field => {
                isValid = fieldValidate(field);
            });

            if(isValid){
                let submitButton = form.querySelector('[type="submit"]');
                if(submitButton){ submitButton.disabled = true; }

                form.querySelectorAll('.is_invalid').forEach(field => {
                    fieldValidate(field);
                });

                let formData = new FormData(form);
                request(form.getAttribute("action"), form.getAttribute("method"), formData).then(data => {
                    if(data.response){
                        let execFunc = form.getAttribute("exec");
                        if (execFunc && data.response && typeof window[execFunc] === 'function') {
                            window[execFunc]({
                                form: form,
                                formData: Object.fromEntries(formData.entries()),
                                response: data,
                            });
                        }
                    }
                    submitButton.disabled = false;
                });
            } else {
                sendNotification(MSG_WARNING, translate('form_required_msg'))
                let firstInvalidField = form.querySelector('.is-invalid');
                if (firstInvalidField) {
                    firstInvalidField.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
            }
        });

        form.querySelectorAll("input, select, textarea").forEach(field => {
            let fieldType = field.tagName.toLowerCase();

            if (fieldType === "input" || fieldType === "textarea") {
                field.addEventListener("blur", function (){
                    fieldValidate(field);
                });
            }

            if (fieldType === "select") {
                field.addEventListener("change", function (){
                    fieldValidate(field);
                });
            }

            if(field.required && field.previousElementSibling){
                field.previousElementSibling.title = translate('form_required_title');
                field.previousElementSibling.insertAdjacentHTML("beforeend",
                    '<span class="ms-1 text-danger">*</span>'
                );
            }
        });
    });
}

function updateStorage(e, showMsg = true){
    request("/api/refresh", "POST", false, showMsg).then(data => {
        if(data && data.response && data.response.response){
            let updated = data.response.response;
            let bar = document.querySelector(".storage_bar_update");
            e.previousElementSibling.innerHTML = updated['detail'];
            bar.setAttribute("aria-valuenow", updated['percent']);
            bar.title = updated['percent']+"%";
            if(updated['class']){
                bar.children[0].classList.remove('bg-danger');
                bar.children[0].classList.add(updated['class']);
            }

            bar.children[0].removeAttribute("style");
            bar.children[0].setAttribute("style", "width: "+updated['percent']+"%;");
        }
    });
}

function openModal(formModal, setTitle = false, showSaveButton = true, fromElement = false){
    loadingContent(true, false, document.querySelector("#body_global_modal"));
    let titleModal = document.querySelector("#title_global_modal");
    let btnSaveModal = document.querySelector("#save_global_modal_btn");
    let sendBtn = document.querySelector("#save_global_modal_btn");
    if(sendBtn.hasAttribute("onclick")){ sendBtn.removeAttribute("onclick"); }

    titleModal.innerHTML = fromElement ? fromElement.children[0].innerHTML : setTitle;
    showSaveButton ?  btnSaveModal.removeAttribute("hidden") : btnSaveModal.setAttribute("hidden", "hidden");

    let instantLoad = "instantLoad=1";
    instantLoad = formModal.includes("?") ? "&"+instantLoad : "?"+instantLoad;

    $("#body_global_modal").load(formModal+instantLoad, function (){
        if(document.querySelector(".alert-error-upload")){
            document.querySelectorAll(".alert-error-upload").forEach(alert => {
                alert.setAttribute("hidden", "hidden");
            });
        }
        revalidateFunctions();
    });
    document.querySelector("#btn_modal_open").click();
}

function closeModal(){
    if(document.querySelector("#globalModal").classList.contains("show")){
        document.querySelector("#btn_modal_open").click();
    }
}

function validateUpload(typeUpload = "create"){
    let sendForm = false;
    let filesInput = document.querySelector('#files');
    let form = filesInput.closest('form');
    let type = document.querySelector("#typeUpload");
    let fileName = document.querySelector("#concatFilePath");
    let folderName = document.querySelector("#concatFolderPath");
    let filePath = document.querySelector("#filepath");
    let oldFilePath = filePath.value;

    type.value = typeUpload;

    if(fileName && fileName.value && isValidUpload(fileName)){
        let ext = fileName.value.includes(".") ? "" : ".txt";
        filePath.value += "/"+fileName.value+ext;
        sendForm = true;
    }

    if(folderName && folderName.value && isValidUpload(folderName)){
        filePath.value += "/"+folderName.value;
        sendForm = true;
    }

    if(filesInput && filesInput.files.length > 0){ sendForm = true; }

    if (sendForm){
        let formData = new FormData(form);
        request(form.getAttribute("action"), form.getAttribute("method"), formData).then(data => {
            if(!data.error && data.response.response){ reloadCurrentScreen(); }
            filePath.value = oldFilePath.value;
            type.value = "";
            if(fileName && fileName.value){ fileName.value = ""; }
            if(folderName && folderName.value){ folderName.value = ""; }
        });
    } else {
        filePath.value = oldFilePath.value;
        type.value = "";
        if(fileName && fileName.value){ fileName.value = ""; }
        if(folderName && folderName.value){ folderName.value = ""; }
        sendNotification(MSG_DANGER, translate('upload_default_error'));
    }

    closeModal();
}

function renameContent(path, currentName){
    openModal('/form/rename', translate('upload_rename'));
    setTimeout(function (){
        let item = document.querySelector("#concatRenameItem");
        item.value = currentName;
        item.setAttribute("path", path);
    }, 100);
}

function validateRename(path, hasElement = false){
    let item = document.querySelector("#concatRenameItem");
    let newContent = item.value;

    if(!hasElement){
        request('/api/rename', 'post', {original_name: path, rename_to: newContent}).then(data => {
            if(!data.error && data.response.response){ reloadCurrentScreen(); }
        });
        closeModal();
    } else {
        if(hasElement.value.trim() && hasElement.value.trim().length > 0){
            alertManagerWithAction(true, "validateRename('"+item.getAttribute('path')+"')");
            return true;
        } else {
            alertManagerWithAction(false);
            return false;
        }
    }
}

function copyContent(path){
    openModal('/form/copy?content='+path, translate('upload_copy'));
}
function validateCopy(from, to){
    request('/api/copy', 'post', {copy_from: from, copy_to: to}).then(data => {
        if(!data.error && data.response.response){ reloadCurrentScreen(); }
    });
    closeModal();
}

function deleteContent(path){
    request('/api/delete', 'post', {filepath: path}).then(data => {
        if(!data.error && data.response.response){ reloadCurrentScreen(); }
    });
}

function isValidUpload(e){
    if(e.value.trim() && e.value.trim().length > 0){
        alertManagerWithAction(true, "validateUpload('create')");
        return true;
    } else {
        alertManagerWithAction(false);
        return false;
    }
}

function alertManagerWithAction(hide, stringFunction = false){
    let alerts = document.querySelectorAll(".alert-error-upload");
    let send = document.querySelector("#save_global_modal_btn");

    if(hide){
        alerts.forEach(alert => { alert.setAttribute("hidden", "hidden"); });
        if(!send.hasAttribute("onclick") && stringFunction){send.setAttribute("onclick", stringFunction);}
    } else {
        alerts.forEach(alert => { alert.removeAttribute("hidden"); });
        if(send.hasAttribute("onclick")){ send.removeAttribute("onclick"); }
    }
}

function reloadCurrentScreen(){
    updateStorage(document.querySelector("#btn-updt-stg"), false);
    let reloadScreen = window.location.href.includes("/?") ? "?"+window.location.href.split("/?")[1] : "";
    includeContent('/'+reloadScreen);
}

async function request(route, method = 'GET', data = false, showServerMessage = true, forceReload = false) {
    try {
        loadingScreen();
        method = method.toUpperCase();
        let options = {
            method: method
        };

        // Se os dados são do tipo FormData, ajuste os cabeçalhos
        if (data instanceof FormData) {
            options.body = data;
        } else {
            options.headers = { 'Content-Type': 'application/json' };
            if (data) {
                if (method === 'POST' || method === 'PUT' || method === 'DELETE') {
                    options.body = JSON.stringify(data);
                } else {
                    route += route.includes('?') ? '&' : '?';
                    route += Object.keys(data).map(key => key + '=' + encodeURIComponent(data[key])).join('&');
                }
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

        loadingScreen(false);

        if(showServerMessage && jsonData.type){
            let msgType = jsonData.type ?? MSG_HELP;
            let msgText = jsonData.message ?? false;
            sendNotification(msgType, msgText);
        }

        return jsonData;
    } catch (error) {
        console.error('Fail to Fetch Data:', error);
        loadingScreen(false);
        throw error;
    }
}