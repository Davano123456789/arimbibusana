<script>
    @if(session('success'))
        iziToast.success({
            title: 'Berhasil',
            message: "{{ session('success') }}",
            position: 'topRight'
        });
    @endif

    @if(session('error'))
        iziToast.error({
            title: 'Gagal',
            message: "{{ session('error') }}",
            position: 'topRight'
        });
    @endif

    @if(session('warning'))
        iziToast.warning({
            title: 'Perhatian',
            message: "{{ session('warning') }}",
            position: 'topRight'
        });
    @endif

    @if(session('info'))
        iziToast.info({
            title: 'Info',
            message: "{{ session('info') }}",
            position: 'topRight'
        });
    @endif

    @if($errors->any())
        @foreach($errors->all() as $error)
            iziToast.error({
                title: 'Error',
                message: "{{ $error }}",
                position: 'topRight'
            });
        @endforeach
    @endif
</script>
