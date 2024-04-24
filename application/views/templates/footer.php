    </div>
        <footer class="bg-gray-200 text-center py-4 text-sm">
            <p>&copy; <?php echo date('Y'); ?> Vienkāršā Ziņu Platforma. Visas tiesības aizsargātas.</p>
        </footer>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function (alert) {
                    setTimeout(function () {
                        alert.style.display = 'none';
                    }, 4500);
                });
            });
        </script>
    </body>
</html>