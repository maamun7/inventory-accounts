<div class="page-header"><h2>Change password</h3></div>
<div class="">
    <form action="<?=base_url()?>admin_dashboard/change_password" id="change_password" method="post"  name="change_password" enctype="multypart/formdata">
        <ul class="thumbnails">
            <li class="well span3"><h4>Old info.</h4>
                <div class="thumbnail">
                    <label class="">Email:</label>
                    <input type="text" placeholder="E-mail" class="" id="email" name="email" value="" />
                    <br>
                    <label class="">Old password:</label>
                    <input type="password" placeholder="Old password" class="" id="old_password" name="old_password" value="" />
                </div>
            </li>
            <li class="well span3"><h4>New info.</h4>
                <div class="thumbnail">
                    <label class="">New password:</label>
                    <input type="password" placeholder="New password" class="" id="password" name="password" value="" />
                    <br>
                    <label class="">Retype new password:</label>
                    <input type="password" placeholder="Retype new password" class="" id="repassword" name="repassword" value="" />
                </div>
            </li>
        </ul>
        <div class="well form-actions">
            <input type="submit" id="change-password" class="btn btn-primary" name="change-password" value="Change password" />
        </div>
    </form>
</div>
