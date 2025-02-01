<?= $this->extend('customer/layouts/customer'); ?>

<?= $this->section('content'); ?>

<h1><?=$user['first_name']?>  <?=$user['last_name']?> Welcome Back!</h1>
<p>Your last login was on: <?= $last_login ? date('Y-m-d H:i:s', strtotime($last_login)) : 'Never logged in' ?></p>

<?= $this->endsection('content'); ?>