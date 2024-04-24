<div class="container mx-auto px-4 py-4">
   <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-center my-4">
      <?php echo $title; ?>
   </h1>
   <?php foreach ($articles as $article): ?>
   <div class="mb-4 p-4 bg-white rounded shadow">
      <?php if (!empty($article['image_path'])): ?>
      <img src="<?php echo base_url($article['image_path']); ?>" alt="Article Image" class="w-full h-auto mb-2 rounded">
      <?php endif; ?>
      <h2 class="text-xl font-bold mb-2">
         <a href="<?php echo base_url('article/view/' . $article['id']); ?>" class="hover:underline">
         <?php echo $article['title'] ?>
         </a>
      </h2>
      <p><?php echo substr($article['content'], 0, 100) . '...'; ?></p>
      <a href="<?php echo base_url('article/view/' . $article['id']); ?>" class="text-blue-600 hover:underline">Lasīt tālāk</a>
   </div>
   <?php endforeach; ?>
</div>
