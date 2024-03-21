<?php ?>

<div class="mb-3">
    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <h5 class="mb-3 mb-sm-0 fw-semibold d-flex align-items-center">
            <span type="button" class="badge btn btn-primary py-1 px-2 ms-2 me-2" onclick="createUser(this)" id="editing_btn">
                <i class="fa-solid fa-user-plus"></i> <?= translate('user_create_user'); ?>
            </span>
            <?= translate('user_all_users') ?> <span class="badge text-bg-primary rounded-4 py-1 px-2 ms-2" id="count_users"><?= count($users) ?></span>
        </h5>
        <form class="position-relative">
            <div class="input-group">
                <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                <input type="search" class="form-control" placeholder="Search users" oninput="filterUsers(this.value)">
            </div>
        </form>
    </div>
    <div class="row listing-users">
        <?php
        foreach ($users as $u){ ?>
            <div class="col-sm-12 col-md-6 col-xl-4 col-xxl-3">
                <input hidden id="user_data_<?= $u['id'] ?>" value="<?= str_replace('"', "'", json_encode($u)) ?>">
                <div class="card">
                    <div class="card-body p-4 d-flex align-items-center gap-3">
                        <img src="<?= getAvatar($u['id']) ?>" id="user_profile_<?= $u['id'] ?>" class="rounded-circle img-fluid" style="width: 40px; height: 40px; object-fit: cover;">
                        <div>
                            <h5 class="fw-semibold mb-0"><?= ucwords($u['user']) ?></h5>
                            <span class="d-flex align-items-center"><?= $u['storage_limit'] != "Unlimited" ? sizer($u['storage_usage'])." / ".$u['storage_limit'] : translate('user_unlimited_storage') ?></span>
                            <div class="progress mt-1 mb-2" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="height: 3px">
                                <div class="progress-bar" style="width: 25%"></div>
                            </div>
                            <small class="d-flex align-items-center"><?= translate('user_expire') ?>: <?= $u['expire_date'] ?? "9999-12-31" ?></small>
                        </div>
                        <button type="button" class="btn btn-primary py-1 px-2 ms-auto" onclick="loadUser(<?= $u['id'] ?>)">
                            <i class="fa-solid fa-pen"></i>
                        </button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
