function filterUsers(searchTerm) {
    document.querySelectorAll('.listing-users .card').forEach(card => {
        let userName = card.querySelector('h5').innerText.trim().toLowerCase();
        card.parentElement.style.display = userName.includes(searchTerm.trim().toLowerCase()) ? 'block' : 'none';
    });
}

function updateUser(...args){
    let data = args[0] ?? null;
    let server = data.response;

    if(parseInt(document.querySelector("#is_admin").value) == 1){
        if(server.response && server.response.refreshing){
            document.querySelector("#user_list").innerHTML = "";
            includeContent('/user/list', document.querySelector("#user_list"), false);
        }
    }
    releaseUserFields(false);
}

function createUser(e){
    let typeUser = document.querySelector("#type_user");
    document.querySelector("#delete_user_btn").setAttribute("hidden", "hidden");
    if(typeUser.name == "edit"){
        typeUser.name = "create";
        e.innerHTML = '<i class="fa-solid fa-user-pen"></i> '+translate('user_update_admin');
        releaseUserFields(true);
    } else {
        e.classList.add("creating");
        typeUser.name = "edit";
        e.innerHTML = '<i class="fa-solid fa-user-plus"></i> '+translate('user_create_user');
        releaseUserFields(false);
    }
}

function deleteUser(){
    document.querySelector("#delete_user").value = "1";
    document.querySelector("#send_user_btn").click();
}

function loadUser(id){
    releaseUserFields(true);
    let user = JSON.parse((document.querySelector("#user_data_"+id).value).replace(/'/g, '"'));
    document.querySelector("#type_user").user = "edit";
    document.querySelector("#user_id").value = user.id;
    document.querySelector("#user").value = user.user;
    document.querySelector("#storage_limit").value = user.storage_limit;
    document.querySelector("#expire_date").value = user.expire_date;
    document.querySelector("#editing_btn").innerHTML = '<i class="fa-solid fa-user-plus"></i> '+translate('user_create_user');
    document.querySelector("#delete_user_btn").removeAttribute("hidden");
}

function releaseUserFields(release = true){
    document.querySelector("#delete_user").value = "";
    document.querySelectorAll(".editable-field").forEach(field => {
        if(release){
            field.removeAttribute("readonly");
            field.value = "";
            if(field.id == 'password'){ field.removeAttribute("required"); }
        } else {
            field.setAttribute("readonly", "readonly");
            field.value = field.getAttribute("original");
            if(field.id == 'password'){ field.setAttribute("required", "required"); }
        }
    });
}