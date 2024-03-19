function loadTranslator(lang){
    request('/languages/pick', 'post', {lang: lang}).then(data => {
       let deleteButton = document.querySelector("#deleteLangButton");
       if(data.response){
           if(Object.keys(data.response).length > 0){
               deleteButton.removeAttribute("hidden");
               Object.keys(data.response).forEach(key => {
                   let field = document.getElementsByName(key)[0];
                   field.value = data.response[key];
                   fieldValidate(field);
               })
           } else {
               deleteButton.setAttribute("hidden", "hidden");
               document.querySelectorAll(".translate-elements").forEach(elem => {
                   elem.value = '';
                   fieldValidate(elem);
               })
           }
       }
    });
}

function deleteLanguage(){
    request('/languages/delete', 'post', {
        lang: document.querySelector("#allLanguagesSelect").value
    }, false).then(data => {
        if(data.response && data.response.deleted){
            changeLanguage(false, 'default');
        }
    });
}

function langUpdate(...args){
    let request = args[0] ?? null;
    if(request.response.response && request.response.response.new_lang){
        changeLanguage(false, request.response.response.new_lang);
    }
}