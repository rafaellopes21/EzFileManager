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
                        <input id="user_id" name="id" original="<?= $user['id'] ?>" value="<?= $user['id'] ?>">
                        <input id="type_user" name="edit" value="1">
                        <input id="delete_user" name="delete" value="0">
                        <input id="is_admin" value="<?= $user['id'] == 1 ? 1 : 0 ?>">
                    </div>

                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0 mt-1">Username</p></div>
                        <div class="col-sm-9">
                            <input class="form-control text-muted editable-field" aria-label="" readonly required
                                   original="<?= $user['user'] ?>"
                                   name="user" id="user" value="<?= $user['user'] ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0 mt-1">My Storage</p></div>
                        <div class="col-sm-9">
                            <input class="form-control text-muted editable-field" aria-label="" readonly required
                                   original="<?= $user['storage_limit'] ?? "Unlimited" ?>"
                                   name="storage_limit" id="storage_limit" value="<?= $user['storage_limit'] ?? "Unlimited" ?>">
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-3"><p class="mb-0 mt-1">Expire Date</p></div>
                        <div class="col-sm-9">
                            <input type="date" class="form-control text-muted editable-field" aria-label="" readonly required
                                   original="<?= $user['expire_date'] ?? "9999-12-31" ?>"
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