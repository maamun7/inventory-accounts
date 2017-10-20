<div class="page-header"><h1>Edit user profile</h1></div>
<div class="row span6 well">
    <form action="<?=base_url()?>admin_dashboard/update_profile" id="edit_profile" method="post"  name="edit_profile" enctype="multypart/formdata">

        <label class="form-label">First name:</label>
        <input type="text" placeholder="First name" class="" id="first_name" name="first_name" value="{first_name}" calss="required" required />
        <br>
        <label class="form-label">Last name:</label>
        <input type="text" placeholder="Last name" class="" id="last_name" name="last_name" value="{last_name}" calss="required" required  />
        <br>
        <div class="form-actions">
            <input type="submit" id="edit-profile" class="btn btn-primary" name="edit-profile" value="Update profile" />
        </div>
    </form>
</div>