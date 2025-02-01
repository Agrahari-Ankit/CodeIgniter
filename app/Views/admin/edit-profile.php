<?= $this->extend('admin/layouts/admin'); ?>
<?= $this->section('content'); ?>
<form id="editUserForm" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $user['id']; ?>"> 
    <div>
        <label>First Name</label>
        <input type="text" name="first_name" value="<?= $user['first_name']; ?>" required>
    </div> 
    <div>
        <label>Last Name</label>
        <input type="text" name="last_name" value="<?= $user['last_name']; ?>" required>
    </div> 
    <div>
        <label>Email</label>
        <input type="email" name="email" value="<?= $user['email']; ?>" required>
    </div> 
    <div>
        <label>Password</label>
        <input type="password" name="password">
    </div> 
    <div>
        <label>Confirm Password</label>
        <input type="password" name="confirm_password">
    </div> 
    <div>
        <label>Profile Image</label>
        <input type="file" id="imageUpload" accept="image/*">
        <img id="imagePreview" src="<?= base_url($user['profile_image']) ?>" alt="User Image" style="max-width: 10%;">
    </div> 

    <button type="submit">Update User</button>
</form>


<div id="cropperModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Crop User Image</h2>
        <img id="cropperImage" src="path_to_default_image.jpg" alt="User Image to Crop">
        <button id="cropImageBtn">Upload Image</button>
    </div>
</div>
<script src="<?= base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
<script src="https://cdn.jsdelivr.net/npm/pica@8.0.0/dist/pica.min.js"></script>
<script>
    $(document).ready(function() {
    $("#editUserForm").submit(function(e) {
        e.preventDefault(); 
        var formData = {
            first_name: $('input[name="first_name"]').val(),
            last_name: $('input[name="last_name"]').val(),
            email: $('input[name="email"]').val(),
            password: $('input[name="password"]').val(),
            confirm_password: $('input[name="confirm_password"]').val(),
        };

        $.ajax({
            url: '/api/users/<?= $user['id']; ?>',  
            type: 'PUT',
            data: JSON.stringify(formData),  
            contentType: 'application/json',  
            dataType: 'json',
            success: function(data) {
                alert(data.message);
                window.location.href = '/admin/dashboard';  
            },
            error: function(xhr, status, error) {
                var response = xhr.responseJSON;
                alert(response.message || "An error occurred while updating the user.");
            }
        });
    });
});




$(document).ready(function () {
    let cropper;  
    $("#imageUpload").on("change", function (e) {
        let file = e.target.files[0];
        if (file && file.type.startsWith('image')) {
            let reader = new FileReader();
            reader.onload = function (event) {
                $("#cropperImage").attr("src", event.target.result);
                $("#cropperModal").show();
                if (cropper) {
                    cropper.destroy();
                }
                cropper = new Cropper(document.getElementById("cropperImage"), {
                    aspectRatio: 0,  
                    viewMode: 0,
                    scalable: true,
                    zoomable: true,
                });
            };
            reader.readAsDataURL(file);
        } else {
            alert("Please upload a valid image.");
        }
    });
 
    $(".close").click(function () {
        $("#cropperModal").hide();
    });
 
    $("#cropImageBtn").click(function () {
        let croppedCanvas = cropper.getCroppedCanvas();
        croppedCanvas.toBlob(function (blob) {
            let formData = new FormData();
            formData.append("image", blob, "user_image.jpg");
 
            $.ajax({
                url: "/api/users/uploadImage/<?= $user['id']; ?>",  
                type: "POST",
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    alert(response.message);
                    $("#cropperModal").hide(); 
                    $("#imagePreview").attr("src", response.imageUrl);
                },
                error: function () {
                    alert("Error uploading image.");
                }
            });
        });
    });
});

</script>

<?= $this->endSection(); ?>
