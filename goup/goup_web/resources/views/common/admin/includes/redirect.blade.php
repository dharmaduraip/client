<script type="text/javascript">
if (localStorage.adminAccess == null) {
    window.location.replace("{{ url('/admin/login') }}");
}
</script>