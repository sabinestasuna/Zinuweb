<?php foreach ($articles as $article): ?>
<div class="mb-4 p-4 bg-white rounded shadow">
    <?php if (!empty($article['image_path'])): ?>
    <img src="<?php echo base_url($article['image_path']); ?>" alt="Article Image" class="w-full h-auto mb-2 rounded">
    <?php endif; ?>
    <h2 class="text-xl font-bold mb-2">
        <a href="<?php echo base_url('article/' . $article['id']); ?>" class="hover:underline">
        <?php echo $article['title'] ?>
        </a>
    </h2>
    <div class="text-gray-600 text-sm">
        <a href="<?php echo base_url('category/' . $article['category_id']); ?>" class="hover:underline">
            <?php echo $article['category_name'];?>
        </a> |
        <a href="<?php echo base_url('author/' . $article['author_id']); ?>" class="hover:underline">
            <?php echo $article['author_name'];?>
        </a>
        @<?php echo date('H:i d.m.Y', strtotime($article['publish_date'])); ?>
    </div>
    <div class="text-gray-600 text-sm mb-2">
        <i class="fas fa-comments"></i> <?php echo $article['comment_count']; ?>
        <i class="fas fa-eye"></i> <?php echo $article['views']; ?>
    </div>

    <p><?php echo substr($article['content'], 0, 100) . '...'; ?></p>
    <a href="<?php echo base_url('article/' . $article['id']); ?>" class="text-blue-600 hover:underline">Lasīt tālāk</a>
    <?php if ($this->session->userdata('is_admin')): ?>
        <button onclick="deleteArticle(<?php echo $article['id']; ?>)" class="text-red-500 hover:text-red-700">
            <i class="fas fa-trash-alt"></i> Dzēst
        </button>
    <?php endif; ?>
</div>
<?php endforeach; ?>
