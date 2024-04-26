<div class="flex flex-col justify-center items-center py-20 bg-gray-100">
    <div class="bg-white p-6 rounded-lg shadow-lg w-full md:w-1/2 lg:w-1/3 mx-auto">
        <h1 class="text-2xl font-bold text-center mb-4">Pievienot rakstu</h1>
        <?php echo form_open_multipart('articles/create', ['class' => 'space-y-3']); ?>
        
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700">Nosaukums:</label>
            <input type="text" name="title" id="title" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <div>
            <label for="content" class="block text-sm font-medium text-gray-700">Saturs:</label>
            <textarea name="content" id="content" required
                      class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
        </div>

        <div>
            <label for="category_id" class="block text-sm font-medium text-gray-700">Kategorija:</label>
            <select name="category_id" 
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category['id']; ?>"><?php echo $category['name']; ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label for="images" class="block text-sm font-medium text-gray-700">Bildes:</label>
            <input type="file" name="images[]" multiple
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>

        <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Publicēt
        </button>

        <?php echo form_close(); ?>
    </div>
</div>
