<!DOCTYPE html>
<html lang="lv">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title><?php echo $title; ?> - Vienkāršā Ziņu Platforma</title>
      <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
      <style>
         body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
      </style>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
   </head>
   <body class="bg-gray-100 text-gray-900">
      <div class="container mx-auto px-4 mt-4">
      <nav class="bg-white shadow mb-4 py-4">
         <ul class="flex justify-between max-w-6xl mx-auto px-5">
            <li><a href="<?php echo site_url('/'); ?>" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-l font-medium">Visi raksti</a></li>
            <?php foreach ($categories as $category): ?>
            <li><a href="<?php echo site_url('category/view/' . $category['id']); ?>" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium"><?php echo $category['name']; ?></a></li>
            <?php endforeach; ?>
         </ul>
      </nav>
