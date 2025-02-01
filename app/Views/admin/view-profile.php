<?= $this->extend('admin/layouts/admin'); ?>

<?= $this->section('content'); ?> 
    
    <h2>Basic Information</h2>
    <table>
        <tr><td><strong>First Name:</strong></td><td><?= esc($user['first_name']); ?></td></tr>
        <tr><td><strong>Last Name:</strong></td><td><?= esc($user['last_name']); ?></td></tr>
        <tr><td><strong>Email:</strong></td><td><?= esc($user['email']); ?></td></tr>
        <tr><td><strong>Role:</strong></td><td><?= esc($user['role']); ?></td></tr>
    </table>

    <h2>Education Details</h2>
    <?php if ($education): ?>
        <table>
            <tr><td><strong>Highest Education:</strong></td><td><?= esc($education['highest_education']); ?></td></tr>
            <tr><td><strong>University:</strong></td><td><?= esc($education['university']); ?></td></tr>
            <tr><td><strong>College:</strong></td><td><?= esc($education['college']); ?></td></tr>
            <tr><td><strong>Percentage:</strong></td><td><?= esc($education['percentage']); ?>%</td></tr>
            <tr><td><strong>Year of Passing:</strong></td><td><?= esc($education['year_of_passing']); ?></td></tr>
        </table>
    <?php else: ?>
        <p>No education details available.</p>
    <?php endif; ?>

    <h2>Employment Details</h2>
    <?php if ($employment): ?>
        <table>
            <tr><td><strong>Company Name:</strong></td><td><?= esc($employment['company_name']); ?></td></tr>
            <tr><td><strong>Designation:</strong></td><td><?= esc($employment['designation']); ?></td></tr>
            <tr><td><strong>Years of Experience:</strong></td><td><?= esc($employment['years_experience']); ?></td></tr>
            <tr><td><strong>Location:</strong></td><td><?= esc($employment['location']); ?></td></tr>
        </table>
    <?php else: ?>
        <p>No employment details available.</p>
    <?php endif; ?>
<?= $this->endSection(); ?>
