
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Auto-cerrar alertas
    setTimeout(() => {
        document.querySelectorAll('.alert-floating').forEach(alert => {
            alert.classList.remove('show');
        });
    }, 5000);
    </script>
</body>
</html>
