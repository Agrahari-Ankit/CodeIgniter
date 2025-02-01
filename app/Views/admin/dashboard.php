<?= $this->extend('admin/layouts/admin'); ?>

<?= $this->section('content'); ?> 

<h1>Welcome</h1>
<p>Your last login was on: <?= $last_login ? date('Y-m-d H:i:s', strtotime($last_login)) : 'Never logged in' ?></p>

<h2>Last 5 Users</h2>
<table id="userTable">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody></tbody>
</table>
<div id="pagination">
    <button id="prevPage">Previous</button>
    <span id="currentPage">Page 1</span>
    <button id="nextPage">Next</button>
</div>


<!-- Education Details Modal -->
<div id="educationModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>User Education Details</h2>

        <form id="educationForm">
            <input type="hidden" id="user_id" name="user_id">
            <div class="form-group">
                <label for="highest_education">Highest Education</label>
                <input type="text" id="highest_education" name="highest_education" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="university">University</label>
                <input type="text" id="university" name="university" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="college">College</label>
                <input type="text" id="college" name="college" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="percentage">Percentage/CGPA</label>
                <input type="text" id="percentage" name="percentage" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="year_of_passing">Year of Passing</label>
                <input type="number" id="year_of_passing" name="year_of_passing" class="form-control" required>
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
</div>

<div id="employmentModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>User Employment Details</h2>
        <form id="employmentForm">
            <input type="hidden" id="user_id" name="user_id">

            <label>Company Name:</label>
            <input type="text" id="company_name" name="company_name" class="form-control">

            <label>Designation:</label>
            <input type="text" id="designation" name="designation" class="form-control">

            <label>Years of Experience:</label>
            <input type="number" id="years_experience" name="years_experience" class="form-control">

            <label>Location:</label>
            <input type="text" id="location" name="location" class="form-control">

            <button type="submit">Save</button>
        </form>
    </div>
</div>



<script src="<?= base_url('assets/js/jquery-3.6.0.min.js'); ?>"></script>
<script>
$(document).ready(function () {
    let currentPage = 1;

    function fetchUsers(page) {
        $.ajax({
            url: `/api/users?page=${page}`,
            type: "GET",
            dataType: "json",
            success: function (data) {
                const tbody = $("#userTable tbody");
                tbody.empty();

                if (data.users.length === 0) {
                    tbody.html(`<tr><td colspan="3">No users found</td></tr>`);
                    return;
                }

                $.each(data.users, function (index, user) {
                    tbody.append(`<tr>
                        <td>${user.id}</td>
                        <td>${user.first_name} ${user.last_name}</td>
                        <td>${user.email}</td>
                        <td>${user.role}</td>
                        <td><a href="/edit-profile/${user.id}" class="editBtn">Edit</a>
                        <a href="/view/${user.id}" class="viewBtn">View</a>
                            <button class="educationBtn" data-id="${user.id}">Education</button>
                            <button class="employmentBtn" data-id="${user.id}">Employment</button>
                            <button class="deleteBtn" data-id="${user.id}">Delete</button></td>
                    </tr>`);
                });

                $("#currentPage").text(`Page ${data.pagination.currentPage}`);
                $("#prevPage").prop("disabled", data.pagination.currentPage === 1);
                $("#nextPage").prop("disabled", data.pagination.currentPage >= data.pagination.totalPages);

                currentPage = data.pagination.currentPage;
            },
            error: function (xhr, status, error) {
                console.error("Error fetching users:", error);
            }
        });
    }

    $("#prevPage").click(function () {
        if (currentPage > 1) fetchUsers(currentPage - 1);
    });

    $("#nextPage").click(function () {
        fetchUsers(currentPage + 1);
    }); 
    fetchUsers(1);
});

$(document).ready(function() {
    $(document).on('click', '.deleteBtn', function() {
        var userId = $(this).data('id');   
        if (confirm('Are you sure you want to delete this user?')) { 
            $.ajax({
                url: '/api/users/' + userId,   
                type: 'DELETE',   
                dataType: 'json',
                success: function(data) {
                    alert(data.message);  
                    window.location.href = '/admin/dashboard';   
                },
                error: function(xhr, status, error) {
                    var response = xhr.responseJSON;
                    alert(response.message || "An error occurred while deleting the user.");
                }
            });
        }
    });
});

$(document).ready(function () { 
    $(document).on("click", ".educationBtn", function () {
        let userId = $(this).data("id");
        $("#user_id").val(userId); 
        $.ajax({
            url: `/api/user/education/${userId}`,
            type: "GET",
            dataType: "json",
            success: function (data) {
                if (data) {
                    $("#highest_education").val(data.highest_education);
                    $("#university").val(data.university);
                    $("#college").val(data.college);
                    $("#percentage").val(data.percentage);
                    $("#year_of_passing").val(data.year_of_passing);
                } else { 
                    $("#educationForm")[0].reset();
                }
                $("#educationModal").show(); l
            },
            error: function () {
                alert("Failed to fetch education details.");
            }
        });
    });
 
    $("#educationForm").submit(function (event) {
        event.preventDefault();

        let formData = {
            user_id: $("#user_id").val(),
            highest_education: $("#highest_education").val(),
            university: $("#university").val(),
            college: $("#college").val(),
            percentage: $("#percentage").val(),
            year_of_passing: $("#year_of_passing").val(),
        };

        $.ajax({
            url: "/api/user/education/save",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                alert(response.message);
                $("#educationModal").hide();
            },
            error: function () {
                alert("Error saving education details.");
            }
        });
    });
 
    $(".close").click(function () {
        $("#educationModal").hide();
    });
});

$(document).ready(function () { 
    $(document).on("click", ".employmentBtn", function () {
        let userId = $(this).data("id");
        $("#user_id").val(userId);
 
        $.ajax({
            url: `/api/user/employment/${userId}`,
            type: "GET",
            dataType: "json",
            success: function (data) {
                if (data) {
                    $("#company_name").val(data.company_name);
                    $("#designation").val(data.designation);
                    $("#years_experience").val(data.years_experience);
                    $("#location").val(data.location);
                } else { 
                    $("#employmentForm")[0].reset();
                }
                $("#employmentModal").show();  
            },
            error: function () {
                alert("Failed to fetch employment details.");
            }
        });
    }); 
    $("#employmentForm").submit(function (event) {
        event.preventDefault();

        let formData = {
            user_id: $("#user_id").val(),
            company_name: $("#company_name").val(),
            designation: $("#designation").val(),
            years_experience: $("#years_experience").val(),
            location: $("#location").val(),
        };

        $.ajax({
            url: "/api/user/employment/save",
            type: "POST",
            data: formData,
            dataType: "json",
            success: function (response) {
                alert(response.message);
                $("#employmentModal").hide();
            },
            error: function () {
                alert("Error saving employment details.");
            }
        });
    });
 
    $(".close").click(function () {
        $("#employmentModal").hide();
    });
});



</script> 

     
<?= $this->endSection(); ?>
 
