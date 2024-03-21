function filterUsers(searchTerm) {
    document.querySelectorAll('.listing-users .card').forEach(card => {
        let userName = card.querySelector('h5').innerText.trim().toLowerCase();
        card.parentElement.style.display = userName.includes(searchTerm.trim().toLowerCase()) ? 'block' : 'none';
    });
}

function updateUser(...args){
    let data = args[0] ?? null;
    let mainUser = parseInt(document.querySelector("#user_id").value) != 1;
    let userList = document.querySelector("#user_list");
    let typeUser = document.querySelector("#type_user");

    if(userList){
        userList.innerHTML = "";
        includeContent('/user/list', userList, false);
    }

    setTimeout(function (){
        releaseUserFields(false);
        typeUser.name = "edit";

        document.querySelectorAll(".editable-field").forEach(field => {
            if(mainUser){ field.value = ""; }
            field.classList.remove("is-valid");
        });

        releaseUserFields(false);
        document.querySelector("#delete_user").value = 0;
        document.querySelector("#preview-avatar").src =  document.querySelector("#preview-avatar").getAttribute("original");
    }, 250);
}

function createUser(e){
    let typeUser = document.querySelector("#type_user");
    let admUsr = document.querySelector("#user_id");
    document.querySelector("#delete_user_btn").setAttribute("hidden", "hidden");
    if(typeUser.name == "edit"){
        admUsr.value = admUsr.getAttribute("original");
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
    document.querySelector("#type_user").name = "edit";
    document.querySelector("#user_id").value = user.id;
    document.querySelector("#user").value = user.user;
    document.querySelector("#storage_limit").value = user.storage_limit;
    document.querySelector("#expire_date").value = user.expire_date;
    document.querySelector("#editing_btn").innerHTML = '<i class="fa-solid fa-user-plus"></i> '+translate('user_create_user');
    document.querySelector("#password").removeAttribute("required");
    document.querySelector("#preview-avatar").src = document.querySelector("#user_profile_"+id).src;
    if(id != 1){
        document.querySelector("#delete_user_btn").removeAttribute("hidden");
    } else {
        document.querySelector("#delete_user_btn").setAttribute("hidden", "hidden");
    }
}

function releaseUserFields(release = true){
    document.querySelector("#delete_user").value = "";
    document.querySelector("#profileimg").value = "";
    document.querySelector("#profileimg").files = null;
    document.querySelectorAll(".editable-field").forEach(field => {
        if(release){
            field.removeAttribute("readonly");
            field.value = "";
            if(field.id == 'password'){ field.setAttribute("required", "required"); }
        } else {
            field.setAttribute("readonly", "readonly");
            field.value = field.getAttribute("original");
            if(field.id == 'password'){ field.removeAttribute("required"); }
        }
    });

    if(document.querySelector('.removevalidation')){
        document.querySelectorAll('.removevalidation').forEach(i => {
            i.classList.remove("is-valid");
            i.classList.remove("is-invalid");
        });
    }
}

function previewImage(input) {
    let preview = document.querySelector('#preview-avatar');
    let previewNav = document.querySelector('.profile-pic img');
    let originalSrc = preview.getAttribute("original");

    input.addEventListener('change', function() {
        let file = this.files[0];

        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                preview.src = event.target.result;
                previewNav.src = event.target.result;
            };

            reader.readAsDataURL(file);
        } else {
            preview.src = originalSrc;
            previewNav.src = originalSrc;
        }
    });
}