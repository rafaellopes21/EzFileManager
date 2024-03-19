<?php ?>
<?= import('_layouts/menus/header'); ?>

<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                <img src="assets/images/user.png" class="rounded-circle img-fluid" style="width: 218px;">
                <h5 class="my-3 mt-4 mb-4">
                    <?= strlen($user['user']) < 20 ? ucwords($user['user']) : substr(ucwords($user['user']), 0, 20)."..." ?>
                </h5>
                <div class="d-flex justify-content-center mb-3" style="margin-top: 30px;">
                    <button type="button" class="btn btn-primary">
                        <i class="fa-solid fa-pen-to-square"></i> Change Avatar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-body">
                <form class="form-validator" method="post" enctype="multipart/form-data" action="/user/update" exec="updateUser">
                    <div hidden style="display: none">
                        <input name="id" value="<?= $user['id'] ?>">
                        <input name="edit" value="1">
                    </div>

                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0 mt-1">Username</p></div>
                        <div class="col-sm-9">
                            <input class="form-control text-muted editable-field" aria-label="" readonly required
                                   name="user" id="user" value="<?= $user['user'] ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0 mt-1">My Storage</p></div>
                        <div class="col-sm-9">
                            <input class="form-control text-muted editable-field" aria-label="" readonly required
                                   name="storage_limit" id="storage_limit" value="<?= $user['storage_limit'] ?? "Unlimited" ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0 mt-1">Expire Date</p></div>
                        <div class="col-sm-9">
                            <input type="date" class="form-control text-muted editable-field" aria-label="" readonly required
                                   name="expire_date" id="expire_date" value="<?= $user['expire_date'] ?? "9999-12-31" ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0 mt-1">Password</p></div>
                        <div class="col-sm-9">
                            <input type="password" class="form-control text-muted" placeholder="*******" aria-label=""
                                   name="password" id="password" value="">
                        </div>
                    </div>
                    <div class="mt-3 d-grid gap-2 d-md-flex justify-content-md-end">
                       <button type="submit" class="btn btn-primary">
                           <i class="fa-solid fa-pen"></i> Update
                       </button>
                   </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="mb-3">
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <h5 class="mb-3 mb-sm-0 fw-semibold d-flex align-items-center">
            <span type="button" class="badge btn btn-primary py-1 px-2 ms-2 me-2">
                <i class="fa-solid fa-user-plus"></i> Create User
            </span>
            All Users <span class="badge text-bg-primary rounded-4 py-1 px-2 ms-2" id="count_users">1</span>
        </h5>
        <form class="position-relative">
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="search" class="form-control" placeholder="Search users" oninput="filterUsers(this.value)">
            </div>
        </form>
    </div>
    <div class="row listing-users">
        <div class="col-sm-12 col-md-6 col-xl-4 col-xxl-3">
            <div class="card">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle" width="40" height="40">
                    <div>
                        <h5 class="fw-semibold mb-0">Admin</h5>
                        <span class="d-flex align-items-center">15 GB</span>
                        <div class="progress mt-1 mb-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 3px">
                            <div class="progress-bar" style="width: 25%"></div>
                        </div>
                        <small class="d-flex align-items-center">Expire: 9999-12-31</small>
                    </div>
                    <button type="button" class="btn btn-primary py-1 px-2 ms-auto">
                        <i class="fa-solid fa-pen"></i> Edit
                    </button>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-xl-4 col-xxl-3">
            <div class="card">
                <div class="card-body p-4 d-flex align-items-center gap-3">
                    <img src="https://bootdey.com/img/Content/avatar/avatar1.png" class="rounded-circle" width="40" height="40">
                    <div class="resume-data">
                        <h5 class="fw-semibold mb-0">John Adams</h5>
                        <span class="d-flex align-items-center">Unlimited</span>
                        <div class="progress mt-1 mb-2" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="height: 3px">
                            <div class="progress-bar" style="width: 0%"></div>
                        </div>
                        <small class="d-flex align-items-center">Expire: 2024-12-31</small>
                    </div>
                    <button type="button" class="btn btn-primary py-1 px-2 ms-auto">
                        <i class="fa-solid fa-pen"></i> Edit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function filterUsers(searchTerm) {
        document.querySelectorAll('.listing-users .card').forEach(card => {
            let userName = card.querySelector('h5').innerText.trim().toLowerCase();
            card.parentElement.style.display = userName.includes(searchTerm.trim().toLowerCase()) ? 'block' : 'none';
        });
    }

    function updateUser(...args){
        let data = args[0] ?? null;
        console.log(data);
    }

    function updateCountUsers(){
        document.querySelector("#count_users").innerText = document.querySelectorAll('.listing-users .card').length;
    }
    updateCountUsers();
</script>