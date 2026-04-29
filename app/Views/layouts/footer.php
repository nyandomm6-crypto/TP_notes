        </div><!-- /.content -->
    </div><!-- /.main -->
</div><!-- /.app -->

<script>
// Global search functionality
document.getElementById('globalSearch')?.addEventListener('keyup', function(e) {
    if (e.key === 'Enter') {
        let keyword = this.value;
        if (keyword.length > 2) {
            window.location.href = '<?= base_url("/etudiant/search?keyword=") ?>' + encodeURIComponent(keyword);
        }
    }
});
</script>
</body>
</html>