</div>
<footer>
    <?php echo bloginfo('name') ?> &copy 2023
</footer>
</div>

<!-- <script>
    var today = new Date().toISOString().split('T')[0];

    var dateInput = document.querySelector('input[type="date"]');
    dateInput.min = today;
</script> -->

<script>
    var date = new Date();
    new Date().setDate(date.getDate() + 2);
    var tomorrow = date.toISOString().split('T')[0];

    var dateInputs = document.querySelectorAll('input[type="date"]');
    dateInputs.forEach(function(input) {
        input.min = tomorrow;
    });
</script>
</body>

</html>