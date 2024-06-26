<div class="container mx-auto px-4 py-4">
   <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-center my-4">
      <?php echo $title; ?>
   </h1>
   <div class="flex items-center justify-center mb-4">
       <select name="sort" id="sort-select" onchange="loadArticles()" class="block appearance-none w-full bg-white border border-gray-300 text-gray-700 py-3 px-4 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-gray-500">
           <option value="newest" <?php echo ($sort === 'newest' ? 'selected' : ''); ?>>Jaunākie</option>
           <option value="most_viewed" <?php echo ($sort === 'most_viewed' ? 'selected' : ''); ?>>Skatītākie</option>
           <option value="most_commented" <?php echo ($sort === 'most_commented' ? 'selected' : ''); ?>>Komentētākie</option>
       </select>
   </div>
   <div id="articles-container">
      <?php $this->load->view('articles/partial_articles', array('articles' => $articles)); ?>
   </div>
</div>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
function loadArticles() {
    var sort = $('#sort-select').val();
    var ajaxUrl = window.location.pathname + "?sort=" + sort;

    $.ajax({
        url: ajaxUrl,
        success: function(data) {
            $('#articles-container').html(data);
        },
        error: function() {
            alert('Error loading articles.');
        }
    });
}

function deleteArticle(articleId) {
    if (confirm('Vai tiešām vēlaties dzēst šo rakstu?')) {
        $.ajax({
            url: "<?php echo site_url('articles/delete'); ?>/" + articleId,
            type: "POST",
            success: function(response) {
                alert('Raksts ir dzēsts.');
                location.reload();
            },
            error: function() {
                alert('Kļūda dzēšanas laikā.');
            }
        });
    }
}

</script>

