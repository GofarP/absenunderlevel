<!-- Bootstrap core JavaScript-->
<script src="{{ asset('dashboardthemeassets/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('dashboardthemeassets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('dashboardthemeassets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('dashboardthemeassets/js/sb-admin-2.min.js') }}"></script>

<!-- Page level plugins -->
<script src="{{ asset('dashboardthemeassets/vendor/chart.js/Chart.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('dashboardthemeassets/js/demo/chart-area-demo.js') }}"></script>
<script src="{{ asset('dashboardthemeassets/js/demo/chart-pie-demo.js') }}"></script>

<!-- Select2js-->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

@livewireScripts

<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            theme: 'bootstrap-5'
        });
    });
</script>

@stack('scripts')