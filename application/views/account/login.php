<div class="flex flex-col justify-center items-center py-48 bg-gray-100">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96 mx-auto">
        <h1 class="text-2xl font-bold text-center mb-4">Pieslēgšanās</h1>
        <?php echo form_open('login', ['class' => 'space-y-3']); ?>
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">E-pasts</label>
            <input type="email" name="email" id="email" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">Parole</label>
            <input type="password" name="password" id="password" required
                   class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
        </div>
        <button type="submit"
                class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Pieslēgties
        </button>
        <?php echo form_close(); ?>
        <a href="<?php echo site_url('register'); ?>" class="text-sm text-gray-600 hover:text-gray-900 text-center block mt-4">Vai vēl neesi reģistrējies?</a>
    </div>
</div>

