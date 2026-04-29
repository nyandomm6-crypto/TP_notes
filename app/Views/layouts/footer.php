        </div>
    </div>
</div>

<script>
// Global search
document.getElementById('globalSearch')?.addEventListener('keypress', function(e) {
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