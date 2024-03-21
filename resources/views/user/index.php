<?php ?>
<?= import('_layouts/menus/header'); ?>

<div class="row">
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body text-center">
                <img src="<?= getAvatar() ?>" original="assets/images/user.png" id="preview-avatar" class="rounded-circle img-fluid"
                     style="width: 181px; height: 181px; object-fit: cover;">
                <h5 class="my-3 mt-3 mb-3">
                    <?= strlen($user['user']) < 20 ? ucwords($user['user']) : substr(ucwords($user['user']), 0, 20)."..." ?>
                </h5>
                <div class="d-flex justify-content-center mb-3" style="margin-top: 30px;">
                    <button type="button" class="btn btn-primary" onclick="profileimg.click();">
                        <i class="fa-solid fa-pen-to-square"></i> <?= translate('user_change_avatar') ?>
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
                        <input id="user_id" name="id" original="<?= $user['id'] ?>" value="<?= $user['id'] ?>">
                        <input id="type_user" name="edit" value="1">
                        <input id="delete_user" name="delete" value="0">
                        <input id="is_admin" value="<?= $user['id'] == 1 ? 1 : 0 ?>">
                        <input type="file" hidden onclick="previewImage(this)" name="profile" id="profileimg">
                    </div>

                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0 mt-1"><?= translate('user_username') ?></p></div>
                        <div class="col-sm-9">
                            <input class="form-control text-muted editable-field" aria-label="" readonly required
                                   original="<?= $user['user'] ?>"
                                   name="user" id="user" value="<?= $user['user'] ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0 mt-1"><?= translate('user_storage') ?></p></div>
                        <div class="col-sm-9">
                            <?php if($user['id'] != 1){
                                echo '<input class="form-control text-muted removevalidation" value="'.($user['storage_limit'] ?? "Unlimited").'" readonly required id="storage_limit" name="storage_limit">';
                            } else { ?>
                                <select class="form-select text-muted editable-field" id="storage_limit" name="storage_limit"
                                        original="<?= $user['storage_limit'] ?? "Unlimited" ?>" readonly required>
                                    <option <?= $user['storage_limit'] == "Unlimited" ? "selected" : "" ?> value="Unlimited"><?= translate('user_unlimited_storage') ?></option>
                                    <option <?= $user['storage_limit'] == sizer(5) ? "selected" : "" ?> value="<?= sizer(5) ?>"><?= sizer(5) ?></option>
                                    <option <?= $user['storage_limit'] == sizer(10) ? "selected" : "" ?> value="<?= sizer(10) ?>"><?= sizer(10) ?></option>
                                    <option <?= $user['storage_limit'] == sizer(25) ? "selected" : "" ?> value="<?= sizer(25) ?>"><?= sizer(25) ?></option>
                                    <option <?= $user['storage_limit'] == sizer(50) ? "selected" : "" ?> value="<?= sizer(50) ?>"><?= sizer(50) ?></option>
                                    <option <?= $user['storage_limit'] == sizer(100) ? "selected" : "" ?> value="<?= sizer(100) ?>"><?= sizer(100) ?></option>
                                    <option <?= $user['storage_limit'] == sizer(250) ? "selected" : "" ?> value="<?= sizer(250) ?>"><?= sizer(250) ?></option>
                                    <option <?= $user['storage_limit'] == sizer(500) ? "selected" : "" ?> value="<?= sizer(500) ?>"><?= sizer(500) ?></option>
                                    <option <?= $user['storage_limit'] == sizer(1000) ? "selected" : "" ?> value="<?= sizer(1000) ?>"><?= sizer(1000) ?></option>
                                    <option <?= $user['storage_limit'] == sizer(2000) ? "selected" : "" ?> value="<?= sizer(2000) ?>"><?= sizer(2000) ?></option>
                                    <option <?= $user['storage_limit'] == sizer(4000) ? "selected" : "" ?> value="<?= sizer(4000) ?>"><?= sizer(4000) ?></option>
                                    <option <?= $user['storage_limit'] == sizer(5000) ? "selected" : "" ?> value="<?= sizer(5000) ?>"><?= sizer(5000) ?></option>
                                    <option <?= $user['storage_limit'] == sizer(10000) ? "selected" : "" ?> value="<?= sizer(10000) ?>"><?= sizer(10000) ?></option>
                                </select>
                            <?php } ?>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0 mt-1"><?= translate('user_expiration_date') ?></p></div>
                        <div class="col-sm-9">
                            <input type="date" class="form-control text-muted editable-field" aria-label="" readonly required
                                   original="<?= $user['expire_date'] ?? "9999-12-31" ?>"
                                   name="expire_date" id="expire_date" value="<?= $user['expire_date'] ?? "9999-12-31" ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0 mt-1"><?= translate('user_password') ?></p></div>
                        <div class="col-sm-9">
                            <input type="password" class="form-control text-muted editable-field" placeholder="*******" aria-label=""
                                   name="password" id="password" value="">
                        </div>
                    </div>
                    <div class="mt-3 d-grid gap-2 d-md-flex justify-content-md-end">
                       <button type="submit" class="btn btn-primary" id="send_user_btn">
                           <i class="fa-solid fa-pen"></i> <?= translate('form_submit') ?>
                       </button>
                        <button type="button" class="btn btn-danger" hidden id="delete_user_btn" onclick="deleteUser()">
                            <i class="fa-solid fa-times"></i> <?= translate('form_delete') ?>
                        </button>
                   </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php if($user['id'] == 1){ ?>
    <div id="user_list"><?= import('user/user_list') ?></div>
<?php } ?>

<script src="assets/js/user/script.js"></script>