<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?> - Vienkāršā Ziņu Platforma</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .nav-container { display: flex; justify-content: space-between; }
        .nav-links { flex: 2; display: flex; justify-content: space-between; }
        .auth-links { flex: 1; display: flex; justify-content: flex-end; align-items: center; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.css" integrity="sha512-Woz+DqWYJ51bpVk5Fv0yES/edIMXjj3Ynda+KWTIkGoynAMHrqTcDUQltbipuiaD5ymEo9520lyoVOo9jCQOCA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js" integrity="sha512-Ixzuzfxv1EqafeQlTCufWfaC6ful6WFqIz4G+dWvK0beHw0NVJwvCKSgafpy5gwNqKmgUfIBraVwkKI+Cz0SEQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="bg-gray-100 text-gray-900">
   <?php if ($this->session->flashdata()): ?>
    <?php foreach ($this->session->flashdata() as $key => $message): ?>
      <div class="alert absolute top-4 right-4 bg-blue-100 text-blue-800 border border-blue-400 px-4 py-2 rounded-lg shadow-lg z-50">
         <?php echo $message; ?>
      </div>
    <?php endforeach; ?>
   <?php endif; ?>
    <div class="container mx-auto px-4 mt-4">
        <nav class="bg-white shadow mb-4 py-4">
            <div class="max-w-6xl mx-auto px-5 nav-container">
                <div class="nav-links">
                    <a href="<?php echo site_url('/'); ?>" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-l font-medium">Visi raksti</a>
                    <?php foreach ($categories as $category): ?>
                    <a href="<?php echo site_url('category/' . $category['id']); ?>" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium"><?php echo $category['name']; ?></a>
                    <?php endforeach; ?>
                </div>
                <div class="auth-links">
                    <?php if (!$this->session->userdata('logged_in')): ?>
                        <a href="<?php echo site_url('login'); ?>" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Pieslēgties</a>
                        <a href="<?php echo site_url('register'); ?>" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">Reģistrēties</a>
                    <?php else: ?>
                        <span>
                            <?php if ($this->session->userdata('is_admin')): ?>
                                <i class="fa-solid fa-user-shield"></i>
                            <?php endif; ?>
                            <?php if ($this->session->userdata('has_google')): ?>
                                <span class="text-red-500 py-2 rounded-md text-sm font-medium cursor-not-allowed">
                                    <i class="fab fa-google"></i>
                                </span>
                            <?php else: ?>
                                <a href="<?php echo site_url('link_google'); ?>" class="text-gray-500 hover:text-red-500 px-3 py-2 rounded-md text-sm font-medium">
                                    <i class="fab fa-google"></i>
                                </a>
                            <?php endif; ?>
                            <?php echo $this->session->userdata('username'); ?>
                            <a href="<?php echo site_url('add'); ?>" class="text-gray-700 hover:text-gray-900 px-1 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-plus"></i> Raksts
                            </a>
                            <a href="<?php echo site_url('logout'); ?>" class="text-gray-700 hover:text-gray-900 px-1 py-2 rounded-md text-sm font-medium">
                                <i class="fas fa-sign-out-alt"></i> Atslēgties
                            </a>
                        </span>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
