<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Admin Panel'; ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style_new.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>

</head>
<body> 
    <nav class="navbar">
        <div class="container">
            <a href="<?= base_url('customer/dashboard'); ?>" class="logo">Customer Panel</a>
            <ul>
                <li><a href="<?= base_url('logout'); ?>">Logout</a></li>
            </ul>
        </div>
    </nav> 
    <div class="container">
        <?= $this->renderSection('content'); ?>
    </div>
   

</body>
</html>
