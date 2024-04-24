<div class="container mx-auto px-4 py-8">
   <h1 class="text-4xl font-bold text-center mb-2"><?php echo $article['title']; ?></h1>
   <div class="text-center text-gray-600 text-sm">
      Kategorija: <a href="<?php echo site_url('category/view/' . $article['category_id']); ?>" class="text-blue-500 hover:text-blue-600"><?php echo $article['category_name']; ?></a>
   </div>
   <div class="text-center text-gray-600 text-sm mb-4">
      Autors: <a href="<?php echo site_url('articles/author/' . $article['author_id']); ?>" class="text-blue-500 hover:text-blue-600"><?php echo $article['author_name']; ?></a> | Publicēts: <?php echo date('Y-m-d', strtotime($article['publish_date'])); ?>
   </div>
   <div class="gallery" style="display: flex; overflow-x: auto; align-items: center; gap: 5px; padding: 10px 0; justify-content: center;">
      <?php foreach ($article['images'] as $image): ?>
      <a href="<?php echo base_url($image); ?>" data-lightbox="article-gallery" data-title="<?php echo $article['title']; ?>" style="flex: 1 1 auto; min-width: 100px; max-width: 80%;">
      <img src="<?php echo base_url($image); ?>" alt="<?php echo $article['title']; ?>" style="width: 100%; object-fit: contain; border-radius: 8px;">
      </a>
      <?php endforeach; ?>
   </div>
   <?php 
      $paragraphs = explode("\n", $article['content']);
      foreach ($paragraphs as $paragraph) {
          echo '<div style="margin-bottom: 16px;">' . $paragraph . '</div>';
      }
      ?>
   <hr class="my-4 border-gray-300">
   <h2 class="text-2xl font-bold mb-3">Komentāri:</h2>
   <?php foreach ($comments as $comment): ?>
   <div class="bg-gray-100 rounded mb-2">
      <p class="text-gray-800"><?php echo $comment['content']; ?></p>
      <p class="text-sm text-gray-600">Autors: <?php echo $comment['author_name']; ?>, Publicēts: <?php echo date('Y-m-d', strtotime($comment['date_posted'])); ?></p>
   </div>
   <?php endforeach; ?>
   <?php if (empty($comments)): ?>
   <p class="text-gray-600">Pagaidām nav komentāru.</p>
   <?php endif; ?>
</div>
