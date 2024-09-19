<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            var elements = document.querySelectorAll('.auto-hide');
            elements.forEach(function(element) {
                element.style.transition = "opacity 0.5s";
                element.style.opacity = 0;
                setTimeout(function() {
                    element.style.display = 'none';
                }, 500);
            });
        }, 9000);
    });
</script>